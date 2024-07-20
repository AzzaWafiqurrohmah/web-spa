@push('script')
    <script>
        const packetsTable = $('#packets-table').DataTable({
            serverSide: true,
            rendering: true,
            ajax: '{{route('packets.datatables')}}',
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'name'},
                {data: 'price'},
                {data: 'member_price'},
                {data: 'action', orderable: false, searchable: false},
            ],
        });

        $('#packets-table').on('click', '.btn-edit', function (e) {
            window.location.href = "{{ route('packets.edit', 'VALUE') }}".replace('VALUE', $(this).data('id'));
        });

        $('#packets-table').on('click', '.btn-delete', function (e) {
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

        function deleteItem(id) {
            $.ajax({
                url: `/packets/${id}`,
                method: 'DELETE',
                success(res) {
                    packetsTable.ajax.reload();

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

    </script>
@endpush
