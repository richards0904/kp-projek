<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    public $timestamps = false;
    protected $table = "pesanans";
    protected $primaryKey = "idPesanan";
    protected $fillable = ['idToko','idPegawai','tglPesanan','status','total'];

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'idPesanan', 'idPesanan');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'idToko', 'idToko');
    }

    public function pegawai()
    {
        return $this->belongsTo(User::class, 'idPegawai', 'idPegawai');
    }
}
