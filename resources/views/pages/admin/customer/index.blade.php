@extends('layouts.app')
@section('content')
    <title>Customer</title>
    <div class="row">
        <div class="col-md-11">
            <div class="mt-5 mb-3">
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
                    <div class="d-flex justify-content-between mb-4">
                        <div style="">
                            <form action="" method="GET">
                                <select class="form-select float-left" id="month" name="month"
                                        aria-label="Default select example">
                                    <option selected>-- Pilih Bulan Lahir --</option>
                                    @foreach($months as $month)
                                        <option
                                            value="{{$month->format('m')}}" {{ request('month') == $month->format('m') ? 'selected' : '' }} >{{$month->format('F')}}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
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
                                <th>Tanggal Lahir</th>
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
