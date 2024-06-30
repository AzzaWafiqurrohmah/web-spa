@extends('layouts.app')
@section('content')
    <title>Presensi</title>
    <div class="mt-0 mb-3">
        <h2>Daftar Kehadiran Terapis</h2>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item">Presence</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-11">
            <div class="card" id="container">
                <ul class="nav nav-pills mb-3 nav-justified p-3" style="display: flex; border: none" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-presence-tab" data-bs-toggle="pill" data-bs-target="#pills-presence" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Presensi Hari Ini</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-presenceAll-tab" data-bs-toggle="pill" data-bs-target="#pills-presenceAll" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Semua Log Presensi</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-presence" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="presence-table">
                                    <thead>
                                    <tr>
                                        <th>ID Terapis</th>
                                        <th>Nama Lengkap</th>
                                        <th>Kehadiran</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-presenceAll" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="presenceAll-table">
                                    <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>ID Terapis</th>
                                        <th>Nama Lengkap</th>
                                        <th>Kehadiran</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .nav-link.active {
            background-color: #e5e7eb !important;
        }
    </style>
@endpush

@push('script')
    <script>
        let presenceTable;
        initPresence();
        function initPresence()
        {
            presenceTable = $('#presence-table').DataTable({
                serverSide: true,
                rendering: true,
                ajax: '{{ route('presences.datatables') }}',
                columns: [
                    {data: 'id'},
                    {data: 'fullname', name: 'fullname'},
                    {data: 'presence'}
                ],
                initComplete: function () {
                    const drdElements = document.querySelectorAll('.dropdown');
                    const drdList = [...drdElements].map(drdToggle => new bootstrap.Dropdown(drdToggle));
                }
            });
        }

        let presenceAllTable;
        function initAllPresence()
        {
            if (!$.fn.dataTable.isDataTable('#presenceAll-table')) {
                presenceAllTable = $('#presenceAll-table').DataTable({
                    serverSide: true,
                    rendering: true,
                    ajax: '{{ route('presences.presenceDatatables') }}',
                    columns: [
                        {data: 'date', name: 'date'},
                        {data: 'id'},
                        {data: 'name'},
                        {data: 'presence'}
                    ],
                    initComplete: function () {
                        dropdown();
                        console.log('Init Dropdown gesss');
                    }
                });
            }
        }

        $('#pills-presenceAll-tab').on('click' ,function (){
            initAllPresence();
        });

        $('#presence-table, #presenceAll-table').on('click', '.presence-item', function(e) {
            update($(this).data('id'), $(this).data('value'));
        });

        function update(id, value)
        {
            $.ajax({
                url: `/presences/${id}/update`,
                dataType: 'JSON',
                method: 'PUT',
                data: {
                    status: value
                },
                success(res) {
                    Swal.fire({
                        icon: 'success',
                        text: res.meta.message,
                        timer: 1500,
                    });

                    presenceTable.ajax.reload();
                    presenceAllTable.ajax.reload();
                }
            });
        }
    </script>
@endpush
