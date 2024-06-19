@extends('layout.masterAdmin')

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Detail Pesanan</h1>
                <div class="card mb-4">
                    <div class="card-body">
                        @if (session()->has('pesan'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <span class="text-danger">{{ session()->get('pesan') }}</span>
                        </div>
                        @endif
                        @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <span class="text-danger">{{ session()->get('success') }}</span>
                        </div>
                        @endif
                        <h5>ID Pesanan: {{ $pesanan->idPesanan }}</h5>
                        <h5>Nama Toko: {{ $pesanan->toko->namaToko }}</h5>
                        <h5>Penginput: {{ $pesanan->pegawai->namaPegawai }}</h3>
                        <h5>Tanggal Pesanan: {{ $pesanan->tglPesanan }}</h5>
                        <h5>Total: {{ $pesanan->formatRupiah('total') }}</h5>
                        <!-- Button to Open the Modal -->
                        @if($pesanan->status == 'Dikonfirmasi')
                            <a href="{{ route('cetak.nota', $pesanan->idPesanan) }}" class="btn btn-primary">
                                <i class="bi bi-printer" style="margin-right: 5px"></i>
                                Cetak Nota
                            </a>
                        @endif
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah Barang</th>
                                    <th>Harga Barang</th>
                                    <th>SubTotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pesanan->detailPesanans as $detail)
                                    <tr>
                                        <td>{{ $detail->idBarang }}</td>
                                        <td>{{ $detail->stokBarang->namaBarang }}</td>
                                        <td>{{ $detail->qtyPesanan }}</td>
                                        <td>{{ $detail->stokBarang->formatRupiah('hargaBarang') }}</td>
                                        <td>{{ $detail->formatRupiah('subTotal')}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
@endsection
