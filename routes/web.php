<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', ['title' => 'Perpustakaan Digital Domain Publik Ramah Pengguna']);
})->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/home', function() {
        return view('pages.home', ['title' => 'Beranda']);
    })->name('home');
    Route::get('/katalog', function() {
        return view('pages.katalog', ['title' => 'Katalog']);
    })->name('katalog');
    Route::get('/tentang', [PageController::class, 'about'])->name('tentang');
    Route::get('/read/{ebook:slug}', [PageController::class, 'reader'])->name('read');
    Route::get('/profile', function() {
        return view('pages.profil', ['title' => 'Pengaturan Profil']);
    })->name('profile');

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
