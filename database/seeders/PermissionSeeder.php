<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create permissions
        Permission::firstOrCreate(['name' => 'daftar_akun']);
        Permission::firstOrCreate(['name' => 'verifikasi_siswa']);
        Permission::firstOrCreate(['name' => 'verifikasi_sekolah']);
    }
}

