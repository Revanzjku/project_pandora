{{-- filepath: d:\laravel-project\pandora_system\resources\views\admin\ebook\index.blade.php --}}
@extends('layouts.app')

@section('content')
    <x-navbar />
    <div class="flex">
        <x-sidebar />

        <!-- Main Content -->
        <div class="flex-1 lg:ml-0">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Page Header -->
                <div class="mb-8 flex items-center justify-between">
                    <div>
                        <h1 class="heading text-2xl sm:text-3xl font-bold text-slate-900 mb-2">
                            Kelola Ebook
                        </h1>
                        <p class="text-slate-600">
                            Mengelola daftar Ebook yang tersedia di sistem.
                        </p>
                    </div>
                    <a href="{{ route('admin.ebooks.create') }}" class="px-4 py-2 bg-sky-600 text-white text-sm font-medium rounded-lg hover:bg-sky-700">
                        Tambah Ebook Baru
                    </a>
                </div>

                <!-- eBooks Table -->
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
                    <!-- Desktop View -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Judul</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider hidden md:table-cell">Penulis</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider hidden lg:table-cell">Tahun</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider hidden lg:table-cell">Gambar Cover</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider hidden xl:table-cell">Deskripsi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @for ($i = 1; $i <= 5; $i++)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $i }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Judul Buku {{ $i }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 hidden md:table-cell">Penulis {{ $i }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 hidden lg:table-cell">202{{ $i }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                                            <img src="https://placehold.co/50" alt="Cover" class="w-12 h-16 rounded-lg">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 hidden xl:table-cell">Deskripsi singkat buku {{ $i }}...</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex space-x-2">
                                                <a href="#" class="text-sky-600 hover:underline">Edit</a>
                                                <a href="#" class="text-red-600 hover:underline">Hapus</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile View -->
                    <div class="block md:hidden">
                        <div class="grid grid-cols-1 gap-4">
                            @for ($i = 1; $i <= 5; $i++)
                                <div class="bg-slate-50 p-4 rounded-lg shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-bold text-slate-900">Judul Buku {{ $i }}</h3>
                                        <div class="flex space-x-2">
                                            <a href="#" class="text-sky-600 hover:underline text-sm">Edit</a>
                                            <a href="#" class="text-red-600 hover:underline text-sm">Hapus</a>
                                        </div>
                                    </div>
                                    <p class="text-xs text-slate-600 mt-2">Penulis: Penulis {{ $i }}</p>
                                    <p class="text-xs text-slate-600">Tahun: 202{{ $i }}</p>
                                    <div class="mt-2">
                                        <img src="https://placehold.co/50" alt="Cover" class="w-16 h-20 rounded-lg">
                                    </div>
                                    <p class="text-xs text-slate-600 mt-2">Deskripsi: Deskripsi singkat buku {{ $i }}...</p>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    <nav class="flex flex-col sm:flex-row justify-between items-center">
                        <div class="mb-4 sm:mb-0">
                            <p class="text-sm text-slate-600">
                                Menampilkan 1-5 dari 20 data
                            </p>
                        </div>
                        <div>
                            <ul class="inline-flex items-center space-x-2">
                                <li>
                                    <a href="#" class="px-3 py-1 text-sm font-medium text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200">1</a>
                                </li>
                                <li>
                                    <a href="#" class="px-3 py-1 text-sm font-medium text-slate-600 bg-white rounded-lg hover:bg-slate-100">2</a>
                                </li>
                                <li>
                                    <a href="#" class="px-3 py-1 text-sm font-medium text-slate-600 bg-white rounded-lg hover:bg-slate-100">3</a>
                                </li>
                                <li>
                                    <a href="#" class="px-3 py-1 text-sm font-medium text-slate-600 bg-white rounded-lg hover:bg-slate-100">...</a>
                                </li>
                                <li>
                                    <a href="#" class="px-3 py-1 text-sm font-medium text-slate-600 bg-white rounded-lg hover:bg-slate-100">4</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection