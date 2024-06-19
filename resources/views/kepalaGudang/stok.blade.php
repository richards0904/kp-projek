@extends('layout.masterKepala')

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Stok Barang</h1>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <!-- Button to Open the Modal -->
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal"
                        name="tambahDataStok">
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
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>ID Barang</th>
                                <th>Nama Barang</th>
                                <th>Jenis Barang</th>
                                <th>Harga/Crt</th>
                                <th>Stok Barang</th>
                                <th>Nilai Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Cara menampilkan data di database ke dalam website -->
                            @foreach ($stokBarang as $barangs)
                            <?php $total = $barangs->hargaBarang * $barangs->stokBarang?>
                                <tr>
                                    <td>{{ $barangs->idBarang }}</td>
                                    <td>{{ $barangs->namaBarang }}</td>
                                    <td>{{ $barangs->jenisBarang }}</td>
                                    <td>{{ $barangs->formatRupiah('hargaBarang') }}</td>
                                    <td>{{ $barangs->stokBarang }}</td>
                                    <td>{{ "Rp. ".number_format($total) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#edit{{ $barangs->idBarang }}">
                                            <i class="bi bi-pencil" style= "margin-right: 5px"></i>
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#delete{{ $barangs->idBarang }}">
                                            <i class="bi bi-trash3" style= "margin-right: 5px"></i>
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            <!-- The Edit Modal -->
                            @foreach ($stokBarang as $barangs)
                                <div class="modal fade" id="edit{{ $barangs->idBarang }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <!-- Edit Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Data</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Edit Modal body -->
                                            <div class="modal-body">
                                                <form method="post" action="{{route('edit.stok.post')}}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <input type="text" name="editNamaBarang"
                                                            value="{{ $barangs->namaBarang }}" maxlength="25" class="form-control" required>
                                                        <br>
                                                        <select name="editJenisBarang" id="editJenisBarang" class="form-select">
                                                            <option value="Kecap" {{ $barangs->jenisBarang === 'Kecap' ? 'selected' : '' }}>Kecap</option>
                                                            <option value="Sambal"  {{ $barangs->jenisBarang === 'Sambal' ? 'selected' : '' }}>Sambal</option>
                                                            <option value="Tomat"  {{ $barangs->jenisBarang === 'Tomat' ? 'selected' : '' }}>Tomat</option>
                                                            <option value="Sardine"  {{ $barangs->jenisBarang === 'Sardine' ? 'selected' : '' }}>Sardine</option>
                                                            <option value="Terasi"  {{ $barangs->jenisBarang === 'Terasi' ? 'selected' : '' }}>Terasi</option>
                                                            <option value="Syrup"  {{ $barangs->jenisBarang === 'Syrup' ? 'selected' : '' }}>Syrup</option>
                                                            <option value="Ready to Drink"  {{ $barangs->jenisBarang === 'Ready to Drink' ? 'selected' : '' }}>Ready to Drink</option>
                                                            <option value="NPD Product"  {{ $barangs->jenisBarang === 'NPD Product' ? 'selected' : '' }}>NPD Product</option>
                                                        </select>
                                                        <br>
                                                        <input type="number" name="editHargaBarang" value="{{ $barangs->hargaBarang }}" class="form-control" min="1000" required>
                                                        <br>
                                                        <input type="hidden" name="idBarang" value="{{ $barangs->idBarang }}">
                                                        <button type="submit" class="btn btn-primary"
                                                            name="editStokAyam">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- The Delete Modal -->
                            @foreach ($stokBarang as $barangs)
                                <div class="modal fade" id="delete{{ $barangs->idBarang }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <!-- Delete Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus Data?</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Delete Modal body -->
                                            <div class="modal-body">
                                                <form method="post" action="{{route('hapus.stok.post')}}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p style="margin-bottom: 5px">Apakah anda yakin ingin menghapus data stok {{ $barangs->namaBarang }} ?</p>
                                                            <span class="text-danger" style="display: block; margin-bottom: 15px" >(Setelah dihapus data yang berkaitan akan hilang dan tidak dapat dikembalikan)</span>
                                                        <input type="hidden" name="idBarang" value="{{ $barangs->idBarang }}">
                                                        <button a type="submit" class="btn btn-danger"
                                                            name="hapusStokAyam">Hapus</button>
                                                    </div>
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
                    <h4 class="modal-title">Tambah Barang</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form autocomplete="off" action="{{route('tambah.stok.post')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <input type="text" id="idBarang" name="idBarang" placeholder="Kode Barang" class="form-control" oninput="this.value = this.value.toUpperCase()" required>
                            <br>
                            <input type="text" id="namaBarang" name="namaBarang" placeholder="Nama Barang" maxlength="25"
                                class="form-control" required>
                            <br>
                            <select name="jenisBarang" id="jenisBarang" class="form-select">
                                <option value="Kecap">Kecap</option>
                                <option value="Sambal">Sambal</option>
                                <option value="Tomat">Tomat</option>
                                <option value="Sardine">Sardine</option>
                                <option value="Terasi">Terasi</option>
                                <option value="Syrup">Syrup</option>
                                <option value="Ready to Drink">Ready to Drink</option>
                                <option value="NPD Product">NPD Product</option>
                            </select>
                            <br>
                            <input type="number" id="hargaBarang" name="hargaBarang" min="1000" class="form-control"
                                placeholder="Harga Jual" required>
                            <br>
                            <button type="submit" class="btn btn-primary" name="addnewbarang">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
