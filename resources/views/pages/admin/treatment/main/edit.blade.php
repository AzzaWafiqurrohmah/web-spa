@extends('layouts.app')
@section('content')
    <title>New Treatment</title>

    <div class="row mt-0">
        <div class="col-md-11">
            <div class="mb-3">
                <h2>Edit Treatment</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('treatments.index')}}">Treatment</a></li>
                        <li class="breadcrumb-item">Edit Treatment</li>
                    </ol>
                </nav>
            </div>
            <form action="{{ route('treatments.update', $treatment->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @include('pages.admin.treatment.main.form')
            </form>
        </div>
    </div>
@endsection
