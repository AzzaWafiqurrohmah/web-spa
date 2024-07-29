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
                    </ol>
                </nav>
            </div>
        </div>
    </div>

{{--    <div class="row mb-2">--}}
{{--        <div class="col-md-9">--}}
{{--            <div class="card">--}}
{{--                <div class="card-body row justify-content-end">--}}
{{--                    <div class="col-md-5 row">--}}
{{--                        <div class="col-md-4">--}}
{{--                            <select id="year" class="form-control">--}}
{{--                                @for ($i = 0; $i <= 4; $i++)--}}
{{--                                    @php $tyear = date('Y') - $i @endphp--}}
{{--                                    <option value="{{ $tyear }}" @selected($year == $tyear)>--}}
{{--                                        {{ $tyear }}--}}
{{--                                    </option>--}}
{{--                                @endfor--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-8">--}}
{{--                            <select class="form-control" id="month">--}}
{{--                                @foreach (months() as $index => $name)--}}
{{--                                    <option value="{{ $index }}" @selected($month == $index)>{{ $name }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-md-3 d-flex justify-content-center align-items-center">--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="row mb-5">
        <div class="col-md-8">
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
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="report-therapist-table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Customer</th>
                                <th>Reservasi</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($therapist[0]->reservation as $rsv)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $rsv->date->format('d/m/Y') }}</td>
                                    <td>{{ $rsv->customer->fullname }}</td>
                                    <td>{{ $rsv->total_packets }} paket, {{ $rsv->total_treatments }} treatment</td>
                                    <td>Rp {{ number_format($rsv->totals) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="3">Grand Total</td>
                                <td>{{ $therapist[0]->reservation->count() }} reservasi</td>
                                <td>Rp {{ number_format($therapist[0]->reservation->sum('totals')) }}</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-2">
                <div class="card-body">
                    <h6 class="m-0">Total Uang Makan</h6>
                    <hr class="mt-2 mb-0">
                    <p class="m-0" style="font-weight: bold; font-size: 1.8rem;"> Rp {{ number_format($therapist[0]->meal)  }}</p>
                </div>
            </div>
            <div class="card mb-2">
                <div class="card-body">
                    <h6 class="m-0">Total Pendapatan Reservasi</h6>
                    <hr class="mt-2 mb-0">
                    <p class="m-0" style="font-weight: bold; font-size: 1.8rem;">Rp {{ number_format($therapist[0]->reservation->sum('totals')) }}</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h6 class="m-0">Total Keseluruhan</h6>
                    <hr class="mt-2 mb-0">
                    <p class="m-0" style="font-weight: bold; font-size: 1.8rem;">Rp {{ number_format($therapist[0]->reservation->sum('totals') + $therapist[0]->meal) }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        const pageParams = new URLSearchParams(window.location.search);

        $('#report-therapist-table').DataTable();

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
