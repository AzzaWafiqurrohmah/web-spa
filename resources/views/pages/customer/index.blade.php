@extends('layouts.app')
@section('content')
<title>Customer</title>
<div class="row">
    <div class="col-md-10">
        <div>
            <h3>Daftar pengguna</h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-4">
                    <div>
                        <a href="" class="btn btn-primary">New User</a>
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
                                <td>Aktif</td>
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
