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
                    <table class="table table-striped table-hover" id="users-table">
                        <thead>
                        <tr>
                            <th>ID customer</th>
                            <th>Nama Lengkap</th>
                            <th>No Telp</th>
                            <th>Member</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
{{--                        @foreach($users as $user)--}}
                            <tr>
                                <td>374.1.008</td>
                                <td>admin</td>
                                <td>081234213213</td>
                                <td>
                                    <a href="" class="btn btn-sm btn-danger">Start member</a>
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="" class="btn btn-sm btn-warning">Details</a>
                                    <a href="" class="btn btn-sm btn-info">Edit</a>
                                    <form action="" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button  type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
{{--                        @endforeach--}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        $('#users-table').DataTable();
    </script>
@endpush
