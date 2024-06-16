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
        Schema::create('users', function (Blueprint $table) {
            $table->id('idPegawai');
            $table->string('namaPegawai', 30);
            $table->string('noTelpPegawai', 14);
            $table->string('alamatPegawai',50);
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('jabatan', ['kepala gudang', 'admin', 'sales' ,'super admin']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
