<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'sekolah']);
        Role::create(['name' => 'siswa']);
        Role::create(['name' => 'super_admin']);
    }
}
