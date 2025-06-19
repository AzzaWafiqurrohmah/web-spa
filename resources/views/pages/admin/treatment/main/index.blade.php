@extends('layouts.app')
@section('content')
    <title>Treatment</title>
    <div class="row">
        <div class="col-md-10">
            <div class="mt-0 mb-3">
                <h2>Daftar Treatment</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item">Treatment</li>
                    </ol>
                </nav>
            </div>
            <div class="card">
                <div class="card-body">
                    @can('crud treatments')
                        <div class="d-flex justify-content-between mb-4">
                            <div style="align-items: center">
                                <button class="btn btn-warning" id="import" name="import">Import</button>
                                <button class="btn btn-success" id="export" name="export">Export</button>
                            </div>
                            <div >
                                <a href="{{route('treatments.create')}}" class="btn btn-primary">Tambah Treatment</a>
                            </div>
                        </div>
                    @endcan
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="treatments-table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Durasi</th>
                                <th>Harga Normal</th>
                                <th>Harga Member</th>
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
    {{-- @include('components.modal.treatment') --}}
    @include('components.modal.treatmentImport')
    @include('components.modal.treatmentModal')
@endsection

@push('script')
    <script>
        let url = '/therapist/treatments/datatables';
        @can('crud treatments')
            url = '{{ route('treatments.datatables') }}';
        @endcan

        const treatmentTable = $('#treatments-table').DataTable({
            serverSide: true,
            rendering: true,
            ajax: url,
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'name', name: 'name'},
                {data: 'duration'},
                {data: 'price'},
                {data: 'member_price'},
                {data: 'action', orderable: false, searchable: false},
            ],
        });

        const treatmentModal = new bootstrap.Modal('#treatment-modal');

        let ID = 0;

        function fillForm() {
            let action = `/therapist/treatments/${ID}`;
            @can('crud treatments')
                action = `/treatments/${ID}`;
            @endcan
            $.ajax({
                url: action,
                success: (res) =>
                    fillFormdata(res.data),
            });
        }

        $('#treatment-modal').on('show.bs.modal', function (event) {
            fillForm();
        });

        $('#treatments-table').on('click', '.btn-detail', function (e) {
            ID = this.dataset.id;
            treatmentModal.show();
        });

        $('#newTreatment').on('click', function (e) {
            treatmentModal.show();
        });

        $('#treatments-table').on('click', '.btn-edit', function (e) {
            window.location.href = "{{ route('treatments.edit', 'VALUE') }}".replace('VALUE', $(this).data('id'));
        });

        function deleteItem(id) {
            $.ajax({
                url: `/treatments/${id}`,
                method: 'DELETE',
                success(res) {
                    treatmentTable.ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        text: res.meta.message,
                        timer: 1500,
                    });
                },
                error(err) {
                    Swal.fire({
                        icon: 'error',
                        text: err,
                        timer: 1500,
                    });
                },
            });
        }

        $('#treatments-table').on('click', '.btn-delete', function (e) {
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
                url: `/treatments/export`,
                method: 'GET',
                success(res) {

                    if(res.data == 'empty'){
                        Swal.fire({
                            icon: 'warning',
                            text: 'Data Bahan Treatment masih kosong',
                            timer: 3000,
                        });
                    } else {
                        window.location.href = '/treatments/export';
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

        const importModal = new bootstrap.Modal('#treatment-modal-import');

        $('#treatment-modal-import').on('show.bs.modal', function (event) {
            $('#treatment-import-title').text('Import File Treatment');
        });

        $('#import').on('click', function (e) {
            importModal.show();
        });

        $('#treatment-form-import').submit(function (e) {
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
                url: '/treatments/import',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success(res) {
                    treatmentTable.ajax.reload();
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
