@extends('layouts.app')
@section('content')
    <title>Packet Treatment</title>
    <div class="row">
        <div class="col-md-8">
            <div class="mt-0 mb-3">
                <h2>Daftar Paket Treatment</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item">Paket Treatment</li>
                    </ol>
                </nav>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-4">
                        <div style="align-items: center">
                            <button class="btn btn-warning" id="import" name="import">Import</button>
                            <button class="btn btn-success" id="export" name="export">Export</button>
                        </div>
                        <div >
                            <button class="btn btn-primary" id="newMaterial" name="newMaterial">Tambah Paket</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="packets-table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Paket</th>
                                <th>Harga Normal</th>
                                <th>Harga Member</th>
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

@include('components.script.packet')
@include('components.modal.packetImport')

@push('script')
    <script>
        const importModal = new bootstrap.Modal('#packet-modal-import');
        function saveFile(){
            var formData = new FormData();
            var fileInput = document.getElementById('fileImport');

            if (fileInput.files.length === 0) {
                console.log('iya');
                Swal.fire({
                    icon: 'error',
                    text: 'Silakan pilih file sebelum mengunggah',
                    timer: 1500,
                });
                return;
            }

            formData.append('fileImport', fileInput.files[0]);

            $.ajax({
                url: '/packets/import',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success(res) {
                    materialTable.ajax.reload();
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
                        text: 'Terdapat masalah saat melakukan aksi',
                        timer: 1500,
                    });
                },
            });
        }

        $('#packet-modal-import').on('show.bs.modal', function (event) {
            $('#packet-import-title').text('Import File Paket Treatment');
        });

        $('#import').on('click', function (e) {
            importModal.show();
        });

        $('#export').on('click', function (e) {
            $.ajax({
                url: `/packets/export`,
                method: 'GET',
                success(res) {

                    if(res.data == 'empty'){
                        Swal.fire({
                            icon: 'warning',
                            text: 'Data Paket Treatment masih kosong',
                            timer: 3000,
                        });
                    } else {
                        window.location.href = '/packets/export';
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
    </script>
    
@endpush
