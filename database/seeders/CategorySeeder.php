<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
 
    public function run(): void
    {
        $now = now();

        DB::table('categories')->insertOrIgnore([
            ['name' => 'Makanan',          'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Minuman',          'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Fashion',          'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kebutuhan Rumah',  'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
