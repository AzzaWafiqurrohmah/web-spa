@extends('layouts.app')
@section('content')
<title>Customer</title>
<div class="row">
    <div class="col-md-10">
        <div class="mt-5 mb-3" >
            <h1>Data pelanggan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item">Customer</li>
                </ol>
            </nav>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-4">
                    <div>
                        <a href="{{route('customers.create')}}" class="btn btn-primary">New User</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="customers-table">
                        <thead>
                        <tr>
                            <th>ID customer</th>
                            <th>Nama Lengkap</th>
                            <th>No Telp</th>
                            <th>Member</th>
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
@endsection

@push('script')
    <script>
        const customersTable = $('#customers-table').DataTable({
            serverSide: true,
            rendering: true,
            ajax: '{{ route('customers.datatables') }}',
            columns: [
                {data: 'id'},
                {data: 'fullname', name: 'fullname'},
                {data: 'phone', name: 'phone'},
                {data: 'member'},
                {data: 'action', orderable: false, searchable: false},
            ],
        });
    </script>
@endpush
