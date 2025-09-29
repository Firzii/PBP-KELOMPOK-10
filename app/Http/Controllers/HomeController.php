<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->query('category_id');
        $q          = $request->query('q');

        // 1) Kategori + jumlah produk (distinct by name)
        $categories = DB::table('categories')
            ->leftJoin('products', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.id',
                'categories.name',
                DB::raw('COUNT(DISTINCT products.name) AS products_count')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('categories.name')
            ->get();

        // 2) Ambil ID produk TERBARU untuk setiap nama (aktif & stok > 0)
        $latestPerName = DB::table('products')
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->groupBy('name')
            ->select(DB::raw('MAX(id) AS id'));

        // 3) Join ke products & categories, lalu paginasi
        $products = DB::table('products')
            ->joinSub($latestPerName, 'latest', 'latest.id', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->select('products.*', 'categories.name AS category_name')
            ->when($categoryId, fn($q2) => $q2->where('products.category_id', $categoryId))
            ->when($q, fn($q2) => $q2->where(function ($w) use ($q) {
                $w->where('products.name', 'like', "%{$q}%")
                  ->orWhere('categories.name', 'like', "%{$q}%");
            }))
            ->orderByDesc('products.created_at')
            ->paginate(12)
            ->withQueryString();

        return view('home', [
            'categories'       => $categories,
            'products'         => $products,
            'activeCategoryId' => $categoryId,
            'q'                => $q,
        ]);
    }
}
