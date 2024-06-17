@extends('layout.master')

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Rekap Pesanan</h1>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <!-- Button to Open the Modal -->
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal"
                        name="tambahDataPesanan">
                        <i class="bi bi-plus-circle" style= "margin-right: 5px"></i>
                        Tambah Data
                    </button>
                </div>
                <div class="card-body">
                    {{-- <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>Perhatian!!!</strong> Stok Ayam Telah Habis
                    </div> --}}
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
                                <th>ID Pesanan</th>
                                <th>Toko Pemesan</th>
                                <th>Penginput</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal Pesan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Cara menampilkan data di database ke dalam website -->
                            @foreach ($pesananAll as $pesanans)
                                <tr>
                                    <td>{{ $pesanans->idPesanan }}</td>
                                    <td>{{ $pesanans->namaToko }}</td>
                                    <td>{{ $pesanans->namaPegawai }}</td>
                                    <td>{{ $pesanans->formatRupiah('total')}}</td>
                                    <td>{{ $pesanans->status }}</td>
                                    <td>{{ $pesanans->tglPesanan }}</td>
                                    <td>
                                        <div class="button-group">
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#konfirmasi{{ $pesanans->idPesanan }}"@if($pesanans->status == 'Dikonfirmasi') disabled @endif>
                                                <i class="bi bi-check-square" style="margin-right: 5px"></i>
                                                Konfirmasi
                                            </button>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit{{ $pesanans->idPesanan }}" data-idpesanan="{{ $pesanans->idPesanan }}" data-idtoko="{{ $pesanans->idToko }}"  @if($pesanans->status == 'Dikonfirmasi') disabled @endif>
                                                <i class="bi bi-pencil" style="margin-right: 5px"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#delete{{ $pesanans->idPesanan }}"  @if($pesanans->status == 'Dikonfirmasi') disabled @endif>
                                                <i class="bi bi-trash3" style= "margin-right: 5px"></i>
                                                Hapus
                                            </button>
                                            <a href="{{ route('detail.pesanan', $pesanans->idPesanan) }}" class="btn btn-info">
                                                <i class="bi bi-eye" style="margin-right: 5px"></i>
                                                Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <!-- The Edit Modal -->
                            @foreach ($pesananAll as $pesanans)
                                <div class="modal fade" id="edit{{ $pesanans->idPesanan }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <!-- Edit Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Data</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Edit Modal body -->
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('edit.pesanan.post')}}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <select id="editIdToko" name="idToko" class="form-select" required>
                                                            @foreach ($tokoAll as $toko)
                                                                <option value="{{ $toko->idToko }}">{{ $toko->namaToko }}</option>
                                                            @endforeach
                                                        </select>
                                                        <br>
                                                        <input type="hidden" name="editIdPesanan" value="{{ $pesanans->idPesanan }}">
                                                        <button type="submit" class="btn btn-primary"
                                                            name="editDataPesanan">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- The Delete Modal -->
                            @foreach ($pesananAll as $pesanans)
                                <div class="modal fade" id="delete{{ $pesanans->idPesanan }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <!-- Delete Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus Data?</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Delete Modal body -->
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('hapus.pesanan.post')}}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p style="margin-bottom: 5px">Apakah anda yakin ingin menghapus pesanan ini? </p>
                                                            <span class="text-danger" style="display: block; margin-bottom: 15px" >(Pesanan yang dihapus tidak dapat dikembalikan)</span>
                                                        <input type="hidden" name="idPesanan" value="{{ $pesanans->idPesanan }}">
                                                        <button a type="submit" class="btn btn-danger"
                                                            name="hapusDataPesanan">Hapus</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- Konfirmasi Modal -->
                            @foreach ($pesananAll as $pesanans)
                                <div class="modal fade" id="konfirmasi{{ $pesanans->idPesanan }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <!-- Konfirmasi Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Konfirmasi Pesanan?</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Konfirmasi Modal body -->
                                            <div class="modal-body">
                                                @if ($pesanans->status !== 'Dikonfirmasi')
                                                <form method="post" action="{{ route('pesanan.konfirmasi', $pesanans->idPesanan) }}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p style="margin-bottom: 5px">Apakah anda yakin ingin mengkonfirmasi pesanan ini? </p>
                                                            <span class="text-danger" style="display: block; margin-bottom: 15px;" >(Setelah Dikonfirmasi pesanan tidak dapat dibatalkan)</span>
                                                        <button a type="submit" class="btn btn-success"
                                                            name="konfirmasiPesanan">Konfirmasi</button>
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
    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Pesanan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form autocomplete="off" action="{{route('tambah.pesanan.post')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <input type="text" id="idToko" name="idToko" list="kodeToko" class="form-select"  placeholder="Ketik Nama Toko">
                            <datalist id="kodeToko">
                                @foreach ($tokoAll as $tokos)
                                    <option value="{{ $tokos->idToko }}" data-namaToko="{{ $tokos->namaToko }}">{{ $tokos->namaToko }}</option>
                                @endforeach
                            </datalist>
                            <br>
                            <input type="text" id="namaToko" name="namaToko" placeholder="Nama Toko" class="form-control" disabled>
                            <br>
                            <input type="text" id="namaPegawai" name="namaPegawai" placeholder="Nama Pegawai" value="{{auth()->user()->namaPegawai}}" class="form-control" disabled>
                            <br>
                            <input type="hidden" id="idPegawai" name="idPegawai" value="{{auth()->user()->idPegawai}}" class="form-control">
                            <button type="submit" class="btn btn-primary" name="addnewpesanan">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/kode_toko.js') }}"></script>
    <script src="{{ asset('js/auto_refresh.js') }}"></script>
@endsection
