<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\Models\User;
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
        $faker = Faker::create();

        // Ensure the roles exist
        $roleSekolah = Role::firstOrCreate(['name' => 'sekolah']);
        $roleSiswa = Role::firstOrCreate(['name' => 'siswa']);

        // Create a user with role 'sekolah'
        $userSekolah = User::create([
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => Hash::make('password'), // or use a secure password
        ]);
        $userSekolah->assignRole($roleSekolah);

        // Create a user with role 'siswa'
        $userSiswa = User::create([
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => Hash::make('password'), // or use a secure password
        ]);
        $userSiswa->assignRole($roleSiswa);
    }
}

