@extends('layouts.app')
@section('content')
    <title>Customer</title>
    <div class="row">
        @role(['admin', 'owner'])
            <div class="col-md-11">
        @endrole
        @role('therapist')
            <div class="col-md-9">
        @endrole
            <div class="mt-0 mb-3">
                <h2>Data pelanggan</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item">Customer</li>
                    </ol>
                </nav>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-4">
                        @can('crud customers')
                            <div>
                                <a href="{{route('customers.create')}}" class="btn btn-primary">Tambah Pelanggan</a>
                            </div>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="customers-table">
                            <thead>
                            <tr>
                                <th>ID customer</th>
                                <th>Nama Lengkap</th>
                                @role(['admin', 'owner'])
                                    <th>Tanggal Lahir</th>
                                @endrole
                                <th>Status</th>
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
    @include('components.modal.customer')
@endsection

@include('components.script.customer')
