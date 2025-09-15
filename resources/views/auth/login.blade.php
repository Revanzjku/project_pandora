@extends('layouts.app')
@section('content')
    <x-navbar />
    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <!-- Card -->
            <div class="bg-white rounded-2xl shadow-xl ring-1 ring-slate-200/60 p-8">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-sky-500 to-cyan-600 grid place-items-center text-white text-2xl font-bold">P</div>
                    <h1 class="heading text-2xl font-bold text-slate-900">Selamat Datang Kembali</h1>
                    <p class="text-sm text-slate-600 mt-2">Masuk ke akun PANDORA Anda</p>
                </div>

                <form action="{{ route('login.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                        <input type="email" id="email" name="email" required
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 focus:outline-none transition-colors"
                            placeholder="nama@email.com">
                        @error('email')
                            <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div x-data="{ show: false }">
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" id="password" name="password" required
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 focus:outline-none transition-colors pr-12"
                                placeholder="Masukkan password">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-500 hover:text-slate-700">
                                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.243 4.243l-4.242-4.242" />
                                </svg>
                                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-gradient-to-r from-sky-600 to-cyan-600 text-white font-semibold py-3 rounded-xl hover:from-sky-700 hover:to-cyan-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                        Masuk
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-sm text-slate-600">
                        Belum punya akun? 
                        <a href="/register" class="text-sky-600 font-medium hover:text-sky-700 hover:underline">Daftar di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </main>
@endsection
