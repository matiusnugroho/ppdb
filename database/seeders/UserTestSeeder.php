<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserTestSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $schoolTypes = [
            ['nama' => 'SMP Negeri', 'jenjang' => 'smp'],
            ['nama' => 'SD Negeri', 'jenjang' => 'sd'],
            ['nama' => 'SMA', 'jenjang' => 'sma'],
            ['nama' => 'SD', 'jenjang' => 'sd'],
        ];
        $numberRange = range(1, 100);

        // Ensure the roles exist
        $roleSekolah = Role::firstOrCreate(['name' => 'sekolah']);
        $roleSiswa = Role::firstOrCreate(['name' => 'siswa']);

        // Create a user with role 'sekolah'
        $userSekolah = User::create([
            'username' => $faker->userName,
            'email' => $faker->unique()->safeEmail,
            'password' => Hash::make('password'), // or use a secure password
        ]);
        $userSekolah->assignRole($roleSekolah);

        // Create a user with role 'siswa'
        $userSiswa = User::create([
            'username' => /* $faker->userName */ 'saritri',
            'email' => $faker->unique()->safeEmail,
            'password' => Hash::make('password'), // or use a secure password
        ]);
        $userSiswa->assignRole($roleSiswa);
        Student::create([
            'user_id' => $userSiswa->id, // Set the user_id here
            'nisn' => $faker->unique()->numerify('######'),
            'nama' => /* $faker->name */ 'Sari Tri Wulandari',
            'tempat_lahir' => $faker->city,
            'tanggal_lahir' => $faker->date,
            'nama_bapak' => $faker->name('male'),
            'nama_ibu' => $faker->name('female'),
            'nik' => $faker->unique()->numerify('################'),
            'no_kk' => $faker->unique()->numerify('################'),
            'no_hp_ortu' => $faker->phoneNumber,
        ]);

        $kecamatans = Kecamatan::all(); // Get all Kecamatan

        foreach ($kecamatans as $kecamatan) {
            for ($i = 0; $i < 10; $i++) {
                $schoolType = $faker->randomElement($schoolTypes); // Randomly select SMAN or SMP
                $schoolNumber = $faker->randomElement($numberRange); // Randomly select a number
                $city = $kecamatan->nama; // Random city name
                $schoolName = "{$schoolType['nama']} {$schoolNumber} {$city}";

                School::create([
                    'nama_sekolah' => $schoolName,
                    'jenjang' => $schoolType['jenjang'],
                    'nss' => $faker->unique()->numerify('######'),
                    'npsn' => $faker->unique()->numerify('######'),
                    'alamat' => $faker->address,
                    'no_telp' => $faker->phoneNumber,
                    'email' => $faker->unique()->companyEmail,
                    'nama_kepsek' => $faker->name,
                    'kecamatan_id' => $kecamatan->id, // Assign the current Kecamatan
                    'user_id' => $userSekolah->id, // Assuming $userSekolah is already defined
                ]);
            }
        }

    }
}
