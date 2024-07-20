@extends('layouts.app')
@section('content')
    <title>Edit Packet</title>

    <div class="row mt-0">
        <div class="col-md-11">
            <div class="mb-3">
                <h2>Edit Paket Treatment</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('packets.index')}}">Paket Treatment</a></li>
                        <li class="breadcrumb-item">Edit Paket Treatment</li>
                    </ol>
                </nav>
            </div>
            <form action="{{ route('packets.update', $packet->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @include('pages.admin.treatment.packet.form')
            </form>
        </div>
    </div>
@endsection
