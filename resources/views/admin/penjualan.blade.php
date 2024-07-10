@extends('layout.masterAdmin')
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Penjualan</h1>
                <form method="POST" action="{{ route('penjualan.filter') }}" class="mb-4">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <label for="bulan">Bulan</label>
                            <select id="bulan" name="bulan" class="form-control">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $i == $bulan ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="tahun">Tahun</label>
                            <select id="tahun" name="tahun" class="form-control">
                                @for ($i = date('Y'); $i >= 2000; $i--)
                                    <option value="{{ $i }}" {{ $i == $tahun ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3 align-self-end">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
                <div class="mb-4">
                    <a href="{{ route('penjualan.laporan', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-primary">
                        <i class="bi bi-printer" style="margin-right: 5px"></i>
                        Cetak Laporan
                    </a>
                </div>
            </div>
            <div class="card mb-4">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th class="text-center">ID Pesanan</th>
                                <th class="text-center">Toko Pemesan</th>
                                <th class="text-center">Penginput</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Tanggal Pesan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Cara menampilkan data di database ke dalam website -->
                            @foreach ($pesananKonfirmasi as $pesanans)
                                <tr>
                                    <td class="text-center">{{ $pesanans->idPesanan }}</td>
                                    <td class="text-center">{{ $pesanans->namaToko }}</td>
                                    <td class="text-center">{{ $pesanans->namaPegawai }}</td>
                                    <td class="text-center">{{ $pesanans->formatRupiah('total')}}</td>
                                    <td class="text-center"><div @if ($pesanans->status == 'Dikonfirmasi')
                                        class= "text-light bg-success"
                                        @endif class="text-dark bg-warning">{{ $pesanans->status }}</div>
                                    </td>
                                    <td class="text-center">{{ $pesanans->tglPesanan }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('detail.admin', $pesanans->idPesanan) }}" class="btn btn-info">
                                        <i class="bi bi-eye" style="margin-right: 5px"></i>
                                        Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
