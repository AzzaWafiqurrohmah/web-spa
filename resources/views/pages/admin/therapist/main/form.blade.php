@php
    $therapist = $therapist ?? null;
@endphp
@csrf
<div class="card">
    <div class="card-body">
        <h5 class="mb-2" style="font-weight: 500; margin-left: -10px; margin-top: -8px; color: #A2A2A2">Detail Terapis</h5>
        <div class="row">
            <div class="col-lg-5" style="margin-right: 30px;">
                <div class="mb-4">
                    <label for="fullname">Nama Lengkap</label>
                    <input type="text" name="fullname" class="form-control @error('fullname') is-invalid @enderror"  value="{{old('fullname', $therapist?->fullname)}}" autofocus>
                    @error('fullname')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="birth_date">Tanggal lahir</label>
                    <div class="input-group">
                        <input id="birth_date" type="date"  class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{old('birth_date', $therapist?->birth_date)}}" autofocus>
                    </div>
                    @error('birth_date')
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
                                    @checked($cat == $therapist?->gender || old('gender') == $cat)>
                                <label class="form-check-label" for="{{$cat}}">{{$val}}</label>
                            </div>
                        @endforeach
                    </fieldset>
                    @error('gender')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-4">
                    <label for="address">Alamat Lengkap</label>
                    <textarea class="form-control" placeholder="Alamat anda ..." id="address" name="address" style="width: 100%;" rows="4"> {{ old('address',$therapist? $therapist->address : '' )}}</textarea>
                    @error('address')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
                <div class="mb-4 row">
                    <div class="col-lg-6">
                        <label for="body_weight"> Berat badan </label>
                        <div class="mb-3">
                            <div class="input-group mb-1">
                                <input type="number" name="body_weight" id="body_weight" aria-describedby="basic-addon1" class="form-control @error('body_weight') is-invalid @enderror"  value="{{old('body_weight', $therapist?->body_weight)}}">
                                <span class="input-group-text"> Kg </span>
                            </div>
                            @error("body_weight")
                            <small class="text-danger mb-3">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <label for="body_height"> Tinggi badan </label>
                        <div class="mb-3">
                            <div class="input-group mb-1">
                                <input type="number" name="body_height" id="body_height" aria-describedby="basic-addon1" class="form-control @error('body_height') is-invalid @enderror"  value="{{old('body_height', $therapist?->body_height)}}">
                                <span class="input-group-text"> cm </span>
                            </div>
                            @error("body_height")
                            <small class="text-danger mb-3">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card" style="margin-top: 20px">
    <div class="card-body">
        <h5 class="mb-2" style="font-weight: 500; margin-left: -10px; margin-top: -8px; color: #A2A2A2">Detail Lainnya</h5>
        <div class="row">
            <div class="col-lg-5" style="margin-right: 30px;">
                <div class="mb-4">
                    <label for="phone">Nomor Telepon</label>
                    <input type="text" name="phone" value="{{old('phone', $therapist?->phone)}}" class="form-control @error('phone') is-invalid @enderror">
                    @error('phone')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="start_working">Mulai Bekerja</label>
                    <div class="input-group">
                        <input id="start_working" type="date"  class="form-control @error('start_working') is-invalid @enderror" name="start_working" value="{{old('start_working', $therapist?->start_working)}}" >
                    </div>
                    @error('start_working')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-4">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="{{old('email', $therapist?->email)}}" class="form-control @error('email') is-invalid @enderror">
                    @error('email')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password">Password</label>
                    <input type="password" name="password" value="{{old('password')}}" class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="mb-2 text-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
