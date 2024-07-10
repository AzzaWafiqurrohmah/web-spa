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
                {data: 'action', orderable: false, searchable: false},
            ],
        });

        $('#reservations-table').on('click', '.btn-edit', function (){
            window.location.href = "{{ route('reservations.edit', 'VALUE') }}".replace('VALUE', $(this).data('id'));
        });

    </script>
@endpush
