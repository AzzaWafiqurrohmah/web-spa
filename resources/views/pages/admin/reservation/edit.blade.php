@extends('layouts.app')
@section('content')
    <title>Edit Reservation</title>

    <div class="row mt-0">
        <div class="col-md-12">
            <div class="mb-3">
                <h2>Edit Reservasi</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('reservations.index')}}">Reservation</a></li>
                        <li class="breadcrumb-item">Edit Reservation</li>
                    </ol>
                </nav>
            </div>
            <form action="{{ route('reservations.update', $reservation->id) }}" enctype="multipart/form-data" id="therapistForm"
                  name="therapistForm" method="POST">
                @method('PUT')
                @include('pages.admin.reservation.form')
            </form>
        </div>
    </div>
@endsection
