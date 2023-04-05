<?php

use App\Http\Livewire\Customer\Index as Customer;
use App\Http\Livewire\Order\Index as Order;
use App\Http\Livewire\Service\Index as Service;
use App\Http\Livewire\Stock\Index as Stock;
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

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Route::middleware(['auth'])->group(function (){
    Route::get('/customer', Customer::class);
    Route::get('/stock', Stock::class);
    Route::get('/service', Service::class);
    Route::get('/order', Order::class);
});