@push('script')
    <script>
        let url = '/therapist/customers/datatables';
        @can('crud customers')
            url = '{{ route('customers.datatables') }}';
        @endcan
        const columns = [
            { data: 'id' },
            { data: 'fullname', name: 'fullname' },
                @can('crud customers')
                    { data: 'birth_date' },
                @endcan
            { data: 'member' },
            { data: 'action', orderable: false, searchable: false }
        ];

        const customersTable = $('#customers-table').DataTable({
            serverSide: true,
            rendering: true,
            ajax: url,
            columns: columns.filter(column => column !== undefined),
        });

        $('#month').change(function () {
            let month = this.value;
            customersTable.settings()[0].ajax = {
                url: `/customers/${month}/birthdate`,
                type: 'POST'
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
            console.log(ID);
            let action = `/therapist/customers/${ID}`;
            @can('crud treatments')
                action = `/customers/${ID}`;
            @endcan
            $.ajax({
                url: action,
                success: (res) =>
                    fillFormdata(res.data),
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

        $('#export').on('click', function (e) {
            $.ajax({
                url: `/customers/export`,
                method: 'GET',
                success(res) {

                    if(res.data == 'empty'){
                        Swal.fire({
                            icon: 'warning',
                            text: 'Data Bahan Treatment masih kosong',
                            timer: 3000,
                        });
                    } else {
                        window.location.href = '/customers/export';
                        Swal.fire({
                            icon: 'success',
                            text: 'Berhasil Mengunduh file',
                            timer: 1500,
                        });
                    }

                },
                error(err) {
                    Swal.fire({
                        icon: 'error',
                        text: 'Terdapat masalah saat melakukan aksi',
                        timer: 1500,
                    });
                },
            });
        });

        const importModal = new bootstrap.Modal('#customer-modal-import');

        $('#customer-modal-import').on('show.bs.modal', function (event) {
            $('#customer-import-title').text('Import File Cutomer');
        });

        $('#import').on('click', function (e) {
            importModal.show();
        });

        $('#customer-form-import').submit(function (e) {
            e.preventDefault();
            removeFormErrors();
            saveFile();
        });

        function saveFile(){
            var formData = new FormData();
            var fileInput = document.getElementById('fileImport');

            if (fileInput.files.length === 0) {
                Swal.fire({
                    icon: 'error',
                    text: 'Silakan pilih file sebelum mengunggah',
                    timer: 1500,
                });
                return;
            }

            formData.append('fileImport', fileInput.files[0]);

            $.ajax({
                url: '/customers/import',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success(res) {
                    customersTable.ajax.reload();
                    importModal.hide();

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
                        text: 'Heading harus berupa "Nama Bahan"',
                        timer: 1500,
                    });
                },
            });
        }

    </script>
@endpush
