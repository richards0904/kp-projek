<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "barang_keluar";
    protected $primaryKey = "idBarangKeluar";
    protected $fillable = ['idBarang', 'qtyKeluar'];
}
