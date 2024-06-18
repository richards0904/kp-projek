@extends('layout.masterAdmin')
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Barang Masuk</h1>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <!-- Button to Open the Modal -->
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal">
                        <i class="bi bi-plus-circle" style= "margin-right: 5px"></i>Tambah Data
                    </button>
                </div>
                <div class="card-body">
                    @if ($errors->has('idBarang'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <span class="text-danger">{{ $errors->first('idBarang') }}</span>
                    </div>
                    @endif
                    @if (session()->has('pesan'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <span class="text-danger">{{ session()->get('pesan') }}</span>
                    </div>
                    @endif
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Tanggal Masuk</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Quantity Masuk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- Cara menampilkan data di database ke dalam website -->
                            @foreach ($stokBarangMasuk as $masuk)
                                <tr>
                                    <td>{{ $masuk->tglMasuk }} </td>
                                    <td>{{ $masuk->idBarang }}</td>
                                    <td>{{ $masuk->namaBarang }}</td>
                                    <td>{{ $masuk->qtyMasuk }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#edit{{ $masuk->idBarangMasuk }}">
                                            <i class="bi bi-pencil" style= "margin-right: 5px"></i>
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#delete{{ $masuk->idBarangMasuk }}">
                                            <i class="bi bi-trash3" style= "margin-right: 5px"></i>
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            <!-- The Edit Modal -->
                            @foreach ($stokBarangMasuk as $masuk)
                                <div class="modal fade" id="edit{{ $masuk->idBarangMasuk }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <!-- Edit Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Data</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Edit Modal body -->
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('edit.barang.masuk') }}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <input type=text value='{{ $masuk->namaBarang }}'
                                                            class='form-control' disabled>
                                                        <br>
                                                        <input type="number" name="qtyMasuk"
                                                            value="{{ $masuk->qtyMasuk }}" class="form-control" min="1" required>
                                                        <br>
                                                        <input type="hidden" name="idBarangMasuk"
                                                            value="{{ $masuk->idBarangMasuk }}">
                                                        <input type="hidden" name="idBarang" value="{{ $masuk->idBarang }}">
                                                        <button type="submit" class="btn btn-primary"
                                                            name="editmasukbarang">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- The Delete Modal -->
                            @foreach ($stokBarangMasuk as $masuk)
                                <div class="modal fade" id="delete{{ $masuk->idBarangMasuk }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <!-- Delete Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus Data?</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Delete Modal body -->
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('hapus.barang.masuk') }}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p style="margin-bottom: 5px">Apakah anda yakin ingin menghapus {{ $masuk->namaBarang }} ?</p>
                                                        <span class="text-danger" style="display: block; margin-bottom: 15px" >(Setelah dihapus data tidak dapat dikembalikan)</span>
                                                        <input type="hidden" name="idBarangMasuk"
                                                            value="{{ $masuk->idBarangMasuk }}">
                                                        <input type="hidden" name="qtyMasuk"
                                                            value="{{ $masuk->qtymasuk }}">
                                                        <input type="hidden" name="idBarang" value="{{ $masuk->idBarang }}">
                                                        <button type="submit" class="btn btn-danger"
                                                            name="hapusmasukbarang">Hapus</button>
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
                    <h4 class="modal-title">Tambah Barang Masuk</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form autocomplete="off" method="post" name="tambahBarangMasuk" action="{{ route('tambah.barang.masuk') }}">
                        @csrf
                        <div class="modal-body">
                            <div>
                                <input type="text" id="idBarang" name="idBarang" list="kodeBarang" class="form-select" placeholder="Ketik Nama Barang">
                                <datalist id="kodeBarang">
                                    @foreach ($stokBarang as $barangs)
                                    <option value="{{ $barangs->idBarang }}" data-namabarang="{{ $barangs->namaBarang }}">{{ $barangs->namaBarang }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                            <br>
                            <input type="text" id="namaBarang" name="namaBarang" placeholder="Nama Barang" class="form-control" disabled>
                            <br>
                            <input type="number" name="qtyMasuk" class="form-control" placeholder="Quantity Masuk" min="1" required>
                            <br>
                            <button type="submit" class="btn btn-primary" name="barangmasuk">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script src="{{ asset('js/kode_nama.js') }}"></script>
@endsection
