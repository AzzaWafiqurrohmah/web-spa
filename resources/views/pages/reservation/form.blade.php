@php
    $reservation = $reservation ?? null;
@endphp
@csrf

<div class="row">
     <div class="col-md-7" style="">
        <div class="card">
            <h4 class="ms-3 mb-0 mt-3">Detail Reservasi</h4>
            <div class="card-body">
                <div class="mb-3">
                    <label for="fullname">Customer</label>
                    <select class="customer-option form-control"></select>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <label for="date">Tanggal</label>
                        <input type="date" name="date" class="form-control"  value="{{old('date', $reservation?->fullname)}}" autofocus>
                    </div>
                    <div class="col-lg-6">
                        <label for="time">Waktu</label>
                        <input type="time" name="time" id="time" class="form-control"  value="{{old('fullname', $reservation?->fullname)}}" autofocus>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="fullname">Pilih Treatment: </label>
                    <select class="treatment-option form-control"></select>
                </div>

                <p id="treatment">Treatment yang dipilih: </p>
                <div class="row" id="treatment-container">
                </div>

            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <h4 class="ms-3 mb-0 mt-3">Reservation Summary</h4>
            <div class="card-body mt-0">
                <div class="row">
                    <div class="col-lg-12 card m-1">
                        <p class="mb-0 mt-1" style="color: #5E5E5E; font-size: 13px"> Tanggal dan Waktu :</p>
                        <h4 class="mb-0 mt-1" style="font-size: 1.17rem"> Sabtu, 18 Mei 2024 </h4>
                        <p style="font-size: 14px;"> 22:23 </p>

                        <h6 class="mb-0 mt-3" >Metode Pembayaran :</h6>
                        <div class="mt-1 mb-3">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="card" style="cursor: pointer">
                                        <h6 class="p-2 mb-0"> Cash </h6>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="card" style="cursor: pointer">
                                        <h6 class="p-2 mb-0"> Transfer </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="mt-4" style="margin-left: -8px; margin-right: -8px;">Price Summary</h5>
                <div style="margin-left: -8px; margin-right: -8px; margin-bottom: 0px">
                    <div class="row">
                        <div class="col-lg-6" style="margin-left: 0px; margin-bottom: 0px">
                            <p style="margin-bottom: 2px; color: #5E5E5E; font-size: 14px">Total Harga Treatment</p>
                        </div>
                        <div class="col-lg-6 text-lg-end" style="margin-bottom: 0px">
                            <p style="margin-bottom: 2px; font-weight: bold; font-size: 14px">Rp 120.000</p>
                        </div>
                    </div>
                </div>
                <div style="margin-left: -8px; margin-right: -8px; margin-top: 0px">
                    <div class="row">
                        <div class="col-lg-6" style="margin-left: 0px; margin-bottom: 0px">
                            <p style="margin-bottom: 2px; color: #5E5E5E; font-size: 14px">Diskon Treatment</p>
                        </div>
                        <div class="col-lg-6 text-lg-end" style="margin-bottom: 0px">
                            <p style="margin-bottom: 2px; font-weight: bold; font-size: 14px">Rp 30.000</p>
                        </div>
                    </div>
                </div>
                <div style="margin-left: -8px; margin-right: -8px; margin-top: 0px">
                    <div class="row">
                        <div class="col-lg-6" style="margin-left: 0px; margin-bottom: 0px">
                            <p style="margin-bottom: 2px; color: #5E5E5E; font-size: 14px">Tarif Transportasi</p>
                        </div>
                        <div class="col-lg-6 text-lg-end" style="margin-bottom: 0px">
                            <p style="margin-bottom: 2px; font-weight: bold; font-size: 14px" id="transport_cost">Rp 10.000</p>
                        </div>
                    </div>
                </div>
                <div style="margin-left: -8px; margin-right: -8px; margin-top: 0px">
                    <div class="row">
                        <div class="col-lg-6" style="margin-left: 0px; margin-bottom: 0px">
                            <p style="margin-bottom: 2px; color: #5E5E5E; font-size: 14px">Biaya Ekstra</p>
                        </div>
                        <div class="col-lg-6 text-lg-end" style="margin-bottom: 0px">
                            <p id="extra_cost" style="margin-bottom: 2px; font-weight: bold; font-size: 14px">Rp 20.000</p>
                        </div>
                    </div>
                </div>

                <div style="margin-left: -8px; margin-right: -8px; margin-top: 0px">
                    <div class="row">
                        <div class="col-lg-6" style="margin-left: 0px; margin-bottom: 0px">
                            <p style="margin-bottom: 2px; font-weight: bold; font-size: 17px;">Total Biaya</p>
                        </div>
                        <div class="col-lg-6 text-lg-end" style="margin-bottom: 0px">
                            <p style="margin-bottom: 2px; font-weight: bold; font-size: 17px">Rp 180.000</p>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2" style="margin-top: 20px; margin-left: -8px; margin-right: -8px">
                    <button type="submit" class="btn btn-success" style="color: white">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
    let transport_cost = 0;
    let extra_cost = 0;
    let reservation = [];
    function updateTotal()
    {
        // const totalReservation = 0;
        // var totalReservation = arrayData.map(function(obj) {
        //     return obj.cost;
        // }).reduce(function(total, cost) {
        //     return total + cost;
        // }, 0);
        // const total = transport_cost + extra_cost + totalReservation;
    }

    function addTreatment(treatment) {
        $('#treatment-container').append(`
            <div class="col-md-6 mb-3" >
                 <input type="hidden" id="treatments" name="treatments[${treatment.id}]" value="${treatment.id}">
                 <div class="card" >
                       <div class="card-body d-flex gap-4 align-items-center">
                             <i class="bi bi-clipboard-check-fill" style="font-size: 2rem"></i>
                              <div>
                                <h6 class="m-0" style="font-size: 1.2rem">${treatment.name}</h6>
                                <p class="m-0">${treatment.price}</p>
                              </div>
                              <span class="position-absolute top-0 end-0 me-2 btn-delete" style="font-size: 1.4rem; cursor: pointer">
                                 <i class="bi bi-x"></i>
                              </span>
                       </div>
                 </div>
            </div>
        `);
    }


    $('#treatment-container').on('click', '.btn-delete', function() {
        $(this).parent().parent().parent().remove();
    });

    function distance(latitude, longitude, latOffice, lngOffice)
    {
        var point1 = L.latLng(latOffice, lngOffice);
        var point2 = L.latLng(latitude, longitude);
        var distance = point1.distanceTo(point2);
        var val =  distance/1000;
        if(val % 1 < 0.5)
            return Math.floor(val);

        return Math.ceil(val);
    }


    //select2 customer
    $(".customer-option").select2({
        ajax: {
            url: "/reservations/customers",
            method: 'GET',
            dataType: 'json',
            delay: 0,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data, params) {
                return {
                    results: $.map(data.data, function (item) {
                        return {
                            text: item.fullname,
                            phone: item.phone,
                            id:item.id
                        }
                    })
                };
            },
            cache: true
        },
        placeholder: '--- Pilih Customer ---',
        minimumInputLength: 1,
        templateResult: formatRepo
    });

    function formatRepo (repo) {
        if (repo.loading) {
            return repo.text;
        }
        return $(
            '<div class="d-flex gap-4 align-items-center">' +
            '<i class="bi bi-person-circle ms-1" style="font-size: 1.5rem"></i>' +
            '<div>' +
            '<h4 class="m-0" style="font-size: 16px">' + repo.text + '</h4>' +
            '<p class="m-0" style="font-size: 12px">' + repo.phone + '</p>' +
            '</div>' +
            '</div>'
        );
    }

    $('.customer-option').on('select2:select', function(repo) {
        const id = $(this).val();
        $.ajax({
            url: `/customers/${id}`,
            dataType: 'JSON',
            success(res) {
                let val = distance(res.data.latitude, res.data.longitude, res.data.latOffice, res.data.lngOffice);
               document.getElementById('transport_cost').textContent = "Rp " + (val * 1000);
            }
        });
    });

    $(".treatment-option").select2({
        ajax: {
            url: "/reservations/treatments",
            method: 'GET',
            dataType: 'json',
            delay: 0,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data, params) {
                return {
                    results: $.map(data.data, function (item) {
                        return {
                            text: item.name,
                            price: item.price,
                            id:item.id
                        }
                    })
                };
            },
            cache: true
        },
        placeholder: '--- Pilih Treatment ---',
        minimumInputLength: 1,
        templateResult: formatRepo2
    });

    function formatRepo2 (repo) {
        if (repo.loading) {
            return repo.text;
        }
        return $(
            '<div class="d-flex gap-4 align-items-center">' +
            '<i class="bi bi-person-circle ms-1" style="font-size: 1.5rem"></i>' +
            '<div>' +
            '<h4 class="m-0" style="font-size: 16px">' + repo.text + '</h4>' +
            '<p class="m-0" style="font-size: 12px">' + repo.price + '</p>' +
            '</div>' +
            '</div>'
        );
    }

    $('.treatment-option').on('select2:select', function(repo) {
        const id = $(this).val();
        $.ajax({
            url: `/treatments/${id}`,
            dataType: 'JSON',
            success(res) {
                addTreatment(res.data);
            }
        });
    });

    document.getElementById('treatment-container').addEventListener('change', function (){
        const hidden = document.getElementById('treatments');
        console.log(hidden.value);
    });

    $('#time').on('change', function() {
        const time = $(this).val();
        // if(time)
    });


</script>
@endpush
