@extends('layouts.app')
@section('content')
    <title>Edit Franchise</title>

    <div class="row mt-0">
        <div class="col-md-11">
            <div class="mb-3" >
                <h2 style="font-family: 'Times New Roman', Times, serif; font-weight: bold">Edit Cabang</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('franchises.index')}}">Franchise</a></li>
                        <li class="breadcrumb-item">Edit Cabang</li>
                    </ol>
                </nav>
            </div>
            <form action="{{ route('franchises.update', $franchise) }}"  method="POST">
                @method('PUT')
                @include('pages.owner.franchise.form')
            </form>
        </div>
    </div>
@endsection
