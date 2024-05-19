@extends('layouts.app')
@section('content')
    <title>New Reservation</title>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="mb-3" >
                <h2 style="font-family: 'Times New Roman', Times, serif; font-weight: bold">Tambah Reservasi</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('reservations.index')}}">Reservation</a></li>
                        <li class="breadcrumb-item">New Reservation</li>
                    </ol>
                </nav>
            </div>
            <form action="{{ route('reservations.store') }}"  enctype="multipart/form-data" id="therapistForm" name="therapistForm" method="POST">
                @include('pages.reservation.from')
            </form>
        </div>
    </div>
@endsection
