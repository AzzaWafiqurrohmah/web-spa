@extends('layouts.app')
@section('content')
    <title>New Therapist</title>

    <div class="row mt-0">
        <div class="col-md-11">
            <div class="mb-3" >
                <h2>Tambah Terapis</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('therapists.index')}}">Therapist</a></li>
                        <li class="breadcrumb-item">Tambah Terapis</li>
                    </ol>
                </nav>
            </div>
            <form action="{{ route('therapists.store') }}"  enctype="multipart/form-data" id="therapistForm" name="therapistForm" method="POST">
                @include('pages.admin.therapist.main.form')
            </form>
        </div>
    </div>
@endsection
