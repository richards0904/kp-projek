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
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['idPesanan', 'idToko', 'idPegawai', 'tglPesanan', 'status', 'total'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->idPesanan = $model->generateNewId();
        });
    }

    private function generateNewId()
    {
        $lastOrder = self::orderBy('idPesanan', 'desc')->first();
        $lastId = $lastOrder ? $lastOrder->idPesanan : 'PES0000';
        $newIdNumber = (int) substr($lastId, 3) + 1;
        return 'PES' . str_pad($newIdNumber, 4, '0', STR_PAD_LEFT);
    }



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
