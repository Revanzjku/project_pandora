<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('pages.welcome', ['title' => 'Perpustakaan Digital Domain Publik Ramah Pengguna']);
    })->name('home');

    Route::get('/katalog', function () {
        return view('pages.katalog', ['title' => 'Katalog Buku']);
    })->name('katalog');

    Route::get('/tentang', function () {
        return view('pages.tentang', ['title' => 'Tentang Kami']);
    })->name('tentang');

    Route::get('/detail', function () {
        return view('pages.detail');
    })->name('detail');

    Route::get('/reader/{title}', function () {
        return view('pages.reader');
    })->name('reader');

    Route::get('/dashboard', function () {
        return view('pages.dashboard', ['title' => 'Dashboard']);
    })->name('dashboard');

    Route::get('/profile', function () {
        return view('pages.profil', ['title' => 'Pengaturan Profil']);
    })->name('profile')->middleware('role:user');
});
