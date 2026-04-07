<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@portfolio.com'],
            [
                'name' => 'Jean Admin',
                'password' => Hash::make('MotDePasseTemporaire123!'),
                'email_verified_at' => now(),
            ]
        );
    }
}