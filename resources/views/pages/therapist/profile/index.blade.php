@php
    $user = $user ?? null;
@endphp

@extends('layouts.app')
@section('content')
    <title>Profile</title>
    <div class="row">
        <div class="col-md-12">
            <div class="mt-0 mb-3">
                @role('therapist')
                    <h2>Profile Terapis</h2>
                @endrole
                @role('admin')
                    <h2>Profile Admin</h2>
                @endrole
                @role('owner')
                    <h2>Profile Owner</h2>
                @endrole
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item">Profile</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-12 col-xl-4">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="card shadow border-0 text-center p-0">
                                <div class="card-body pb-0 mb-4">
                                    <div class="border-bottom">
                                        <img src="{{ $user->image ? Storage::url($user->image) : 'https://apsensi.my.id/img/profile/noimage.jpg' }}"
                                             class="rounded-circle mx-auto mb-2" width="100" height="100" alt="Neil Portrait">
                                        @role('therapist')
                                            <h5 class=" mb-0" style="font-family: 'Poppins',sans-serif">{{ $user->fullname }}</h5>
                                            <p class="text-gray mb-2" style="color: #A2A2A2; font-family: 'Poppins',sans-serif">Terapis</p>
                                        @endrole

                                        @role('admin')
                                            <h5 class=" mb-0" style="font-family: 'Poppins',sans-serif">{{ $user->name }}</h5>
                                            <p class="text-gray mb-2" style="color: #A2A2A2; font-family: 'Poppins',sans-serif">Admin</p>
                                        @endrole

                                        @role('owner')
                                            <h5 class=" mb-0" style="font-family: 'Poppins',sans-serif">{{ $user->name }}</h5>
                                            <p class="text-gray mb-2" style="color: #A2A2A2; font-family: 'Poppins',sans-serif">Owner</p>
                                        @endrole


                                    </div>
                                    <div class="mb-3 mt-4" style="text-align: left">
                                        <div class="mb-3 d-flex gap-3 ">
                                            <span class="d-flex align-items-center justify-content-center bg-light rounded-3 p-2 m-0" >
                                                <i class="bx bx-envelope fs-5" style="color: #FFA800"></i>
                                            </span>
                                            <div class="d-inline-block v-middle ps-0">
                                                <h6 class="mb-0" style="font-family: 'Poppins',sans-serif; font-size: 12px; color: #ADADAD"> Mail </h6>
                                                <span class=" mt-0 d-block text-dark fw-bold" style="font-family: 'Poppins',sans-serif; font-size: 14px">{{ $user->email }}</span>
                                            </div>
                                        </div>
                                        @role('therapist')
                                            <div class="mb-3 d-flex gap-3 ">
                                                <span class="d-flex align-items-center justify-content-center bg-light rounded-3 p-2 m-0" >
                                                    <i class="bx bx-calendar-alt fs-5" style="color: #FFA800"></i>
                                                </span>
                                                <div class="d-inline-block v-middle ps-0">
                                                    <h6 class="mb-0" style="font-family: 'Poppins',sans-serif; font-size: 12px; color: #ADADAD"> Tanggal Lahir </h6>
                                                    <span class=" mt-0 d-block text-dark fw-bold" style="font-family: 'Poppins',sans-serif;font-size: 14px;">{{ $user->birth_date }}</span>
                                                </div>
                                            </div>
                                            <div class="mb-3 d-flex gap-3 ">
                                                <span class="d-flex align-items-center justify-content-center bg-light rounded-3 p-2 m-0" >
                                                    <i class="bx bx-phone fs-5" style="color: #FFA800"></i>
                                                </span>
                                                <div class="d-inline-block v-middle ps-0">
                                                    <h6 class="mb-0" style="font-family: 'Poppins',sans-serif; font-size: 12px; color: #ADADAD"> No Telp </h6>
                                                    <span class=" mt-0 d-block text-dark fw-bold" style="font-family: 'Poppins',sans-serif;font-size: 14px;">{{ $user->phone }}</span>
                                                </div>
                                            </div>
                                            <div class="mb-3 d-flex gap-3 ">
                                                <span class="d-flex align-items-center justify-content-center bg-light rounded-3 p-2 m-0" >
                                                    <i class="bx bx-map fs-5" style="color: #FFA800"></i>
                                                </span>
                                                <div class="d-inline-block v-middle ps-0">
                                                    <h6 class="mb-0" style="font-family: 'Poppins',sans-serif; font-size: 12px; color: #ADADAD"> Alamat </h6>
                                                    <span class=" mt-0 d-block text-dark fw-bold" style="font-family: 'Poppins',sans-serif;font-size: 14px;">{{ $user->address }}</span>
                                                </div>
                                            </div>
                                        @endrole
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-8">
                    <div class="card">
                        <div class="card-body pl-3 pt-0">
                            <ul class="nav nav-tabs nav-tabs-bordered" style="display: flex; justify-content: left">
                                <li class="nav-item" style="background-color: #ffffff">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Edit Profile</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Ubah Password</button>
                                </li>

                            </ul>
                            <div class="tab-content pt-3">
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    @role('therapist')
                                        <form action="profiles/update" method="POST" enctype="multipart/form-data">
                                    @endrole

                                    @role(['admin', 'owner'])
                                            <form action="{{ route('profiles.update') }}" method="POST" enctype="multipart/form-data">
                                    @endrole

                                        @method('PUT')
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-5" style="margin-right: 30px;">
                                                <div class="mb-4">
                                                    <label for="image" class="form-label">Foto Profil</label>
                                                    <label class="image-preview" for="image" style="background-image: url('{{ Storage::url($user ? $user->image : old('image')) }}')">
                                                        <small>Klik untuk {{ $user ? 'mengganti' : 'mengunggah' }}</small>
                                                        <input type="file" name="image" id="image" class="d-none" accept="image/*">
                                                    </label>

                                                    @error('image')
                                                    <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                @role('therapist')
                                                    <div class="mb-3">
                                                        <label for="address">Alamat Lengkap</label>
                                                        <textarea class="form-control" placeholder="Alamat anda ..." id="address" name="address" style="width: 100%;" rows="4"> {{ old('address',$user? $user->address : '' )}}</textarea>
                                                        @error('address')
                                                        <div class="invaid-feedback">
                                                            <small class="text-danger">{{ $message }}</small>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-2">
                                                        <fieldset style=" flex-direction: row; align-items: center;">
                                                            <legend class="h6" >Jenis Kelamin</legend>
                                                            @foreach (App\Enums\Gender::values() as $cat => $val)
                                                                <div class="form-check-inline" style="margin-right: 20px;">
                                                                    <input class="form-check-input" type="radio" name="gender" id="{{$cat}}" value="{{$cat}}"
                                                                        @checked($cat == $user?->gender || old('gender') == $cat)>
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
                                                @endrole
                                            </div>
                                            <div class="col-lg-6">
                                                @role(['admin', 'owner'])
                                                    <div class="mb-4">
                                                        <label for="name">Nama Lengkap</label>
                                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"  value="{{ old('name', $user?->name) }}">
                                                        @error('name')
                                                        <div class="invaid-feedback">
                                                            <small class="text-danger">{{ $message }}</small>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                @endrole

                                                @role('therapist')
                                                    <div class="mb-4">
                                                        <label for="fullname">Nama Lengkap</label>
                                                        <input type="text" name="fullname" class="form-control @error('fullname') is-invalid @enderror"  value="{{old('fullname', $user?->fullname)}}">
                                                        @error('fullname')
                                                        <div class="invaid-feedback">
                                                            <small class="text-danger">{{ $message }}</small>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="birth_date">Tanggal lahir</label>
                                                        <div class="input-group">
                                                            <input id="birth_date" type="date"  class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{old('birth_date', $user?->birth_date)}}">
                                                        </div>
                                                        @error('birth_date')
                                                        <div class="invaid-feedback">
                                                            <small class="text-danger">{{ $message }}</small>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="phone">Nomor Telepon</label>
                                                        <input type="text" name="phone" value="{{old('phone', $user?->phone)}}" class="form-control @error('phone') is-invalid @enderror">
                                                        @error('phone')
                                                        <div class="invaid-feedback">
                                                            <small class="text-danger">{{ $message }}</small>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                @endrole
                                                <div class="mb-4">
                                                    <label for="email">Email</label>
                                                    <input type="email" name="email" value="{{old('email', $user?->email)}}" class="form-control @error('email') is-invalid @enderror">
                                                    @error('email')
                                                    <div class="invaid-feedback">
                                                        <small class="text-danger">{{ $message }}</small>
                                                    </div>
                                                    @enderror
                                                </div>
                                                @role('therapist')
                                                    <div class="mb-2 row">
                                                        <div class="col-lg-6">
                                                            <label for="body_weight"> Berat badan </label>
                                                            <div class="mb-3">
                                                                <div class="input-group mb-1">
                                                                    <input type="number" name="body_weight" id="body_weight" aria-describedby="basic-addon1" class="form-control @error('body_weight') is-invalid @enderror"  value="{{old('body_weight', $user?->body_weight)}}">
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
                                                                    <input type="number" name="body_height" id="body_height" aria-describedby="basic-addon1" class="form-control @error('body_height') is-invalid @enderror"  value="{{old('body_height', $user?->body_height)}}">
                                                                    <span class="input-group-text"> cm </span>
                                                                </div>
                                                                @error("body_height")
                                                                <small class="text-danger mb-3">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endrole
                                            </div>
                                        </div>
                                        <div style="text-align: right;">
                                            <button type="submit" class="btn btn-primary" style="font-size: 14px; margin-bottom: 10px;" >Simpan</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="profile-change-password">
                                    <form class="needs-validation" method="POST" id="passwordForm" novalidate>
                                        @method('PUT')
                                        @csrf

                                        <div class="mb-3">
                                            <label for="password" class="form-label">Masukkan password baru</label>
                                            <div class="password-input-container input-group mb-0">
                                                <input type="password" name="password" class="form-control" id="password">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>


                                        <label for="password_confirmation" class="form-label">Ulangi Password</label>
                                        <div class="password-input-container input-group mb-4">
                                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                                            <div class="invalid-feedback"></div>
                                        </div>

                                        <div style="text-align: right;">
                                            <button type="submit" class="btn btn-primary" style="font-size: 14px; margin-bottom: 10px;" >Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $('#image').on('change', function() {
            const preview = $(this).parent();
            const file = this.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.css('background-image', `url('${e.target.result}')`);
            }

            reader.readAsDataURL(file);
            console.log($(this).value);
        });

        let urlPassword = "{{ route('profiles.updatePassword') }}";
        @if($user->hasRole('therapist'))
            urlPassword = 'profiles/updatePassword';
        @endif

        document.getElementById('passwordForm').addEventListener('submit', function (e){
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: urlPassword,
                data: $(this).serialize(),
                success(res) {
                    Swal.fire({
                        icon: 'success',
                        text: res.meta.message,
                        timer: 1500,
                    }).then(function() {
                        location.reload();
                    });
                },
                error(err) {
                    if(err.status == 422) {
                        displayFormErrors(err.responseJSON.data);
                    }
                }
            });
        });
    </script>
@endpush
