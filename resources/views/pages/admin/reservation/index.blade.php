@extends('layouts.app')
@section('content')
    <title>Reservation</title>
    <div class="row">
        <div class="col-md-11">
            <div class="mt-0 mb-3">
                <h2>Daftar Reservasi</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item">Reservation</li>
                    </ol>
                </nav>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-4">
                        <div>
                            <a href="{{route('reservations.create')}}" class="btn btn-primary">Tambah Reservasi</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="reservations-table">
                            <thead>
                            <tr>
                                <th>ID Reservasi</th>
                                <th>Tanggal Reservasi</th>
                                <th>Nama Terapis</th>
                                <th>Nama Pelanggan</th>
                                <th>Total Biaya</th>
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
        const treatmentTable = $('#reservations-table').DataTable({
            serverSide: true,
            rendering: true,
            ajax: '{{ route('reservations.datatables') }}',
            columns: [
                {data: 'id'},
                {data: 'date', name: 'date'},
                {data: 'therapist', name: 'therapist.fullname'},
                {data: 'customer', name: 'customer.fullname'},
                {data: 'totals', name: 'totals'},
                {data: 'action', orderable: false, searchable: false},
            ],
        });

        const treatmentModal = new bootstrap.Modal('#treatment-modal');

        let ID = 0;

        function fillForm() {
            $.ajax({
                url: `/treatments/${ID}`,
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
