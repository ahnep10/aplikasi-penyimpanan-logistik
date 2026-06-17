<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();

        User::create([
            'name' => 'System Admin',
            'email' => 'admin@logistic-mis.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);
    }
}
