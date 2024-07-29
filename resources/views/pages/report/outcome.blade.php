@extends('layouts.app')

@php $grandTotals = 0; @endphp

@section('content')
<div class="row">
    <div class="col-md-11">
        <div class="mt-0 mb-3">
            <h2>Laporan Pengeluaran</h2>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item">Laporan</li>
                    <li class="breadcrumb-item">Pengeluaran</li>
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
    <div class="col-md-3 d-flex justify-content-center align-items-center">
        <button id="btn-export" class="btn btn-primary mb-2"><i class="fas fa-upload me-1"></i> Ekspor</button>
    </div>
</div>

<div class="row mb-5">
    <div class="col-md-9">
        <div class="card mb-2">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="report-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Terapis</th>
                                <th>Total Reservasi</th>
                                <th>Total</th>
                                <th>Uang Makan</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $dt)

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $dt->fullname }}</td>
                                <td>{{ $dt->reservations->count() }} kali</td>
                                <td>Rp {{ number_format($dt->reservations->sum('totals')) }}</td>
                                <td>Rp {{ number_format($dt->meal) }}</td>
                                <td>Rp {{ number_format($dt->meal + $dt->reservations->sum('totals')) }}</td>
                            </tr>

                            @php
                                $grandTotals += $dt->reservations->sum('totals') + $dt->meal;
                            @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">Grand Total</td>
                                <td>Rp {{ number_format($grandTotals) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="m-0">Total Pengeluaran</h5>
                <hr class="mt-2 mb-0">
                <p class="m-0" style="font-weight: bold; font-size: 2rem;">Rp {{ number_format($grandTotals) }}</p>
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

    $('#btn-export').click(function() {
        document.location.href = '{{ route('reports.outcome.export') }}?' + encodeURI(pageParams.toString());
    });
</script>
@endpush
