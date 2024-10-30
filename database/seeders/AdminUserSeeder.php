<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'username' => 'admin',
            'email' => config('app.admin_email'),
            'password' => bcrypt('ppdbroot'),
        ]);

        // Assign the super_admin role to the user
        $user->assignRole('super_admin');
    }
}
