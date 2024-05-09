@extends('layouts.app')
@section('content')
    <title>New Therapist</title>

    <div class="row mt-4">
        <div class="col-md-11">
            <div class="mb-3" >
                <h2 style="font-family: 'Times New Roman', Times, serif; font-weight: bold">Tambah Terapis</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('treatments.index')}}">Therapist</a></li>
                        <li class="breadcrumb-item">Tambah Terapis</li>
                    </ol>
                </nav>
            </div>
            <form action="{{ route('therapists.store') }}"  enctype="multipart/form-data" id="therapistForm" name="therapistForm" method="POST">
                @include('pages.therapist.main.form')
            </form>
        </div>
    </div>
@endsection
