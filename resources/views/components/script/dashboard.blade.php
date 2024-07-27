@push('script')
    <script>
        let role = $('#role').val();
        url = '{{ route('dashboard.adminChart') }}';
        if(role === 'therapist'){
            url = '{{ route('therapist.dashboard.adminChart') }}'
        }
        if(d.querySelector('.ct-chart-sales-value')) {
            $.ajax({
                url: url,
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
