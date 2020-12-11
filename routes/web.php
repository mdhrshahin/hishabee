<?php

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
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $quotes = \App\Models\Quote::where('user_id', auth()->id())->get();
    return view('dashboard', compact('quotes'));
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->name('quote.')->prefix('quote')->group(function (){
   Route::post('/add', [\App\Http\Controllers\QuoteController::class, 'add_quote'])->name('add');
   Route::post('/edit', [\App\Http\Controllers\QuoteController::class, 'edit_quote'])->name('edit');
   Route::delete('/delete', [\App\Http\Controllers\QuoteController::class, 'delete_quote'])->name('delete');
});

