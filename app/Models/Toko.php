<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "toko";
    protected $primaryKey = "idToko";
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['namaToko','alamat','noTelp'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->idToko = $model->generateNewId();
        });
    }

    private function generateNewId()
    {
        $lastOrder = self::orderBy('idToko', 'desc')->first();
        $lastId = $lastOrder ? $lastOrder->idToko : 'TOK0000';
        $newIdNumber = (int) substr($lastId, 3) + 1;
        return 'TOK' . str_pad($newIdNumber, 4, '0', STR_PAD_LEFT);
    }
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'idToko', 'idToko');
    }
}
