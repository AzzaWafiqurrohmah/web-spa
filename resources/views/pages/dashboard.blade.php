@extends('layouts.app')
@section('content')
<title>Volt Laravel Dashboard</title>
<div class=" mt-4 row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow" style="background-color: #fac0b9">
            <div class="card-header d-sm-flex flex-row align-items-center flex-0">
                <div class="d-block mb-3 mb-sm-0">
                    <div class="fs-5 fw-normal mb-1">Total Pendapatan</div>
                    <h3 class="fs-3 fw-bold">{{ $thisMonth }}</h3>
                    <div class="small mt-2">
                        <span class="fw-normal me-2">Bulan ini</span>
                        @if($condition == 'minus')
                            <span class="fas fa-angle-down text-danger"></span>
                            <span class="text-danger fw-bold">{{ $incomePercentage }}</span>
                        @else
                            <span class="fas fa-angle-up text-success"></span>
                            <span class="text-success fw-bold">{{ $incomePercentage }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body p-2">
                <div class="ct-chart-sales-value ct-double-octave ct-series-g"></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-4 mb-4">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row d-block d-xl-flex align-items-center">
                    <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                        <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                            <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                        </div>
                        <div class="d-sm-none">
                            <h2 class="fw-extrabold h5">Pelanggan</h2>
                            <h3 class="mb-1"> {{ $customer }} </h3>
                        </div>
                    </div>
                    <div class="col-12 col-xl-7 px-xl-0">
                        <div class="d-none d-sm-block">
                            <h2 class="h6 text-gray-400 mb-0">Pelanggan</h2>
                            <h3 class="fw-extrabold mb-2">{{ $customer }} </h3>
                        </div>
                        <div class="small d-flex mt-1">
                            <div>Total seluruh pelanggan </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-4 mb-4">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row d-block d-xl-flex align-items-center">
                    <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                        <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                            <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                        </div>
                        <div class="d-sm-none">
                            <h2 class="fw-extrabold h5">Terapis</h2>
                            <h3 class="mb-1">{{ $therapist }}</h3>
                        </div>
                    </div>
                    <div class="col-12 col-xl-7 px-xl-0">
                        <div class="d-none d-sm-block">
                            <h2 class="h6 text-gray-400 mb-0">Terapis</h2>
                            <h3 class="fw-extrabold mb-2">{{ $therapist }}</h3>
                        </div>
                        <div class="small d-flex mt-1">
                            <div>Total seluruh terapis</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-4 mb-4">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row d-block d-xl-flex align-items-center">
                    <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                        <div class="icon-shape icon-shape-secondary rounded me-4 me-sm-0">
                            <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg>
                        </div>
                        <div class="d-sm-none">
                            <h2 class="fw-extrabold h5"> Reservasi </h2>
                            <h3 class="mb-1">50.88%</h3>
                        </div>
                    </div>
                    <div class="col-12 col-xl-7 px-xl-0">
                        <div class="d-none d-sm-block">
                            <h2 class="h6 text-gray-400 mb-0"> Reservasi </h2>
                            <h3 class="fw-extrabold mb-2">{{ $reservation }}</h3>
                        </div>
                        <div class="small d-flex mt-1">
                            <div>Bulan ini
                                @if($rsvCondition == 'minus')
                                    <span class="fas fa-angle-down text-danger"></span>
                                    <span class="text-danger fw-bold">{{ $rsvPercentage }}</span>
                                @else
                                    <span class="fas fa-angle-up text-success"></span>
                                    <span class="text-success fw-bold">{{ $rsvPercentage }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-xl-8">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="fs-5 fw-bold mb-0">Terapis Ter - Aktif</h2>
                            </div>
                            <div class="col text-end">
                                <small>Bulan ini</small>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th class="border-bottom" style="width: 400px" scope="col">Nama Terapis</th>
                                <th class="border-bottom text-center" scope="col">Total Reservasi</th>
                                <th class="border-bottom text-end" scope="col">Total Gaji / Pendapatan</th>
{{--                                <th class="border-bottom" scope="col">Persentase</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($actTherapist as $therapist)
                                <tr>
                                    <th class="text-gray-900" style="width: 400px" scope="row">
                                        {{ $therapist->fullname }}
                                    </th>
                                    <td class="fw-bolder text-gray-500 text-center">
                                        {{ $therapist->reservations->count() }}  Reservasi
                                    </td>
                                    <td class="fw-bolder text-gray-500 text-end">
                                        {{ 'Rp ' . number_format($therapist->reservations->sum('totals')) }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-4">
        <div class="col-12 px-0 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header d-flex flex-row align-items-center flex-0 border-bottom">
                    <div class="d-block">
                        <div class="h6 fw-normal text-gray mb-2">Total Reservasi</div>
                        <h2 class="h3 fw-extrabold">{{ $reservation }}</h2>
                        <div class="small mt-2">
                            @if($rsvCondition == 'minus')
                                <span class="fas fa-angle-down text-danger"></span>
                                <span class="text-danger fw-bold">{{ $rsvPercentage }}</span>
                            @else
                                <span class="fas fa-angle-up text-success"></span>
                                <span class="text-success fw-bold">{{ $rsvPercentage }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="d-block ms-auto">
                        <div class="d-flex align-items-center text-end mb-2">
                            <span class="dot rounded-circle bg-gray-800 me-2"></span>
                            <span class="fw-normal small">2 Minggu Awal</span>
                        </div>
                        <div class="d-flex align-items-center text-end">
                            <span class="dot rounded-circle bg-secondary me-2"></span>
                            <span class="fw-normal small">2 Minggu Akhir</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-2">
                    <div class="ct-chart-ranking ct-golden-section ct-series-a"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        if(d.querySelector('.ct-chart-sales-value')) {
            $.ajax({
                url: `{{ route('dashboard.adminChart') }}`,
                method: 'GET',
                success(res) {
                    let month = [];
                    let totals = [];
                    res.data.forEach(function (item){
                        month.push(item.month);
                        totals.push(item.total);
                    })
                    chartMaker(month, totals);
                }
            });
        }

        function chartMaker( month, total){
            new Chartist.Line('.ct-chart-sales-value', {
                labels: month,
                series: [
                    total
                ]
            }, {
                low: 0,
                showArea: true,
                fullWidth: true,
                plugins: [
                    Chartist.plugins.tooltip()
                ],
                axisX: {
                    // On the x-axis start means top and end means bottom
                    position: 'end',
                    showGrid: true
                },
                axisY: {
                    // On the y-axis start means left and end means right
                    showGrid: false,
                    showLabel: false,
                    labelInterpolationFnc: function(value) {
                        return '$' + (value / 1) + 'k';
                    }
                }
            });
        }

        if(d.querySelector('.ct-chart-ranking')) {
            $.ajax({
                url: `{{ route('dashboard.adminRanking') }}`,
                method: 'GET',
                success(res) {
                    let month = res.data.month;
                    let first = res.data.first;
                    let second = res.data.second;

                    adminRanking(month, first, second);
                }
            });
        }

        function adminRanking(month, first, second){
            var chart = new Chartist.Bar('.ct-chart-ranking', {
                labels: month,
                series: [
                    first,
                    second,
                ]
            }, {
                low: 0,
                showArea: true,
                plugins: [
                    Chartist.plugins.tooltip()
                ],
                axisX: {
                    // On the x-axis start means top and end means bottom
                    position: 'end'
                },
                axisY: {
                    // On the y-axis start means left and end means right
                    showGrid: false,
                    showLabel: false,
                    offset: 0
                }
            });

            chart.on('draw', function(data) {
                if(data.type === 'line' || data.type === 'area') {
                    data.element.animate({
                        d: {
                            begin: 2000 * data.index,
                            dur: 2000,
                            from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
                            to: data.path.clone().stringify(),
                            easing: Chartist.Svg.Easing.easeOutQuint
                        }
                    });
                }
            });
        }

    </script>
@endpush
