@php
    $reservation = $reservation ?? null;
@endphp
@csrf
<div class="card">
    <div class="card-body">
        <h4 style="margin-bottom: 20px; margin-left: -5px; font-family: 'Times New Roman', Times, serif; font-weight: bold">Detail Reservasi</h4>
{{--        <div class="row">--}}
{{--            <div class="col-lg-5" style="margin-right: 30px;">--}}
{{--                <div class="mb-4">--}}
{{--                    <label for="fullname">Nama Lengkap</label>--}}
{{--                    <input type="text" name="fullname" class="form-control @error('fullname') is-invalid @enderror"  value="{{old('fullname', $therapist?->fullname)}}" autofocus>--}}
{{--                    @error('fullname')--}}
{{--                    <div class="invaid-feedback">--}}
{{--                        <small class="text-danger">{{ $message }}</small>--}}
{{--                    </div>--}}
{{--                    @enderror--}}
{{--                </div>--}}
{{--                <div class="mb-4">--}}
{{--                    <label for="birth_date">Tanggal lahir</label>--}}
{{--                    <div class="input-group">--}}
{{--                        <input id="birth_date" type="date"  class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{old('birth_date', $therapist?->birth_date)}}" autofocus>--}}
{{--                    </div>--}}
{{--                    @error('birth_date')--}}
{{--                    <div class="invaid-feedback">--}}
{{--                        <small class="text-danger">{{ $message }}</small>--}}
{{--                    </div>--}}
{{--                    @enderror--}}
{{--                </div>--}}
{{--                <div class="mb-3">--}}
{{--                    <fieldset style=" flex-direction: row; align-items: center;">--}}
{{--                        <legend class="h6" >Jenis Kelamin</legend>--}}
{{--                        @foreach (App\Enums\Gender::values() as $cat => $val)--}}
{{--                            <div class="form-check-inline" style="margin-right: 20px;">--}}
{{--                                <input class="form-check-input" type="radio" name="gender" id="{{$cat}}" value="{{$cat}}"--}}
{{--                                    @checked($cat == $therapist?->gender || old('gender') == $cat)>--}}
{{--                                <label class="form-check-label" for="{{$cat}}">{{$val}}</label>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
{{--                    </fieldset>--}}
{{--                    @error('gender')--}}
{{--                    <div class="invaid-feedback">--}}
{{--                        <small class="text-danger">{{ $message }}</small>--}}
{{--                    </div>--}}
{{--                    @enderror--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-6">--}}
{{--                <div class="mb-4">--}}
{{--                    <label for="address">Alamat Lengkap</label>--}}
{{--                    <textarea class="form-control" placeholder="Alamat anda ..." id="address" name="address" style="width: 100%;" rows="4"> {{ old('address',$therapist? $therapist->address : '' )}}</textarea>--}}
{{--                    @error('address')--}}
{{--                    <div class="invaid-feedback">--}}
{{--                        <small class="text-danger">{{ $message }}</small>--}}
{{--                    </div>--}}
{{--                    @enderror--}}
{{--                </div>--}}
{{--                <div class="mb-4 row">--}}
{{--                    <div class="col-lg-6">--}}
{{--                        <div>--}}
{{--                            <label for="fbody_weight">Berat badan</label>--}}
{{--                            <input type="number" name="body_weight" class="form-control @error('body_weight') is-invalid @enderror"  value="{{old('body_weight', $therapist?->body_weight)}}">--}}
{{--                            @error('body_weight')--}}
{{--                            <div class="invaid-feedback">--}}
{{--                                <small class="text-danger">{{ $message }}</small>--}}
{{--                            </div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-lg-6">--}}
{{--                        <div >--}}
{{--                            <label for="body_height">Tinggi badan</label>--}}
{{--                            <input type="number" name="body_height" class="form-control @error('body_height') is-invalid @enderror"  value="{{old('body_height', $therapist?->body_height)}}">--}}
{{--                            @error('body_height')--}}
{{--                            <div class="invaid-feedback">--}}
{{--                                <small class="text-danger">{{ $message }}</small>--}}
{{--                            </div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
</div>
