@extends('layouts.app')
@section('content')
    <title>New Customer</title>

    <div class="row mt-4">
        <div class="col-md-11">
            <div class="mb-3" >
                <h2 style="font-family: 'Times New Roman', Times, serif; font-weight: bold">Tambah Pelanggan</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('customers.index')}}">Customer</a></li>
                        <li class="breadcrumb-item">Tambah Pelanggan</li>
                    </ol>
                </nav>
            </div>
            <form action="{{ route('customers.store') }}"  method="POST" enctype="multipart/form-data">
                @include('pages.admin.customer.form')
            </form>
        </div>
    </div>
@endsection
