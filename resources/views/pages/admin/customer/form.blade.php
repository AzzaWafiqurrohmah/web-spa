@php
    $customer = $customer ?? null;
@endphp
@csrf
<div class="card">
    <div class="card-body">
        <h4 style="margin-bottom: 20px; margin-left: -5px; font-family: 'Times New Roman', Times, serif; font-weight: bold">Detail Pelanggan</h4>
        <div class="row">
            <div class="col-lg-5" style="margin-right: 30px;">
                <div class="mb-4">
                    <label for="fullname">Nama Lengkap</label>
                    <input type="text" name="fullname" class="form-control @error('fullname') is-invalid @enderror"  value="{{old('fullname', $customer?->fullname)}}" autofocus>
                    @error('fullname')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="birth_date">Tanggal lahir</label>
                    <div class="input-group">
                        <input id="birth_date" type="date"  class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{old('birth_date', $customer?->birth_date)}}" autofocus>
                    </div>
                    @error('birthDate')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-4">
                    <label for="phone">Nomor Telepon</label>
                    <input type="text" name="phone" value="{{old('phone', $customer?->phone)}}" class="form-control @error('phone') is-invalid @enderror">
                    @error('phone')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <fieldset style=" flex-direction: row; align-items: center;">
                        <legend class="h6" >Jenis Kelamin</legend>
                        @foreach (App\Enums\Gender::values() as $cat => $val)
                            <div class="form-check-inline" style="margin-right: 20px;">
                                <input class="form-check-input" type="radio" name="gender" id="{{$cat}}" value="{{$cat}}"
                                    @checked($cat == $customer?->gender || old('gender') == $cat)>
                                <label class="form-check-label" for="{{$cat}}">{{$val}}</label>
                            </div>
                        @endforeach
                    </fieldset>
                </div>
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
                    <label for="home_pict" class="form-label">Foto Depan Rumah</label>
                    <label class="image-preview" for="home_pict" style="background-image: url('{{ Storage::url($customer ? $customer->home_pict : old('home_pict')) }}')">
                        <small>Klik untuk {{ $customer ? 'mengganti' : 'mengunggah' }}</small>
                        <input type="file" name="home_pict" id="home_pict" class="d-none" accept="image/*">
                    </label>

                    @error('home_pict')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-4">
                    <label for="home_details">Detail Rumah</label>
                    <textarea class="form-control" placeholder="Detail rumah anda ..." id="home_details" name="home_details" style="width: 100%;" rows="4" >{{ $customer? $customer->home_details : '' }}</textarea>
                    @error('home_details')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="address">Alamat Lengkap</label>
                    <textarea class="form-control" placeholder="Alamat anda ..." id="address" name="address" style="width: 100%;" rows="4"> {{ $customer? $customer->address : '' }}</textarea>
                    @error('address')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
            <label for="map" style="margin-bottom: 10px">Detail lokasi rumah</label>
            <div id="map">
                <input type="hidden" id="latitude" name="latitude" value="{{ $customer?->latitude }}">
                <input type="hidden" id="longitude" name="longitude" value="{{ $customer?->longitude }}">
            </div>
        </div>
    </div>
</div>

<div class="card" style="margin-top: 15px">
    <div class="card-body">
        <h4 style="margin-bottom: 20px; margin-left: -5px; font-family: 'Times New Roman', Times, serif; font-weight: bold">Keterangan Member</h4>
        <div class="row">
            <div class="col-lg-5" style="margin-right: 30px;">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="member" name="member" @checked($customer && $customer?->member_id != '0')
                        @disabled($customer && $customer?->member_id != '0')>
                    <label class="form-check-label" for="member">
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

        //put latlng
        const lat = document.getElementById('latitude');
        const lng = document.getElementById('longitude');

        var previousMarker = null;
        @if($customer)
            previousMarker = L.marker([{{ $customer?->latitude }}, {{ $customer?->longitude }}]).addTo(map);
        @endif
        function onMapClick(e) {
            if (previousMarker !== null) {
                map.removeLayer(previousMarker);
            }

            lat.value = e.latlng.lat;
            lng.value = e.latlng.lng;
            previousMarker = L.marker(e.latlng).addTo(map);
        }
        map.on('click', onMapClick);



        $('#home_pict').on('change', function() {
            const preview = $(this).parent();
            const file = this.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.css('background-image', `url('${e.target.result}')`);
            }

            reader.readAsDataURL(file);
            console.log($(this).value);
        });


    </script>
@endpush
