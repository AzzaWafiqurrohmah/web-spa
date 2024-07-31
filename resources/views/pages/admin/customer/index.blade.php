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
                    @can('crud customers')
                        <div class="d-flex justify-content-between mb-4">
                            <div style="align-items: center">
                                <button class="btn btn-warning" id="import" name="import">Import</button>
                                <button class="btn btn-success" id="export" name="export">Export</button>
                            </div>
                            <div >
                                <a href="{{route('customers.create')}}" class="btn btn-primary">Tambah Pelanggan</a>
                            </div>
                        </div>
                    @endcan
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
    @include('components.modal.customerImport')
@endsection

@include('components.script.customer')
