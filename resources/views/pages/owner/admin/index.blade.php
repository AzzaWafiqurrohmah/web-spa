@extends('layouts.app')
@section('content')
    <title>Admin</title>
    <div class="row">
        <div class="col-md-8">
            <div class="mt-0 mb-3">
                <h1>Daftar Admin</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item">Admin</li>
                    </ol>
                </nav>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-4">
                        <div>
                            <a href="{{route('admin.create')}}" class="btn btn-primary">Tambah Admin</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="admin-table">
                            <thead>
                            <tr>
                                <th>ID Admin</th>
                                <th>Nama Lengkap</th>
                                <th>Nama Kota Cabang</th>
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
@include('components.script.owner.admin')
