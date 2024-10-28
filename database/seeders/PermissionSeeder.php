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
        $permissionSekolah = [
            'verifikasi_siswa',
            'edit_my_profile_sekolah',
            'verifikasi_dokumen_siswa',
            'reject_dokumen_siswa',
            'edit_registration_status',
            'lihat_pendaftar',
            'daftar_sekolah',
            'luluskan_siswa',

        ];
        $permissionVerifikatorSekolah = [
            'verifikasi_dokumen_siswa',
            'reject_dokumen_siswa',
            'edit_registration_status',
            'lihat_pendaftar',
            'luluskan_siswa',
        ];
        $permissionSiswa = [
            'edit_my_profile_siswa',
            'edit_document_siswa',
            'upload_document_siswa',
            'daftar_siswa',
        ];
        $permissionAdmin = [
            'verifikasi_sekolah',
            'create_registration_period',
            'edit_registration_period',
        ];
        //buat permission untuk admin
        foreach ($permissionAdmin as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        //buat permission untuk sekolah
        foreach ($permissionSekolah as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        //buat permission untuk siswa
        foreach ($permissionSiswa as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        //Assign permission to role
        $roleAdmin = \Spatie\Permission\Models\Role::where('name', 'super_admin')->first();
        $roleSekolah = \Spatie\Permission\Models\Role::where('name', 'sekolah')->first();
        $roleSiswa = \Spatie\Permission\Models\Role::where('name', 'siswa')->first();
        $roleVerifikatorSekolah = \Spatie\Permission\Models\Role::where('name', 'verifikator_sekolah')->first();
        $roleAdmin->givePermissionTo($permissionAdmin);
        $roleSekolah->givePermissionTo($permissionSekolah);
        $roleSiswa->givePermissionTo($permissionSiswa);
        $roleVerifikatorSekolah->givePermissionTo($permissionVerifikatorSekolah);
    }
}
