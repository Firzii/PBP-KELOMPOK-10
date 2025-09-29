<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Ambil admin (kalau ada), kalau tidak ambil user pertama
        $userId = DB::table('users')->where('email','admin@example.com')->value('id')
                  ?? DB::table('users')->value('id');

        // Ambil produk pertama yang tersedia
        $product = DB::table('products')->first();

        if (!$userId || !$product) {
            // Jika belum ada user/produk, hentikan supaya tidak langgar FK
            return;
        }

        // Pastikan cart 1:1 dengan user
        DB::table('carts')->updateOrInsert(
            ['user_id' => $userId],
            ['updated_at' => $now, 'created_at' => $now]
        );
        $cartId = DB::table('carts')->where('user_id', $userId)->value('id');

        // Tambah/merge item di cart (kalau sudah ada, set qty=2 saja biar idempotent)
        DB::table('cart_items')->updateOrInsert(
            ['cart_id' => $cartId, 'product_id' => $product->id],
            ['qty' => 2, 'updated_at' => $now, 'created_at' => $now]
        );

        // Buat order contoh jika belum ada untuk user ini
        $orderId = DB::table('orders')->where('user_id', $userId)->value('id');
        if (!$orderId) {
            $total = $product->price * 2;
            $orderId = DB::table('orders')->insertGetId([
                'user_id'     => $userId,
                'total'       => $total,
                'status'      => 'diproses',
                'address_text'=> 'Jl. Mawar No. 1',
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }

        // Upsert detail item order (qty=2, idempotent)
        DB::table('order_items')->updateOrInsert(
            ['order_id' => $orderId, 'product_id' => $product->id],
            [
                'price'      => $product->price,
                'qty'        => 2,
                'subtotal'   => $product->price * 2,
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );
    }
}
