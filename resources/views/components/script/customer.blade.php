@push('script')
    <script>
        const customersTable = $('#customers-table').DataTable({
            serverSide: true,
            rendering: true,
            ajax: '{{ route('customers.datatables') }}',
            columns: [
                {data: 'id'},
                {data: 'fullname', name: 'fullname'},
                {data: 'birth_date', orderable: false},
                {data: 'member'},
                {data: 'action', orderable: false, searchable: false},
            ],
        });

        $('#month').change(function () {
            let month = this.value;
            customersTable.settings()[0].ajax = {
                url: `/customers/${month}/birthdate`,
                type: 'POST' // Set the method here
            };
            customersTable.ajax.reload();
        });


        $('#customers-table').on('click', '.btn-edit', function (e) {
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
                        text: err,
                        timer: 1500,
                    });
                },
            });
        }

        $('#customers-table').on('click', '.btn-delete', function (e) {
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

        $('#customers-table').on('click', '.btn-detail', function (e) {
            // console.log($(this).data('id'));
            ID = this.dataset.id;
            customerModal.show();
        });


        function member(id) {
            $.ajax({
                url: `/customers/${id}/member`,
                method: 'POST',
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
                        text: err,
                        timer: 1500,
                    });
                },
            });
        }


        $('#customers-table').on('click', '.btn-member', function (e) {
            Swal.fire({
                icon: 'question',
                text: 'Apakah anda ingin menambahkan menjadi member?',
                showCancelButton: true,
                cancelButtonText: 'Batal',
            }).then((res) => {
                if (res.isConfirmed)
                    // console.log(this.dataset.id);
                    member(this.dataset.id);
            });

        });

    </script>
@endpush
