@push('script')
    <script>
        const adminTable = $('#admin-table').DataTable({
            serverSide: true,
            rendering: true,
            ajax: '{{ route('admin.datatables') }}',
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'name', name: 'name'},
                {data: 'franchise_name'},
                {data: 'action', orderable: false, searchable: false},
            ],
        });


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


        $('#admin-table').on('click', '.btn-edit', function (e) {
            window.location.href = "{{ route('admin.edit', 'VALUE') }}".replace('VALUE', $(this).data('id'));
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
