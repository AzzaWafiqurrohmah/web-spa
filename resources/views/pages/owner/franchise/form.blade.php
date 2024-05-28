@php
    $franchise = $franchise ?? null;
@endphp
@csrf
<div class="card">
    <div class="card-body">
        <h4 style="margin-bottom: 20px; margin-left: -5px; font-family: 'Times New Roman', Times, serif; font-weight: bold">Detail Cabang</h4>
        <div class="row">
            <div class="col-lg-10">
                <div class="mb-4">
                    <label for="fullname">Kota / Kabupaten</label>
                    <select class="city-option form-control" name="province">
                        <option >--- Pilih Kota / Kabupaten ---</option>
                        @foreach($cities as $key => $city)
                            <option value="{{$key}}" data-city="{{$city}}"> {{$city}} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-4">
                <label for="fullname">Lokasi</label>
                <div id="map">
                    <input type="hidden" id="latitude" name="latitude" value="">
                    <input type="hidden" id="longitude" name="longitude" value="">
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>

        $('.city-option').select2();


        let lat = 0;
        let lng = 0;
        $('.city-option').change(function() {
            var selectedOption = $(this).find('option:selected');
            var data = selectedOption.data('city');
            var position = data.indexOf('.');
            var city = data.substring(position + 2);

            $.ajax({
                url: `/franchises/${city}/latLng`,
                method: 'GET',
                CORS: true ,
                success(res) {
                    lat = res.lat;
                    lng = res.lng;
                    var map = L.map('map').setView([lat, lng], 14);
                },
                error(err) {
                    Swal.fire({
                        icon: 'error',
                        text: err,
                        timer: 1500,
                    });
                },
            });
        })



        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);


    </script>
@endpush
