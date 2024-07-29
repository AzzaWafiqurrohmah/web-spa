@php
$user = $user ?? null;
$setting = $setting ?? null;
@endphp
@csrf
<div class="card mb-3">
    <div class="card-body">
        <h5 class="mb-2" style="font-weight: 500; margin-left: -10px; margin-top: -8px; color: #A2A2A2">Detail Admin</h5>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user?->name) }}" id="name" >

                    @error('name')
                    <div class="invalid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="franchise_id">Nama Cabang</label>
                    <select name="franchise_id" class="form-control @error('franchise_id') is-invalid @enderror"  aria-label="Small select example" id="franchise_id">
                        <option disabled selected>-- Pilih Cabang --</option>
                        @foreach($franchises as $franchise)
                            <option value="{{ $franchise->id }}" @selected($franchise->id == $user?->franchise_id|| old('franchise_id') == $franchise->id)>{{ $franchise->name }}</option>
                        @endforeach
                    </select>

                    @error('franchise_id')
                    <div class="invalid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user?->email) }}" id="email">

                    @error('email')
                    <div class="invalid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" >

                    @error('password')
                    <div class="invalid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="mb-2" style="font-weight: 500; margin-left: -10px; margin-top: -8px; color: #A2A2A2">Pengaturan Admin</h5>

        <div class="row">
            <div class="col-md-6">
                <label for="usng_makan"> Biaya Uang Makan </label>
                <div class="mb-4">
                    <div class="input-group mb-1">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="uang_makan" id="discountAdd" aria-describedby="basic-addon1" class="form-control @error('uang_makan') is-invalid @enderror" value="{{ old('uang_makan', $setting? $setting['uang_makan'] : '') }}">
                    </div>
                    @error("uang_makan")
                    <small class="text-danger mb-3">{{ $message }}</small>
                    @enderror
                </div>
                <label for="biaya_ekstra_malam"> Biaya Ekstra Malam </label>
                <div class="mb-4">
                    <div class="input-group mb-1">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="biaya_ekstra_malam" id="biaya_ekstra_malam" aria-describedby="basic-addon1" class="form-control @error('biaya_ekstra_malam') is-invalid @enderror" value="{{ old('biaya_ekstra_malam', $setting? $setting['biaya_ekstra_malam'] : '' ) }}">
                    </div>
                    @error("biaya_ekstra_malam")
                    <small class="text-danger mb-3">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <label for="biaya_transport"> Tarif Transportasi </label>
                <div class="mb-4">
                    <div class="input-group mb-1">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="biaya_transport" id="biaya_transport" aria-describedby="basic-addon1" class="form-control @error('biaya_transport') is-invalid @enderror" value="{{ old('biaya_transport', $setting? $setting['biaya_transport'] : '' ) }}">
                    </div>
                    @error("biaya_transport")
                    <small class="text-danger mb-3">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class=" text-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>

    </div>
</div>
@push('script')
    <script>
        $('#franchise_id').select2();
    </script>
@endpush
