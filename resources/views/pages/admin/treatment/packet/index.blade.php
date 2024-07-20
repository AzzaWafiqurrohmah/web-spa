@extends('layouts.app')
@section('content')
    <title>Packet Treatment</title>
    <div class="row">
        <div class="col-md-8">
            <div class="mt-0 mb-3">
                <h2>Daftar Paket Treatment</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item">Paket Treatment</li>
                    </ol>
                </nav>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-4">
                        <div>
                            <a href="{{route('packets.create')}}" class="btn btn-primary">Tambah Treatment</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="packets-table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Paket</th>
                                <th>Harga Normal</th>
                                <th>Harga Member</th>
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

@include('components.script.packet')
