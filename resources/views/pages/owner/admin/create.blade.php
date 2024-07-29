@extends('layouts.app')
@section('content')
    <title>New Admin</title>

    <div class="row mt-0">
        <div class="col-md-10">
            <div class="mb-3" >
                <h2 style="font-family: 'Times New Roman', Times, serif; font-weight: bold">Tambah Admin</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Admin</a></li>
                        <li class="breadcrumb-item">Tambah Admin</li>
                    </ol>
                </nav>
            </div>
            <form action="{{ route('admin.store') }}"  method="POST">
                @include('pages.owner.admin.form')
            </form>
        </div>
    </div>
@endsection
