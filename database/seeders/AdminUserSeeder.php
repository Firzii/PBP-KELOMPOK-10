<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('users')->updateOrInsert(
            ['email' => 'admin@example.com'],
            [
                'name'       => 'Admin',
                'password'   => Hash::make('secret'), 
                'role'       => 'admin',              
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );
    }
}
