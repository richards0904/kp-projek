<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "tokos";
    protected $primaryKey = "idToko";
    protected $fillable = ['namaToko','alamat','noTelp'];

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'idToko', 'idToko');
    }
}
