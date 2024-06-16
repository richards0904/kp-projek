@extends('layout.master')

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
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal" name="tambahDataDetail">
                            <i class="bi bi-plus-circle" style= "margin-right: 5px"></i>
                            Tambah Data
                        </button>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah Barang</th>
                                    <th>Harga Barang</th>
                                    <th>SubTotal</th>
                                    <th>Aksi</th>
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
                                        <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#edit{{ $detail->idBarang }}">
                                                <i class="bi bi-pencil" style= "margin-right: 5px"></i>
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#delete{{ $detail->idBarang }}">
                                                <i class="bi bi-trash3" style= "margin-right: 5px"></i>
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="edit{{ $detail->idBarang }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">Edit Jumlah Barang Pesanan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('detail.pesanan.ubah') }}" method="post">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <input type="number" id="editQtyPesanan" name="editQtyPesanan" placeholder="Banyak Pesanan" min="1" class="form-control" value="{{ $detail->qtyPesanan }}" required>
                                                            <input type="hidden" name="editIdPesanan" id="editIdPesanan" value="{{$pesanan->idPesanan}}">
                                                            <input type="hidden" name="editIdBarang" id="editIdBarang" value="{{$detail->idBarang}}">
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="delete{{ $detail->idBarang }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Hapus Barang Pesanan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin menghapus barang pesanan ini?</p>
                                                    <form action="{{ route('detail.pesanan.hapus') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="hapusIdPesanan" id="hapusIdPesanan" value="{{$pesanan->idPesanan}}">
                                                        <input type="hidden" name="hapusIdBarang" id="hapusIdBarang" value="{{$detail->idBarang}}">
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
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
    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Barang Pesanan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{route('detail.pesanan.tambah')}}" method="post">
                        @csrf
                            <div class="mb-3">
                                <input type="text" id="idBarang" name="idBarang" list="kodeBarang" placeholder="Kode Barang" class="form-select" oninput="this.value = this.value.toUpperCase()" placeholder="ID Barang">
                                <datalist id="kodeBarang">
                                    @foreach ($stokBarangs as $barangs)
                                    <option value="{{ $barangs->idBarang }}" data-namabarang="{{ $barangs->namaBarang }}">{{ $barangs->idBarang }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="mb-3">
                                <input type="number" id="qtyPesanan" name="qtyPesanan" class="form-control" placeholder="Banyak Barang" min="1" required>
                            </div>
                            <input type="hidden" name="idPesanan" id="idPesanan" value=" {{ $pesanan->idPesanan }}">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
