@extends('layouts.app')
@section('content')
    <title>Therapist</title>
    <div class="row">
        <div class="col-md-9">
            <div class="mt-0 mb-3" >
                <h2>Daftar Terapis</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item">Therapist</li>
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
                            <a href="{{route('therapists.create')}}" class="btn btn-primary">Tambah Terapis</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="therapist-table">
                            <thead>
                            <tr>
                                <th>ID Terapis</th>
                                <th>Nama Lengkap</th>
                                <th>Tanggal Lahir</th>
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
    @include('components.modal.therapistImport')
@endsection

@push('script')
    <script>
        const therapistTable = $('#therapist-table').DataTable({
            serverSide: true,
            rendering: true,
            ajax: '{{ route('therapists.datatables') }}',
            columns: [
                {data: 'id'},
                {data: 'fullname', name: 'fullname'},
                {data: 'birth_date'},
                {data: 'action', orderable: false, searchable: false},
            ],
        });


        $('#therapist-table').on('click', '.btn-edit', function(e) {
            window.location.href = "{{ route('therapists.edit', 'VALUE') }}".replace('VALUE', $(this).data('id'));
        });

        function deleteItem(id) {
            $.ajax({
                url: `/therapists/${id}`,
                method: 'DELETE',
                success(res) {
                    therapistTable.ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        text: res.meta.message,
                        timer: 1500,
                    });
                },
                error(err) {
                    Swal.fire({
                        icon: 'error',
                        text: err ,
                        timer: 1500,
                    });
                },
            });
        }

        $('#therapist-table').on('click', '.btn-delete', function(e) {
            Swal.fire({
                icon: 'question',
                text: 'Apakah anda yakin?',
                showCancelButton: true,
                cancelButtonText: 'Batal',
            }).then((res) => {
                if(res.isConfirmed)
                    deleteItem(this.dataset.id);
            });
        });

        $('#export').on('click', function (e) {
            $.ajax({
                url: `/therapists/export`,
                method: 'GET',
                success(res) {

                    if(res.data == 'empty'){
                        Swal.fire({
                            icon: 'warning',
                            text: 'Data Bahan Treatment masih kosong',
                            timer: 3000,
                        });
                    } else {
                        window.location.href = '/therapists/export';
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

        const importModal = new bootstrap.Modal('#therapist-modal-import');

        $('#therapist-modal-import').on('show.bs.modal', function (event) {
            $('#therapist-import-title').text('Import File Therapist');
        });

        $('#import').on('click', function (e) {
            importModal.show();
        });

        $('#therapist-form-import').submit(function (e) {
            e.preventDefault();
            removeFormErrors();
            saveFile();
        });

        function saveFile(){
            var formData = new FormData();
            var fileInput = document.getElementById('fileImport');

            if (fileInput.files.length === 0) {
                Swal.fire({
                    icon: 'error',
                    text: 'Silakan pilih file sebelum mengunggah',
                    timer: 1500,
                });
                return;
            }

            formData.append('fileImport', fileInput.files[0]);

            $.ajax({
                url: '/therapists/import',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success(res) {
                    therapistTable.ajax.reload();
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
                        text: 'Heading harus berupa "Nama Bahan"',
                        timer: 1500,
                    });
                },
            });
        }

    </script>
@endpush
