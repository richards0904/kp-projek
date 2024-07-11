<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokBarang extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    public $timestamps = false;
    protected $table = "barang";
    protected $primaryKey = "idBarang";
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['idBarang','namaBarang', 'jenisBarang', 'stokBarang', 'hargaBarang'];

    // untuk mendeklarasikan hubungan many to many tabel pesanan dan stok barang
    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'idBarang', 'idBarang');
    }
}
