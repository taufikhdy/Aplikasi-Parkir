<?php

namespace Database\Seeders;

use App\Models\Tarif;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TarifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Tarif::create([
            'jenis_kendaraan' => 'motor',
            'tarif_per_jam' => 0,
        ]);

        Tarif::create([
            'jenis_kendaraan' => 'mobil',
            'tarif_per_jam' => 0,
        ]);

        Tarif::create([
            'jenis_kendaraan' => 'lainnya',
            'tarif_per_jam' => 0,
        ]);
    }
}
