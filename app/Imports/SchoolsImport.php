<?php

namespace App\Imports;

use App\Models\Kecamatan;
use App\Models\School;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class SchoolsImport implements ToModel
{
    public function model(array $row)
    {
        $namaSekolah = $row['nama_sekolah'];
        $kecamatanName = $row['kecamatan'];

        // Find the Kecamatan ID
        $kecamatan = Kecamatan::where('name', $kecamatanName)->first();
        if (! $kecamatan) {
            return null; // Skip if kecamatan is not found
        }

        // Generate username
        $username = strtolower(str_replace(' ', '', $namaSekolah));

        // Find or create the user
        $user = User::updateOrCreate(
            ['username' => $username],
            ['name' => $namaSekolah, 'password' => bcrypt('password')]
        );

        // Create or update the school
        return new School([
            'nama_sekolah' => $namaSekolah,
            'kecamatan_id' => $kecamatan->id,
            'user_id' => $user->id,
        ]);
    }
}
