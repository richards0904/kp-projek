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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->string('idPesanan')->primary();
            $table->string('idToko');
            $table->unsignedBigInteger('idPegawai');
            $table->date('tglPesanan')->default(DB::raw('CURRENT_TIMESTAMP'));;
            $table->enum('status', ['Dikonfirmasi', 'Sedang Diproses'])->default('Sedang Diproses');
            $table->integer('total');
            $table->foreign('idPegawai')->references('idPegawai')->on('users')->onDelete('cascade');
            $table->foreign('idToko')->references('idToko')->on('tokos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesanans');
    }
};
