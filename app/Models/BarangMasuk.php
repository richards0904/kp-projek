<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    public $timestamps = false;
    protected $table = "barang_masuk";
    protected $primaryKey = "idBarangMasuk";
    protected $fillable = ['idBarang', 'hargaBeli', 'qtyMasuk'];
}
