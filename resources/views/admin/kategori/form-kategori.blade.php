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
                        {{ isset($category) ? 'Edit Kategori' : 'Tambah Kategori Baru' }}
                    </h1>
                    <p class="mt-1 text-slate-600">
                        {{ isset($category) ? 'Perbarui data kategori yang ada.' : 'Tambahkan kategori baru ke sistem.' }}
                    </p>
                </div>

                <!-- Card -->
                <div class="bg-white rounded-2xl shadow-lg ring-1 ring-slate-200/70 p-8 transition hover:shadow-xl">
                    <form action="{{ isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}"
                          method="POST" class="space-y-6">
                        @csrf
                        @if (isset($category))
                            @method('PUT')
                        @endif

                        <!-- Nama Kategori -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Kategori</label>
                            <input type="text" name="name" id="name"
                                class="block w-full rounded-xl border @error('name') border-red-500 @else border-slate-300 @enderror bg-slate-50 px-4 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:outline-none"
                                value="{{ old('name', $category->name ?? '') }}" required>
                            @error('name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tombol -->
                        <div class="flex items-center space-x-3 pt-4">
                            <button type="submit"
                                class="px-5 py-2.5 bg-sky-600 text-white text-sm font-medium rounded-xl hover:bg-sky-700 focus:ring-2 focus:ring-sky-400 focus:outline-none transition">
                                {{ isset($category) ? 'Perbarui' : 'Simpan' }}
                            </button>
                            <a href="{{ route('admin.categories.index') }}"
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