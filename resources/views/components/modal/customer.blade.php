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

                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                    <div >
                        <div class="col-lg-12 col-md-12 mb-2">
                        <label >Nama Lengkap</label>
                            <div class="card" style="padding-top: 5px; padding-left: 10px; padding-right: 10px">
                                <p id="fullname"></p>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 mb-2" >
                            <label >Tanggal Lahir</label>
                            <div class="card" style="padding-top: 5px; padding-left: 10px; padding-right: 10px">
                                <p id="birth_date"></p>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 mb-2">
                            <label >Nomor Telepon</label>
                            <div class="card" style="padding-top: 5px; padding-left: 10px; padding-right: 10px">
                                <p id="phone"></p>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 mb-2">
                            <label >Jenis Kelamin</label>
                            <div class="card" style="padding-top: 5px; padding-left: 10px; padding-right: 10px">
                                <p id="gender"></p>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 mb-2">
                            <label >Member Id</label>
                            <div class="card" style="padding-top: 5px; padding-left: 10px; padding-right: 10px">
                                <p id="member_id"></p>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 mb-2">
                            <label >Tanggal Aktif</label>
                            <div class="card" style="padding-top: 5px; padding-left: 10px; padding-right: 10px">
                                <p id="start_member"></p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="tab-pane fade profile-edit pt-2" id="profile-edit">

                    <div class="col-lg-12" style="">
                        <div class="mb-4">
                            <label for="address">Alamat Lengkap</label>
                            <div class="card" style="padding-top: 5px; padding-left: 10px; padding-right: 10px">
                                <p id="address"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-7" >
                                <label for="home_pict" class="form-label">Foto Depan Rumah</label>
                                <label class="image-preview" for="home_pict" style="background-image:none; aspect-ratio: 2/2;">
                                    <input type="file" name="home_pict" id="home_pict" class="d-none" accept="image/*">
                                </label>
                            </div>
                            <div class="col-lg-5" >
                                <label for="home_details">Detail Rumah</label>
                                <div class="card" style="padding-top: 5px; padding-left: 10px; padding-right: 10px">
                                    <p id="home_details"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="tab-pane fade pt-2" id="profile-change-password">
                    <label for="map" style="margin-bottom: 10px; margin-left: 5px">Detail lokasi rumah</label>
                    <div id="map">
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <input type="hidden" id="latOffice" name="latOffice">
                        <input type="hidden" name="lngOffice" id="lngOffice">
                    </div>

                    <div class="d-flex justify-content-between align-items-center" style="padding-left: 10px; padding-right: 10px">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-fill" style="font-size: 1.5rem;"></i>
                        </div>
                        <h5 class="text-center" id="distance"></h5>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-building" style="font-size: 1.5rem;"></i>
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
