@php
    $franchise = $franchise ?? null;
@endphp
@csrf
<div class="card">
    <div class="card-body">
        <h4 style="margin-bottom: 20px; margin-left: -5px; font-family: 'Times New Roman', Times, serif; font-weight: bold">Detail Cabang</h4>

        <div class="mb-3">
            <label for="name">Nama Cabang</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $franchise?->name) }}" id="name" autofocus>

            @error('name')
            <div class="invalid-feedback">
                <small class="text-danger">{{ $message }}</small>
            </div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="province-select">Provinsi</label>
                    <select id="province-select" class="form-control @error('province') is-invalid @enderror" name="province">
                        <option value="">--- Pilih Provinsi ---</option>
                        @foreach ($provinces as $prov)
                        <option value="{{ $prov->code }}" @selected($regency?->parent == $prov->code)>{{ $prov->name }}</option>
                        @endforeach
                    </select>

                    @error('province')
                    <div class="invalid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="regency-select">Kabupaten/Kota</label>
                    <select id="regency-select" class="form-control @error('regency') is-invalid @enderror" name="regency" disabled>
                        <option value="">--- Pilih Kabupaten/Kota ---</option>
                    </select>

                    @error('regency')
                    <div class="invalid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mb-4 location-container">
            <div class="location-loader d-none">
                <i class='bx bx-loader-alt bx-spin' style="font-size: 2.5rem"></i>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="latitude">Latitude</label>
                        <input type="text" name="latitude" class="form-control @error('latitude') is-invalid @enderror" id="latitude" value="{{ old('latitude', $franchise?->latitude) ?? '-6.197386521671376' }}" name="latitude">

                        @error('latitude')
                        <div class="invalid-feedback">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="longitude">Longitude</label>
                        <input type="text" name="longitude" class="form-control @error('longitude') is-invalid @enderror" id="longitude" value="{{ old('longitude', $franchise?->longitude) ?? '106.82082656307375' }}" name="longitude">

                        @error('longitude')
                        <div class="invalid-feedback">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                        @enderror
                    </div>
                </div>
            </div>

            <label for="map">Lokasi</label>
            <div id="map"></div>
        </div>

    </div>

    <div class="card-footer text-end">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</div>

@push('style')
    <style>
        .location-container {
            position: relative;
        }

        .location-container .location-loader {
            position: absolute;
            inset: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(3.5px);
            -webkit-backdrop-filter: blur(3.5px);
            z-index: 99999;
        }

        #map {
            min-height: 25rem;
        }
    </style>
@endpush

@push('script')
    <script>
        const loader = $('.location-loader');
        const latitude = $('#latitude');
        const longitude = $('#longitude');

        const popup = L.popup([latitude.val(), longitude.val()], {
            content: 'Lokasi Cabang',
        });

        const marker = L.marker([latitude.val(), longitude.val()], {
            title: 'Lokasi Cabang',
        });

        const map = L.map('map', {
            center: [latitude.val(), longitude.val()],
            zoom: 15,
        });

        function updateMap() {
            const lat = latitude.val();
            const long = longitude.val();

            map.panTo(new L.latLng(lat, long));
            popup.setLatLng(new L.latLng(lat, long));
            marker.setLatLng(new L.latLng(lat, long));
        }

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.Control.geocoder().addTo(map);

        popup.openOn(map);
        marker.addTo(map);

        map.on('click', function(event) {
            latitude.val(event.latlng.lat);
            longitude.val(event.latlng.lng);

            updateMap();
        });

        $('#province-select').select2();
        $('#regency-select').select2({
            ajax: {
                url: '{{ route('regions.regencies')}}',
                data: function(params) {
                    const prov_code = $('#province-select').val();

                    return {
                        q: params.term,
                        page: params.page || 1,
                        prov_code
                    };
                },
                processResults: function(res) {
                    return { results: res.data };
                },
            },
        });

        $('#latitude, #longitude').on('change', function() {
            updateMap();
        });

        $('#province-select').change(function() {
            ($(this).val().length > 0) ?
                $('#regency-select').removeAttr('disabled') :
                $('#regency-select').attr('disabled', true);

            $('#regency-select').val('').trigger('change');
        });

        $('#regency-select').change(function() {
            if(this.value.length < 1) return;
            loader.removeClass('d-none');

            $.ajax({
                url: `/regions/${this.value}`,
                dataType: 'json',
                success(res) {
                    loader.addClass('d-none');
                    latitude.val(res.data.lat);
                    longitude.val(res.data.long);

                    updateMap();
                },
            });
        });

        @error('regency')
            $('#province-select').trigger('change');
        @enderror

        @if($regency)
            $('#province-select').trigger('change');
            $('#regency-select').append(`
                <option value="{{ $regency->code }}" selected>{{ $regency->name }}</option>
            `);
        @endif
    </script>
@endpush
