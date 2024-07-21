@php
    $packet = $packet ?? null;
@endphp

@csrf
<div class="row">
    <div class="col-md-7" style="">
        <div class="card">
            <div class="card-body">
                <div class="mb-4">
                    <label for="date">Nama Paket</label>
                    <input type="text" name="name" id="date" class="form-control @error('name') is-invalid @enderror"  value="{{old('name', $packet?->name)}}">
                    @error('name')
                    <small class="text-danger mb-3">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="treatment">Pilih Treatment: </label>
                    <select class="treatment-option form-control @error('treatment') is-invalid @enderror"></select>
                    @error("treatment")
                    <small class="text-danger mb-3">{{ $message }}</small>
                    @enderror
                </div>

                <p class="mb-2" id="treatment">Treatment yang dipilih: </p>
                <div class="row" id="treatment-container">
                    @if(isset($packet) || old('treatments'))
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
    <div class="col-md-5" style="">
        <div class="card">
            <div class="card-body">
                <label for="total"> Harga Total </label>
                <div class="mb-4">
                    <div class="input-group mb-1">
                        <span class="input-group-text"> Rp </span>
                        <input type="number" name="total" id="total" aria-describedby="basic-addon1" class="form-control @error('total') is-invalid @enderror" value="{{old('total') ?? ( $totalTreatment ?? '' )}}">
                    </div>
                    @error("total")
                    <small class="text-danger mb-3">{{ $message }}</small>
                    @enderror
                </div>
                <label for="packet_price"> Harga Normal Paket </label>
                <div class="mb-4">
                    <div class="input-group mb-1">
                        <span class="input-group-text"> Rp </span>
                        <input type="number" name="packet_price" id="packet_price" aria-describedby="basic-addon1" class="form-control @error('packet_price') is-invalid @enderror" value="{{old('packet_price') ?? ($packet?->packet_price ?? '')}}">
                    </div>
                    @error("price")
                    <small class="text-danger mb-3">{{ $message }}</small>
                    @enderror
                </div>
                <label for="member_price"> Harga Member </label>
                <div class="mb-0">
                    <div class="input-group mb-1">
                        <span class="input-group-text"> Rp </span>
                        <input type="number" name="member_price" id="member_price" aria-describedby="basic-addon1" class="form-control @error('member_price') is-invalid @enderror" value="{{old('member_price') ?? ($packet?->member_price ?? '')}}">
                    </div>
                    @error("member_price")
                    <small class="text-danger mb-3">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-check ms-1 mt-2">
                    <input class="form-check-input" type="checkbox" {{ $checkBox }} id="checkBox" name="checkBox">
                    <label class="form-check-label" for="checkBox">Gunakan Harga default</label>
                </div>

                <div class="d-grid gap-2" style="margin-top: 20px; margin-left: -8px; margin-right: -8px">
                    <button type="submit" id="confirm" class="btn btn-success" style="color: white">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

@include('components.script.packetForm')
