<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Pastikan minimal kategori inti ada (tanpa Kerajinan)
        DB::table('categories')->upsert(
            [
                ['name'=>'Makanan',         'created_at'=>$now, 'updated_at'=>$now],
                ['name'=>'Minuman',         'created_at'=>$now, 'updated_at'=>$now],
                ['name'=>'Fashion',         'created_at'=>$now, 'updated_at'=>$now],
                ['name'=>'Kebutuhan Rumah', 'created_at'=>$now, 'updated_at'=>$now],
            ],
            ['name'],
            ['updated_at']
        );

        $cat = DB::table('categories')->pluck('id','name'); // ['Makanan'=>1, ...]

        // Susun produk hanya jika category_id-nya tersedia
        $rows = collect([
            [
                'name'=>'Takoyaki',
                'price'=>15000, 'stock'=>100,
                'category_name'=>'Makanan',
                'is_active'=>true,
            ],
            [
                'name'=>'Es Kopi Susu',
                'price'=>18000, 'stock'=>50,
                'category_name'=>'Minuman',
                'is_active'=>true,
            ],
            [
                'name'=>'Kaos Katun',
                'price'=>65000, 'stock'=>40,
                'category_name'=>'Fashion',
                'is_active'=>true,
            ],
            [
                'name'=>'Sapu Serbaguna',
                'price'=>20000, 'stock'=>60,
                'category_name'=>'Kebutuhan Rumah',
                'is_active'=>true,
            ],
        ])->map(function ($p) use ($cat, $now) {
            $cid = $cat[$p['category_name']] ?? null;
            if (!$cid) return null; // skip jika kategori tidak ada
            return [
                'name'        => $p['name'],
                'price'       => $p['price'],
                'stock'       => $p['stock'],
                'category_id' => $cid,
                'is_active'   => $p['is_active'],
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        })->filter()->values()->all();

        if (!empty($rows)) {
            DB::table('products')->upsert(
                $rows,
                ['name'], // anggap nama produk unik secara bisnis
                ['price','stock','category_id','is_active','updated_at']
            );
        }
    }
}
