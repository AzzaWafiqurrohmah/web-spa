@extends('layouts.app')
@section('content')
    <title>New Packet</title>

    <div class="row mt-0">
        <div class="col-md-11">
            <div class="mb-3" >
                <h2>Tambah Paket Treatment</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('packets.index')}}">Paket Treatment</a></li>
                        <li class="breadcrumb-item">Tambah Paket</li>
                    </ol>
                </nav>
            </div>
            <form action="{{ route('packets.store') }}"  enctype="multipart/form-data" id="packetForm" name="treatmentForm" method="POST">
                @include('pages.admin.treatment.packet.form')
            </form>
        </div>
    </div>
@endsection
