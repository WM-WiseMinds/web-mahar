<?php

use App\Models\Barang;
use App\Models\Faq;
use App\Models\Portfolio;
use App\Models\Rekening;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/gallery', function () {
    $portfolios = Portfolio::all();
    return view('gallery', compact('portfolios'));
});

Route::get('/produk', function () {
    $barang = Barang::all();
    return view('produk', compact('barang'));
});

Route::get('/faqs', function () {
    $faqs = Faq::all();
    return view('faqs', compact('faqs'));
})->name('faqs');

Route::get('/detail-produk/{id}', function ($id) {
    $barang = Barang::findOrFail($id);
    return view('detail-produk', compact('barang'));
})->name('detail-produk');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        if (Gate::allows('viewAny', User::class)) {
            $userCount = User::count();
            $barangCount = Barang::count();
            $rekeningCount = Rekening::count();
            return view('dashboard', compact('userCount', 'barangCount', 'rekeningCount'));
        } else {
            return view('welcome');
        }
    })->name('dashboard');

    Route::get('/permissions', function () {
        return view('permissions');
    })->name('permissions');

    Route::get('/roles', function () {
        return view('roles');
    })->name('roles');

    Route::get('/users', function () {
        return view('users');
    })->name('users');

    Route::get('/portfolio', function () {
        return view('portfolio');
    })->name('portfolio');

    Route::get('/barang', function () {
        return view('barang');
    })->name('barang');

    Route::get('/detailpembeli', function () {
        return view('detailpembeli');
    })->name('detailpembeli');

    Route::get('/pembayaran', function () {
        return view('pembayaran');
    })->name('pembayaran');

    Route::get('/rekening', function () {
        return view('rekening');
    })->name('rekening');

    Route::get('/transaksi', function () {
        return view('transaksi');
    })->name('transaksi');

    Route::get('/keranjang', function () {
        return view('keranjang');
    })->name('keranjang');

    Route::get('/faq', function () {
        return view('faq');
    })->name('faq');
});
