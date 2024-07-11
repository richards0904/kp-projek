<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('barang', function (Blueprint $table) {
            $table->string('idBarang',25)->unique();
            $table->string('namaBarang', 60);
            $table->enum('jenisBarang', ["Kecap", "Sambal", "Tomat", "Sardine", "Terasi", "Syrup", "Ready to Drink", "NPD Product"]);
            $table->integer('hargaBarang');
            $table->integer('stokBarang');
            $table->primary('idBarang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
};
