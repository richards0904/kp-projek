@extends('layout.masterSuper')
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Kelola Pengguna</h1>
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
                                <th>No</th>
                                <th>Nama Pegawai</th>
                                <th>Email</th>
                                <th>No Telepon</th>
                                <th>Alamat Pegawai</th>
                                <th>Jabatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Cara menampilkan data di database ke dalam website -->
                            @foreach ($dataPengguna as $index => $admins)
                                <tr>
                                    <td>{{ $index + 1  }}</td>
                                    <td>{{ $admins->namaPegawai }}</td>
                                    <td>{{ $admins->email }}</td>
                                    <td>{{ $admins->noTelpPegawai }}</td>
                                    <td>{{ $admins->alamatPegawai }}</td>
                                    <td>{{ $admins->jabatan }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#edit{{ $admins->idPegawai }}">
                                            <i class="bi bi-pencil" style= "margin-right: 5px"></i>
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#delete{{ $admins->idPegawai }}">
                                            <i class="bi bi-trash3" style= "margin-right: 5px"></i>
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            <!-- The Edit Modal -->
                            @foreach ($dataPengguna as $admins)
                                <div class="modal fade" id="edit{{ $admins->idPegawai }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <!-- Edit Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Data</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Edit Modal body -->
                                            <div class="modal-body">
                                                <form method="post" action="{{route('edit.pengguna')}}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <input type="text" id="namaPegawai" name="namaPegawai" placeholder="Nama Pegawai" value="{{$admins->namaPegawai}}"  maxlength="30" class="form-control" required>
                                                        <br>
                                                        <input type="text" id="noTelpPegawai" name="noTelpPegawai" placeholder="Nomor Telepon Pegawai"
                                                        value="{{$admins->noTelpPegawai}}" minlength="10" maxlength="14"  class="form-control" required >
                                                        <br>
                                                        <input type="text" id="alamatPegawai" name="alamatPegawai" placeholder="Alamat Pegawai" value="{{$admins->alamatPegawai}}" maxlength="50" class="form-control" required >
                                                        <br>
                                                        <input type="email" id="email" name="email" placeholder="Email" value="{{$admins->email}}" class="form-control" required>
                                                        <br>
                                                        <input type="password" id="password" name="password" placeholder="Password"  value="{{$admins->noTelpPegawai}}" class="form-control" minlength="8" required>
                                                        <br>
                                                        <select class="form-select" name="jabatan" id="jabatan">
                                                            <option value="sales" @if ($admins->jabatan == 'sales')selected
                                                            @endif>Sales</option>
                                                            <option value="kepala gudang" @if ($admins->jabatan == 'kepala gudang')selected
                                                            @endif>Kepala Gudang</option>
                                                            <option value="admin" @if ($admins->jabatan == 'admin')selected
                                                            @endif>Admin</option>
                                                        </select>
                                                        <br>
                                                        <input type="hidden" name="idPegawai" value="{{ $admins->idPegawai }}">
                                                        <button type="submit" class="btn btn-primary"
                                                            name="editdataPengguna">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- The Delete Modal -->
                            @foreach ($dataPengguna as $admins)
                                <div class="modal fade" id="delete{{ $admins->idPegawai }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <!-- Delete Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus Data?</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Delete Modal body -->
                                            <div class="modal-body">
                                                <form method="post" action="{{route('hapus.pengguna')}}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p style="margin-bottom: 5px">Apakah anda yakin ingin menghapus data Pegawai {{ $admins->namaPegawai }} ?</p>
                                                            <span class="text-danger" style="display: block; margin-bottom: 15px" >(Setelah dihapus data yang berkaitan akan hilang dan tidak dapat dikembalikan)</span>
                                                        <input type="hidden" name="idPegawai" value="{{ $admins->idPegawai }}">
                                                        <button a type="submit" class="btn btn-danger"
                                                            name="hapusdataPengguna">Hapus</button>
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
                    <h4 class="modal-title">Tambah Pegawai</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form autocomplete="off" action="{{route('tambah.pengguna')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <input type="text" id="namaPegawai" name="namaPegawai" placeholder="Nama Pegawai" maxlength="30" class="form-control" required >
                            <br>
                            <input type="text" id="noTelpPegawai" name="noTelpPegawai" placeholder="Nomor Telepon Pegawai" minlength="10" maxlength="14" class="form-control" required >
                            <br>
                            <input type="text" id="alamatPegawai" name="alamatPegawai" placeholder="Alamat Pegawai" class="form-control" maxlength="50" required >
                            <br>
                            <input type="email" id="email" name="email" placeholder="Email" class="form-control" required>
                            <br>
                            <input type="password" id="password" name="password" placeholder="Password" minlength="8" class="form-control" required>
                            <br>
                            <select class="form-select" name="jabatan" id="jabatan">
                                <option value="sales" selected>Sales</option>
                                <option value="kepala gudang">Kepala Gudang</option>
                                <option value="admin">Admin</option>
                            </select>
                            <br>

                            <button type="submit" class="btn btn-primary" name="addnewPegawai">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
