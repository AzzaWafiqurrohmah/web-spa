<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
    <div class="sidebar-inner px-2 pt-3">
    <div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
      <div class="d-flex align-items-center">
        <div class="avatar-lg me-4">
          <img src="/assets/img/team/profile-picture-3.jpg" class="card-img-top rounded-circle border-white"
            alt="Bonnie Green">
        </div>
        <div class="d-block">
          <h2 class="h5 mb-3">Hi, Jane</h2>
          <a href="/login" class="btn btn-secondary btn-sm d-inline-flex align-items-center">
            <svg class="icon icon-xxs me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            Sign Out
          </a>
        </div>
      </div>
      <div class="collapse-close d-md-none">
        <a href="#sidebarMenu" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu"
          aria-expanded="true" aria-label="Toggle navigation">
          <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"></path>
          </svg>
        </a>
      </div>
    </div>
    <ul class="nav flex-column pt-3 pt-md-0">
      <li class="nav-item">
        <a href="/dashboard" class="nav-link d-flex align-items-center">
          <span class="sidebar-icon me-3">
            <img src="/assets/img/brand/light.svg" height="20" width="20" alt="Volt Logo">
          </span>
          <span class="mt-1 ms-1 sidebar-text">
            web - spa
          </span>
        </a>
      </li>

        <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>

      <li class="nav-item {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
          <a href="/dashboard" class="nav-link">
              <i class="bx bx-home sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
              <span class="sidebar-text ms-1">Dashboard</span>
          </a>
      </li>

        <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>

    @role('admin')
        <li class="nav-item {{ Request::segment(1) == 'reservations' ? 'active' : '' }}">
            <a href="{{ route('reservations.index') }}" class="nav-link">
                <i class="bx bx-receipt sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                <span class="sidebar-text ms-1">Reservasi</span>
            </a>
        </li>

        <li class="nav-item {{ Request::segment(1) == 'customers' ? 'active' : '' }}">
            <a href="{{route('customers.index')}}" class="nav-link">
                <i class="bx bxs-user-account sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                <span class="sidebar-text ms-1">Customer</span>
            </a>
        </li>

        <li class="nav-item" >
            <span class="nav-link collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
              data-bs-target="#submenu-pages">
              <span>
                <i class="bx bx-note sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                <span class="sidebar-text">Treatment</span>
              </span>
              <span class="link-arrow">
                  <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd">
                      </path>
                  </svg>
              </span>
            </span>
            <div class="multi-level collapse" role="list" id="submenu-pages" aria-expanded="false">
              <ul class="flex-column nav">
                  <li class="nav-item {{ Request::segment(1) == 'treatmentCategories' ? 'active' : '' }}">
                      <a class="nav-link" href="{{ route('treatmentCategories.index') }}">
                          <span class="sidebar-text">Kategori Treatment</span>
                      </a>
                  </li>
                <li class="nav-item" {{ Request::segment(1) == 'treatments' ? 'active' : '' }}>
                  <a class="nav-link" href="{{ route('treatments.index') }}">
                    <span class="sidebar-text">Daftar Treatment</span>
                  </a>
                </li>
                <li class="nav-item {{ Request::segment(1) == 'tools' ? 'active' : '' }}">
                  <a class="nav-link" href=" {{ route('tools.index') }}">
                    <span class="sidebar-text">Alat Treatment</span>
                  </a>
                </li>
                <li class="nav-item {{ Request::segment(1) == 'materials' ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('materials.index') }}">
                    <span class="sidebar-text">Bahan Treatment</span>
                  </a>
                </li>
              </ul>
            </div>
        </li>

        <li class="nav-item">
            <span class="nav-link collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
              data-bs-target="#submenu-components">
              <span>
                <i class="bx bxs-user-detail sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                <span class="sidebar-text">Terapis</span>
              </span>
              <span class="link-arrow">
                  <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd">
                      </path>
                  </svg>
              </span>
            </span>
            <div
              class="multi-level collapse {{ Request::segment(1) == 'buttons' || Request::segment(1) == 'notifications' || Request::segment(1) == 'forms' || Request::segment(1) == 'modals' || Request::segment(1) == 'typography' ? 'show' : '' }}"
              role="list" id="submenu-components" aria-expanded="false">
              <ul class="flex-column nav">
                <li class="nav-item {{ Request::segment(1) == 'therapists' ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('therapists.index') }}">
                    <span class="sidebar-text">Daftar Terapis</span>
                  </a>
                </li>
                <li class="nav-item {{ Request::segment(1) == 'notifications' ? 'active' : '' }}">
                  <a class="nav-link" href="/notifications">
                    <span class="sidebar-text">Jadwal Terapis</span>
                  </a>
                </li>
                <li class="nav-item {{ Request::segment(1) == 'presence' ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('presences.index') }}">
                    <span class="sidebar-text">Presensi Terapis</span>
                  </a>
                </li>
              </ul>
            </div>
        </li>

        <li class="nav-item {{ Request::segment(1) == 'laporan' ? 'active' : '' }}">
            <a href="" class="nav-link">
                <i class="bx bx-notepad sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                <span class="sidebar-text ms-1">Laporan</span>
            </a>
        </li>

        <li class="nav-item {{ Request::segment(1) == 'setting' ? 'active' : '' }}">
            <a href="{{ route('setting.index') }}" class="nav-link">
                <i class="bx bxs-cog sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                <span class="sidebar-text ms-1">Pengaturan</span>
            </a>
        </li>
        <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>
        @endrole

        @role('owner')

        <li class="nav-item {{ Request::segment(1) == 'franchises' ? 'active' : '' }}">
            <a href="{{ route('franchises.index') }}" class="nav-link">
                <i class="bx bx-buildings sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                <span class="sidebar-text ms-1">Franchise</span>
            </a>
        </li>

        <li class="nav-item {{ Request::segment(1) == 'admin' ? 'active' : '' }}">
            <a href="{{ route('admin.index') }}" class="nav-link">
                <i class="bx bxs-user-account sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                <span class="sidebar-text ms-1">Admin</span>
            </a>
        </li>

        <li class="nav-item {{ Request::segment(1) == 'transaction' ? 'active' : '' }}">
            <a href="" class="nav-link">
                <i class="bx bx-home sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                <span class="sidebar-text ms-1">Transaksi</span>
            </a>
        </li>

        <li class="nav-item {{ Request::segment(1) == 'laporan' ? 'active' : '' }}">
            <a href="" class="nav-link">
                <i class="bx bx-home sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                <span class="sidebar-text ms-1">Laporan</span>
            </a>
        </li>
      @endrole


        @role('therapist')
        <li class="nav-item {{ Request::segment(2) == 'treatments' ? 'active' : '' }}">
            <a href="/therapist/treatments" class="nav-link">
                <i class="bx bx-buildings sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                <span class="sidebar-text ms-1">Treatment</span>
            </a>
        </li>

        <li class="nav-item {{ Request::segment(2) == 'customers' ? 'active' : '' }}">
            <a href="/therapist/customers" class="nav-link">
                <i class="bx bxs-user-account sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                <span class="sidebar-text ms-1">Customer</span>
            </a>
        </li>
        @endrole

      <li class="nav-item" id="signOut">
        <a href=""
          class="btn btn-secondary d-flex align-items-center justify-content-center btn-upgrade-pro">
            <i class="bx bx-log-out sidebar-icon d-inline-flex align-items-center justify-content-center"
               style="font-size: 1.5rem"></i>
          <span class="ms-2">Log out</span>
        </a>
      </li>
    </ul>
  </div>
</nav>
@include('components.script.auth')
