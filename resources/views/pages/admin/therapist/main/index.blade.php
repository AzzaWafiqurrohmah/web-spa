@extends('layouts.app')
@section('content')
    <title>Therapist</title>
    <div class="row">
        <div class="col-md-9">
            <div class="mt-5 mb-3" >
                <h2>Daftar Terapis</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item">Therapist</li>
                    </ol>
                </nav>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-4">
                        <div style="">
                            <form action="" method="GET">
                                <select class="form-select float-left" id="month" name="month" aria-label="Default select example">
                                    <option selected>-- Pilih Bulan Lahir --</option>
                                    @foreach($months as $month)
                                        <option value="{{$month->format('m')}}" {{ request('month') == $month->format('m') ? 'selected' : '' }} >{{$month->format('F')}}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        <div>
                            <a href="{{route('therapists.create')}}" class="btn btn-primary">Tambah Terapis</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="therapist-table">
                            <thead>
                            <tr>
                                <th>ID Terapis</th>
                                <th>Nama Lengkap</th>
                                <th>Tanggal Lahir</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        const therapistTable = $('#therapist-table').DataTable({
            serverSide: true,
            rendering: true,
            ajax: '{{ route('therapists.datatables') }}',
            columns: [
                {data: 'id'},
                {data: 'fullname', name: 'fullname'},
                {data: 'birth_date'},
                {data: 'action', orderable: false, searchable: false},
            ],
        });


        $('#therapist-table').on('click', '.btn-edit', function(e) {
            window.location.href = "{{ route('therapists.edit', 'VALUE') }}".replace('VALUE', $(this).data('id'));
        });

        function deleteItem(id) {
            $.ajax({
                url: `/therapists/${id}`,
                method: 'DELETE',
                success(res) {
                    therapistTable.ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        text: res.meta.message,
                        timer: 1500,
                    });
                },
                error(err) {
                    Swal.fire({
                        icon: 'error',
                        text: err ,
                        timer: 1500,
                    });
                },
            });
        }

        $('#therapist-table').on('click', '.btn-delete', function(e) {
            Swal.fire({
                icon: 'question',
                text: 'Apakah anda yakin?',
                showCancelButton: true,
                cancelButtonText: 'Batal',
            }).then((res) => {
                if(res.isConfirmed)
                    deleteItem(this.dataset.id);
            });
        });

    </script>
@endpush
