<div class="modal fade" id="customer-modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="card">
                <div class="card-body pt-2">
                    <ul class="nav nav-tabs nav-tabs-bordered" style="align-items: center">

                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Detail Diri</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Alamat</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Detail Alamat</button>
                        </li>

                    </ul>
                <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview" style="text-align: center">
                        <div class="modal-body p-1" style="text-align: left">
                            <div class="mb-3">
                                <small for="nik" class="form-label">ID Pelanggan</small>
                                <div class="card" style="padding-top: 5px; padding-left: 10px; padding-right: 10px">
                                    <small class="mb-1" id="customer_id"></small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <small for="nama" class="form-label">ID Member</small>
                                <div class="card" style="padding-top: 5px; padding-left: 10px; padding-right: 10px">
                                    <small class="mb-1" id="member_id"></small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <small for="nama" class="form-label">Nama Lengkap</small>
                                <div class="card" style="padding-top: 5px; padding-left: 10px; padding-right: 10px">
                                    <small class="mb-1" id="fullname"></small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <small for="nama" class="form-label">Tanggal Lahir</small>
                                <div class="card" style="padding-top: 5px; padding-left: 10px; padding-right: 10px">
                                    <small class="mb-1" id="birth_date"></small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <small for="nama" class="form-label">Jenis Kelamin</small>
                                <div class="card" style="padding-top: 5px; padding-left: 10px; padding-right: 10px">
                                    <small class="mb-1" id="gender"></small>
                                </div>
                            </div>
                        </div>

                </div>

                <div class="tab-pane fade profile-edit pt-2" id="profile-edit">

                    <div class="col-lg-12" style="">
                        <div class="p-2" style="text-align: center" >
                            <label class="image-preview mb-0" for="home_pict">
                                <input type="file" name="home_pict" id="home_pict" class="d-none" accept="image/*" disabled>
                            </label>
                            <small class="justify-content-center mt-1" style="color: #ADADAD">Gambar Rumah</small>
                        </div>

                        <div class="mt-2" style="text-align: left">
                            <div class="mb-3 d-flex gap-3 ">
                            <span class="d-flex align-items-center justify-content-center bg-light rounded-3 p-2 m-0" >
                                <i class="bx bx-home fs-5" style="color: #FFA800"></i>
                            </span>
                                <div class="d-inline-block v-middle ps-0">
                                    <h6 class="mb-0" style="font-family: 'Poppins',sans-serif; font-size: 12px; color: #ADADAD"> Detail Rumah </h6>
                                    <span class=" mt-0 d-block text-dark fw-bold" style="font-family: 'Poppins',sans-serif;font-size: 14px;" id="home_details"></span>
                                </div>
                            </div>

                            <div class="mb-3 d-flex gap-3 ">
                                <span class="d-flex align-items-center justify-content-center bg-light rounded-3 p-2 m-0" >
                                    <i class="bx bx-map fs-5" style="color: #FFA800"></i>
                                </span>
                                <div class="d-inline-block v-middle ps-0">
                                    <h6 class="mb-0" style="font-family: 'Poppins',sans-serif; font-size: 12px; color: #ADADAD"> Detail Alamat </h6>
                                    <span class=" mt-0 d-block text-dark fw-bold" style="font-family: 'Poppins',sans-serif;font-size: 14px;" id="address"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="tab-pane fade pt-1" id="profile-change-password">
                    <small style="display: block; text-align: center; color: #ADADAD" >Detail lokasi rumah</small>
                    <div id="map">
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <input type="hidden" id="latOffice" name="latOffice">
                        <input type="hidden" name="lngOffice" id="lngOffice">
                    </div>

                    <div class="d-flex justify-content-between align-items-center" style="padding-left: 10px; padding-right: 10px">
                        <div class="mb-0 d-flex gap-3 ">
                            <span class="d-flex align-items-center justify-content-center bg-light rounded-3 p-2 m-0" >
                                <i class="bx bx-user fs-5" style="color: #FFA800"></i>
                            </span>
                        </div>
                        <small class="text-center" id="distance"></small>
                        <div class="mb-0 d-flex gap-3 ">
                            <span class="d-flex align-items-center justify-content-center bg-light rounded-3 p-2 m-0" >
                                <i class="bx bx-building fs-5" style="color: #FFA800"></i>
                            </span>
                        </div>
                    </div>

                </div>

            </div>
        </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>

        $('#customer-modal').on('shown.bs.modal', function (event) {
            const latitude = document.getElementById('latitude').value;
            const longitude = document.getElementById('longitude').value;

            const latOffice = document.getElementById('latOffice').value;
            const lngOffice = document.getElementById('lngOffice').value;

            var point1 = L.latLng(latOffice, lngOffice);
            var point2 = L.latLng(latitude, longitude);
            var distance = point1.distanceTo(point2);
            document.getElementById('distance').textContent = (distance/1000).toLocaleString('id-ID', { minimumFractionDigits: 2 }) + " km" ;


            var map = L.map('map').setView([latitude, longitude], 14);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            L.marker([ latitude, longitude]).addTo(map);
        });
    </script>
@endpush
