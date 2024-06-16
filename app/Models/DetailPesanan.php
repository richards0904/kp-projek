<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    public $timestamps = false;
    protected $table = "detail_pesanans";
    protected $primaryKey = ['idPesanan', 'idBarang'];
    public $incrementing = false;
    protected $fillable = ['idPesanan','idBarang','qtyPesanan','subTotal'];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'idPesanan', 'idPesanan');
    }

    public function stokBarang()
    {
        return $this->belongsTo(StokBarang::class, 'idBarang', 'idBarang');
    }
}
