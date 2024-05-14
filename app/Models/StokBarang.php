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
    protected $table = "stok_barangs";
    protected $primaryKey = "idBarang";
    protected $fillable = ['namaBarang', 'jenisBarang', 'stokBarang', 'hargaBarang'];
}
