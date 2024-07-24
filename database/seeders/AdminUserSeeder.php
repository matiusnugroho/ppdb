<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'admin',
            'email' => env('ADMIN_EMAIL'),
            'password' => bcrypt('ppdbroot'),
        ]);

        // Assign the super_admin role to the user
        $user->assignRole('super_admin');
    }
}
