@extends('layouts.app')

@section('content')
    <x-navbar />
    <div class="flex">
        <x-sidebar />

        <!-- Main Content -->
        <div class="flex-1">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                
                <!-- Page Header -->
                <div class="mb-10">
                    <h1 class="text-3xl font-bold text-slate-900">
                        {{ isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}
                    </h1>
                    <p class="mt-1 text-slate-600">
                        {{ isset($user) ? 'Perbarui data pengguna yang ada.' : 'Tambahkan pengguna baru ke sistem.' }}
                    </p>
                </div>

                <!-- Card -->
                <div class="bg-white rounded-2xl shadow-lg ring-1 ring-slate-200/70 p-8 transition hover:shadow-xl">
                    <form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}"
                            method="POST" class="space-y-6">
                        @csrf
                        @if (isset($user))
                            @method('PUT')
                        @endif

                        <!-- Nama Pengguna -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Pengguna</label>
                            <input type="text" name="name" id="name"
                                    class="block w-full rounded-xl border @error('name') border-red-500 @else border-slate-300 @enderror bg-slate-50 px-4 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:outline-none"
                                    value="{{ old('name', $user->name ?? '') }}" required>
                            @error('name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                            <input type="email" name="email" id="email"
                                    class="block w-full rounded-xl border @error('email') border-red-500 @else border-slate-300 @enderror bg-slate-50 px-4 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:outline-none"
                                    value="{{ old('email', $user->email ?? '') }}" required>
                            @error('email')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div x-data="{ showPassword: false }">
                            <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" name="password" id="password"
                                    class="block w-full rounded-xl border @error('password') border-red-500 @else border-slate-300 @enderror bg-slate-50 pr-12 px-4 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:outline-none"
                                    {{ isset($user) ? '' : 'required' }}>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer"
                                     @click="showPassword = !showPassword">
                                    <svg x-show="!showPassword" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.243 4.243l-4.242-4.242" />
                                    </svg>
                                    <svg x-show="showPassword" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
                            @if (isset($user))
                                <p class="mt-1 text-xs text-slate-500">Kosongkan jika tidak ingin mengubah password.</p>
                            @endif
                            @error('password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Konfirmasi Password -->
                        <div x-data="{ showPassword: false }">
                            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password</label>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" name="password_confirmation" id="password_confirmation"
                                    class="block w-full rounded-xl border border-slate-300 bg-slate-50 pr-12 px-4 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:outline-none">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer"
                                     @click="showPassword = !showPassword">
                                    <svg x-show="!showPassword" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.243 4.243l-4.242-4.242" />
                                    </svg>
                                    <svg x-show="showPassword" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-slate-700 mb-1">Role</label>
                            <select name="role" id="role"
                                    class="block w-full rounded-xl border @error('role') border-red-500 @else border-slate-300 @enderror bg-slate-50 px-4 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:outline-none"
                                    required>
                                <option value="user" {{ old('role', $user->role ?? '') == 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tombol -->
                        <div class="flex items-center space-x-3 pt-4">
                            <button type="submit"
                                    class="px-5 py-2.5 bg-sky-600 text-white text-sm font-medium rounded-xl hover:bg-sky-700 focus:ring-2 focus:ring-sky-400 focus:outline-none transition">
                                {{ isset($user) ? 'Perbarui' : 'Simpan' }}
                            </button>
                            <a href="{{ route('admin.users.index') }}"
                               class="px-5 py-2.5 bg-slate-100 text-slate-700 text-sm font-medium rounded-xl hover:bg-slate-200 transition">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection