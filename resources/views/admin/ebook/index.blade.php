@extends('layouts.app')

@section('content')
    <x-navbar />
    <div class="flex">
        <x-sidebar />

        <!-- Main Content -->
        <div class="flex-1 lg:ml-0" x-data="{ showModal: false, ebook: {} }">
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
                    <a href="{{ route('admin.ebooks.create') }}" 
                       class="px-4 py-2 bg-sky-600 text-white text-sm font-medium rounded-lg hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500">
                        Tambah Ebook Baru
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

                <!-- eBooks Table -->
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
                    <!-- Desktop View -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Judul</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider hidden md:table-cell">Penulis</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider hidden lg:table-cell">Tahun</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider hidden lg:table-cell">Gambar Cover</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider hidden xl:table-cell">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @forelse ($ebooks as $ebook)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $ebooks->firstItem() + $loop->index }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 font-medium">{{ $ebook->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 hidden md:table-cell">{{ $ebook->author }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 hidden lg:table-cell">{{ $ebook->year }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                                            @if ($ebook->cover_image_path)
                                                <img src="{{ asset('storage/' . $ebook->cover_image_path) }}" alt="Cover" class="w-16 h-16 rounded-lg object-cover">
                                            @else
                                                <img src="https://placehold.co/64x64/e2e8f0/94a3b8?text=No+Cover" alt="Cover" class="w-16 h-16 rounded-lg bg-slate-100">
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 hidden xl:table-cell">{{ $ebook->category->name ?? '-'}}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex items-center space-x-4">
                                                <!-- Tombol Detail -->
                                                <button 
                                                    class="text-gray-600 hover:underline"
                                                    @click="
                                                        ebook = {
                                                            title: '{{ $ebook->title }}',
                                                            author: '{{ $ebook->author }}',
                                                            year: '{{ $ebook->year }}',
                                                            category: '{{ $ebook->category->name ?? '-' }}',
                                                            description: '{{ $ebook->description ? addslashes($ebook->description) : '-' }}',
                                                            cover: '{{ $ebook->cover_image_path ? asset('storage/' . $ebook->cover_image_path) : '' }}',
                                                            file: '{{ $ebook->ebook_file_path ? asset('storage/' . $ebook->ebook_file_path) : '' }}'
                                                        };
                                                        showModal = true;
                                                    ">
                                                    Detail
                                                </button>
                                                <a href="{{ route('admin.ebooks.edit', $ebook) }}" class="text-sky-600 hover:underline">Edit</a>
                                                <form action="{{ route('admin.ebooks.destroy', $ebook) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ebook ini?')">
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
                                        <td colspan="7" class="text-center py-10 text-slate-500">
                                            Tidak ada data ebook.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile View -->
                    <div class="block md:hidden">
                        <div class="grid grid-cols-1 gap-4">
                            @forelse ($ebooks as $ebook)
                                <div class="bg-slate-50 p-4 rounded-lg shadow-sm">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex items-center space-x-3">
                                            @if ($ebook->cover_image_path)
                                                <img src="{{ asset('storage/' . $ebook->cover_image_path) }}" alt="Cover" class="w-12 h-12 rounded-lg object-cover">
                                            @else
                                                <img src="https://placehold.co/48x48/e2e8f0/94a3b8?text=No+Cover" alt="Cover" class="w-12 h-12 rounded-lg bg-slate-100">
                                            @endif
                                            <div>
                                                <h3 class="text-base font-bold text-slate-900">{{ $ebook->title }}</h3>
                                                <p class="text-sm text-slate-600">{{ $ebook->author }}</p>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-slate-100 text-slate-800">
                                                {{ $ebook->category->name ?? '-' }}
                                            </span>
                                        </div>
                                    </div>
                                   
                                    <div class="flex justify-end items-center border-t border-slate-200 pt-3 space-x-4 text-sm">
                                        <button 
                                            class="text-gray-600 hover:underline"
                                            @click="
                                                ebook = {
                                                    title: '{{ $ebook->title }}',
                                                    author: '{{ $ebook->author }}',
                                                    year: '{{ $ebook->year }}',
                                                    category: '{{ $ebook->category->name ?? '-' }}',
                                                    description: '{{ $ebook->description ? addslashes($ebook->description) : '-' }}',
                                                    cover: '{{ $ebook->cover_image_path ? asset('storage/' . $ebook->cover_image_path) : '' }}',
                                                    file: '{{ $ebook->ebook_file_path ? asset('storage/' . $ebook->ebook_file_path) : '' }}'
                                                };
                                                showModal = true;
                                            ">
                                            Detail
                                        </button>
                                        <a href="{{ route('admin.ebooks.edit', $ebook) }}" class="text-sky-600 hover:underline">Edit</a>
                                        <form action="{{ route('admin.ebooks.destroy', $ebook) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ebook ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10 text-slate-500">
                                    Tidak ada data ebook.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Modal Detail Ebook -->
                <div x-show="showModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
                    <div @click.away="showModal = false" class="bg-white rounded-2xl shadow-lg max-w-lg w-full p-6 mx-4 max-h-[90vh] overflow-y-auto">
                        <h2 class="text-xl font-bold text-slate-900 mb-4" x-text="ebook.title || '-'"></h2>
                        
                        <template x-if="ebook.cover">
                            <img :src="ebook.cover" alt="Cover" class="w-40 h-56 object-cover rounded-xl shadow-md mb-4 mx-auto">
                        </template>
                        
                        <div class="space-y-3 text-slate-700">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-slate-500">Penulis</p>
                                    <p class="text-sm text-slate-900" x-text="ebook.author || '-'"></p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-500">Tahun</p>
                                    <p class="text-sm text-slate-900" x-text="ebook.year || '-'"></p>
                                </div>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-slate-500">Kategori</p>
                                <p class="text-sm text-slate-900" x-text="ebook.category || '-'"></p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-slate-500">Deskripsi</p>
                                <p class="text-sm text-slate-600 mt-1" x-text="ebook.description || 'Tidak ada deskripsi'"></p>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end space-x-3">
                            <button @click="showModal = false" class="px-4 py-2 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-300">
                                Tutup
                            </button>
                            <template x-if="ebook.file">
                                <a :href="ebook.file" target="_blank" class="px-4 py-2 rounded-lg bg-sky-600 text-white hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500">
                                    Unduh Ebook
                                </a>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    <nav class="flex flex-col sm:flex-row justify-between items-center">
                        <div class="mb-4 sm:mb-0">
                            <p class="text-sm text-slate-600">
                                Menampilkan {{ $ebooks->firstItem() }}-{{ $ebooks->lastItem() }} dari {{ $ebooks->total() }} data
                            </p>
                        </div>
                        <div>
                            <ul class="inline-flex items-center space-x-2">
                                {{-- Previous --}}
                                @if ($ebooks->onFirstPage())
                                    <li><span class="px-3 py-1 text-sm font-medium text-slate-400 bg-slate-100 rounded-lg cursor-not-allowed">Sebelumnya</span></li>
                                @else
                                    <li><a href="{{ $ebooks->previousPageUrl() }}" class="px-3 py-1 text-sm font-medium text-slate-600 bg-white rounded-lg hover:bg-slate-100">Sebelumnya</a></li>
                                @endif
                                {{-- Number --}}
                                @foreach ($ebooks->getUrlRange(1, $ebooks->lastPage()) as $page => $url)
                                    @if ($page == $ebooks->currentPage())
                                        <li><span class="px-3 py-1 text-sm font-medium text-white bg-sky-600 rounded-lg">{{ $page }}</span></li>
                                    @else
                                        <li><a href="{{ $url }}" class="px-3 py-1 text-sm font-medium text-slate-600 bg-white rounded-lg hover:bg-slate-100">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                                {{-- Next --}}
                                @if ($ebooks->hasMorePages())
                                    <li><a href="{{ $ebooks->nextPageUrl() }}" class="px-3 py-1 text-sm font-medium text-slate-600 bg-white rounded-lg hover:bg-slate-100">Berikutnya</a></li>
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