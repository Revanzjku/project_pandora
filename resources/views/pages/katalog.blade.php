@extends('layouts.app')
@section('content')
    <x-navbar />
        <!-- Hero Section -->
        <section class="relative overflow-hidden">
            <div aria-hidden="true" class="absolute inset-0 -z-10">
                <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-200/40 blur-3xl rounded-full"></div>
                <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-sky-200/40 blur-3xl rounded-full"></div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
                <div class="text-center">
                    <h1 class="heading text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 leading-snug md:leading-snug lg:leading-normal xl:leading-relaxed max-w-2xl lg:max-w-3xl xl:max-w-4xl mx-auto">
                        Katalog E-Book Domain Publik
                    </h1>
                    <p class="mt-4 text-slate-600 max-w-xl mx-auto">Jelajahi ribuan koleksi e-book gratis dan legal yang dapat diakses kapan saja, di mana saja.</p>

                    <!-- Search Bar -->
                    <form action="/katalog" method="GET" class="mt-8 max-w-2xl mx-auto">
                        <div class="flex items-center gap-2 bg-white shadow-sm ring-1 ring-slate-200 rounded-xl px-3 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul, penulis, atau kata kunci" class="w-full bg-transparent focus:outline-none text-slate-700 placeholder-slate-400">
                            @if(request('q'))
                                <a href="{{ route('katalog', array_merge(request()->except('q', 'page'), ['q' => ''])) }}" class="p-1 text-slate-400 hover:text-slate-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                        <!-- Hidden fields to preserve other filters -->
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                    </form>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="py-8 sm:py-10 lg:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                    <!-- Sidebar Filter -->
                    <aside class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6 sticky top-24">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="heading text-lg font-semibold text-slate-900">Filter & Urutkan</h2>
                                @if(request()->hasAny(['q', 'category', 'sort']))
                                    <a href="{{ route('katalog') }}" class="text-xs text-sky-600 hover:text-sky-700">Reset Filter</a>
                                @endif
                            </div>
                            <div class="space-y-6">
                                <!-- Category Filter -->
                                <div>
                                    <h3 class="font-medium text-slate-700 mb-3">Kategori</h3>
                                    <form id="categoryForm" action="/katalog" method="GET">
                                        <ul class="space-y-2 text-sm">
                                            @foreach($categories as $category)
                                                <li>
                                                    <label class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-slate-50 cursor-pointer">
                                                        <input type="radio" name="category" value="{{ $category->id }}" 
                                                               {{ request('category') == $category->id ? 'checked' : '' }}
                                                               class="rounded text-sky-600 focus:ring-sky-500"
                                                               onchange="document.getElementById('categoryForm').submit()">
                                                        <span class="text-slate-600 hover:text-sky-700">{{ $category->name }}</span>
                                                    </label>
                                                </li>
                                            @endforeach
                                            @if(request('category'))
                                                <li>
                                                    <label class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-slate-50 cursor-pointer">
                                                        <input type="radio" name="category" value="" 
                                                               class="rounded text-sky-600 focus:ring-sky-500"
                                                               onchange="document.getElementById('categoryForm').submit()">
                                                        <span class="text-slate-600 hover:text-sky-700">Semua Kategori</span>
                                                    </label>
                                                </li>
                                            @endif
                                        </ul>
                                        <!-- Hidden fields to preserve other filters -->
                                        @if(request('q'))
                                            <input type="hidden" name="q" value="{{ request('q') }}">
                                        @endif
                                        @if(request('sort'))
                                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                                        @endif
                                    </form>
                                </div>
                                
                                <!-- Sort Filter -->
                                <div>
                                    <h3 class="font-medium text-slate-700 mb-3">Urutkan</h3>
                                    <form id="sortForm" action="/katalog" method="GET">
                                        <select name="sort" onchange="document.getElementById('sortForm').submit()" 
                                                class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 focus:outline-none">
                                            <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                            <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>A-Z Judul</option>
                                            <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Z-A Judul</option>
                                        </select>
                                        <!-- Hidden fields to preserve other filters -->
                                        @if(request('q'))
                                            <input type="hidden" name="q" value="{{ request('q') }}">
                                        @endif
                                        @if(request('category'))
                                            <input type="hidden" name="category" value="{{ request('category') }}">
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </aside>

                    <div class="lg:col-span-3" x-data="{ 
                        showModal: false, 
                        showCitationModal: false,
                        ebook: {},
                        citationStyle: 'apa',
                        generateCitation(style, ebook) {
                            const authors = ebook.author ? ebook.author.split(', ').map(author => author.trim()) : ['Anonim'];
                            const year = ebook.year || 't.t.';
                            const title = ebook.title || 'Judul tidak tersedia';
                            
                            // Format nama penulis untuk semua gaya
                            const formatAuthorNames = (authors, style) => {
                                if (authors.length === 0) return 'Anonim';
                                
                                const formatSingleAuthor = (author, style) => {
                                    const parts = author.split(' ');
                                    if (parts.length === 1) return author;
                                    
                                    switch(style) {
                                        case 'apa':
                                            // APA: Lastname, F. (Initial)
                                            const lastname = parts[parts.length - 1];
                                            const initials = parts.slice(0, -1).map(name => name.charAt(0) + '.').join(' ');
                                            return `${lastname}, ${initials}`;
                                        
                                        case 'chicago':
                                            // Chicago: Lastname, Firstname
                                            const lastnameChi = parts[parts.length - 1];
                                            const firstnamesChi = parts.slice(0, -1).join(' ');
                                            return `${lastnameChi}, ${firstnamesChi}`;
                                        
                                        case 'mla':
                                            // MLA: Lastname, Firstname
                                            const lastnameMla = parts[parts.length - 1];
                                            const firstnamesMla = parts.slice(0, -1).join(' ');
                                            return `${lastnameMla}, ${firstnamesMla}`;
                                        
                                        default:
                                            return author;
                                    }
                                };

                                if (authors.length === 1) {
                                    return formatSingleAuthor(authors[0], style);
                                }
                                
                                const formattedAuthors = authors.map(author => formatSingleAuthor(author, style));
                                
                                switch(style) {
                                    case 'apa':
                                        if (authors.length === 2) {
                                            return `${formattedAuthors[0]} & ${formattedAuthors[1]}`;
                                        } else {
                                            return `${formattedAuthors[0]} et al.`;
                                        }
                                    
                                    case 'chicago':
                                        if (authors.length === 2) {
                                            return `${formattedAuthors[0]} and ${formattedAuthors[1]}`;
                                        } else {
                                            return `${formattedAuthors[0]}, ${formattedAuthors[1]}, and ${formattedAuthors[2]}`;
                                        }
                                    
                                    case 'mla':
                                        if (authors.length === 2) {
                                            return `${formattedAuthors[0]}, and ${formattedAuthors[1]}`;
                                        } else {
                                            return `${formattedAuthors[0]}, et al.`;
                                        }
                                    
                                    default:
                                        return formattedAuthors[0];
                                }
                            };

                            const formattedAuthors = formatAuthorNames(authors, style);
                            
                            switch(style) {
                                case 'apa':
                                    return `${formattedAuthors} (${year}). <em>${title}</em>.`;
                                
                                case 'chicago':
                                    return `${formattedAuthors}. ${year}. <em>${title}</em>.`;
                                
                                case 'mla':
                                    return `${formattedAuthors}. <em>${title}</em>. ${year}.`;
                                
                                default:
                                    return `${formattedAuthors} (${year}). ${title}.`;
                            }
                        }
                    }">
                        <div class="flex items-center justify-between gap-4 mb-6">
                            <div>
                                <h2 class="heading text-xl sm:text-2xl font-semibold text-slate-900">
                                    @if(request()->hasAny(['q', 'category']))
                                        Hasil Pencarian
                                    @else
                                        Semua E-Book
                                    @endif
                                </h2>
                                <p class="text-sm text-slate-600 mt-1">
                                    Menampilkan {{ $ebooks->count() }} dari {{ $ebooks->total() }} e-book tersedia
                                    @if(request('q'))
                                        untuk "<span class="font-medium">{{ request('q') }}</span>"
                                    @endif
                                    @if(request('category'))
                                        @php
                                            $selectedCategory = $categories->firstWhere('id', request('category'));
                                        @endphp
                                        @if($selectedCategory)
                                            dalam kategori <span class="font-medium">{{ $selectedCategory->name }}</span>
                                        @endif
                                    @endif
                                </p>
                            </div>
                            
                            <!-- Active Filters -->
                            @if(request()->hasAny(['q', 'category']))
                                <div class="flex flex-wrap gap-2">
                                    @if(request('q'))
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-sky-100 text-sky-800">
                                            Pencarian: {{ request('q') }}
                                            <a href="{{ route('katalog', array_merge(request()->except('q', 'page'), ['q' => ''])) }}" class="ml-1 hover:text-sky-900">
                                                ×
                                            </a>
                                        </span>
                                    @endif
                                    @if(request('category'))
                                        @php
                                            $selectedCategory = $categories->firstWhere('id', request('category'));
                                        @endphp
                                        @if($selectedCategory)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-slate-100 text-slate-800">
                                                Kategori: {{ $selectedCategory->name }}
                                                <a href="{{ route('katalog', array_merge(request()->except('category', 'page'), ['category' => ''])) }}" class="ml-1 hover:text-slate-900">
                                                    ×
                                                </a>
                                            </span>
                                        @endif
                                    @endif
                                </div>
                            @endif
                        </div>
                        
                        @if($ebooks->count() > 0)
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-6">
                                @foreach ($ebooks as $ebook)
                                    <div class="group bg-white rounded-xl ring-1 ring-slate-200 hover:ring-sky-200 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col h-full">
                                        <!-- Cover Container dengan Fixed Aspect Ratio tanpa Crop -->
                                        <div class="relative aspect-[3/4] bg-slate-100 overflow-hidden flex items-center justify-center">
                                            @if ($ebook->cover_image_path)
                                                <img 
                                                    src="{{ asset('storage/' . $ebook->cover_image_path) }}" 
                                                    alt="Cover {{ $ebook->title }}"
                                                    class="max-w-full max-h-full object-contain transition-transform duration-300 group-hover:scale-105"
                                                    loading="lazy"
                                                    style="max-width: 90%; max-height: 90%;"
                                                >
                                            @else
                                                <div class="absolute inset-0 bg-gradient-to-br from-slate-200 to-slate-300 flex flex-col items-center justify-center p-4">
                                                    <svg class="w-8 h-8 text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                    </svg>
                                                    <span class="text-slate-500 text-xs text-center">No Cover</span>
                                                </div>
                                            @endif
                                            <!-- Overlay Effect -->
                                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors duration-300"></div>
                                        </div>
                                        
                                        <!-- Content dengan Fixed Height -->
                                        <div class="p-4 flex-1 flex flex-col min-h-[140px]">
                                            <!-- Judul dan Author -->
                                            <div class="flex-1">
                                                <h3 class="text-sm font-semibold text-slate-900 line-clamp-2 group-hover:text-sky-700 mb-2 leading-tight">
                                                    {{ $ebook->title }}
                                                </h3>
                                                <p class="text-xs text-slate-500 line-clamp-1 mb-3">{{ $ebook->author }}</p>
                                            </div>
                                            
                                            <!-- Metadata -->
                                            <div class="flex items-center justify-between mb-3">
                                                <span class="text-xs text-slate-500">{{ $ebook->year }}</span>
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-slate-100 text-slate-800 whitespace-nowrap">
                                                    {{ $ebook->category->name ?? '-' }}
                                                </span>
                                            </div>
                                            
                                            <!-- Action Buttons -->
                                            <div class="pt-3 border-t border-slate-100 space-y-2">
                                                <button 
                                                    class="w-full text-xs text-sky-700 hover:text-sky-800 hover:underline text-center font-medium transition-colors"
                                                    @click="
                                                        ebook = {
                                                            title: `{{ addslashes($ebook->title) }}`,
                                                            slug: `{{ $ebook->slug }}`,
                                                            author: `{{ addslashes($ebook->author) }}`,
                                                            year: `{{ $ebook->year }}`,
                                                            category: `{{ addslashes($ebook->category->name ?? '-') }}`,
                                                            description: `{{ $ebook->description ? addslashes($ebook->description) : '-' }}`,
                                                            cover: `{{ $ebook->cover_image_path ? asset('storage/' . $ebook->cover_image_path) : '' }}`,
                                                            file: `{{ $ebook->ebook_file_path ? asset('storage/' . $ebook->ebook_file_path) : '' }}`
                                                        };
                                                        showModal = true;
                                                    ">
                                                    Detail
                                                </button>
                                                @if ($ebook->ebook_file_path)
                                                    <a href="{{ route('read', $ebook) }}"  
                                                    class="block w-full text-xs text-center py-2 px-3 bg-sky-50 text-sky-700 rounded-lg hover:bg-sky-100 hover:text-sky-800 transition-colors font-medium">
                                                        Baca Sekarang
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="max-w-md mx-auto">
                                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                    </svg>
                                    <h3 class="text-lg font-medium text-slate-900 mb-2">Tidak ada hasil ditemukan</h3>
                                    <p class="text-slate-600 mb-4">Coba ubah kata kunci pencarian atau filter yang Anda gunakan.</p>
                                    <a href="{{ route('katalog') }}" class="inline-flex items-center px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition-colors">
                                        Tampilkan Semua E-Book
                                    </a>
                                </div>
                            </div>
                        @endif

                        <!-- Modal Detail Ebook - Perbaikan Cover Tidak Crop -->
                        <div x-show="showModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black/60 z-50 p-4">
                            <div @click.away="showModal = false" 
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full flex flex-col max-h-[85vh] overflow-hidden">

                                <!-- Header dengan Close Button -->
                                <div class="relative p-6 border-b border-slate-200 bg-gradient-to-r from-sky-50 to-cyan-50">
                                    <button @click="showModal = false" 
                                            class="absolute top-4 right-4 p-2 text-slate-400 hover:text-slate-600 hover:bg-white/50 rounded-full transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                    <h2 class="text-2xl font-bold text-slate-900 pr-8 leading-tight" x-text="ebook.title || 'Detail E-Book'"></h2>
                                    <div class="mt-2 flex items-center gap-3 text-sm text-slate-600">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <span x-text="ebook.author || 'Penulis tidak diketahui'"></span>
                                        </span>
                                        <span class="w-1 h-1 bg-slate-400 rounded-full"></span>
                                        <span x-text="ebook.year || '-'"></span>
                                    </div>
                                </div>

                                <!-- Body Content -->
                                <div class="flex-1 overflow-y-auto">
                                    <!-- Layout dengan Cover -->
                                    <template x-if="ebook.cover">
                                        <div class="p-6">
                                            <div class="flex flex-col sm:flex-row gap-6">
                                                <!-- Cover Image - Tidak Crop -->
                                                <div class="flex-shrink-0 flex justify-center sm:justify-start">
                                                    <div class="relative group">
                                                        <img :src="ebook.cover" 
                                                            alt="Cover" 
                                                            class="max-w-48 max-h-64 object-contain rounded-xl shadow-lg ring-1 ring-slate-200/50 group-hover:shadow-xl transition-shadow duration-300 bg-slate-50 p-2"
                                                            style="max-width: 12rem; max-height: 16rem;"
                                                        >
                                                        <div class="absolute inset-0 rounded-xl bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Book Details -->
                                                <div class="flex-1 space-y-4">
                                                    <!-- Metadata Cards -->
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                        <div class="bg-slate-50 rounded-lg p-3">
                                                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Kategori</p>
                                                            <p class="text-sm font-medium text-slate-900" x-text="ebook.category || 'Tidak dikategorikan'"></p>
                                                        </div>
                                                        <div class="bg-slate-50 rounded-lg p-3">
                                                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Tahun Terbit</p>
                                                            <p class="text-sm font-medium text-slate-900" x-text="ebook.year || 'Tidak diketahui'"></p>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Description -->
                                                    <div class="bg-gradient-to-br from-slate-50 to-slate-100/50 rounded-lg p-4">
                                                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Deskripsi</p>
                                                        <div class="prose prose-sm prose-slate max-w-none">
                                                            <p class="text-sm text-slate-700 leading-relaxed" 
                                                            x-text="ebook.description || 'Deskripsi untuk e-book ini belum tersedia. Silakan baca langsung untuk mengetahui isi dari buku ini.'"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Layout tanpa Cover -->
                                    <template x-if="!ebook.cover">
                                        <div class="p-6 space-y-6">
                                            <!-- No Cover Placeholder -->
                                            <div class="flex justify-center mb-4">
                                                <div class="w-32 h-40 bg-gradient-to-br from-slate-100 to-slate-200 rounded-lg flex items-center justify-center border-2 border-dashed border-slate-300">
                                                    <div class="text-center">
                                                        <svg class="w-8 h-8 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                        </svg>
                                                        <p class="text-xs text-slate-500">Tidak ada cover</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Metadata Grid -->
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                <div class="bg-slate-50 rounded-lg p-4">
                                                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Kategori</p>
                                                    <p class="text-base font-medium text-slate-900" x-text="ebook.category || 'Tidak dikategorikan'"></p>
                                                </div>
                                                <div class="bg-slate-50 rounded-lg p-4">
                                                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Tahun Terbit</p>
                                                    <p class="text-base font-medium text-slate-900" x-text="ebook.year || 'Tidak diketahui'"></p>
                                                </div>
                                            </div>
                                            
                                            <!-- Description -->
                                            <div class="bg-gradient-to-br from-slate-50 to-slate-100/50 rounded-lg p-4">
                                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Deskripsi</p>
                                                <div class="prose prose-sm prose-slate max-w-none">
                                                    <p class="text-sm text-slate-700 leading-relaxed" 
                                                    x-text="ebook.description || 'Deskripsi untuk e-book ini belum tersedia. Silakan baca langsung untuk mengetahui isi dari buku ini.'"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <!-- Footer Actions -->
                                <div class="p-6 border-t border-slate-200 bg-slate-50/50">
                                    <div class="flex flex-col sm:flex-row gap-3 sm:justify-between">
                                        <!-- Tombol Kiri: Lihat Kutipan -->
                                        <button @click="
                                            showModal = false;
                                            setTimeout(() => showCitationModal = true, 300);
                                        " 
                                                class="px-6 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-colors duration-200 font-medium flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                            </svg>
                                            Lihat Kutipan
                                        </button>

                                        <!-- Tombol Kanan: Tutup dan Baca -->
                                        <div class="flex flex-col sm:flex-row gap-3">
                                            <button @click="showModal = false" 
                                                    class="px-6 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-colors duration-200 font-medium">
                                                Tutup
                                            </button>
                                            <template x-if="ebook.file">
                                                <a :href="`{{ url('read') }}/${ebook.slug}`" 
                                                class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-sky-600 to-cyan-600 text-white hover:from-sky-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 shadow-sm hover:shadow-md transition-all duration-200 font-medium text-center flex items-center justify-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                    </svg>
                                                    Baca Sekarang
                                                </a>
                                            </template>
                                            <template x-if="!ebook.file">
                                                <button disabled 
                                                        class="px-6 py-2.5 rounded-lg bg-slate-200 text-slate-500 cursor-not-allowed font-medium">
                                                    File tidak tersedia
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Kutipan -->
                        <div x-show="showCitationModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black/60 z-50 p-4">
                            <div @click.away="showCitationModal = false" 
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full flex flex-col max-h-[85vh] overflow-hidden">

                                <!-- Header Modal Kutipan -->
                                <div class="relative p-6 border-b border-slate-200 bg-gradient-to-r from-emerald-50 to-green-50">
                                    <button @click="showCitationModal = false" 
                                            class="absolute top-4 right-4 p-2 text-slate-400 hover:text-slate-600 hover:bg-white/50 rounded-full transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                    <h2 class="text-xl font-bold text-slate-900 pr-8">Kutipan E-Book</h2>
                                    <p class="text-sm text-slate-600 mt-1" x-text="ebook.title"></p>
                                </div>

                                <!-- Body Modal Kutipan -->
                                <div class="flex-1 overflow-y-auto p-6">
                                    <!-- Style Selector -->
                                    <div class="mb-6">
                                        <label class="block text-sm font-medium text-slate-700 mb-3">Pilih Gaya Kutipan:</label>
                                        <div class="flex flex-wrap gap-2">
                                            <template x-for="style in ['apa', 'chicago', 'mla']">
                                                <button 
                                                    @click="citationStyle = style"
                                                    :class="{
                                                        'bg-emerald-600 text-white': citationStyle === style,
                                                        'bg-slate-100 text-slate-700 hover:bg-slate-200': citationStyle !== style
                                                    }"
                                                    class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 capitalize"
                                                    x-text="style">
                                                </button>
                                            </template>
                                        </div>
                                    </div>

                                    <!-- Citation Display -->
                                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                                        <div class="flex items-center justify-between mb-3">
                                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider" x-text="citationStyle.toUpperCase() + ' Style'"></span>
                                            <button 
                                                @click="
                                                    const citation = generateCitation(citationStyle, ebook);
                                                    const plainText = citation.replace(/<[^>]*>/g, '');
                                                    
                                                    // Fallback method untuk copy text
                                                    const textArea = document.createElement('textarea');
                                                    textArea.value = plainText;
                                                    textArea.style.position = 'fixed';
                                                    textArea.style.left = '-999999px';
                                                    textArea.style.top = '-999999px';
                                                    document.body.appendChild(textArea);
                                                    textArea.focus();
                                                    textArea.select();
                                                    
                                                    try {
                                                        document.execCommand('copy');
                                                        textArea.remove();
                                                        
                                                        // Update button text
                                                        const btn = $el;
                                                        const originalHTML = btn.innerHTML;
                                                        btn.innerHTML = '<svg class=\'w-4 h-4\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M5 13l4 4L19 7\'/></svg><span>Tersalin!</span>';
                                                        
                                                        setTimeout(() => {
                                                            btn.innerHTML = originalHTML;
                                                        }, 2000);
                                                    } catch (err) {
                                                        console.error('Gagal menyalin:', err);
                                                        textArea.remove();
                                                        alert('Gagal menyalin teks. Silakan copy manual.');
                                                    }
                                                "
                                                class="text-xs text-emerald-600 hover:text-emerald-700 font-medium flex items-center gap-1 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                                <span>Salin</span>
                                            </button>
                                        </div>
                                        <div class="prose prose-sm max-w-none">
                                            <p class="text-slate-700 leading-relaxed" x-html="generateCitation(citationStyle, ebook)"></p>
                                        </div>
                                    </div>

                                    <!-- Preview for all styles -->
                                    <div class="mt-6 space-y-4">
                                        <h3 class="text-sm font-semibold text-slate-700">Pratinjau Gaya Lain:</h3>
                                        <template x-for="style in ['apa', 'chicago', 'mla'].filter(s => s !== citationStyle)">
                                            <div class="border border-slate-200 rounded-lg p-3 hover:border-slate-300 transition-colors">
                                                <div class="flex items-center justify-between mb-2">
                                                    <span class="text-xs font-medium text-slate-600 capitalize" x-text="style + ' Style'"></span>
                                                    <button 
                                                        @click="citationStyle = style"
                                                        class="text-xs text-sky-600 hover:text-sky-700 font-medium">
                                                        Gunakan
                                                    </button>
                                                </div>
                                                <p class="text-xs text-slate-600 leading-relaxed" x-html="generateCitation(style, ebook)"></p>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <!-- Footer Modal Kutipan -->
                                <div class="p-6 border-t border-slate-200 bg-slate-50/50">
                                    <div class="flex justify-end gap-3">
                                        <button @click="showCitationModal = false" 
                                                class="px-6 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-colors duration-200 font-medium">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination dengan preservasi filter -->
                        @if ($ebooks->hasPages())
                            <div class="mt-8 flex justify-center">
                                <nav class="flex items-center gap-2">
                                    {{-- Tombol Previous --}}
                                    @if ($ebooks->onFirstPage())
                                        <button class="px-3 py-2 rounded-lg border border-slate-300 text-slate-400 bg-slate-100 cursor-not-allowed" disabled>
                                            ←
                                        </button>
                                    @else
                                        <a href="{{ $ebooks->previousPageUrl() . '&' . http_build_query(request()->except('page')) }}" 
                                        class="px-3 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50">
                                            ←
                                        </a>
                                    @endif

                                    {{-- Nomor Halaman --}}
                                    @foreach ($ebooks->getUrlRange(1, $ebooks->lastPage()) as $page => $url)
                                        @if ($page == $ebooks->currentPage())
                                            <span class="px-3 py-2 rounded-lg bg-sky-600 text-white">{{ $page }}</span>
                                        @else
                                            <a href="{{ $url . '&' . http_build_query(array_merge(request()->except('page'), ['page' => $page])) }}" 
                                            class="px-3 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endforeach

                                    {{-- Tombol Next --}}
                                    @if ($ebooks->hasMorePages())
                                        <a href="{{ $ebooks->nextPageUrl() . '&' . http_build_query(request()->except('page')) }}" 
                                        class="px-3 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50">
                                            →
                                        </a>
                                    @else
                                        <button class="px-3 py-2 rounded-lg border border-slate-300 text-slate-400 bg-slate-100 cursor-not-allowed" disabled>
                                            →
                                        </button>
                                    @endif
                                </nav>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </section>
    <x-footer />
@endsection