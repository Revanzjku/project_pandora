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
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 focus:outline-none transition-colors"
                            placeholder="Masukkan password">
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