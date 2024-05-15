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
                'nama' => 'Mas Admin',
                'email' => 'admin@gmail.com',
                'password' => 'admin123!',
                'jabatan' => 'admin'
            ],
            [
                'nama' => 'Mas Owner',
                'email' => 'owner@gmail.com',
                'password' => 'owner123!',
                'jabatan' => 'owner'
            ],
            [
                'nama' => 'Mas Gudang',
                'email' => 'gudang@gmail.com',
                'password' => 'gudang123!',
                'jabatan' => 'Kepala Gudang'
            ],
            [
                'nama' => 'Mas Sales',
                'email' => 'sales@gmail.com',
                'password' => 'sales123!',
                'jabatan' => 'Sales'
            ]
        ];

        foreach ($userData as $key => $val) {
            User::create($val);
        }    }
}
