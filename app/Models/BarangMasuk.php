<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "barang_masuks";
    protected $primaryKey = "idBarangMasuk";
    protected $fillable = ['idBarang', 'qtyMasuk'];
}
