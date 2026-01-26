<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'nama_lengkap' => 'Miguel Johnson',
            'username' => 'Miguel',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'email' => 'migueljhn@gmail.com'
        ]);

        User::create([
            'nama_lengkap' => 'Usep',
            'username' => 'Usep',
            'password' => Hash::make('12345678'),
            'role' => 'petugas',
            'email' => 'Usepss@gmail.com'
        ]);

        User::create([
            'nama_lengkap' => 'Primis',
            'username' => 'Primis',
            'password' => Hash::make('12345678'),
            'role' => 'owner',
            'email' => 'primis5@gmail.com'
        ]);
    }
}
