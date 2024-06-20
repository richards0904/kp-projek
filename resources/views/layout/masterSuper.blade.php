<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Sistem Penjualan</title>
    <link rel="icon" href="{{ asset('gambar/logo.ico') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> {{-- CSS Bootsrap Icon --}}
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/tombolPesanan.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="#">Sistem Penjualan</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="bi bi-grid-3x3-gap-fill"></i></button>
        <!-- Navbar-->
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div>
                            <h6 style="text-align: center; font-weight: 400; color: white; padding: 3%">Halo {{auth()->user()->namaPegawai}} anda adalah seorang {{auth()->user()->jabatan}}</h6>
                        </div>
                        <a class="nav-link" href="{{route('pengguna.halaman')}}">
                            <div class="sb-nav-link-icon"><i class="bi bi-envelope"></i></div>
                            Kelola Pengguna
                        </a>
                        <a class="nav-link" href="/logout">
                            <div class="sb-nav-link-icon"><i class="bi bi-box-arrow-left"></i></div>
                            Log Out
                        </a>
                    </div>
            </nav>
        </div>
        @yield('content')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
        </script>
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="{{ asset('js/datatables.js') }}"></script>
</body>

</html>
