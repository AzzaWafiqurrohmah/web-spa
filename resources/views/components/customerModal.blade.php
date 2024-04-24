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
                        <input type="text" value="" id="fullname" name="fullname" class="form-control" disabled>
                        </div>

                        <div class="col-lg-12 col-md-12 mb-2" >
                            <label >Tanggal Lahir</label>
                            <input type="text" value="" id="birth_date" name="birth_date" class="form-control" disabled>
                        </div>

                        <div class="col-lg-12 col-md-12 mb-2">
                            <label >Nomor Telepon</label>
                            <input type="text" value="" id="phone" name="phone" class="form-control" disabled>
                        </div>

                        <div class="col-lg-12 col-md-12 mb-2">
                            <label >Jenis Kelamin</label>
                            <input type="text" value="" id="gender" name="gender" class="form-control" disabled>
                        </div>

                        <div class="col-lg-12 col-md-12 mb-2">
                            <label >Member Id</label>
                            <input type="text" value="" id="member_id" name="member_id" class="form-control" disabled>
                        </div>

                        <div class="col-lg-12 col-md-12 mb-2">
                            <label >Tanggal Aktif</label>
                            <input type="text" value="" id="start_member" name="start_member" class="form-control" disabled>
                        </div>
                    </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                    <div class="col-lg-12" style="">
                        <div class="mb-4">
                            <label for="address">Alamat Lengkap</label>
                            <textarea class="form-control" id="address" name="address" style="width: 100%;" rows="4"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-lg-8" >
                                <label for="home_pict" class="form-label">Foto Depan Rumah</label>
                                <label class="image-preview" for="home_pict" style="background-image:none; aspect-ratio: 2/2;">
                                    <input type="file" name="home_pict" id="home_pict" class="d-none" accept="image/*">
                                </label>
                            </div>
                            <div class="col-lg-4" >
                                <label for="home_details">Detail Rumah</label>
                                <textarea class="form-control" id="home_details" name="home_details" style="width: 100%;" rows="4"></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                    <label for="map" style="margin-bottom: 10px">Detail lokasi rumah</label>
                    <div id="map">
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <input type="hidden" id="latOffice" name="latOffice">
                        <input type="hidden" name="lngOffice" id="lngOffice">
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person" style="font-size: 1.5rem;"></i>
                            <small class="ms-2">Label Orang</small>
                        </div>
                        <h5 class="text-center" id="distance"></h5>
                        <div class="d-flex align-items-center">
                            <small class="me-2">Label Kantor</small>
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
            document.getElementById('distance').textContent = (distance/1000).toFixed(2);


            var map = L.map('map').setView([latitude, longitude], 14);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            L.marker([ latitude, longitude]).addTo(map);
        });
    </script>
@endpush
