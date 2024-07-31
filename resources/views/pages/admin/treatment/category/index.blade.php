@extends('layouts.app')
@section('content')
    <title>Customer</title>
    <div class="row">
        <div class="col-md-7">
            <div class="mt-0 mb-3">
                <h2>Daftar Kategori Treatment</h2>
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
                            <button class="btn btn-primary" id="newCategory" name="newCategory">New Category</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="treatmentCategories-table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Kategori</th>
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
    @include('components.modal.treatmentCategory')
    @include('components.modal.treatmentCategoryImport')
@endsection

@push('script')
    <script>
        const categoriesTable = $('#treatmentCategories-table').DataTable({
            serverSide: true,
            rendering: true,
            ajax: '{{ route('treatmentCategories.datatables') }}',
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'name', name: 'name'},
                {data: 'action', orderable: false, searchable: false},
            ],
        });

        const categoryModal = new bootstrap.Modal('#treatmentCategory-modal');
        let editID = 0;

        function fillForm() {
            $.ajax({
                url: `/treatmentCategories/${editID}`,
                success: (res) => fillFormdata(res.data),
            });
        }

        function saveItem() {
            const url = editID != 0 ?
                `/treatmentCategories/${editID}/update` :
                `/treatmentCategories/store`;

            const method = editID != 0 ? 'PUT' : 'POST';

            // console.log($('#treatmentCategory-form').serialize());
            $.ajax({
                url,
                method,
                data: $('#treatmentCategory-form').serialize(),
                success(res) {
                    console.log(res.data);
                    categoriesTable.ajax.reload();
                    categoryModal.hide();


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

        function deleteItem(id) {
            $.ajax({
                url: `/treatmentCategories/${id}`,
                method: 'DELETE',
                success(res) {
                    categoriesTable.ajax.reload();

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

        $('#treatmentCategory-modal').on('show.bs.modal', function (event) {
            $('#treatmentCategory-modal-title').text(editID ? 'Edit Kategori' : 'Tambah Kategori');
            if (editID != 0)
                fillForm();
        });

        $('#treatmentCategory-modal').on('hidden.bs.modal', function (event) {
            editID = 0;

            removeFormErrors();
            $('#treatmentCategory-form').trigger('reset');
        });

        $('#treatmentCategory-form').submit(function (e) {
            e.preventDefault();

            removeFormErrors();
            saveItem();
        });

        $('#treatmentCategories-table').on('click', '.btn-edit', function (e) {
            editID = this.dataset.id;
            categoryModal.show();
        });

        $('#newCategory').on('click', function (e) {
            categoryModal.show();
        });


        $('#treatmentCategories-table').on('click', '.btn-delete', function (e) {
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

        $('#export').on('click', function (e) {
            $.ajax({
                url: `/treatmentCategories/export`,
                method: 'GET',
                success(res) {

                    if(res.data == 'empty'){
                        Swal.fire({
                            icon: 'warning',
                            text: 'Data Bahan Treatment masih kosong',
                            timer: 3000,
                        });
                    } else {
                        window.location.href = '/treatmentCategories/export';
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

        const importModal = new bootstrap.Modal('#treatmentCategory-modal-import');

        $('#treatmentCategory-modal-import').on('show.bs.modal', function (event) {
            $('#treatmentCategory-import-title').text('Import File Kategori Treatment');
        });

        $('#import').on('click', function (e) {
            importModal.show();
        });

        $('#treatmentCategory-form-import').submit(function (e) {
            e.preventDefault();

            removeFormErrors();
            saveFile();
        });

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
                url: '/treatmentCategories/import',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success(res) {
                    categoriesTable.ajax.reload();
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
                        text: 'Heading Anda Salah',
                        timer: 1500,
                    });
                },
            });
        }


    </script>
@endpush

