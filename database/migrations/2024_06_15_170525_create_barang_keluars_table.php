<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_keluars', function (Blueprint $table) {
            $table->id('idBarangKeluar');
            $table->string('idBarang',25);
            $table->date('tglKeluar')->default(DB::raw('CURRENT_TIMESTAMP'));;
            $table->integer('qtyKeluar');
            $table->foreign('idBarang')->references('idBarang')->on('stok_barangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang_keluars');
    }
};
