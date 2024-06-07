@extends('layouts.app')
@section('content')
    <title>Treatment</title>
    <div class="row">
        <div class="col-md-10">
            <div class="mt-5 mb-3">
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
                            <div>
                                <a href="{{route('treatments.create')}}" class="btn btn-primary">Tambah Treatment</a>
                            </div>
                        </div>
                    @endcan
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="treatments-table">
                            <thead>
                            <tr>
                                <th>ID Treatment</th>
                                <th>Nama</th>
                                <th>Durasi</th>
                                <th>Harga</th>
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
    @include('components.modal.treatment')
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
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'duration'},
                {data: 'price'},
                {data: 'action', orderable: false, searchable: false},
            ],
        });

        const treatmentModal = new bootstrap.Modal('#treatment-modal');

        let ID = 0;

        function fillForm() {
            let action = `/therapist/treatments/${ID}`;
            @can('crud treatments')
                url = '/treatments/${ID}';
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

    </script>
@endpush
