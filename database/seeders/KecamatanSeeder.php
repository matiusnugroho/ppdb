<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Seeder; // Import the Kecamatan model

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kecamatans = [
            ['nama' => 'Kuantan Mudik'],
            ['nama' => 'Kuantan Tengah'],
            ['nama' => 'Singingi'],
            ['nama' => 'Kuantan Hilir'],
            ['nama' => 'Cerenti'],
            ['nama' => 'Benai'],
            ['nama' => 'Gunung Toar'],
            ['nama' => 'Singingi Hilir'],
            ['nama' => 'Pangean'],
            ['nama' => 'Logas Tanah Darat'],
            ['nama' => 'Inuman'],
            ['nama' => 'Hulu Kuantan'],
            ['nama' => 'Kuantan Hilir Seberang'],
            ['nama' => 'Sentajo Raya'],
            ['nama' => 'Pucuk Rantau'],
        ];

        // Insert data using the Kecamatan model
        foreach ($kecamatans as $kecamatan) {
            Kecamatan::create($kecamatan);
        }
    }
}
