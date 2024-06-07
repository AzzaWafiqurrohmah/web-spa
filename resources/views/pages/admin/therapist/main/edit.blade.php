@extends('layouts.app')
@section('content')
    <title>Edit Therapist</title>

    <div class="row mt-4">
        <div class="col-md-11">
            <div class="mb-3">
                <h2 >Edit Therapist</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('therapists.index')}}">Therapist</a></li>
                        <li class="breadcrumb-item">Edit Therapist</li>
                    </ol>
                </nav>
            </div>
            <form action="{{ route('therapists.update', $therapist->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @include('pages.admin.therapist.main.form')
            </form>
        </div>
    </div>
@endsection
