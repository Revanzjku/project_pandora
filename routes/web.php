<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', ['title' => 'Perpustakaan Digital Domain Publik Ramah Pengguna']);
})->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('pages.home', ['title' => 'HOME']);
    })->name('home');

    Route::get('/katalog', function () {
        return view('pages.katalog', ['title' => 'Katalog Buku']);
    })->name('katalog');

    Route::get('/tentang', function () {
        return view('pages.tentang', ['title' => 'Tentang Kami']);
    })->name('tentang');

    Route::get('/reader/{title}', function () {
        return view('pages.reader');
    })->name('reader');

    Route::get('/profile', function () {
        return view('pages.profil', ['title' => 'Pengaturan Profil']);
    })
    ->name('profile');

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
        Route::get('/statistics', function () {
            return view('admin.statistik', ['title' => 'Statistik Pengunjung',
                                                        'dibaca' => 320,
                                                        'didownload' => 180,
                                                        'dikutip' => 75,
                                                        'pengguna' => 2341,]);
        })->name('statistics');
        // Route::get('/history', function);
    });
});
