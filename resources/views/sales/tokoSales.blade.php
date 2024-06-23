@extends('layout.masterSales')
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Kelola Toko</h1>
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
                                <th>ID Toko</th>
                                <th>Nama Toko</th>
                                <th>Alamat</th>
                                <th>Nomor Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Cara menampilkan data di database ke dalam website -->
                            @foreach ($dataToko as $tokos)
                                <tr>
                                    <td>{{ $tokos->idToko }}</td>
                                    <td>{{ $tokos->namaToko }}</td>
                                    <td>{{ $tokos->alamat }}</td>
                                    <td>{{ $tokos->noTelp }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#edit{{ $tokos->idToko }}">
                                            <i class="bi bi-pencil" style= "margin-right: 5px"></i>
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#delete{{ $tokos->idToko }}">
                                            <i class="bi bi-trash3" style= "margin-right: 5px"></i>
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            <!-- The Edit Modal -->
                            @foreach ($dataToko as $tokos)
                                <div class="modal fade" id="edit{{ $tokos->idToko }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <!-- Edit Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Data</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Edit Modal body -->
                                            <div class="modal-body">
                                                <form method="post" action="{{route('edit.toko.post')}}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <input type="text" name="editNamaToko" id="editNamaToko"
                                                            value="{{ $tokos->namaToko }}" maxlength="60" class="form-control" required>
                                                        <br>
                                                        <input type="text" name="editAlamat" id="editAlamat"
                                                            value="{{ $tokos->alamat }}" maxlength="60" class="form-control" required>
                                                        <br>
                                                        <input type="text" name="editNoTelp" id="editNoTelp"
                                                            value="{{ $tokos->noTelp }}"  minlength="10" maxlength="14" class="form-control" required>
                                                        <br>
                                                        <input type="hidden" name="idToko" value="{{ $tokos->idToko }}">
                                                        <button type="submit" class="btn btn-primary"
                                                            name="editDataToko">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- The Delete Modal -->
                            @foreach ($dataToko as $tokos)
                                <div class="modal fade" id="delete{{ $tokos->idToko }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <!-- Delete Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus Data?</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Delete Modal body -->
                                            <div class="modal-body">
                                                <form method="post" action="{{route('hapus.toko.post')}}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p style="margin-bottom: 5px">Apakah anda yakin ingin menghapus data toko {{ $tokos->namaToko }} ?</p>
                                                            <span class="text-danger" style="display: block; margin-bottom: 15px" >(Setelah dihapus data yang berkaitan akan hilang dan tidak dapat dikembalikan)</span>
                                                        <input type="hidden" name="idToko" value="{{ $tokos->idToko }}">
                                                        <button a type="submit" class="btn btn-danger"
                                                            name="hapusDataToko">Hapus</button>
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
                    <h4 class="modal-title">Tambah Toko</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form autocomplete="off" action="{{route('tambah.toko.post')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <input type="text" id="namaToko" name="namaToko" placeholder="Nama Toko" maxlength="60" class="form-control" required >
                            <br>
                            <input type="text" id="alamat" name="alamat" placeholder="Alamat Toko" maxlength="60" class="form-control" required >
                            <br>
                            <input type="text" id="noTelp" name="noTelp" placeholder="Nomor Telepon" class="form-control" required>
                            <br>
                            <button type="submit" class="btn btn-primary" name="addnewtoko">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
