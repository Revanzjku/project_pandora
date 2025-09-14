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
                            <input type="text" name="name" id="name" class="w-full px-4 py-2 rounded-lg bg-slate-50 ring-1 ring-slate-300 focus:ring-2 focus:ring-sky-500 focus:outline-none" value="{{ old('name', auth()->user()->name) }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                            <input type="email" name="email" id="email" class="w-full px-4 py-2 rounded-lg bg-slate-50 ring-1 ring-slate-300 focus:ring-2 focus:ring-sky-500 focus:outline-none" value="{{ old('email', auth()->user()->email) }}" required>
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-sky-600 text-white text-sm hover:bg-sky-700">Simpan</button>
                    </form>
                </div>

                <div class="bg-white rounded-xl shadow-md ring-1 ring-slate-200 p-6">
                    <h2 class="text-xl font-semibold text-slate-900 mb-4">Ubah Kata Sandi</h2>
                    <form method="POST" action="{{ route('user-password.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="current_password" class="block text-sm font-medium text-slate-700 mb-2">Kata Sandi Saat Ini</label>
                            <input type="password" name="current_password" id="current_password" class="w-full px-4 py-2 rounded-lg bg-slate-50 ring-1 ring-slate-300 focus:ring-2 focus:ring-sky-500 focus:outline-none" required>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Kata Sandi Baru</label>
                            <input type="password" name="password" id="password" class="w-full px-4 py-2 rounded-lg bg-slate-50 ring-1 ring-slate-300 focus:ring-2 focus:ring-sky-500 focus:outline-none" required>
                        </div>
                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Kata Sandi</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 rounded-lg bg-slate-50 ring-1 ring-slate-300 focus:ring-2 focus:ring-sky-500 focus:outline-none" required>
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-sky-600 text-white text-sm hover:bg-sky-700">Simpan</button>
                    </form>
                </div>

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
            </div>
        </div>
@endsection