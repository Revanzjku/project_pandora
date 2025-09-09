<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome', ['title' => '- Perpustakaan Digital Domain Publik Ramah Pengguna']);
});

Route::get('/katalog', function () {
    return view('pages.katalog', ['title' => '- Katalog Buku']);
});

Route::get('/tentang', function () {
    return view('pages.tentang', ['title' => '- Tentang Kami']);
});

Route::get('/detail', function () {
    return view('pages.detail');
});

Route::get('/reader', function () {
    return view('pages.reader');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard', ['title' => '- Dashboard']);
})->middleware(['auth'])->name('dashboard');

Route::get('/profile', function () {
    return view('pages.profil');
})->middleware(['auth'])->name('profile');
