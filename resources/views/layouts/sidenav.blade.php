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
            <img src="/assets/img/brand/icon.png" height="33" width="40" alt="Volt Logo">
          </span>
          <span class="mt-1 ms-1 sidebar-text">
            AromaTherapy Spa
          </span>
        </a>
      </li>

        <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>

      <li class="nav-item @active('dashboard')">
          <a href="/dashboard" class="nav-link d-flex">
              <span class="d-flex align-items-center justify-content-center" >
                <i class="bx bx-home sidebar-icon" style="font-size: 1.5rem; padding-bottom: 0px"></i>
              </span>
              <span class="sidebar-text ms-1 mt-0 d-block ">Dashboard</span>
          </a>
      </li>

        <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>

    @role('admin')
        <li class="nav-item @active('reservations.*')">
            <a href="{{ route('reservations.index') }}" class="nav-link d-flex">
                <span class="d-flex align-items-center justify-content-center" >
                    <i class="bx bx-receipt sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                </span>
                <span class="sidebar-text ms-1 mt-0 d-block">Reservasi</span>
            </a>
        </li>

        <li class="nav-item @active('customers.*')">
            <a href="{{route('customers.index')}}" class="nav-link d-flex">
                <span class="d-flex align-items-center justify-content-center" >
                    <i class="bx bxs-user-account sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                </span>
                <span class="sidebar-text ms-1 mt-0 d-block">Customer</span>
            </a>
        </li>

        <li class="nav-item">
            <span class="nav-link collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
              data-bs-target="#submenu-pages">
              <span class="d-flex">
                  <span class="d-flex align-items-center justify-content-center" >
                        <i class="bx bx-note sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                  </span>
                <span class="sidebar-text mt-0 d-block">Treatment</span>
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
            <div class="multi-level collapse @active('treatments.*,treatmentCategories,tools,materials', 'show')" role="list" id="submenu-pages" aria-expanded="false">
              <ul class="flex-column nav">
                  <li class="nav-item @active('treatmentCategories')">
                      <a class="nav-link" href="{{ route('treatmentCategories.index') }}">
                          <span class="sidebar-text">Kategori Treatment</span>
                      </a>
                  </li>
                <li class="nav-item @active('treatments.*')">
                  <a class="nav-link" href="{{ route('treatments.index') }}">
                    <span class="sidebar-text">Daftar Treatment</span>
                  </a>
                </li>

                  <li class="nav-item @active('packets.*')">
                      <a class="nav-link" href="{{ route('packets.index') }}">
                          <span class="sidebar-text">Paket Treatment</span>
                      </a>
                  </li>

                <li class="nav-item @active('tools')">
                  <a class="nav-link" href=" {{ route('tools.index') }}">
                    <span class="sidebar-text">Alat Treatment</span>
                  </a>
                </li>

                <li class="nav-item @active('materials')">
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
              <span class="d-flex">
                <span class="d-flex align-items-center justify-content-center" >
                    <i class="bx bxs-user-detail sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                </span>
                <span class="sidebar-text mt-0 d-block">Terapis</span>
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
              class="multi-level collapse @active('therapists.*,schedules,presences', 'show')"
              role="list" id="submenu-components" aria-expanded="false">
              <ul class="flex-column nav">
                <li class="nav-item @active('therapists.*')">
                  <a class="nav-link" href="{{ route('therapists.index') }}">
                    <span class="sidebar-text">Daftar Terapis</span>
                  </a>
                </li>
                <li class="nav-item @active('schedules.*')">
                  <a class="nav-link" href="{{ route('schedules.index') }}">
                    <span class="sidebar-text">Jadwal Terapis</span>
                  </a>
                </li>
                <li class="nav-item @active('presences.*')">
                  <a class="nav-link" href="{{ route('presences.index') }}">
                    <span class="sidebar-text">Presensi Terapis</span>
                  </a>
                </li>
              </ul>
            </div>
        </li>

        <li class="nav-item">
            <span class="nav-link collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
              data-bs-target="#report-components">
              <span class="d-flex">
                <span class="d-flex align-items-center justify-content-center" >
                    <i class="bx bx-notepad sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                </span>
                <span class="sidebar-text mt-0 d-block">Laporan</span>
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
              class="multi-level collapse @active('reports', 'show')"
              role="list" id="report-components" aria-expanded="false">
              <ul class="flex-column nav">
                <li class="nav-item @active('reports.income')">
                  <a class="nav-link" href="{{ route('reports.income') }}">
                    <span class="sidebar-text">Pendapatan</span>
                  </a>
                </li>
                <li class="nav-item @active('reports.outcome')">
                    <a class="nav-link" href="{{ route('reports.outcome') }}">
                        <span class="sidebar-text">Pengeluaran</span>
                    </a>
                </li>
                <li class="nav-item @active('reports.presence')">
                    <a class="nav-link" href="{{ route('reports.presence') }}">
                        <span class="sidebar-text">Kehadiran</span>
                    </a>
                </li>
              </ul>
            </div>
        </li>

        <li class="nav-item @active('setting')">
            <a href="{{ route('setting.index') }}" class="nav-link d-flex">
                <span class="d-flex align-items-center justify-content-center" >
                    <i class="bx bxs-cog sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                </span>
                <span class="sidebar-text ms-1 mt-0 d-block">Pengaturan</span>
            </a>
        </li>

        <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>
        @endrole

        @role('owner')

        <li class="nav-item @active('franchises.*')">
            <a href="{{ route('franchises.index') }}" class="nav-link d-flex">
                <span class="d-flex align-items-center justify-content-center" >
                    <i class="bx bx-buildings sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                </span>
                <span class="sidebar-text ms-1 mt-0 d-block">Franchise</span>
            </a>
        </li>

        <li class="nav-item @active('admin')">
            <a href="{{ route('admin.index') }}" class="nav-link d-flex">
                <span class="d-flex align-items-center justify-content-center" >
                    <i class="bx bxs-user-account sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                </span>
                <span class="sidebar-text ms-1 mt-0 d-block">Admin</span>
            </a>
        </li>

        <li class="nav-item {{ Request::segment(1) == 'reservations' ? 'active' : '' }}">
            <a href="{{ route('reservations.index') }}" class="nav-link d-flex">
                <span class="d-flex align-items-center justify-content-center" >
                    <i class="bx bx-receipt sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                </span>
                <span class="sidebar-text ms-1 mt-0 d-block">Reservasi</span>
            </a>
        </li>

        <li class="nav-item {{ Request::segment(1) == 'laporan' ? 'active' : '' }}">
            <a href="" class="nav-link d-flex">
                <span class="d-flex align-items-center justify-content-center" >
                    <i class="bx bx-notepad sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                </span>
                <span class="sidebar-text ms-1 mt-0 d-block">Laporan</span>
            </a>
        </li>
      @endrole


        @role('therapist')
        <li class="nav-item {{ Request::segment(2) == 'treatments' ? 'active' : '' }}">
            <a href="/therapist/treatments" class="nav-link d-flex">
                <span class="d-flex align-items-center justify-content-center" >
                    <i class="bx bx-buildings sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                </span>
                <span class="sidebar-text ms-1 mt-0 d-block">Treatment</span>
            </a>
        </li>

        <li class="nav-item {{ Request::segment(2) == 'customers' ? 'active' : '' }}">
            <a href="/therapist/customers" class="nav-link d-flex">
                <span class="d-flex align-items-center justify-content-center" >
                    <i class="bx bxs-user-account sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                </span>
                <span class="sidebar-text ms-1 mt-0 d-block">Customer</span>
            </a>
        </li>

        <li class="nav-item {{ Request::segment(2) == 'reservations' ? 'active' : '' }}">
            <a href="/therapist/reservations" class="nav-link d-flex">
                <span class="d-flex align-items-center justify-content-center" >
                    <i class="bx bx-receipt sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                </span>
                <span class="sidebar-text ms-1 mt-0 d-block">Reservasi</span>
            </a>
        </li>

        <li class="nav-item {{ Request::segment(2) == 'schedules' ? 'active' : '' }}">
            <a href="/therapist/schedules" class="nav-link d-flex">
                <span class="d-flex align-items-center justify-content-center" >
                    <i class="bx bxs-spreadsheet sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                </span>
                <span class="sidebar-text ms-1 mt-0 d-block">Jadwal Reservasi</span>
            </a>
        </li>

        <li class="nav-item {{ Request::segment(2) == 'presences' ? 'active' : '' }}">
            <a href="/therapist/presences" class="nav-link d-flex">
                <span class="d-flex align-items-center justify-content-center" >
                    <i class="bx bxs-calendar sidebar-icon " style="font-size: 1.5rem; padding-bottom: 0px"></i>
                </span>
                <span class="sidebar-text ms-1 mt-0 d-block">Presensi</span>
            </a>
        </li>

        @endrole

      <li class="nav-item sign-out" id="signOut">
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
