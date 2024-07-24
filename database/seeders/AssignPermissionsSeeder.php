<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignPermissionsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve the 'sekolah' role
        $roleSekolah = Role::where('name', 'sekolah')->first();

        // Retrieve the 'verifikasi_siswa' permission
        $verifikasiSiswa = Permission::where('name', 'verifikasi_siswa')->first();

        // Check if both role and permission exist before assigning
        if ($roleSekolah && $verifikasiSiswa) {
            $roleSekolah->givePermissionTo($verifikasiSiswa);
        } else {
            // Optionally, handle the case where the role or permission does not exist
            if (!$roleSekolah) {
                echo "Role 'sekolah' does not exist.\n";
            }
            if (!$verifikasiSiswa) {
                echo "Permission 'verifikasi_siswa' does not exist.\n";
            }
        }
    }
}
