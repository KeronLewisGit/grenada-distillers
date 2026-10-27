<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Production-safe: creates the first administrator when ADMIN_EMAIL and
     * ADMIN_PASSWORD are set in .env. No sample requests or vacancies.
     */
    public function run(): void
    {
        $email = config('gdl.admin.email');
        $password = config('gdl.admin.password');

        if ($email && $password) {
            User::firstOrCreate(['email' => strtolower($email)], [
                'name' => config('gdl.admin.name'),
                'password' => Hash::make($password),
                'role' => Role::Admin,
                'active' => true,
            ]);
        }
    }
}
