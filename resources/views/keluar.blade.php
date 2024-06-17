@extends('layout.master')
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Barang Keluar</h1>
            </div>
            <div class="card mb-4">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Tanggal Keluar</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Quantity Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Cara menampilkan data di database ke dalam website -->
                            @foreach ($stokBarangKeluar as $keluar)
                                <tr>
                                    <td>{{ $keluar->tglKeluar }} </td>
                                    <td>{{ $keluar->idBarang }}</td>
                                    <td>{{ $keluar->namaBarang }}</td>
                                    <td>{{ $keluar->qtyKeluar }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
