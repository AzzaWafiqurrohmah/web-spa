@extends('layouts.app')
@section('content')
    <title>New Treatment</title>

    <div class="row mt-4">
        <div class="col-md-11">
            <div class="mb-3" >
                <h2 style="font-family: 'Times New Roman', Times, serif; font-weight: bold">Tambah Treatment</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('treatments.index')}}">Customer</a></li>
                        <li class="breadcrumb-item">Tambah Treatment</li>
                    </ol>
                </nav>
            </div>
            <form action="{{ route('treatments.store') }}"  enctype="multipart/form-data" id="treatmentForm" name="treatmentForm" method="POST">
                @include('pages.treatment.main.form')
            </form>
        </div>
    </div>
@endsection
