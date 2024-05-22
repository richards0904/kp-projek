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
        Schema::create('stok_barangs', function (Blueprint $table) {
            $table->string('idBarang',10)->unique();
            $table->string('namaBarang', 25);
            $table->enum('jenisBarang', ["Kecap", "Sambal", "Tomat", "Sardine", "Terasi", "Syrup", "Ready to Drink", "NPD Product"]);
            $table->integer('hargaBarang');
            $table->integer('stokBarang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stok_barangs');
    }
};
