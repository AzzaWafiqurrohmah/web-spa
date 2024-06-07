@extends('layouts.app')
@section('content')
    <title>Treatment</title>
    <div class="row">
        <div class="col-md-8">
            <div class="mt-5 mb-3">
                <h2>Daftar Bahan Treatment</h2>
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
                            <button class="btn btn-primary" id="newMaterial" name="newMaterial">New Material</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="materials-table">
                            <thead>
                            <tr>
                                <th>ID Bahan</th>
                                <th>Nama Bahan</th>
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
    @include('components.modal.material')
@endsection

@push('script')
    <script>
        const materialTable = $('#materials-table').DataTable({
            serverSide: true,
            rendering: true,
            ajax: '{{ route('materials.datatables') }}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'action', orderable: false, searchable: false},
            ],
        });

        const materialModal = new bootstrap.Modal('#material-modal');
        let editID = 0;

        function fillForm() {
            $.ajax({
                url: `/materials/${editID}`,
                success: (res) => fillFormdata(res.data),
            });
        }

        function saveItem() {
            const url = editID != 0 ?
                `/materials/${editID}/update` :
                `/materials/store`;

            const method = editID != 0 ? 'PUT' : 'POST';

            $.ajax({
                url,
                method,
                data: $('#material-form').serialize(),
                success(res) {
                    materialTable.ajax.reload();
                    materialModal.hide();


                    Swal.fire({
                        icon: 'success',
                        text: res.meta.message,
                        timer: 1500,
                    });
                },
                error(err) {
                    if (err.status == 422) {
                        displayFormErrors(err.responseJSON.data);
                        return;
                    }

                    Swal.fire({
                        icon: 'error',
                        text: 'Terdapat masalah saat melakukan aksi',
                        timer: 1500,
                    });
                },
            });
        }

        function deleteItem(id) {
            $.ajax({
                url: `/materials/${id}`,
                method: 'DELETE',
                success(res) {
                    materialTable.ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        text: res.meta.message,
                        timer: 1500,
                    });
                },
                error(err) {
                    Swal.fire({
                        icon: 'error',
                        text: 'Terdapat masalah saat melakukan aksi',
                        timer: 1500,
                    });
                },
            });
        }

        $('#material-modal').on('show.bs.modal', function (event) {
            $('#material-modal-title').text(editID ? 'Edit Bahan Treatment' : 'Tambah Bahan Treatment');
            if (editID != 0)
                fillForm();
        });

        $('#material-modal').on('hidden.bs.modal', function (event) {
            editID = 0;

            removeFormErrors();
            $('#material-form').trigger('reset');
        });

        $('#material-form').submit(function (e) {
            e.preventDefault();

            removeFormErrors();
            saveItem();
        });

        $('#materials-table').on('click', '.btn-edit', function (e) {
            editID = this.dataset.id;
            materialModal.show();
        });

        $('#newMaterial').on('click', function (e) {
            materialModal.show();
        });


        $('#materials-table').on('click', '.btn-delete', function (e) {
            Swal.fire({
                icon: 'question',
                text: 'Apakah anda yakin?',
                showCancelButton: true,
                cancelButtonText: 'Batal',
            }).then((res) => {
                if (res.isConfirmed)
                    deleteItem(this.dataset.id);
            });
        });


    </script>
@endpush
