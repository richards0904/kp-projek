<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\DetailPesanan;
use App\Models\Pesanan;
use App\Models\StokBarang;
use App\Models\Toko;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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

    public function indexAdmin()
    {
        $b = 'Sedang Diproses';
        $pesananAll = Pesanan::select('*')
            ->join('tokos', 'pesanans.idToko', '=', 'tokos.idToko')
            ->join('users', 'pesanans.idPegawai', '=', 'users.idPegawai')
            ->where(function ($query) use ($b) {
                $query->where('status', '=', )
                    ->orWhere('status', '=', $b);
            })
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

    public function konfirmasiPesanan(Request $request, $idPesanan)
    {
        $pesanan = Pesanan::with('detailPesanans.stokBarang')->find($idPesanan);

        if (!$pesanan) {
            return redirect()->route('pesanan.barang')->with('msg', 'Pesanan tidak ditemukan.');
        }

        // Start transaction
        DB::beginTransaction();

        try {
            foreach ($pesanan->detailPesanans as $detail) {
                $stokBarang = $detail->stokBarang;

                // Check if enough stock is available
                if ($stokBarang->stokBarang < $detail->qtyPesanan) {
                    // Rollback transaction
                    DB::rollBack();
                    return redirect()->route('pesanan.barang')->with('msg', 'Stok barang tidak mencukupi untuk barang: ' . $stokBarang->namaBarang);
                }

                //  Mengurangi Stok
                $stokBarang->stokBarang -= $detail->qtyPesanan;
                $stokBarang->save();

                // Record the outgoing stock
                BarangKeluar::create([
                    'idBarang' => $stokBarang->idBarang,
                    'qtyKeluar' => $detail->qtyPesanan,
                ]);
            }

            // Update order status
            $pesanan->status = 'Dikonfirmasi';
            $pesanan->save();

            // Commit transaction
            DB::commit();

            return redirect()->route('pesanan.barang')->with('msg', 'Pesanan berhasil dikonfirmasi.');
        } catch (\Exception $e) {
            // Rollback transaction in case of error
            DB::rollBack();
            return redirect()->route('pesanan.barang')->with('msg', 'Terjadi kesalahan: ' . $e->getMessage());
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

    public function cetakNota($id)
    {
        $pesanan = Pesanan::with('detailPesanans.stokBarang', 'toko', 'pegawai')->findOrFail($id);

        $pdf = FacadePdf::loadView('cetakNota', compact('pesanan'));
        return $pdf->download('nota_pesanan_' . $id . '.pdf');
    }

    public function tampilPenjualan()
    {
        $a = 'Dikonfirmasi';
        $pesananKonfirmasi = Pesanan::select('*')
            ->join('tokos', 'pesanans.idToko', '=', 'tokos.idToko')
            ->join('users', 'pesanans.idPegawai', '=', 'users.idPegawai')
            ->where(function ($query) use ($a) {
                $query->where('status', '=', $a);
            })
            ->get();
        $bulan = date('m');
        $tahun = date('Y');
        return view('penjualan', compact('pesananKonfirmasi','bulan', 'tahun'));
    }

    public function filter(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        $a = 'Dikonfirmasi';
        $pesananKonfirmasi = Pesanan::select('*')
            ->join('tokos', 'pesanans.idToko', '=', 'tokos.idToko')
            ->join('users', 'pesanans.idPegawai', '=', 'users.idPegawai')
            ->where(function ($query) use ($a) {
                $query->where('status', '=', $a);
            })
            ->whereMonth('tglPesanan', $bulan)
            ->whereYear('tglPesanan', $tahun)
            ->get();

        return view('penjualan', compact('pesananKonfirmasi', 'bulan', 'tahun'));
    }

    public function cetakLaporan(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $pesananKonfirmasi = Pesanan::where('status', 'Dikonfirmasi')
            ->whereMonth('tglPesanan', $bulan)
            ->whereYear('tglPesanan', $tahun)
            ->get();

        $pdf = FacadePdf::loadView('cetakLaporan', compact('pesananKonfirmasi', 'bulan', 'tahun'));
        return $pdf->download('laporan_penjualan_' . $bulan . '_' . $tahun . '.pdf');
    }


}
