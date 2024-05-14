@extends('layout.master')

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Stok Barang</h1>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <!-- Button to Open the Modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal"
                        name="tambahDataStok">
                        Tambah Data
                    </button>
                </div>
                <div class="card-body">

                    {{-- <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>Perhatian!!!</strong> Stok Ayam Telah Habis
                    </div> --}}

                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>ID Barang</th>
                                <th>Nama Barang</th>
                                <th>Jenis Barang</th>
                                <th>Harga Barang</th>
                                <th>Stok Barang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Cara menampilkan data di database ke dalam website -->
                            @foreach ($stokBarang as $barangs)
                                <tr>
                                    <td>{{ $barangs->idBarang }}</td>
                                    <td>{{ $barangs->namaBarang }}</td>
                                    <td>{{ $barangs->jenisBarang }}</td>
                                    <td>{{ $barangs->formatRupiah('hargaBarang') }}</td>
                                    <td>{{ $barangs->stokBarang }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#edit{{ $barangs->idBarang }}">
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#delete{{ $barangs->idBarang }}">
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
                                                            value="{{ $barangs->namaBarang }}" class="form-control" required>
                                                        <br>
                                                        <input type="text" name="editJenisBarang"
                                                            value="{{ $barangs->jenisBarang }}" class="form-control" required>
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
                                                        <p>Apakah anda yakin ingin menghapus {{ $barangs->namaBarang }} ? </p>
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
                    <form action="{{route('tambah.stok.post')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <input type="text" id="namaBarang" name="namaBarang" placeholder="Nama Barang"
                                class="form-control" required>
                            <br>
                            <input type="text" id="jenisBarang" name="jenisBarang" placeholder="Jenis Barang "
                                class="form-control" required>
                            <br>
                            <input type="number" id="hargaBarang" name="hargaBarang" class="form-control"
                                placeholder="Harga Jual" min="0" required>
                            <br>
                            <button type="submit" class="btn btn-primary" name="addnewbarang">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
