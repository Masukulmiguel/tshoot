<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@tshoot-angola.com'],
            [
                'name' => 'Admin TSHOOT',
                'password' => Hash::make('191925Tshoot@'),
            ]
        );
    }
}