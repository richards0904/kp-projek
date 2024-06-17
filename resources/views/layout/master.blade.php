<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>BarangKoe</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> {{-- CSS Bootsrap Icon --}}
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/tombolPesanan.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="#">BarangKoe</a>
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
                        {{-- Mulai Stok DropDown --}}
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="bi bi-houses-fill"></i></div>
                            Stok
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{route('stok.barang')}}">
                                    <div class="sb-nav-link-icon"><i class="bi bi-house-door-fill"></i></div>
                                    Stok Barang
                                </a>
                                <a class="nav-link" href="{{route('barang.masuk')}}">
                                    <div class="sb-nav-link-icon"><i class="bi bi-house-add-fill"></i></div>
                                    Barang Masuk
                                </a>
                                <a class="nav-link" href="{{route('barang.keluar')}}">
                                    <div class="sb-nav-link-icon"><i class="bi bi-house-dash-fill"></i></div>
                                    Barang Keluar
                                </a>
                            </nav>
                        </div>
                        {{-- Akhir Stok DropDown --}}
                        <a class="nav-link" href="{{route('toko.pelanggan')}}">
                            <div class="sb-nav-link-icon"><i class="bi bi-shop"></i></div>
                            Data Toko
                        </a>
                        <a class="nav-link" href="{{route('pesanan.barang')}}">
                            <div class="sb-nav-link-icon"><i class="bi bi-envelope"></i></div>
                            Rekap Pesanan
                        </a>
                        <a class="nav-link" href="{{route('penjualan.barang')}}">
                            <div class="sb-nav-link-icon"><i class="bi bi-envelope"></i></div>
                            Penjualan
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="{{ asset('js/datatables.js') }}"></script>
</body>

</html>
