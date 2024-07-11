@extends('layout.masterAdmin')
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Rekap Pesanan</h1>
            </div>
            <div class="card mb-4">
            </div>
                <div class="card-body">
                    @if (session()->has('pesan'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <span class="text-danger">{{ session()->get('pesan') }}</span>
                    </div>
                    @endif
                    @if (session('msg'))
                        <div class="alert alert-warning">
                            {{ session('msg') }}
                        </div>
                    @endif
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
                            @foreach ($pesananAll as $pesanan)
                                <tr>
                                    <td class="text-center">{{ $pesanan->idPesanan }}</td>
                                    <td class="text-center">{{ $pesanan->namaToko }}</td>
                                    <td class="text-center">{{ $pesanan->namaPegawai }}</td>
                                    <td class="text-center">{{ $pesanan->formatRupiah('total')}}</td>
                                    <td class="text-center"><div @if ($pesanan->status == 'Dikonfirmasi')
                                        class= "text-light bg-success"
                                        @endif class="text-dark bg-warning">{{ $pesanan->status }}</div>
                                    </td>
                                    <td class="text-center">{{ $pesanan->tglPesanan }}</td>
                                    <td>
                                        <div class="button-group">
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#konfirmasi{{ $pesanan->idPesanan }}"@if($pesanan->status == 'Dikonfirmasi' || $pesanan->total == 0) disabled @endif>
                                                <i class="bi bi-check-square" style="margin-right: 5px"></i>
                                                Konfirmasi
                                            </button>
                                            <a href="{{ route('detail.admin', $pesanan->idPesanan) }}" class="btn btn-info">
                                                <i class="bi bi-eye" style="margin-right: 5px;"></i>
                                                Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Konfirmasi Modal -->
                                <div class="modal fade" id="konfirmasi{{ $pesanan->idPesanan }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <!-- Konfirmasi Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Konfirmasi Pesanan?</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Konfirmasi Modal body -->
                                        <div class="modal-body">
                                        @if ($pesanan->status !== 'Dikonfirmasi')
                                            <form method="post" action="{{ route('pesanan.konfirmasi', $pesanan->idPesanan) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <p style="margin-bottom: 5px">Apakah anda yakin ingin mengkonfirmasi pesanan ini? </p>
                                                    <span class="text-danger" style="display: block; margin-bottom: 15px;" >(Setelah Dikonfirmasi pesanan tidak dapat dibatalkan)</span>
                                                    <button a type="submit" class="btn btn-success" name="konfirmasiPesanan">Konfirmasi
                                                    </button>
                                            </form>
                                        @else
                                        <button class="btn btn-secondary" disabled>Sudah Dikonfirmasi</button>
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
    </main>
    <script src="{{ asset('js/auto_refresh.js') }}"></script>
@endsection
