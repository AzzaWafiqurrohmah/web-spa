@extends('layouts.app')
@section('content')
<title>Customer</title>
<div class="row">
    <div class="col-md-10">
        <div class="mt-5 mb-3" >
            <h1>Data pelanggan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item">Customer</li>
                </ol>
            </nav>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-4">
                    <div>
                        <a href="{{route('customers.create')}}" class="btn btn-primary">New User</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="customers-table">
                        <thead>
                        <tr>
                            <th>ID customer</th>
                            <th>Nama Lengkap</th>
                            <th>No Telp</th>
                            <th>Member</th>
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
    @include('components.customerModal')
@endsection

@push('script')
    <script>
        const customersTable = $('#customers-table').DataTable({
            serverSide: true,
            rendering: true,
            ajax: '{{ route('customers.datatables') }}',
            columns: [
                {data: 'id'},
                {data: 'fullname', name: 'fullname'},
                {data: 'phone', name: 'phone'},
                {data: 'member'},
                {data: 'action', orderable: false, searchable: false},
            ],
        });


        $('#customers-table').on('click', '.btn-edit', function(e) {
            window.location.href = "{{ route('customers.edit', 'VALUE') }}".replace('VALUE', $(this).data('id'));
        });

        function deleteItem(id) {
            $.ajax({
                url: `/customers/${id}`,
                method: 'DELETE',
                success(res) {
                    customersTable.ajax.reload();

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

        $('#customers-table').on('click', '.btn-delete', function(e) {
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

        const customerModal = new bootstrap.Modal('#customer-modal');
        // let editID = 0;

        let ID = 0;
        function fillForm() {
            $.ajax({
                url: `/customers/${ID}`,
                success: (res) => fillFormdata(res.data),
            });
        }

        $('#customer-modal').on('show.bs.modal', function (event) {
            fillForm();
        });

        $('#customers-table').on('click', '.btn-detail', function(e) {
            // console.log($(this).data('id'));
            ID = this.dataset.id;
            customerModal.show();
        });

    </script>
@endpush
