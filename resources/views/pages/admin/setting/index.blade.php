@extends('layouts.app')
@section('content')
    <title>Setting</title>
    <div class="row">
        <div class="col-md-5">
            <div class="mt-0 mb-3">
                <h2>Pengaturan</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item">Setting</li>
                    </ol>
                </nav>
            </div>
            <div class="card">
                <form action="{{ route('setting.store') }}" method="POST">
                    <div class="card-body">
                        @csrf
                        @foreach($settings as $setting)
                            <label class="mb-1" for="setting[{{ $setting->key }}]">{{ \Illuminate\Support\Str::title(str_replace('_', ' ', $setting->key)) }}</label>
                            <div class="mb-4">
                                <div class="input-group mb-1">
                                    @if( $setting->key == 'diskon_member' )
                                        <span class="input-group-text" id="basic-addon1">%</span>
                                    @else
                                        <span class="input-group-text" id="basic-addon1">Rp</span>
                                    @endif
                                    <input type="number" name="setting[{{ $setting->key }}]" aria-describedby="basic-addon1" class="form-control @error("setting.$setting->key") is-invalid @enderror"  value="{{ $setting->value }}">
                                </div>
                                @error("setting.$setting->key")
                                <small class="text-danger mb-3">{{ $message }}</small>
                                @enderror
                            </div>
                        @endforeach
                        <div class="mb-2 text-end">
                            <button type="submit" id="save" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
