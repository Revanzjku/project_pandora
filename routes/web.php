<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', ['title' => 'Perpustakaan Digital Domain Publik Ramah Pengguna']);
})->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/home', [PageController::class, 'home'])->name('home');
    Route::get('/katalog', [PageController::class, 'catalog'])->name('katalog');
    Route::get('/tentang', [PageController::class, 'about'])->name('tentang');
    Route::get('/read/{ebook:slug}', [PageController::class, 'reader'])->name('read');
    Route::get('/profile', [PageController::class, 'profile'])->name('profile');

    Route::delete('/profile', [\App\Http\Controllers\UserAccountDelete::class, 'destroy'])
    ->name('user.destroy'); //User Delete Account

    // Admin Section Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('pages.dashboard', ['title' => 'Dashboard']);
        })->name('dashboard');

        Route::resource('ebooks', \App\Http\Controllers\Admin\EbookController::class)->except(['show']);
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(['show']);
    });
});
