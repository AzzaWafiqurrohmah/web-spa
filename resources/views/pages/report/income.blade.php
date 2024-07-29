@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-11">
        <div class="mt-0 mb-3">
            <h2>Laporan Pendapatan</h2>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item">Laporan</li>
                    <li class="breadcrumb-item">Pendapatan</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-md-9">
        <div class="card">
            <div class="card-body row justify-content-between">
                <div class="col-md-3">
                    <select id="therapist" class="form-control">
                        <option value="">Semua Terapis</option>
                    </select>
                </div>

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
        <button id="btn-export" class="btn btn-primary"><i class="fas fa-upload me-1"></i> Ekspor</button>
    </div>
</div>

<div class="row mb-5">
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="report-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Terapis</th>
                                <th>Customer</th>
                                <th>Tanggal</th>
                                <th>Reservasi</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservations as $rsv)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $rsv->therapist->fullname }}</td>
                                <td>{{ $rsv->customer->fullname }}</td>
                                <td>{{ $rsv->date->format('d/m/Y') }}</td>
                                <td>{{ $rsv->total_packets }} paket, {{ $rsv->total_treatments }} treatment</td>
                                <td>Rp {{ number_format($rsv->totals) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">Grand Total</td>
                                <td>{{ $reservations->count() }} reservasi</td>
                                <td>Rp {{ number_format($reservations->sum('totals')) }}</td>
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
                <h5 class="m-0">Total Pendapatan</h5>
                <hr class="mt-2 mb-0">
                <p class="m-0" style="font-weight: bold; font-size: 2rem;">Rp {{ number_format($reservations->sum('totals')) }}</p>
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

    $('#btn-export').click(function() {
        document.location.href = '{{ route('reports.income.export') }}?' + encodeURI(pageParams.toString());
    });

    $('#therapist').change(() => {
        pageParams.set('t', $('#therapist').val());
        window.location.search = pageParams.toString();
    });

    @if($therapist)
    $('#therapist').append(`
        <option value="{{ $therapist->id }}" selected>{{ $therapist->fullname }}</option>
    `);
    @endif

    $('#therapist').select2({
        ajax: {
            url: '{{ route('select2.therapists') }}',
            processResults: (data) => {
                data.unshift({ id: '', text: 'Semua Terapis' });
                return {
                    results: data
                }
            }
        }
    });
</script>
@endpush
