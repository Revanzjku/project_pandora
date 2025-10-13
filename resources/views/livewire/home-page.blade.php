<div>
    <!-- Welcome Section -->
    <section class="py-6 sm:py-8 lg:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">
                Mulai untuk membaca, {{ Auth::user()->name }}!
            </h1>
            <p class="mt-2 text-slate-600 max-w-2xl mx-auto">
                Ayo mulai menjelajah koleksi buku dan e-book di PANDORA.  
                Temukan bacaan baru atau lanjutkan bacaan favoritmu.
            </p>
        </div>
    </section>

    <!-- Section Terbaru -->
    <section class="py-8 sm:py-10 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between gap-4 mb-6">
                <div>
                    <h2 class="heading text-xl sm:text-2xl font-semibold text-slate-900">Terbaru untuk Anda</h2>
                    <p class="text-sm text-slate-600">Jelajahi koleksi e-book domain publik pilihan kami.</p>
                </div>
                <a href="/katalog" class="hidden sm:inline-flex text-sm text-sky-700 hover:text-sky-800">Lihat semua →</a>
            </div>

            <!-- Grid Buku - Fixed Height tanpa Crop -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-6">
                @forelse ($ebooks as $ebook)
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
                                    wire:click="$dispatch('showDetail', { ebookId: {{ $ebook->id }} })"
                                    class="w-full text-xs text-sky-700 hover:text-sky-800 hover:underline text-center font-medium transition-colors">
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
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="max-w-md mx-auto">
                            <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-slate-900 mb-2">Belum ada e-book tersedia</h3>
                            <p class="text-slate-600">E-book akan segera ditambahkan ke koleksi.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 sm:hidden text-center">
                <a href="/katalog" class="inline-flex items-center px-6 py-3 rounded-lg bg-sky-600 text-white text-sm font-medium hover:bg-sky-700 transition-colors shadow-sm">
                    Lihat Semua E-Book
                </a>
            </div>
        </div>
    </section>

    <livewire:ebook-modal />
</div>