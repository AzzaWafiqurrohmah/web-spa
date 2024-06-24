@php
    $user = \Illuminate\Support\Facades\Auth::user();
@endphp
<nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0">
    <div class="container-fluid px-0">
        <div class="d-flex justify-content-between w-100" id="navbarSupportedContent">
            <!-- Navbar links -->
            <div class="btn-group ms-auto">
                <div class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer">
                    <img
                        src="{{ $user->image ? Storage::url($user->image) : 'https://apsensi.my.id/img/profile/noimage.jpg' }}"
                        class="rounded-circle"
                        width="40"
                        height="40"
                        alt=""
                    />
                </div>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" style="width: auto; white-space: nowrap;">
                    <div class="position-relative" style="">
                        <div class="py-3 pr-15 pl-1 pb-0" style="padding-left: 1rem; padding-right: 13rem" >
                            <h6 class="mb-0 fs-5 fw-normal">Therapist Profile</h6>
                        </div>
                        <div class="d-flex align-items-center py-3 mx-4 border-bottom">
                            <img
                                src="{{ $user->image ? Storage::url($user->image) : 'https://apsensi.my.id/img/profile/noimage.jpg' }}"
                                class="rounded-circle"
                                width="80"
                                height="80"
                                alt=""
                            />
                            <div class="ms-3">
                                @role('therapist')
                                    <h6 class="mb-1 fs-6">{{ $user->fullname }}</h6>
                                    <span class="mb-1 d-block text-dark">Terapis</span>
                                @endrole

                                @role('admin')
                                    <h6 class="mb-1 fs-6">{{ $user->name }}</h6>
                                    <span class="mb-1 d-block text-dark">Admin</span>
                                @endrole

                                @role('owner')
                                    <h6 class="mb-1 fs-6">{{ $user->name }}</h6>
                                    <span class="mb-1 d-block text-dark">Owner</span>
                                @endrole

                                <p class="mb-0 d-flex text-dark align-items-center gap-2">
                                    <i class="bx bx-envelope fs-5"></i> <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="dbbabfb6b2b59bb6bab2b7f5b8b4b6">{{ $user->email }}</a>
                                </p>
                            </div>
                        </div>
                        <div class="message-body">
                            <a href="/therapist/profiles" class="py-2 px-4 mt-2 d-flex align-items-center">
                                <span class="d-flex align-items-center justify-content-center bg-light rounded-1 p-2">
                                    <i class="bx bx-cog"></i>
                                </span>
                                <div class="w-75 d-inline-block v-middle ps-3">
                                    <h6 class="mb-1 bg-hover-primary fw-semibold"> My Profile </h6>
                                    <span class="d-block text-dark">Account Settings</span>
                                </div>
                            </a>
                        </div>
                        <div class="d-grid py-2 px-3 pt-2">
                            <a href="" class="btn btn-outline-warning">Log Out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
