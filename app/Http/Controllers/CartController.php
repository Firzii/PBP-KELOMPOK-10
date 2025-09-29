<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $userId = 1; 

        $validated = $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'qty' => ['required','integer','min:1','max:999'],
        ]);

        $product = DB::table('products')->where('id',$validated['product_id'])->first();
        if (!$product || !$product->is_active || $product->stock < $validated['qty']) {
            return back()->with('error','Produk tidak tersedia atau stok tidak cukup.');
        }

        DB::beginTransaction();
        try {
            DB::table('carts')->updateOrInsert(
                ['user_id'=>$userId],
                ['created_at'=>now(),'updated_at'=>now()]
            );
            $cartId = DB::table('carts')->where('user_id',$userId)->value('id');

            $existing = DB::table('cart_items')
                ->where('cart_id',$cartId)
                ->where('product_id',$product->id)
                ->first();

            $newQty = ($existing->qty ?? 0) + $validated['qty'];
            if ($newQty > $product->stock) {
                DB::rollBack();
                return back()->with('error','Stok tidak mencukupi.');
            }

            if ($existing) {
                DB::table('cart_items')->where('id',$existing->id)
                    ->update(['qty'=>$newQty,'updated_at'=>now()]);
            } else {
                DB::table('cart_items')->insert([
                    'cart_id'=>$cartId,'product_id'=>$product->id,'qty'=>$validated['qty'],
                    'created_at'=>now(),'updated_at'=>now()
                ]);
            }

            DB::commit();
            return back()->with('success','Produk ditambahkan ke keranjang.');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return back()->with('error','Terjadi kesalahan.');
        }
    }
}
