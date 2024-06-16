<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $userData = [
            [
                'namaPegawai' => 'Mas Admin',
                'noTelpPegawai' => '081234567891',
                'alamatPegawai' => 'Jln pesangon',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin123!'),
                'jabatan' => 'admin'
            ],
            [
                'namaPegawai' => 'Mas Super Admin',
                'noTelpPegawai' => '081234567890',
                'alamatPegawai' => 'Jln Lemon',
                'email' => 'super@gmail.com',
                'password' => bcrypt('super123!'),
                'jabatan' => 'super admin'
            ],
            [
                'namaPegawai' => 'Mas Gudang',
                'noTelpPegawai' => '081919191912',
                'alamatPegawai' => 'Jln. ponli',
                'email' => 'gudang@gmail.com',
                'password' => bcrypt('gudang123!'),
                'jabatan' => 'kepala gudang'
            ],
            [
                'namaPegawai' => 'Mas Sales',
                'noTelpPegawai' => '087171711717',
                'alamatPegawai' => 'Jln Apel',
                'email' => 'sales@gmail.com',
                'password' => bcrypt('sales123!'),
                'jabatan' => 'sales'
            ]
        ];

        foreach ($userData as $key => $val) {
            User::create($val);
        }    }
}
