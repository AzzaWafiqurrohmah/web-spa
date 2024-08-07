@extends('layouts.app')
@section('content')
    <title>Reservation</title>
    <div class="row">
        <div class="col-md-12">
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
                        @role('admin')
                        <div>
                            <a href="{{route('reservations.create')}}" class="btn btn-primary">Tambah Reservasi</a>
                        </div>
                        @endrole
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="reservations-table">
                            <thead>
                            <tr>
                                <th>ID Reservasi</th>
                                <th>Tanggal </th>
                                <th>Nama Terapis</th>
                                <th>Nama Pelanggan</th>
                                <th>Total Biaya</th>
                                <th>Status </th>
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
        let url ='{{ route('reservations.datatables') }}';
        @if($user->hasRole('therapist'))
            url = '/therapist/reservations/datatables'
        @endif
        const reservationTable = $('#reservations-table').DataTable({
            serverSide: true,
            rendering: true,
            ajax: url,
            columns: [
                {data: 'id'},
                {data: 'date', name: 'date'},
                {data: 'therapist', name: 'therapist.fullname'},
                {data: 'customer', name: 'customer.fullname'},
                {data: 'totals', name: 'totals'},
                {data: 'status'},
                {data: 'action', orderable: false, searchable: false},
            ],
        });

        $('#reservations-table').on('click', '.btn-edit', function (){
            window.location.href = "{{ route('reservations.edit', 'VALUE') }}".replace('VALUE', $(this).data('id'));
        });

        function cancel(id) {
            $.ajax({
                url: `/reservations/cancel/${id}`,
                method: 'GET',
                success(res) {
                    reservationTable.ajax.reload();
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

        $('#reservations-table').on('click', '.btn-cancel', function (e) {
            Swal.fire({
                icon: 'question',
                text: 'Apakah anda yakin ingin membatalkan pesanan?',
                showCancelButton: true,
                cancelButtonText: 'Tidak',
                confirmButtonText: 'Iya'
            }).then((res) => {
                if (res.isConfirmed)
                    cancel(this.dataset.id);
            });
        });
    </script>
@endpush
