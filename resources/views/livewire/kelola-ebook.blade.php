<div>

    <!-- Page Header -->
    <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="heading text-2xl sm:text-3xl font-bold text-slate-900 mb-2">
                Kelola E-book
            </h1>
            <p class="text-slate-600">
                Mengelola daftar Ebook yang tersedia di sistem.
            </p>
        </div>
        <a href="{{ route('admin.ebooks.create') }}" 
           class="px-4 py-2 bg-sky-600 text-white text-sm font-medium rounded-lg hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 transition-colors">
            Tambah E-book Baru
        </a>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6 mb-6">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <!-- Search Bar -->
            <div class="lg:col-span-2">
                <div class="flex items-center gap-2 bg-slate-50 rounded-lg px-3 py-2 ring-1 ring-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input 
                        type="text" 
                        wire:model.live.debounce.500ms="search"
                        placeholder="Cari judul, penulis, atau deskripsi..." 
                        class="w-full bg-transparent focus:outline-none text-slate-700 placeholder-slate-400">
                    @if($search)
                        <button 
                            wire:click="$set('search', '')"
                            class="p-1 text-slate-400 hover:text-slate-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Category Filter -->
            <div>
                <select 
                    wire:model.live="category"
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 focus:outline-none bg-white">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $categoryItem)
                        <option value="{{ $categoryItem->id }}">{{ $categoryItem->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Sort Filter -->
            <div>
                <select 
                    wire:model.live="sort"
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 focus:outline-none bg-white">
                    <option value="latest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="title_asc">A-Z Judul</option>
                    <option value="title_desc">Z-A Judul</option>
                </select>
            </div>
        </div>

        <!-- Active Filters -->
        @if($search || $category)
            <div class="mt-4 flex flex-wrap items-center gap-3">
                <span class="text-sm text-slate-600">Filter aktif:</span>
                <div class="flex flex-wrap gap-2">
                    @if($search)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-sky-100 text-sky-800">
                            Pencarian: {{ $search }}
                            <button 
                                wire:click="$set('search', '')" 
                                class="ml-1 hover:text-sky-900">
                                ×
                            </button>
                        </span>
                    @endif
                    @if($category)
                        @php
                            $selectedCategory = $categories->firstWhere('id', $category);
                        @endphp
                        @if($selectedCategory)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-slate-100 text-slate-800">
                                Kategori: {{ $selectedCategory->name }}
                                <button 
                                    wire:click="$set('category', '')" 
                                    class="ml-1 hover:text-slate-900">
                                    ×
                                </button>
                            </span>
                        @endif
                    @endif
                </div>
                <button 
                    wire:click="resetFilters"
                    class="text-sm text-sky-600 hover:text-sky-700 font-medium">
                    Reset Filter
                </button>
            </div>
        @endif
    </div>

    <!-- Results Info -->
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="heading text-xl font-semibold text-slate-900">
                @if($search || $category)
                    Hasil Pencarian
                @else
                    Semua E-Book
                @endif
            </h2>
            <p class="text-sm text-slate-600 mt-1">
                Menampilkan {{ $ebooks->count() }} dari {{ $ebooks->total() }} e-book
            </p>
        </div>
    </div>

    <!-- eBooks Card Grid -->
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
        @if($ebooks->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 sm:gap-6">
                @foreach ($ebooks as $ebook)
                    <div class="group bg-white rounded-xl ring-1 ring-slate-200 hover:ring-sky-200 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col h-full">
                        <!-- Cover Container -->
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
                        
                        <!-- Content -->
                        <div class="p-4 flex-1 flex flex-col min-h-[140px]">
                            <!-- Judul dan Author -->
                            <div class="flex-1">
                                <h3 class="text-xs font-semibold text-slate-900 line-clamp-2 group-hover:text-sky-700 mb-2 leading-tight">
                                    {{ $ebook->title }}
                                </h3>
                                <p class="text-xs text-slate-500 line-clamp-1 mb-2">{{ $ebook->author }}</p>
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
                                <!-- Detail Button -->
                                <button 
                                    wire:click="$dispatch('showDetail', { ebookId: {{ $ebook->id }} })"
                                    class="w-full text-xs text-sky-700 hover:text-sky-800 hover:underline text-center font-medium transition-colors">
                                    Detail
                                </button>
                                
                                <!-- Edit and Delete Buttons -->
                                <div class="flex justify-between items-center gap-2">
                                    <a href="{{ route('admin.ebooks.edit', $ebook) }}" 
                                       class="flex-1 text-xs text-center py-2 px-2 bg-sky-50 text-sky-700 rounded-lg hover:bg-sky-100 hover:text-sky-800 transition-colors font-medium">
                                        Edit
                                    </a>
                                    <button 
                                        wire:click="confirmDelete({{ $ebook->id }})"
                                        class="flex-1 text-xs text-center py-2 px-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 hover:text-red-700 transition-colors font-medium">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-slate-900 mb-2">
                        @if($search || $category)
                            Tidak ada e-book ditemukan
                        @else
                            Belum ada e-book tersedia
                        @endif
                    </h3>
                    <p class="text-slate-600 mb-4">
                        @if($search || $category)
                            Coba ubah kata kunci pencarian atau filter yang Anda gunakan.
                        @else
                            Mulai tambahkan e-book pertama Anda.
                        @endif
                    </p>
                    @if($search || $category)
                        <button 
                            wire:click="resetFilters"
                            class="inline-flex items-center px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition-colors">
                            Tampilkan Semua E-Book
                        </button>
                    @else
                        <a href="{{ route('admin.ebooks.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition-colors">
                            Tambah E-Book Pertama
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Detail Modal -->
    <livewire:ebook-modal />

    <!-- Pagination -->
    @if ($ebooks->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $ebooks->links() }}
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    <div x-data x-show="$wire.showDeleteModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black/60 z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
            <div class="text-center">
                <!-- Warning Icon -->
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                
                <h3 class="text-lg font-semibold text-slate-900 mb-2">
                    Hapus E-Book?
                </h3>
                
                <p class="text-slate-600 mb-6">
                    Apakah Anda yakin ingin menghapus 
                    <span class="font-semibold">"{{ $ebookToDelete->title ?? '' }}"</span>? 
                    Tindakan ini tidak dapat dibatalkan.
                </p>
                
                <div class="flex gap-3 justify-center">
                    <button 
                        wire:click="closeDeleteModal"
                        class="px-4 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors font-medium">
                        Batal
                    </button>
                    <button 
                        wire:click="deleteEbook"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>