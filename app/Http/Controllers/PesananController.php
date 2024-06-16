<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Pesanan;
use App\Models\StokBarang;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        $a = 'Dikonfirmasi';
        $b = 'Sedang Diproses';
        $pesananAll = Pesanan::select('*')
            ->join('tokos', 'pesanans.idToko', '=', 'tokos.idToko')
            ->join('users', 'pesanans.idPegawai', '=', 'users.idPegawai')
            ->where(function ($query) use ($a, $b) {
                $query->where('status', '=', $a)
                    ->orWhere('status', '=', $b);
            })
            ->where('users.idPegawai', Auth::user()->idPegawai)
            ->get();
        $tokoAll = Toko::all();
        return view('pesanan', compact('pesananAll','tokoAll'));
    }

    public function buatPesanan(Request $request)
    {
        Pesanan::create([
            'idToko' => $request->idToko,
            'idPegawai' => $request->idPegawai,
            'total' => 0,
        ]);
        return redirect()->route('pesanan.barang');
    }

    public function editPesanan(Request $request)
    {
        $editPesanan = Pesanan::where('idPesanan', $request->editIdPesanan)
            ->update([
                'idToko' => $request->idToko,
            ]);
        return redirect()->route('pesanan.barang');
    }

    public function hapusPesanan(Request $request)
    {
        $hapusPesanan = Pesanan::where('idPesanan', $request->hapusIdPesanan)
            ->delete();
        return redirect()->route('pesanan.barang');
    }

    public function batalPesanan(Request $request)
    {
        $batalPesanan = Pesanan::where('idPesanan', $request->idPesanan)
            ->update([
                'status' => 'Dibatalkan',
            ]);
        return redirect()->route('pelanggan.pesanan');
    }

    public function konfirmasiPesanan(Request $request)
    {
        $stokAwal = StokBarang::where('idBarang', $request->idBarang)
            ->first();
        $stokKeluar = Pesanan::where('idPesanan', $request->idPesanan)
            ->join('users', 'pesanans.idPegawai', '=', 'users.idPegawai')
            ->first();
        $stokAkhir = $stokAwal->stok - $stokKeluar->jumlahBeli;
        if ($stokAkhir < 0) {
            return redirect()->route('pesanan.admin')->with('msg', 'Data gagal dibuat!!! Stok Ayam tidak mencukupi, silahkan tambah stok terlebih dahulu atau ubah jumlah beli dengan mendiskusikan kepada pelanggan');
        } else {
            $editStok = StokBarang::where('idAyam', $request->idAyam)
                ->update([
                    'stok' => $stokAkhir,
                ]);
            // AyamKeluar::create([
            //     'idAyam' => $request->idAyam,
            //     'penjual' => $stokKeluar->namalengkap,
            //     'qtyKeluar' => $stokKeluar->jumlahBeli
            // ]);
            $konfirmasiPesanan = Pesanan::where('idPesanan', $request->idPesanan)
                ->update([
                    'status' => 'Dikonfirmasi',
                ]);
            return redirect()->route('pesanan.admin');
        }
    }


// Fungsi Detail
    public function showDetail($id)
    {
        $pesanan = Pesanan::with(['detailPesanans', 'toko'])->find($id);
        $stokBarangs = StokBarang::all();
        return view('detail', compact('pesanan','stokBarangs'));
    }

    public function tambahDetailPesanan(Request $request)
    {
        $request->validate([
            'idPesanan' => 'required|exists:pesanans,idPesanan',
            'idBarang' => 'required|exists:stok_barangs,idBarang',
            'qtyPesanan' => 'required|integer|min:1'
        ]);

        $idPesanan = $request->idPesanan;
        $idBarang = $request->idBarang;
        $qtyPesanan = $request->qtyPesanan;

        $existingDetail = DetailPesanan::where('idPesanan', $idPesanan)->where('idBarang', $idBarang)->first();

        if ($existingDetail) {
            return redirect()->back()->with('pesan','Data detail pesanan sudah ada.');
        }

        // Ambil harga barang
        $barang = StokBarang::find($idBarang);
        $hargaBarang = $barang->hargaBarang;

        // Hitung subtotal
        $subTotal = $qtyPesanan * $hargaBarang;

        // Buat detail pesanan
        DetailPesanan::create([
            'idPesanan' => $idPesanan,
            'idBarang' => $idBarang,
            'qtyPesanan' => $qtyPesanan,
            'subTotal' => $subTotal,
        ]);

        // Update total pesanan
        $pesanan = Pesanan::find($idPesanan);
        $total = $pesanan->detailPesanans->sum('subTotal');
        $pesanan->total = $total;
        $pesanan->save();

        return redirect()->back()->with('success', 'Detail pesanan berhasil ditambahkan');
    }

    public function ubahDetailPesanan(Request $request)
    {
        $request->validate([
            'editQtyPesanan' => 'required|integer|min:1',
        ]);
        $idPesanan = $request->editIdPesanan;
        $idBarang = $request->editIdBarang;

        $detailPesanan = DetailPesanan::where('idPesanan', $idPesanan)->where('idBarang', $idBarang)->first();
        print($detailPesanan);
        if ($detailPesanan) {
            $oldSubTotal = $detailPesanan->subTotal;
            $detailPesanan->qtyPesanan = $request->input('editQtyPesanan');
            $barang = StokBarang::where('idBarang', $idBarang)->first();

            $newSubTotal = $request->editQtyPesanan * $barang->hargaBarang;

        $editDetail = DetailPesanan::where('idPesanan', $idPesanan)->where('idBarang',$idBarang)-> update([
                'qtyPesanan' => $request->editQtyPesanan,
                'subTotal' => $newSubTotal,
            ]);

            $pesanan = Pesanan::find($idPesanan);
            $pesanan->total = $pesanan->total - $oldSubTotal + $newSubTotal;
            $pesanan->save();

                return redirect()->route('detail.pesanan', ['id' => $idPesanan])->with('success', 'Detail pesanan berhasil diubah.');
                    }

        return redirect()->route('detail.pesanan', ['id' => $idPesanan])->with('pesan','Detail pesanan tidak ditemukan.');
    }

    public function hapusDetailPesanan(Request $request)
    {
    $idPesanan = $request->hapusIdPesanan;
    $idBarang = $request->hapusIdBarang;
    // Mencari detail pesanan berdasarkan idPesanan dan idBarang
    $detailPesanan = DetailPesanan::where('idPesanan', $idPesanan)->where('idBarang', $idBarang)->first();

    if ($detailPesanan) {
        $pesanan = Pesanan::where('idPesanan', $idPesanan)->first();
        $totalLama = $pesanan->total;
        $totalBaru = $totalLama - $detailPesanan->subTotal;
        $ubahTotal =  Pesanan::where('idPesanan', $idPesanan)-> update([
                'total' => $totalBaru,
            ]);

        $hapusDetail = DetailPesanan::where('idPesanan', $idPesanan)->where('idBarang',$idBarang)-> delete();


        return redirect()->route('detail.pesanan', $idPesanan)->with('success', 'Detail pesanan berhasil dihapus.');
    } else {
        return redirect()->route('detail.pesanan', $idPesanan)->with('pesan', 'Detail pesanan tidak ditemukan.');
    }
    }
}
