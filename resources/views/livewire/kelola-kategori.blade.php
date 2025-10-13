<div>
    <!-- Page Header -->
    <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="heading text-2xl sm:text-3xl font-bold text-slate-900 mb-2">
                Kelola Kategori
            </h1>
            <p class="text-slate-600">
                Mengelola daftar kategori ebook yang tersedia di sistem.
            </p>
        </div>
        <a href="{{ route('admin.categories.create') }}" 
           class="px-4 py-2 bg-sky-600 text-white text-sm font-medium rounded-lg hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 transition-colors">
            Tambah Kategori
        </a>
    </div>

    <!-- Search Bar -->
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6 mb-6">
        <div class="max-w-md">
            <div class="flex items-center gap-2 bg-slate-50 rounded-lg px-3 py-2 ring-1 ring-slate-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input 
                    type="text" 
                    wire:model.live.debounce.500ms="search"
                    placeholder="Cari nama kategori..." 
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

        <!-- Active Search Filter -->
        @if($search)
            <div class="mt-4 flex flex-wrap items-center gap-3">
                <span class="text-sm text-slate-600">Filter aktif:</span>
                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-sky-100 text-sky-800">
                        Pencarian: {{ $search }}
                        <button 
                            wire:click="$set('search', '')" 
                            class="ml-1 hover:text-sky-900">
                            ×
                        </button>
                    </span>
                </div>
            </div>
        @endif
    </div>

    <!-- Results Info -->
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="heading text-xl font-semibold text-slate-900">
                @if($search)
                    Hasil Pencarian
                @else
                    Semua Kategori
                @endif
            </h2>
            <p class="text-sm text-slate-600 mt-1">
                Menampilkan {{ $categories->count() }} dari {{ $categories->total() }} kategori
            </p>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
        <!-- Desktop View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nama Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Jumlah Ebook</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                {{ $categories->firstItem() + $loop->index }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 font-medium">
                                {{ $category->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                {{ $category->ebooks_count ?? $category->ebooks()->count() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center space-x-4">
                                    <a href="{{ route('admin.categories.edit', $category) }}" 
                                       class="text-sky-600 hover:text-sky-700 hover:underline transition-colors">
                                        Edit
                                    </a>
                                    <button 
                                        wire:click="confirmDelete({{ $category->id }})"
                                        class="text-red-600 hover:text-red-700 hover:underline transition-colors">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-10 text-slate-500">
                                @if($search)
                                    Tidak ada kategori ditemukan untuk "{{ $search }}"
                                @else
                                    Belum ada data kategori.
                                @endif
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
                    <div class="bg-slate-50 p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="text-base font-bold text-slate-900 mb-1">{{ $category->name }}</h3>
                                <p class="text-sm text-slate-600">
                                    {{ $category->ebooks_count ?? $category->ebooks()->count() }} ebook
                                </p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('admin.categories.edit', $category) }}" 
                                   class="text-sky-600 hover:text-sky-700 text-sm font-medium">
                                    Edit
                                </a>
                                <button 
                                    wire:click="confirmDelete({{ $category->id }})"
                                    class="text-red-600 hover:text-red-700 text-sm font-medium">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 text-slate-500">
                        @if($search)
                            Tidak ada kategori ditemukan untuk "{{ $search }}"
                        @else
                            Belum ada data kategori.
                        @endif
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if ($categories->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $categories->links() }}
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
                    Hapus Kategori?
                </h3>
                
                <p class="text-slate-600 mb-4">
                    Apakah Anda yakin ingin menghapus kategori 
                    <span class="font-semibold">"{{ $categoryToDelete->name ?? '' }}"</span>?
                </p>

                @if($categoryToDelete && $categoryToDelete->ebooks()->exists())
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                        <p class="text-sm text-yellow-700">
                            ⚠️ Kategori ini digunakan oleh {{ $categoryToDelete->ebooks()->count() }} ebook. 
                            Penghapusan tidak diperbolehkan.
                        </p>
                    </div>
                @endif
                
                <div class="flex gap-3 justify-center">
                    <button 
                        wire:click="closeDeleteModal"
                        class="px-4 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors font-medium">
                        Batal
                    </button>
                    
                    @if(!$categoryToDelete || !$categoryToDelete->ebooks()->exists())
                        <button 
                            wire:click="deleteCategory"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                            Ya, Hapus
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>