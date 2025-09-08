<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/katalog', function () {
    return view('katalog');
});

Route::get('/tentang', function () {
    return view('tentang');
});

Route::get('/detail', function () {
    return view('detail');
});

Route::get('/reader', function () {
    return view('reader');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/profile', function () {
    return view('profil');
})->middleware(['auth'])->name('profile');
