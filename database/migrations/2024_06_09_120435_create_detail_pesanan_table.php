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
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->string('idPesanan');
            $table->string('idBarang', 25);
            $table->integer('qtyPesanan');
            $table->integer('subTotal');

            $table->primary(['idPesanan', 'idBarang']);

            $table->foreign('idPesanan')->references('idPesanan')->on('pesanan')->onDelete('cascade');
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
        Schema::dropIfExists('detail_pesanan');
    }
};
