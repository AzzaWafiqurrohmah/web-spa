@push('script')
    <script>
        const adminTable = $('#admin-table').DataTable({
            serverSide: true,
            rendering: true,
            ajax: '{{ route('admin.datatables') }}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'franchise_name'},
                {data: 'action', orderable: false, searchable: false},
            ],
        });

        const adminModal = new bootstrap.Modal('#admin-modal');
        let editID = 0;


        function fillForm() {
            $.ajax({
                url: `/admin/${editID}`,
                success: (res) => fillFormdata(res.data),
            });
        }

        function saveItem() {
            const url = editID != 0 ?
                `/admin/${editID}/update` :
                `/admin/store`;

            const method = editID != 0 ? 'PUT' : 'POST';

            $.ajax({
                url,
                method,
                data: $('#admin-form').serialize(),
                success(res) {
                    adminTable.ajax.reload();
                    adminModal.hide();


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
                url: `/admin/${id}`,
                method: 'DELETE',
                success(res) {
                    adminTable.ajax.reload();

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

        $('#admin-modal').on('show.bs.modal', function (event) {
            $('#admin-modal-title').text(editID ? 'Edit Data Admin' : 'Tambah Data Admin');
            if (editID != 0) {
                fillForm();

                $.get(`/admin/${editID}`, function(data) {
                    appendOption(data.data.franchise_id);
                });
            }
        });

        function appendOption(selectedOption)
        {
            $.get('/franchises/json', function(data) {
                $('#franchise_id').empty();
                $.each(data.data, function(key, value) {
                    var selected = (value.id === selectedOption) ? 'selected' : '';
                    $('#franchise_id').append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
                });
            });
        }

        $('#admin-modal').on('hidden.bs.modal', function (event) {
            editID = 0;

            removeFormErrors();
            $('#admin-form').trigger('reset');
        });

        $('#admin-form').submit(function (e) {
            e.preventDefault();

            removeFormErrors();
            saveItem();
        });

        $('#admin-table').on('click', '.btn-edit', function (e) {
            editID = this.dataset.id;
            adminModal.show();
        });

        $('#newAdmin').on('click', function (e) {
            adminModal.show();
        });


        $('#admin-table').on('click', '.btn-delete', function (e) {
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
