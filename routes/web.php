<?php

use App\Http\Controllers\DiscountController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Auth::check() ? redirect()->route('discount.index') : redirect()->route('login');
})->name('home');

Route::get('/dashboard', function () {
    return Auth::check() ? redirect()->route('discount.index') : redirect()->route('login');
})->middleware(['auth'])->name('dashboard');

Route::get('lang/{locale}', function($locale) {
    if (in_array($locale,['es', 'en'])) {
        app()->setLocale($locale);
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('changelocale');

Route::resource('discount', DiscountController::class)->middleware(['auth'])->except(['show']);

require __DIR__.'/auth.php';
