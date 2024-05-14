@extends('layouts.app')
@section('content')
    <title>Treatment</title>
    <div class="row">
        <div class="col-md-9">
            <div class="mt-5 mb-3" >
                <h3>Daftar Treatment</h3>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item">Treatment</li>
                    </ol>
                </nav>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-4">
                        <div>
                            <a href="{{route('treatments.create')}}" class="btn btn-primary">Tambah Treatment</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="treatments-table">
                            <thead>
                            <tr>
                                <th>ID Treatment</th>
                                <th>Nama</th>
                                <th>Durasi (menit)</th>
                                <th>Harga</th>
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
        const treatmentTable = $('#treatments-table').DataTable({
            serverSide: true,
            rendering: true,
            ajax: '{{ route('treatments.datatables') }}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'duration', name: 'duration'},
                {data: 'price', name: 'price'},
                {data: 'action', orderable: false, searchable: false},
            ],
        });


        $('#newTreatment').on('click', function (e) {
            treatmentModal.show();
        });

        $('#treatments-table').on('click', '.btn-edit', function(e) {
            window.location.href = "{{ route('treatments.edit', 'VALUE') }}".replace('VALUE', $(this).data('id'));
        });

        function deleteItem(id) {
            $.ajax({
                url: `/treatments/${id}`,
                method: 'DELETE',
                success(res) {
                    treatmentTable.ajax.reload();

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

        $('#treatments-table').on('click', '.btn-delete', function (e){
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
