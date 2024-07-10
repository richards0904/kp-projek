@extends('layout.masterSales')

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Lihat Stok</h1>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <table class="table" id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>ID Barang</th>
                                <th>Nama Barang</th>
                                <th>Jenis Barang</th>
                                <th>Harga/Crt</th>
                                <th>Stok Barang</th>
                                <th>Nilai Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stokBarang as $barangs)
                            <?php $total = $barangs->hargaBarang * $barangs->stokBarang?>
                                <tr>
                                    <td>{{ $barangs->idBarang }}</td>
                                    <td>{{ $barangs->namaBarang }}</td>
                                    <td>{{ $barangs->jenisBarang }}</td>
                                    <td>{{ $barangs->formatRupiah('hargaBarang') }}</td>
                                    <td>{{ $barangs->stokBarang }}</td>
                                    <td>{{ "Rp. ".number_format($total , 0, ',' , '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
@endsection
