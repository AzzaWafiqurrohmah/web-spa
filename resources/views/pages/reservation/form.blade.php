@php
    $reservation = $reservation ?? null;
@endphp
@csrf

<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <h4>Tambah Reservasi</h4>

                <h6>Treatment yang Dipilih:</h6>
                <div class="row" id="treatment-container">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-success text-white">Simpan</button>
            </div>
        </div>
    </div>
    {{-- <div class="col-lg-7" style="">
        <div class="card">
            <div class="card-body">
                <h4 style="margin-bottom: 20px; margin-left: -5px; font-family: 'Times New Roman', Times, serif; font-weight: bold">Detail Reservasi</h4>
                <div class="mb-3">
                    <label for="fullname">Customer</label>
                    <input type="text" name="fullname" class="form-control @error('fullname') is-invalid @enderror"  value="{{old('fullname', $reservation?->fullname)}}" autofocus>
                    @error('fullname')
                        <div class="invaid-feedback">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                    @enderror
                </div>
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <label for="fullname">Tanggal</label>
                        <input type="text" name="fullname" class="form-control @error('fullname') is-invalid @enderror"  value="{{old('fullname', $reservation?->fullname)}}" autofocus>
                    </div>
                    <div class="col-lg-6">
                        <label for="fullname">Waktu</label>
                        <input type="text" name="fullname" class="form-control @error('fullname') is-invalid @enderror"  value="{{old('fullname', $reservation?->fullname)}}" autofocus>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="fullname">Pilih Treatment: </label>
                    <input type="text" name="fullname" class="form-control @error('fullname') is-invalid @enderror"  value="{{old('fullname', $reservation?->fullname)}}" autofocus>
                    @error('fullname')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>

                <div class="row" style="margin-left: 0px; margin-right: 0px">
                    <label style="margin-left: -10px" for="">Treatment yang dipilih: </label>
                    <div class="card col-lg-6" >
                        <div class="row" style=" margin-top: 7px; margin-bottom: 7px; margin-left: -8px; margin-right: 0px">
                            <div class="col-lg-2">
                                <i class="bi bi-cart-check" style="font-size: 2rem"></i>
                            </div>
                            <div class="col-lg-7" style="">
                                <p style="font-weight: bold; font-size: 16px; margin-bottom: 0px">Hair Spa</p>
                                <p style="color: #5E5E5E; font-size: 12px; margin-bottom: 0px">Rp 25.000</p>
                            </div>
                            <div class="col-lg-3 text-lg-end" style="display: flex; align-items: center;">
                                <button type="button" class="btn btn-outline-danger" style="padding: 7px 12px;" >
                                    <i class="bi bi-trash3-fill" style=""></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card col-lg-6" >
                        <div class="row" style=" margin-top: 7px; margin-bottom: 7px; margin-left: -8px; margin-right: 0px">
                            <div class="col-lg-2">
                                <i class="bi bi-cart-check" style="font-size: 2rem"></i>
                            </div>
                            <div class="col-lg-7" style="">
                                <p style="font-weight: bold; font-size: 16px; margin-bottom: 0px">Creambath</p>
                                <p style="color: #5E5E5E; font-size: 12px; margin-bottom: 0px">Rp 10.000</p>
                            </div>
                            <div class="col-lg-3 text-lg-end" style="display: flex; align-items: center;">
                                <button type="button" class="btn btn-outline-danger" style="padding: 7px 12px;" >
                                    <i class="bi bi-trash3-fill" style=""></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-lg-5" style="">
        <div class="card">
            <div class="card-body">
                <h4 style="margin-bottom: 10px; margin-left: -8px; font-size: 20px">Reservation Summary</h4>
                <div class="row">
                    <div class="col-lg-12 card" style="">
                        <p style="font-size: 13px; margin-bottom: 0px; margin-top: 8px; color: #5E5E5E"> Tanggal dan Waktu </p>
                        <p style="font-size: 16px; font-weight: bold; margin-top: 0px; margin-bottom: 0px"> Sabtu, 18 Mei 2024 </p>
                        <p style="font-size: 16px; margin-top: -5px;"> 22:23 </p>

                        <div style="margin-top: 10px; margin-bottom: 10px">
                            <p style="margin-bottom: 3px" >Metode Pembayaran</p>
                            <div class="row" style="margin-left: 0px; margin-bottom: 10px">
                                <div class="card col-lg-5" style="margin-right: 10px">
                                    <p style="margin-bottom: 0px; padding: 10px 0px"> Cash </p>
                                </div>
                                <div class="card col-lg-5">
                                    <p style="margin-bottom: 0px; padding: 10px 0px" > Transfer </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h4 style="margin-top: 30px;margin-bottom: 5px; margin-left: -8px; font-size: 20px; font-weight: bold">Price Summary</h4>
                <div style="margin-left: -8px; margin-right: -8px; margin-bottom: 0px">
                    <div class="row">
                        <div class="col-lg-6" style="margin-left: 0px; margin-bottom: 0px">
                            <p style="margin-bottom: 2px; color: #5E5E5E; font-size: 15px">Total Harga Treatment</p>
                        </div>
                        <div class="col-lg-6 text-lg-end" style="margin-bottom: 0px">
                            <p style="margin-bottom: 2px; font-weight: bold; font-size: 15px">Rp 120.000</p>
                        </div>
                    </div>
                </div>
                <div style="margin-left: -8px; margin-right: -8px; margin-top: 0px">
                    <div class="row">
                        <div class="col-lg-6" style="margin-left: 0px; margin-bottom: 0px">
                            <p style="margin-bottom: 2px; color: #5E5E5E; font-size: 15px">Diskon Treatment</p>
                        </div>
                        <div class="col-lg-6 text-lg-end" style="margin-bottom: 0px">
                            <p style="margin-bottom: 2px; font-weight: bold; font-size: 15px">Rp 30.000</p>
                        </div>
                    </div>
                </div>
                <div style="margin-left: -8px; margin-right: -8px; margin-top: 0px">
                    <div class="row">
                        <div class="col-lg-6" style="margin-left: 0px; margin-bottom: 0px">
                            <p style="margin-bottom: 2px; color: #5E5E5E; font-size: 15px">Tarif Transportasi</p>
                        </div>
                        <div class="col-lg-6 text-lg-end" style="margin-bottom: 0px">
                            <p style="margin-bottom: 2px; font-weight: bold; font-size: 15px">Rp 10.000</p>
                        </div>
                    </div>
                </div>
                <div style="margin-left: -8px; margin-right: -8px; margin-top: 0px">
                    <div class="row">
                        <div class="col-lg-6" style="margin-left: 0px; margin-bottom: 0px">
                            <p style="margin-bottom: 2px; color: #5E5E5E; font-size: 15px">Biaya Ekstra</p>
                        </div>
                        <div class="col-lg-6 text-lg-end" style="margin-bottom: 0px">
                            <p style="margin-bottom: 2px; font-weight: bold; font-size: 15px">Rp 20.000</p>
                        </div>
                    </div>
                </div>

                <div style="margin-left: -8px; margin-right: -8px; margin-top: 0px">
                    <div class="row">
                        <div class="col-lg-6" style="margin-left: 0px; margin-bottom: 0px">
                            <p style="margin-bottom: 2px; font-weight: bold; font-size: 18px; color: #5377D5">Total Biaya</p>
                        </div>
                        <div class="col-lg-6 text-lg-end" style="margin-bottom: 0px">
                            <p style="margin-bottom: 2px; font-weight: bold; font-size: 18px; color: #5377D5">Rp 180.000</p>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2" style="margin-top: 20px; margin-left: -8px; margin-right: -8px">
                    <button type="button" class="btn btn-success" style="color: white">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div> --}}
</div>

@push('script')
<script>
    let counter = 0;

    function addTreatment(treatment) {
        $('#treatment-container').append(`
            <div class="col-md-6 mb-2">
                <input type="hidden" name="treatments[]" value="${treatment.id}">
                <div class="card">
                    <div class="card-body d-flex gap-4 align-items-center">
                        <i class="bi bi-clipboard-check-fill" style="font-size: 2rem;"></i>
                        <div>
                            <h6 class="m-0" style="font-size: 1.2rem;;">${treatment.name}</h6>
                            <p class="m-0">Rp ${treatment.price}</p>
                        </div>

                        <span class="position-absolute top-0 end-0 me-2 btn-delete" style="font-size: 1.4rem; cursor: pointer;">
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
</script>
@endpush
