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
                            Kelola Kategori
                        </h1>
                        <p class="text-slate-600">
                            Mengelola daftar kategori ebook yang tersedia di sistem.
                        </p>
                    </div>
                    <a href="{{ route('admin.categories.create') }}" 
                       class="px-4 py-2 bg-sky-600 text-white text-sm font-medium rounded-lg hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500">
                        Tambah Kategori
                    </a>
                </div>

                @if (session('success'))
                    <div class="mb-6 rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Categories Table -->
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
                    <!-- Desktop View -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nama Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @forelse ($categories as $category)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                            {{ $categories->firstItem() + $loop->index }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 font-medium">
                                            {{ $category->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex items-center space-x-4">
                                                <a href="{{ route('admin.categories.edit', $category) }}" 
                                                   class="text-sky-600 hover:underline">Edit</a>
                                                <form action="{{ route('admin.categories.destroy', $category) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:underline">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-10 text-slate-500">
                                            Tidak ada data kategori.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile View -->
                    <div class="block md:hidden">
                        <div class="grid grid-cols-1 gap-4">
                            @forelse ($categories as $category)
                                <div class="bg-slate-50 p-4 rounded-lg shadow-sm">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h3 class="text-base font-bold text-slate-900">{{ $category->name }}</h3>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <a href="{{ route('admin.categories.edit', $category) }}" 
                                               class="text-sky-600 hover:underline text-sm">Edit</a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline text-sm">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10 text-slate-500">
                                    Tidak ada data kategori.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    <nav class="flex flex-col sm:flex-row justify-between items-center">
                        <div class="mb-4 sm:mb-0">
                            <p class="text-sm text-slate-600">
                                Menampilkan {{ $categories->firstItem() }}-{{ $categories->lastItem() }} dari {{ $categories->total() }} data
                            </p>
                        </div>
                        <div>
                            <ul class="inline-flex items-center space-x-2">
                                {{-- Previous --}}
                                @if ($categories->onFirstPage())
                                    <li><span class="px-3 py-1 text-sm font-medium text-slate-400 bg-slate-100 rounded-lg cursor-not-allowed">Sebelumnya</span></li>
                                @else
                                    <li><a href="{{ $categories->previousPageUrl() }}" class="px-3 py-1 text-sm font-medium text-slate-600 bg-white rounded-lg hover:bg-slate-100">Sebelumnya</a></li>
                                @endif
                                {{-- Number --}}
                                @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                                    @if ($page == $categories->currentPage())
                                        <li><span class="px-3 py-1 text-sm font-medium text-white bg-sky-600 rounded-lg">{{ $page }}</span></li>
                                    @else
                                        <li><a href="{{ $url }}" class="px-3 py-1 text-sm font-medium text-slate-600 bg-white rounded-lg hover:bg-slate-100">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                                {{-- Next --}}
                                @if ($categories->hasMorePages())
                                    <li><a href="{{ $categories->nextPageUrl() }}" class="px-3 py-1 text-sm font-medium text-slate-600 bg-white rounded-lg hover:bg-slate-100">Berikutnya</a></li>
                                @else
                                    <li><span class="px-3 py-1 text-sm font-medium text-slate-400 bg-slate-100 rounded-lg cursor-not-allowed">Berikutnya</span></li>
                                @endif
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection