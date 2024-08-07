@extends('layouts.app')
@section('content')
    <title>Treatment</title>
    <div class="row">
        <div class="col-md-8">
            <div class="mt-0 mb-3">
                <h2>Daftar Alat Treatment</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item">Treatment</li>
                    </ol>
                </nav>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-4">
                        <div style="align-items: center">
                            <button class="btn btn-warning" id="import" name="import">Import</button>
                            <button class="btn btn-success" id="export" name="export">Export</button>
                        </div>
                        <div >
                            <button class="btn btn-primary" id="newTool" name="newTool">Tambah Alat</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="tools-table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Alat</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.modal.tool')
    @include('components.modal.toolImport')
@endsection

@push('script')
    <script>
        const toolsTable = $('#tools-table').DataTable({
            serverSide: true,
            rendering: true,
            ajax: '{{ route('tools.datatables') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'name', name: 'name'},
                {data: 'action', orderable: false, searchable: false},
            ],
        });

        const importModal = new bootstrap.Modal('#tool-modal-import');

        const toolModal = new bootstrap.Modal('#tool-modal');
        let editID = 0;

        function fillForm() {
            $.ajax({
                url: `/tools/${editID}`,
                success: (res) => fillFormdata(res.data),
            });
        }

        function saveItem() {
            const url = editID != 0 ?
                `/tools/${editID}/update` :
                `/tools/store`;

            const method = editID != 0 ? 'PUT' : 'POST';

            $.ajax({
                url,
                method,
                data: $('#tool-form').serialize(),
                success(res) {
                    toolsTable.ajax.reload();
                    toolModal.hide();


                    Swal.fire({
                        icon: 'success',
                        text: res.meta.message,
                        timer: 1500,
                    });
                },
                error(err) {
                    if (err.status == 422) {
                        displayFormErrors(err.responseJSON.data);
                        return;
                    }

                    Swal.fire({
                        icon: 'error',
                        text: 'Terdapat masalah saat melakukan aksi',
                        timer: 1500,
                    });
                },
            });
        }

        function saveFile(){
            var formData = new FormData();
            var fileInput = document.getElementById('fileImport');

            if (fileInput.files.length === 0) {
                console.log('iya');
                Swal.fire({
                    icon: 'error',
                    text: 'Silakan pilih file sebelum mengunggah',
                    timer: 1500,
                });
                return;
            }

            formData.append('fileImport', fileInput.files[0]);

            $.ajax({
                url: '/tools/import',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success(res) {
                    toolsTable.ajax.reload();
                    importModal.hide();

                    Swal.fire({
                        icon: 'success',
                        text: res.meta.message,
                        timer: 1500,
                    });

                },
                error(err) {
                    if (err.status == 422) {
                        displayFormErrors(err.responseJSON.data);
                        return;
                    }

                    Swal.fire({
                        icon: 'error',
                        text: 'Heading harus berupa "Nama Alat"',
                        timer: 1500,
                    });
                },
            });
        }

        function deleteItem(id) {
            $.ajax({
                url: `/tools/${id}`,
                method: 'DELETE',
                success(res) {
                    toolsTable.ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        text: res.meta.message,
                        timer: 1500,
                    });
                },
                error(err) {
                    Swal.fire({
                        icon: 'error',
                        text: 'Terdapat masalah saat melakukan aksi',
                        timer: 1500,
                    });
                },
            });
        }

        $('#tool-modal').on('show.bs.modal', function (event) {
            $('#tool-modal-title').text(editID ? 'Edit Alat Treatment' : 'Tambah Alat Treatment');
            if (editID != 0)
                fillForm();
        });

        $('#tool-modal-import').on('show.bs.modal', function (event) {
            $('#tool-import-title').text('Import File Alat Treatment');
        });

        $('#tool-modal').on('hidden.bs.modal', function (event) {
            editID = 0;

            removeFormErrors();
            $('#tool-form').trigger('reset');
        });

        $('#tool-form').submit(function (e) {
            e.preventDefault();

            removeFormErrors();
            saveItem();
        });

        $('#tool-form-import').submit(function (e) {
            e.preventDefault();

            removeFormErrors();
            saveFile();
        });

        $('#tools-table').on('click', '.btn-edit', function (e) {
            editID = this.dataset.id;
            toolModal.show();
        });

        $('#newTool').on('click', function (e) {
            toolModal.show();
        });

        $('#import').on('click', function (e) {
            importModal.show();
        });

        $('#export').on('click', function (e) {
            $.ajax({
                url: `/tools/export`,
                method: 'GET',
                success(res) {

                    if(res.data == 'empty'){
                        Swal.fire({
                            icon: 'warning',
                            text: 'Data Alat Treatment masih kosong',
                            timer: 3000,
                        });
                    } else {
                        window.location.href = '/tools/export';
                        Swal.fire({
                            icon: 'success',
                            text: 'Berhasil Mengunduh file',
                            timer: 1500,
                        });
                    }

                },
                error(err) {
                    Swal.fire({
                        icon: 'error',
                        text: 'Terdapat masalah saat melakukan aksi',
                        timer: 1500,
                    });
                },
            });
        });


        $('#tools-table').on('click', '.btn-delete', function (e) {
            Swal.fire({
                icon: 'question',
                text: 'Apakah anda yakin?',
                showCancelButton: true,
                cancelButtonText: 'Batal',
            }).then((res) => {
                if (res.isConfirmed)
                    deleteItem(this.dataset.id);
            });
        });


    </script>
@endpush
