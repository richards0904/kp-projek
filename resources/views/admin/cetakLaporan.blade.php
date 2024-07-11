<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
        }
        .header p {
            margin: 5px 0;
        }
        .kop-surat img {
            max-width: 100%;
            height: auto;
            max-height: 150px;
            margin: 0 auto;
            display: block;
            page-break-inside: avoid;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        .right{
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="kop-surat">
        <img src="{{ public_path('gambar/kop.jpg') }}" alt="Kop Surat">
    </div>
    <h2>Laporan Penjualan Bulan {{ date('F', mktime(0, 0, 0, $bulan, 1)) }} Tahun {{ $tahun }}</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Pesanan</th>
                <th>Tanggal Pesan</th>
                <th>Toko Pemesan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            {{ $totalSemuaPesanan = 0;}}
            @foreach ($pesananKonfirmasi as $index => $pesanan)
                <tr>
                    <td>{{$index + 1 }}</td>
                    <td>{{ $pesanan->idPesanan }}</td>
                    <td>{{ $pesanan->tglPesanan }}</td>
                    <td>{{ $pesanan->toko->namaToko }}</td>
                    <td>{{ $pesanan->formatRupiah('total') }}</td>
                </tr>
                {{$totalSemuaPesanan += $pesanan->total;}}
            @endforeach
            <tr>
                <td class="right" colspan="4"><strong>Total:</strong></td>
                <td>{{ "Rp. ".number_format($totalSemuaPesanan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
