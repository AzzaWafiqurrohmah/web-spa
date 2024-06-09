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
                    <label for="customer_id">Pelanggan</label>
                    <select class="customer-option form-control @error('customer_id') is-invalid @enderror" id="customer_id" name="customer_id" autofocus>
                        @if(old('customer_id'))
                            @php( $customer = \App\Models\Customer::find(old('customer_id')))
                            <option value="{{old('customer_id')}}">{{ $customer->fullname  }}</option>
                        @endif
                    </select>
                    @error("customer_id")
                    <small class="text-danger mb-3">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="therapist_id">Terapis</label>
                    <select name="therapist_id"
                            class="form-control @error('therapist_id') is-invalid @enderror"  aria-label="Small select example" id="therapist_id">
                        <option disabled selected>-- Pilih Terapis --</option>
                        @foreach($therapists as $therapist)
                            <option value="{{$therapist->id}}" @selected($therapist->id == $reservation?->therapist->id|| old('therapist_id') == $therapist->id) >{{$therapist->fullname}}</option>
                        @endforeach
                    </select>
                    @error("therapist_id")
                    <small class="text-danger mb-3">{{ $message }}</small>
                    @enderror
                </div>
                <label for="discountAdd">Diskon Tambahan </label>
                <div class="mb-3">
                    <div class="input-group mb-1">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="discountAdd" id="discountAdd" aria-describedby="basic-addon1" class="form-control @error('discountAdd') is-invalid @enderror" value="{{ old('discount', $reservation?->discount ?? 0) }}">
                    </div>
                    @error("discountAdd")
                    <small class="text-danger mb-3">{{ $message }}</small>
                    @enderror
                </div>
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <label for="date">Tanggal</label>
                        <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror"  value="{{old('date', $reservation?->date)}}">
                        @error('date')
                        <small class="text-danger mb-3">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <label for="time">Waktu</label>
                        <input type="hidden" name="duration" id="duration">
                        <input type="time" name="time" id="time" class="form-control @error('time') is-invalid @enderror"  value="{{old('time', $reservation?->time)}}" >
                        @error("time")
                        <small class="text-danger mb-3">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="treatment">Pilih Treatment: </label>
                    <select class="treatment-option form-control @error('treatment') is-invalid @enderror"></select>
                    @error("treatment")
                    <small class="text-danger mb-3">{{ $message }}</small>
                    @enderror
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
                        <h4 id="dateString" class="mb-0 mt-1" style="font-size: 1.17rem"> {{ old('dateHidden') ?? 'dd/mm/yyyy' }} </h4>
                        <input type="hidden" name="dateHidden" id="dateHidden">
                        <p id="timeString" style="font-size: 14px;"> {{ old('time') ?? '--:--' }} </p>

                        <legend class="h6" >Metode Pembayaran</legend>
                            <div class="form-check-inline" style="margin-right: 20px;">
                                <div class="mb-3">
                                    <div class="row">
                                        @foreach (App\Enums\PaymentMethod::values() as $method => $val)
                                            <div class="col-md-5">
                                                <div class="card p-2 d-flex align-items-center" style="cursor: pointer; width: 100%; display: flex; justify-content: center;" onclick="selectPayment('{{ $method }}')">
                                                    <div style="display: flex; align-items: center;">
                                                        <input class="form-check-input mt-0 " type="radio" name="payment_type" id="{{$method}}" value="{{$method}}" style="margin-right: 10px;"
                                                            @checked($method == $reservation?->payment_type || old('payment_type') == $method)>
                                                        <label class="form-check-label m-0" for="{{ $method }}" >{{ $val }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                            @error("payment_type")
                                            <small class="text-danger mb-0 mt-1">{{ $message }}</small>
                                            @enderror
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
                            <p id="totalTreatmentString" style="margin-bottom: 2px; font-weight: bold; font-size: 14px">Rp {{ old('totalTreatment') ?? '0' }}</p>
                            <input type="hidden" name="totalTreatment" id="totalTreatment" value="{{ old('totalTreatment') }}">
                        </div>
                    </div>
                </div>
                <div style="margin-left: -8px; margin-right: -8px; margin-top: 0px">
                    <div class="row">
                        <div class="col-lg-6" style="margin-left: 0px; margin-bottom: 0px">
                            <p style="margin-bottom: 2px; color: #5E5E5E; font-size: 14px">Tarif Transportasi</p>
                        </div>
                        <div class="col-lg-6 text-lg-end" style="margin-bottom: 0px">
                            <p style="margin-bottom: 2px; font-weight: bold; font-size: 14px" id="transport_cost_string">Rp {{ old('transport_cost') ?? '0' }}</p>
                            <input type="hidden" name="transport_cost" value="{{ old('transport_cost') }}" id="transport_cost">
                        </div>
                    </div>
                </div>
                <div style="margin-left: -8px; margin-right: -8px; margin-top: 0px">
                    <div class="row">
                        <div class="col-lg-6" style="margin-left: 0px; margin-bottom: 0px">
                            <p style="margin-bottom: 2px; color: #5E5E5E; font-size: 14px">Biaya Ekstra</p>
                        </div>
                        <div class="col-lg-6 text-lg-end" style="margin-bottom: 0px">
                            <p id="extra_cost_string" style="margin-bottom: 2px; font-weight: bold; font-size: 14px">Rp {{ old('extra_cost') ?? '0' }}</p>
                            <input type="hidden" name="extra_cost" id="extra_cost" value="{{ old('extra_cost') }}" >
                        </div>
                    </div>
                </div>

                <div style="margin-left: -8px; margin-right: -8px; margin-top: 0px">
                    <div class="row">
                        <div class="col-lg-6" style="margin-left: 0px; margin-bottom: 0px">
                            <p style="margin-bottom: 2px; color: #5E5E5E; font-size: 14px">Diskon Treatment</p>
                        </div>
                        <div class="col-lg-6 text-lg-end" style="margin-bottom: 0px">
                            <p id="discString" style="margin-bottom: 2px; font-weight: bold; font-size: 14px">Rp {{ old('discount') ?? '0' }}</p>
                            <input type="hidden" name="discount" id="discount" value="{{old('discount')}}">
                        </div>
                    </div>
                </div>

                <div style="margin-left: -8px; margin-right: -8px; margin-top: 0px">
                    <div class="row">
                        <div class="col-lg-6" style="margin-left: 0px; margin-bottom: 0px">
                            <p style="margin-bottom: 2px; font-weight: bold; font-size: 17px;">Total Biaya</p>
                        </div>
                        <div class="col-lg-6 text-lg-end" style="margin-bottom: 0px">
                            <p id="totalString" style="margin-bottom: 2px; font-weight: bold; font-size: 17px">Rp {{ old('total') ?? '0' }}</p>
                            <input type="hidden" name="total" id="total" value="{{ old('total') }}">
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

    function selectPayment(id) {
        document.getElementById(id).checked = true;
    }

    function parseVal(val)
    {
        return parseInt(val.replace(/[^0-9]/g,''));
    }

    let ekstra_malam = {{ $setting['biaya_ekstra_malam'] }};
    let date = new Date();
    let treatments = [];
    let customer;
    let discAdd = 0;

    $('#discountAdd').on('change', function (){
        discAdd = $(this).val();
        updateTotal();
    })

    function updateTotal()
    {
        customer = $('#customer_id').val();
        $.ajax({
            url: `/reservations/treatmentTotal`,
            dataType: 'JSON',
            method: 'POST',
            data: {
                cust: customer,
                treatment: treatments
            },
            success(res) {
                date = setTime($('#time').val(), $('#date').val());
                var totalEkstra = setEkstraMalam(res.data.duration);
                var totalDisc = res.data.disc + parseInt(discAdd);
                total = (parseVal($('#transport_cost_string').text()) + res.data.totalTreatment + totalEkstra ) - totalDisc;

                $('#extra_cost_string').text(`Rp ${totalEkstra}`);
                $('#extra_cost').val(totalEkstra);
                $('#discString').text(`Rp ${ totalDisc }`);
                $('#discount').val(totalDisc);
                $('#totalTreatmentString').text(`Rp ${ res.data.totalTreatment }`)
                $('#totalTreatment').val(res.data.totalTreatment);
                $('#totalString').text(`Rp ${total}`);
                $('#total').val(total);
            }
        });
    }


    function setEkstraMalam($totalDuration)
    {
        let deadline = new Date($('#date').val());
        let hour, minute;
        deadline.setHours('18');
        deadline.setMinutes('00');

        if(date.getHours() < deadline.getHours())
        {
            date.setMinutes(date.getMinutes() + $totalDuration);

            let difference = date - deadline;
            hour = Math.floor(difference / (1000 * 60 * 60));
            minute = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));

            if (hour < 0) {
                hour = 0;
            } else {
                if (hour < 1 && minute > 0) {
                    hour = 1;
                }

                if (hour >= 1 && minute > 30) {
                    hour += 1;
                }
            }

        } else {
            hour = Math.floor($totalDuration / 60);
            if(hour == 0)
            {
                hour = 1;
            }
        }
        return hour * ekstra_malam;
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
                              <span class="position-absolute top-0 end-0 me-2 btn-delete" data-id="${treatment.id}" style="font-size: 1.4rem; cursor: pointer">
                                 <i class="bi bi-x"></i>
                              </span>
                       </div>
                 </div>
            </div>
        `);
    }


    $('#treatment-container').on('click', '.btn-delete', function() {
        id = $(this).data('id')
        treatments = treatments.filter(val => val !== id);
        updateTotal();

        $(this).parent().parent().parent().remove();
    });



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
                customer = res.data.id;
                $('#transport_cost_string').text(`Rp ${res.data.transport_cost}`);
                $('#transport_cost').val(res.data.transport_cost);
                updateTotal();
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

                treatments.push(res.data.id);
                updateTotal();
            }
        });
    });

    document.getElementById('treatment-container').addEventListener('change', function (){
        const hidden = document.getElementById('treatments');
    });

    $('#time').on('change', function() {
        date = setTime($(this).val(), $('#date').val());
        document.getElementById('timeString').textContent = $(this).val();
        updateTotal();
    });

    $('#date').on('change', function (){
        // date = new Date($(this).val());
        let dateString = new Date($(this).val());
        let options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        let formattedDate = dateString.toLocaleDateString('id-ID', options);
        $('#dateHidden').val(formattedDate);
        document.getElementById('dateString').textContent = formattedDate;
    });

    function setTime(time, dateString)
    {
        let dateVal = new Date(dateString);
        dateVal.setHours(time.substring(0, 2));
        dateVal.setMinutes(time.substring(3,5));
        return dateVal;
    }


</script>
@endpush
