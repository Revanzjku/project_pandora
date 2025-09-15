@extends('layouts.app')
@section('content')
    <x-navbar />
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
            <div class="grid gap-10">
                <div class="bg-white rounded-xl shadow-md ring-1 ring-slate-200 p-6">
                    <h2 class="text-xl font-semibold text-slate-900 mb-4">Informasi Profil</h2>
                    <form method="POST" action="{{ route('user-profile-information.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nama</label>
                            <input type="text" name="name" id="name" class="w-full px-4 py-2 rounded-lg bg-slate-50 ring-1 ring-slate-300 focus:ring-2 focus:ring-sky-500 focus:outline-none @error('name') ring-red-500 @enderror" value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                            <input type="email" name="email" id="email" class="w-full px-4 py-2 rounded-lg bg-slate-50 ring-1 ring-slate-300 focus:ring-2 focus:ring-sky-500 focus:outline-none @error('email') ring-red-500 @enderror" value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-sky-600 text-white text-sm hover:bg-sky-700">Simpan</button>
                    </form>
                </div>

                <div class="bg-white rounded-xl shadow-md ring-1 ring-slate-200 p-6">
                    <h2 class="text-xl font-semibold text-slate-900 mb-4">Ubah Kata Sandi</h2>
                    <form method="POST" action="{{ route('user-password.update') }}">
                        @csrf
                        @method('PUT')

                        {{-- Kata Sandi Saat Ini --}}
                        <div class="mb-4" x-data="{ show: false }">
                            <label for="current_password" class="block text-sm font-medium text-slate-700 mb-2">Kata Sandi Saat Ini</label>
                            <div class="relative">
                                <input :type="show ? 'text' : 'password'" name="current_password" id="current_password" class="w-full px-4 py-2 rounded-lg bg-slate-50 ring-1 ring-slate-300 focus:ring-2 focus:ring-sky-500 focus:outline-none pr-10 @error('current_password') ring-red-500 @enderror" required>
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center px-3 text-slate-500 hover:text-slate-700">
                                    <svg x-show="!show" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.243 4.243l-4.242-4.242" />
                                    </svg>
                                    <svg x-show="show" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                            @error('current_password')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kata Sandi Baru --}}
                        <div class="mb-4" x-data="{ show: false }">
                            <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Kata Sandi Baru</label>
                            <div class="relative">
                                <input :type="show ? 'text' : 'password'" name="password" id="password" class="w-full px-4 py-2 rounded-lg bg-slate-50 ring-1 ring-slate-300 focus:ring-2 focus:ring-sky-500 focus:outline-none pr-10 @error('password') ring-red-500 @enderror" required>
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center px-3 text-slate-500 hover:text-slate-700">
                                    <svg x-show="!show" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.243 4.243l-4.242-4.242" />
                                    </svg>
                                    <svg x-show="show" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Konfirmasi Kata Sandi --}}
                        <div class="mb-4" x-data="{ show: false }">
                            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Kata Sandi</label>
                            <div class="relative">
                                <input :type="show ? 'text' : 'password'" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 rounded-lg bg-slate-50 ring-1 ring-slate-300 focus:ring-2 focus:ring-sky-500 focus:outline-none pr-10 @error('password_confirmation') ring-red-500 @enderror" required>
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center px-3 text-slate-500 hover:text-slate-700">
                                    <svg x-show="!show" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.243 4.243l-4.242-4.242" />
                                    </svg>
                                    <svg x-show="show" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-sky-600 text-white text-sm hover:bg-sky-700">Simpan</button>
                    </form>
                </div>

                @if (Auth::user()->role !== 'admin')
                    {{-- Bagian: Hapus Akun --}}
                    <div class="bg-white rounded-xl shadow-md ring-1 ring-slate-200 p-6">
                        <h2 class="text-xl font-semibold text-slate-900 mb-4">Hapus Akun</h2>
                        <p class="text-sm text-slate-600 mb-4">
                            Setelah akun Anda dihapus, semua data dan sumber daya yang terkait akan dihapus secara permanen. Sebelum menghapus akun, pastikan Anda telah mengunduh data yang ingin disimpan.
                        </p>
                        <form method="POST" action="/">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-red-600 text-white text-sm hover:bg-red-700">Hapus Akun</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
@endsection