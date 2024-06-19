<!DOCTYPE html>
<html>
<head>
    <title>Nota Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            margin: 20px;
        }
        .header, .footer {
            text-align: center;
        }
        .content {
            margin-top: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Nota Pesanan</h1>
            <p>ID Pesanan: {{ $pesanan->idPesanan }}</p>
        </div>
        <div class="content">
            <h3>Detail Toko</h3>
            <p>Nama Toko: {{ $pesanan->toko->namaToko }}</p>
            <h3>Detail Pegawai</h3>
            <p>Penginput: {{ $pesanan->pegawai->namaPegawai }}</p>
            <h3>Detail Pesanan</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Barang</th>
                        <th>Nama Barang</th>
                        <th>Jumlah Barang</th>
                        <th>Harga Barang</th>
                        <th>SubTotal</th>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <h3>Total: {{ $pesanan->formatRupiah('total') }}</h3>
        </div>
        <div class="footer">
            <p>Terima kasih atas pesanan Anda!</p>
        </div>
    </div>
</body>
</html>
