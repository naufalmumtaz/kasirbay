<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title') - Kasirbay</title>
    <link rel="stylesheet" href="{{ asset('admin_dashboard/css/bootstrap.min.css') }}" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
      integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="{{ asset('admin_dashboard/css/style.css') }}" />

    @stack('style')
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-light navbar-light">
      <div class="container-fluid">
        <!-- Offcanvas trigger -->
        <button
          class="navbar-toggler me-2"
          type="button"
          data-bs-toggle="offcanvas"
          data-bs-target="#offcanvasExample"
          aria-controls="offcanvasExample"
        >
          <span class="navbar-toggler-icon" data-bs-target="#offcanvasExample"></span>
        </button>

        <a class="navbar-brand me-auto" href="#">
          <img src="{{ asset('images/logo_nobg.png') }}" width="50">
          <span class="align-middle">Kasirbay</span>
        </a>
        <ul class="nav ms-auto">
          <li class="nav-item dropdown">
            <a
              class="nav-link text-dark dropdown-toggle"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <i class="fa fa-bell fs-5" aria-hidden="true"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end"">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><hr class="dropdown-divider" /></li>
              <li>
                <a class="dropdown-item" href="#">Something else here</a>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a
              class="nav-link text-dark dropdown-toggle"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <i class="fa fa-user fs-5" aria-hidden="true"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end"">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><hr class="dropdown-divider" /></li>
              <li>
                <a class="dropdown-item" href="#">Something else here</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Sidebar -->
    <div
      class="offcanvas offcanvas-start sidebar-nav bg-dark text-light"
      tabindex="-1"
      id="offcanvasExample"
      aria-labelledby="offcanvasExampleLabel"
    >
      <div class="offcanvas-body p-0">
        <nav class="navbar-dark">
          <ul class="navbar-nav">
            <li>
              <div class="px-3 py-2 d-flex sidebar-profile">
                  <div>
                      <img src="{{ asset('images/logo.png') }}" width="40" class="rounded-circle">
                  </div>
                  <div class="sidebar-profile-name">
                      <p class="sidebar-name">
                          Admin
                      </p>
                      <p class="sidebar-email">
                          admin@gmail.com
                      </p>
                  </div>
              </div>
          </li>
            <small class="fw-semibold text-uppercase px-3 my-2">
              Menu
            </small>
            <li>
              <a class="nav-link px-3 py-2 {{ Request::is('admin') ? "active" : "" }}" href="index.html">
                  <i class="me-2 fa fa-tachometer" aria-hidden="true"></i> <span>Dashboard</span>
              </a>
            </li>
            <li>
                <a class="nav-link px-3 {{ Request::is('admin/supplier') ? "active" : "" }}" href="supplier.html">
                    <i class="me-2 fa fa-truck" aria-hidden="true"></i> <span>Supplier</span>
                </a>
            </li>
            <li>
              <a class="nav-link px-3 py-2 sidebar-link {{ Request::is('admin/produk*') || Request::is('admin/kategori-produk*') ? "active" : "" }}" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="{{ Request::is('admin/produk*') || Request::is('admin/kategori-produk*') ? "true" : "false" }}" aria-controls="collapseExample">
                <i class="me-2 fa fa-archive" aria-hidden="true"></i>
                <span>Produk</span>
                <span class="ms-auto right-icon">
                  <i class="fa fa-chevron-down" aria-hidden="true"></i>
                </span>
              </a>
              <div class="collapse {{ Request::is('admin/produk*') || Request::is('admin/kategori-produk*') ? "show" : "" }}" id="collapseExample">
                <ul class="navbar-nav ps-3">
                  <li>
                    <a href="#" class="nav-link px-3 py-2 {{ Request::is('admin/produk*') ? "active" : "" }}">
                      Produk
                    </a>
                  </li>
                  <li>
                    <a href="#" class="nav-link px-3 py-2 {{ Request::is('admin/kategori-produk*') ? "active" : "" }}">
                      Kategori Produk
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li>
                <a class="nav-link px-3 py-2 {{ Request::is('admin/transaksi*') ? "active" : "" }}" href="transaksi.html">
                    <i class="me-2 fa fa-credit-card" aria-hidden="true"></i> <span>Transaksi</span>
                </a>
            </li>
            <li>
                <a class="nav-link px-3 py-2 {{ Request::is('admin/pelanggan') ? "active" : "" }}" href="pelanggan.html">
                    <i class="me-2 fa fa-user" aria-hidden="true"></i> <span>Pelanggan</span>
                </a>
            </li>
            <li>
                <a class="nav-link px-3 py-2 {{ Request::is('admin/pelaporan') ? "active" : "" }}" href="pelaporan.html">
                    <i class="me-2 fa fa-file-text" aria-hidden="true"></i> <span>Pelaporan</span>
                </a>
            </li>
            <li>
                <a class="nav-link px-3 py-2 {{ Request::is('admin/karyawan') ? "active" : "" }}" href="karyawan.html">
                    <i class="me-2 fa fa-users" aria-hidden="true"></i> <span>Karyawan</span>
                </a>
            </li>
            <li>
                <a class="nav-link px-3 py-2 {{ Request::is('admin/cabang*') ? "active" : "" }}" href="cabang.html">
                    <i class="me-2 fa fa-building" aria-hidden="true"></i> <span>Cabang</span>
                </a>
            </li>
            <li>
                <a class="nav-link px-3 py-2 {{ Request::is('admin/users') ? "active" : "" }}" href="users.html">
                    <i class="me-2 fa fa-user-secret" aria-hidden="true"></i> <span>Users</span>
                </a>
            </li>
            <small class="fw-semibold text-uppercase px-3 my-2">
              Pengaturan
            </small>
            <li>
                <a class="nav-link px-3 py-2" href="profil.html">
                    <i class="me-2 fa fa-user-circle-o" aria-hidden="true"></i> <span>Profil</span>
                </a>
            </li>
            <li>
                <a class="nav-link px-3 py-2" href="pengaturan.html">
                    <i class="me-2 fa fa-cog" aria-hidden="true"></i> <span>Pengaturan</span>
                </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>

    <!-- Main -->
    <main class="mt-4">
      <div class="container-fluid">
        <div class="row mb-1">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="fw-bold fs-3">
                        @yield('title')
                    </h4>
                    <p class="fs-6">@yield('title')</p>
                  </div>
                  <div>
                    @yield('titleProp')
                  </div>
            </div>
        </div>
        @yield('content')
      </div>
    </main>

    <script src="{{ asset('admin_dashboard/js/bootstrap.bundle.min.js') }}"></script>
    @stack('script')
    @include('sweetalert::alert')
  </body>
</html>
