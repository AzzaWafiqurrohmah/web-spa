@extends('layouts.app')
@section('content')
    <title>Edit Customer</title>

    <div class="row mt-4">
        <div class="col-md-11">
            <div class="mb-3" >
                <h2 style="font-family: 'Times New Roman', Times, serif; font-weight: bold">Ubah Data Pelanggan</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('customers.index')}}">Customer</a></li>
                        <li class="breadcrumb-item">Tambah Pelanggan</li>
                    </ol>
                </nav>
            </div>
            <form action="{{ route('customers.update', $customer->id) }}"  method="POST" enctype="multipart/form-data">
                @method('PUT')
                @include('pages.customer.form')
            </form>
        </div>
    </div>
@endsection
