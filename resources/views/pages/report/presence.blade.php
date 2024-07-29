@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-11">
        <div class="mt-0 mb-3">
            <h2>Laporan Kehadiran</h2>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item">Laporan</li>
                    <li class="breadcrumb-item">Kehadiran</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-9">
        <div class="card mb-2">
            <div class="card-body row justify-content-end">
                <div class="col-md-5 row">
                    <div class="col-md-4">
                        <select id="year" class="form-control">
                            @for ($i = 0; $i <= 4; $i++)
                            @php $tyear = date('Y') - $i @endphp
                            <option value="{{ $tyear }}" @selected($year == $tyear)>
                                {{ $tyear }}
                            </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" id="month">
                            @foreach (months() as $index => $name)
                            <option value="{{ $index }}" @selected($month == $index)>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-hover" id="report-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Terapis</th>
                            <th>Hadir</th>
                            <th>Absen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($therapists as $therapist)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $therapist->fullname }}</td>
                            <td>{{ $therapist->present }} kali</td>
                            <td>{{ $therapist->absent }} kali</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    const pageParams = new URLSearchParams(window.location.search);

    $('#report-table').DataTable();

    $('#year').change(() => {
        pageParams.set('y', $('#year').val());
        window.location.search = pageParams.toString();
    });

    $('#month').change(() => {
        pageParams.set('m', $('#month').val());
        window.location.search = pageParams.toString();
    });
</script>
@endpush
