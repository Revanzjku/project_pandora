<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', ['title' => 'Perpustakaan Digital Domain Publik Ramah Pengguna',
                            'bookCount' => \App\Models\Ebook::count(),
                            'userCount' => \App\Models\User::count(),
]);
})->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/home', function() {
        return view('pages.home', ['title' => 'Beranda']);
    })->name('home');
    Route::get('/katalog', function() {
        return view('pages.katalog', ['title' => 'Katalog']);
    })->name('katalog');
    Route::get('/tentang', [\App\Http\Controllers\PageController::class, 'about'])->name('tentang');
    Route::get('/read/{ebook:slug}', [\App\Http\Controllers\PageController::class, 'reader'])->name('read');
    Route::get('/profile', function() {
        return view('pages.profil', ['title' => 'Pengaturan Profil']);
    })->name('profile');

    // Admin Section Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('ebooks', \App\Http\Controllers\Admin\EbookController::class)->except(['show', 'store', 'update', 'destroy']);
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show', 'store', 'update', 'destroy']);
        Route::get('users', function() {
            return view('admin.user.index', ['title' => 'Kelola Pengguna']);
        })->name('users.index');
    });
});
