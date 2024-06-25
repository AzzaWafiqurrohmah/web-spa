@extends('layouts.app')
@section('content')
    <title>Presence</title>
    <div class="row">
        <div class="col-md-10">
            <div class="mt-0 mb-3 ">
                <h2>Presensi</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item">Presence</li>
                    </ol>
                </nav>
            </div>
            <div class="card">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'id',
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: "prev next",
                center: "title",
                right: "dayGridMonth",
            },

        });

        function renderEvents() {
            $.ajax({
                url: 'presences/show',
                dataType: 'json',
                method: 'get',
                success(res) {
                    Object.values(res.data).forEach((presence) => {
                        calendar.addEvent({
                            id: presence.id,
                            title: presence.status,
                            start: presence.date,
                            color: getColor(presence.status),
                            textColor: textColor(presence.status)
                        });
                    });
                },
            });
        }

        function getColor(status) {
            switch (status) {
                case 'full':
                    return '#8FF58D';
                case 'half':
                    return '#FDFFA2';
                case 'absent':
                    return '#7CE5F3';
                default:
                    return '#FF6D6D';
            }
        }

        function textColor(status) {
            switch (status) {
                case 'full':
                    return '#297B1C';
                case 'half':
                    return '#FFA800';
                case 'absent':
                    return '#2D9393';
                default:
                    return '#AE3D3D';
            }
        }

        calendar.render();
        renderEvents();

    </script>
@endpush
