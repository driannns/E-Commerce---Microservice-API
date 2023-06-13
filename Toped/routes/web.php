<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use GuzzleHttp\Client;


use App\Models\Product;

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
    $client = new Client();
    $url = "http://127.0.0.1:8888/api/product";
    $response  = $client->request('GET', $url);
    $datas = json_decode($response->getBody()->getContents());
    $result = $datas[0]->data;
    // dd($datas);
    // $product = Product::all();
    return view('welcome', compact('result'));
});

Route::get('/dashboard', function () {
    $client = new Client();
    $url = "http://127.0.0.1:8888/api/product";
    $response  = $client->request('GET', $url);
    $datas = json_decode($response->getBody()->getContents());
    $result = $datas[0]->data;
    // $product = Product::all();
    return view('dashboard', compact('result'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{id}', [CartController::class, 'addCart'])->name('cart.addCart');
    Route::get('/cart/{id}', [CartController::class, 'removeCart'])->name('cart.removeCart');
    
    Route::patch('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/detailPayment', [CartController::class, 'detailPayment'])->name('detailPayment');
    Route::post('/storeOrder', [CartController::class, 'storeOrder'])->name('storeOrder');

    
    Route::get('/myorder', [ProfileController::class, 'myorder'])->name('myorder');
    
});

require __DIR__.'/auth.php';
