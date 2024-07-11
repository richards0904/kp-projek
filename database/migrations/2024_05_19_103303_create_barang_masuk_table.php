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
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id('idBarangMasuk');
            $table->string('idBarang',25);
            $table->date('tglMasuk')->default(DB::raw('CURRENT_TIMESTAMP'));;
            $table->integer('hargaBeli');
            $table->integer('qtyMasuk');
            $table->foreign('idBarang')->references('idBarang')->on('barang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang_masuk');
    }
};
