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
                        @if(isset($reservation) || old('customer_id'))
                            <option value="{{ $customer->id }}">{{ $customer->fullname }}</option>
                        @endif
                    </select>
                    @error("customer_id")
                    <small class="text-danger mb-3">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="therapist_id">Terapis</label>
                    <select name="therapist_id"
                            class="therapist-option form-control @error('therapist_id') is-invalid @enderror"  aria-label="Small select example" id="therapist_id">
                        @if(isset($reservation) || old('therapist_id'))
                            <option value="{{ $therapist->id }}">{{ $therapist->fullname }}</option>
                        @endif
                    </select>
                    @error("therapist_id")
                    <small class="text-danger mb-3">{{ $message }}</small>
                    @enderror
                </div>
                <label for="discountAdd">Diskon Tambahan </label>
                <div class="mb-3">
                    <div class="input-group mb-1">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="discountAdd" id="discountAdd" aria-describedby="basic-addon1" class="form-control @error('discountAdd') is-invalid @enderror" value="{{ old('discount', $additional_disc ?? 0) }}">
                    </div>
                    @error("discountAdd")
                    <small class="text-danger mb-3">{{ $message }}</small>
                    @enderror
                </div>
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <label for="date">Tanggal</label>
                        <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror"  value="{{old('date', $reservation?->date->format('Y-m-d'))}}">
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
                    @if(isset($reservation) || old('treatments'))
                        @foreach($treatmentsModal as $treatment)
                            <div class="col-md-6 mb-3" >
                                <input type="hidden" id="treatments" name="treatments[{{$treatment->id}}]" value="{{$treatment->id}}">
                                <div class="card" >
                                    <div class="card-body d-flex gap-4 align-items-center">
                                        <i class="bi bi-clipboard-check-fill" style="font-size: 2rem"></i>
                                        <div>
                                            <h6 class="m-0" style="font-size: 1.2rem">{{$treatment->name}}</h6>
                                            <p class="m-0">{{$treatment->price}}</p>
                                        </div>
                                        <span class="position-absolute top-0 end-0 me-2 btn-delete" data-id="{{$treatment->id}}" style="font-size: 1.4rem; cursor: pointer">
                                            <i class="bi bi-x"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
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
                        <h4 id="dateString" class="mb-0 mt-1" style="font-size: 1.17rem">
                            {{ old('dateHidden') ?? (rsv_date($reservation?->date) ?? 'dd/mm/yyyy') }}
                        </h4>
                        <input type="hidden" name="dateHidden" id="dateHidden">
                        <p id="timeString" style="font-size: 14px;">
                            {{ old('time') ?? ($reservation?->time ?? '--:--') }}
                        </p>

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
                            <p id="totalTreatmentString" style="margin-bottom: 2px; font-weight: bold; font-size: 14px">
                                Rp {{ old('totalTreatment') ?? ($totalTreatments ?? '0') }}
                            </p>
                            <input type="hidden" name="totalTreatment" id="totalTreatment"
                                   value="{{ old('totalTreatment') ?? ($totalTreatments ?? '0') }}"
                            >
                        </div>
                    </div>
                </div>
                <div style="margin-left: -8px; margin-right: -8px; margin-top: 0px">
                    <div class="row">
                        <div class="col-lg-6" style="margin-left: 0px; margin-bottom: 0px">
                            <p style="margin-bottom: 2px; color: #5E5E5E; font-size: 14px">Tarif Transportasi</p>
                        </div>
                        <div class="col-lg-6 text-lg-end" style="margin-bottom: 0px">
                            <p style="margin-bottom: 2px; font-weight: bold; font-size: 14px" id="transport_cost_string">
                                Rp {{ old('transport_cost') ?? ($reservation?->transport_cost ?? '0') }}
                            </p>
                            <input type="hidden" name="transport_cost"
                                   value="{{ old('transport_cost') ?? ($reservation?->transport_cost ?? '0') }}"
                                   id="transport_cost"
                            >
                        </div>
                    </div>
                </div>
                <div style="margin-left: -8px; margin-right: -8px; margin-top: 0px">
                    <div class="row">
                        <div class="col-lg-6" style="margin-left: 0px; margin-bottom: 0px">
                            <p style="margin-bottom: 2px; color: #5E5E5E; font-size: 14px">Biaya Ekstra</p>
                        </div>
                        <div class="col-lg-6 text-lg-end" style="margin-bottom: 0px">
                            <p id="extra_cost_string" style="margin-bottom: 2px; font-weight: bold; font-size: 14px">
                                Rp {{ old('extra_cost') ?? ($reservation?->extra_cost ?? '0') }}
                            </p>
                            <input type="hidden" name="extra_cost" id="extra_cost"
                                   value="{{ old('extra_cost') ?? ($reservation?->extra_cost ?? '0') }}"
                            >
                        </div>
                    </div>
                </div>

                <div style="margin-left: -8px; margin-right: -8px; margin-top: 0px">
                    <div class="row">
                        <div class="col-lg-6" style="margin-left: 0px; margin-bottom: 0px">
                            <p style="margin-bottom: 2px; color: #5E5E5E; font-size: 14px">Diskon Treatment</p>
                        </div>
                        <div class="col-lg-6 text-lg-end" style="margin-bottom: 0px">
                            <p id="discString" style="margin-bottom: 2px; font-weight: bold; font-size: 14px">
                                Rp {{ old('discount') ?? ($reservation?->discount ?? '0') }}
                            </p>
                            <input type="hidden" name="discount" id="discount"
                                   value="{{ old('discount') ?? ($reservation?->discount ?? '0') }}"
                            >
                        </div>
                    </div>
                </div>

                <div style="margin-left: -8px; margin-right: -8px; margin-top: 0px">
                    <div class="row">
                        <div class="col-lg-6" style="margin-left: 0px; margin-bottom: 0px">
                            <p style="margin-bottom: 2px; font-weight: bold; font-size: 17px;">Total Biaya</p>
                        </div>
                        <div class="col-lg-6 text-lg-end" style="margin-bottom: 0px">
                            <p id="totalString" style="margin-bottom: 2px; font-weight: bold; font-size: 17px">
                                Rp {{ old('totals') ?? ($reservation?->totals ?? '0') }}
                            </p>
                            <input type="hidden" name="totals" id="totals"
                                   value="{{ old('totals') ?? ($reservation?->totals ?? '0') }}"
                            >
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2" style="margin-top: 20px; margin-left: -8px; margin-right: -8px">
                    <button type="submit" id="confirm" class="btn btn-success" style="color: white">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>
</div>
@include('components.script.reservationForm');
