<?php
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
// (opsional, jika nanti ada menu admin)
// use App\Http\Controllers\Admin\ProductController as AdminProductController;
// use App\Http\Controllers\Admin\OrderController   as AdminOrderAdminController;
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get ('/login',  [LoginController::class, 'show'])->name('login');
Route::post('/login',  [LoginController::class, 'submit'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth.session')->group(function () {

    // 1) Keranjang
    Route::get   ('/cart',                 [CartController::class, 'index'])->name('cart.index');
    Route::post  ('/cart/items',           [CartController::class, 'store'])->name('cart.items.store');      // +Keranjang
    Route::patch ('/cart/items/{item}',    [CartController::class, 'update'])->name('cart.items.update');    // ubah qty
    Route::delete('/cart/items/{item}',    [CartController::class, 'destroy'])->name('cart.items.destroy');  // hapus item
    Route::delete('/cart/clear',           [CartController::class, 'clear'])->name('cart.clear');            // kosongkan keranjang (opsional)


});

/*
|---------------------------------------------------------------------------
| (OPSIONAL) ROUTE ADMIN — jika nanti ada peran admin
| Tambahkan middleware 'admin.only' milikmu jika sudah dibuat.
|---------------------------------------------------------------------------
*/
// Route::middleware(['auth.session', 'admin.only'])->prefix('admin')->name('admin.')->group(function () {
//     // Kelola produk
//     Route::resource('products', AdminProductController::class); // index, create, store, edit, update, destroy
//
//     // Kelola pesanan: ubah status (diproses, dikirim, selesai, batal)
//     Route::get   ('orders',                [AdminOrderAdminController::class, 'index'])->name('orders.index');
//     Route::get   ('orders/{order}',        [AdminOrderAdminController::class, 'show'])->name('orders.show');
//     Route::patch ('orders/{order}/status', [AdminOrderAdminController::class, 'updateStatus'])->name('orders.updateStatus');
// });
