@php
    $customer = $customer ?? null;
@endphp
@csrf
<div class="card">
    <div class="card-body">
        <h4 style="margin-bottom: 20px; margin-left: -5px; font-family: 'Times New Roman', Times, serif; font-weight: bold">Detail Pelanggan</h4>
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-5" style="margin-right: 30px;">
                <div class="mb-4">
                    <label for="fullname">Nama Lengkap</label>
                    <input type="text" name="fullname" class="form-control @error('fullname') is-invalid @enderror"  autofocus>
                    @error('fullname')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="birthday">Tanggal lahir</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        </span>
                        <input data-datepicker="" class="form-control" id="birthday" type="text" placeholder="dd/mm/yyyy" required>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-4">
                    <label for="phone">Nomor Telepon</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror">
                    @error('phone')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <fieldset style=" flex-direction: row; align-items: center;">
                        <legend class="h6" >Jenis Kelamin</legend>
                        <div class="form-check-inline" style="margin-right: 20px;">
                            <input class="form-check-input" type="radio" name="gender" id="male" value="male" checked>
                            <label class="form-check-label" for="male">Laki - laki</label>
                        </div>
                        <div class="form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                            <label class="form-check-label" for="female">Perempuan</label>
                        </div>
                    </fieldset>
                </div>
{{--                <div class="form-check">--}}
{{--                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck10">--}}
{{--                    <label class="form-check-label" for="defaultCheck10">--}}
{{--                        Tambahkan sebagai member--}}
{{--                    </label>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
</div>

<div class="card" style="margin-top: 15px">
    <div class="card-body">
        <h4 style="margin-bottom: 10px; margin-left: -5px; font-family: 'Times New Roman', Times, serif; font-weight: bold">Detail Alamat</h4>
        <div class="row">
            <div class="col-lg-5" style="margin-right: 30px;">
                <div class="mb-4">
                    <label for="homepict">Foto Depan Rumah</label>
                    <label class="image-preview" for="homepict" style="background-image: none">
                        <small>Klik untuk {{ $customer ? 'mengganti' : 'mengunggah' }}</small>
                        <input type="file" name="homepict" id="homepict" class="d-none" accept="image/*">
                    </label>

                    @error('homepict')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-4">
                    <label for="homedetail">Detail Rumah</label>
                    <textarea class="form-control" placeholder="Detail rumah anda ..." id="homedetail" style="width: 100%;" rows="4"></textarea>
                    @error('homedetail')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="homedetail">Alamat Lengkap</label>
                    <textarea class="form-control" placeholder="Alamat anda ..." id="homedetail" style="width: 100%;" rows="4"></textarea>
                    @error('homedetail')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
            <label for="map" style="margin-bottom: 10px">Detail lokasi rumah</label>
            <div id="map"></div>
        </div>
    </div>
</div>

<div class="card" style="margin-top: 15px">
    <div class="card-body">
        <h4 style="margin-bottom: 20px; margin-left: -5px; font-family: 'Times New Roman', Times, serif; font-weight: bold">Keterangan Member</h4>
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-5" style="margin-right: 30px;">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck10">
                    <label class="form-check-label" for="defaultCheck10">
                        Tambahkan sebagai member
                    </label>
                </div>
            </div>
            <div class="mb-2 text-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        var map = L.map('map').setView([-8.173043, 113.701767], 14);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var marker = L.marker([-8.173043, 113.701767]).addTo(map);
        var previousMarker = null;
        function onMapClick(e) {
            if (previousMarker !== null) {
                map.removeLayer(previousMarker);
            }

            previousMarker = L.marker(e.latlng).addTo(map);
        }
        map.on('click', onMapClick);



    </script>
@endpush
