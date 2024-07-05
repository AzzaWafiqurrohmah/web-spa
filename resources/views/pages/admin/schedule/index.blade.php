@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-11">
        <div class="mt-0 mb-3">
            <h2>Jadwal Terapis</h2>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item">Schedule</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-2">
            <div class="card-body">
                <h6 class="mb-4"><b>{{ date('d M Y') }}</b></h6>

                <div class="month-carousel owl-carousel">
                    @foreach ($months as $index => $month)
                    <div
                        class="month-item {{ $index == intval(date('m')) ? 'selected' : '' }} text-center"
                        data-position="{{ $loop->index }}"
                    >
                        {{ $month }}
                    </div>
                    @endforeach
                </div>

                <div class="date-carousel owl-carousel mt-2">
                    @for ($i = 1; $i <= date('t'); $i++)
                        @php
                            $tmp = strtotime(date('Y-m') . '-' . $i);
                            $day = strftime('%A', $tmp);
                        @endphp
                        <div
                            class="date-item text-center d-flex justify-content-center align-items-center flex-column"
                            data-position="{{ $i - 1 }}"
                        >
                            <div class="d-flex justify-content-center align-items-center date-number bg-primary">{{ $i }}</div>
                            <p class="m-0 date-day">{{ $days[$day] }}</p>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body" data-scrollbar>
                <div id="time-container" class="d-flex flex-column gap-4"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('pages.admin.schedule.style')
@include('pages.admin.schedule.script')
