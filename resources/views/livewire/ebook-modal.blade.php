<div>
    <!-- Modal Detail Ebook -->
    @if($showModal && $selectedEbook)
        <div x-data x-show="true" x-cloak class="fixed inset-0 flex items-center justify-center bg-black/60 z-50 p-4">
            <div @click.away="$wire.closeModal()" 
                class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full flex flex-col max-h-[85vh] overflow-hidden">

                <!-- Header dengan Close Button -->
                <div class="relative p-6 border-b border-slate-200 bg-gradient-to-r from-sky-50 to-cyan-50">
                    <button wire:click="closeModal()" 
                            class="absolute top-4 right-4 p-2 text-slate-400 hover:text-slate-600 hover:bg-white/50 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <h2 class="text-2xl font-bold text-slate-900 pr-8 leading-tight">{{ $selectedEbook['title'] }}</h2>
                    <div class="mt-2 flex items-center gap-3 text-sm text-slate-600">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>{{ $selectedEbook['author'] ?? 'Penulis tidak diketahui' }}</span>
                        </span>
                        <span class="w-1 h-1 bg-slate-400 rounded-full"></span>
                        <span>{{ $selectedEbook['year'] ?? '-' }}</span>
                    </div>
                </div>

                <!-- Body Content -->
                <div class="flex-1 overflow-y-auto">
                    @if($selectedEbook['cover'])
                        <div class="p-6">
                            <div class="flex flex-col sm:flex-row gap-6">
                                <!-- Cover Image - Tidak Crop -->
                                <div class="flex-shrink-0 flex justify-center sm:justify-start">
                                    <div class="relative group">
                                        <img src="{{ $selectedEbook['cover'] }}" 
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
                                            <p class="text-sm font-medium text-slate-900">{{ $selectedEbook['category'] ?? 'Tidak dikategorikan' }}</p>
                                        </div>
                                        <div class="bg-slate-50 rounded-lg p-3">
                                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Tahun Terbit</p>
                                            <p class="text-sm font-medium text-slate-900">{{ $selectedEbook['year'] ?? 'Tidak diketahui' }}</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Description -->
                                    <div class="bg-gradient-to-br from-slate-50 to-slate-100/50 rounded-lg p-4">
                                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Deskripsi</p>
                                        <div class="prose prose-sm prose-slate max-w-none">
                                            <p class="text-sm text-slate-700 leading-relaxed">
                                                {{ $selectedEbook['description'] ?? 'Deskripsi untuk e-book ini belum tersedia. Silakan baca langsung untuk mengetahui isi dari buku ini.' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
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
                                    <p class="text-base font-medium text-slate-900">{{ $selectedEbook['category'] ?? 'Tidak dikategorikan' }}</p>
                                </div>
                                <div class="bg-slate-50 rounded-lg p-4">
                                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Tahun Terbit</p>
                                    <p class="text-base font-medium text-slate-900">{{ $selectedEbook['year'] ?? 'Tidak diketahui' }}</p>
                                </div>
                            </div>
                            
                            <!-- Description -->
                            <div class="bg-gradient-to-br from-slate-50 to-slate-100/50 rounded-lg p-4">
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Deskripsi</p>
                                <div class="prose prose-sm prose-slate max-w-none">
                                    <p class="text-sm text-slate-700 leading-relaxed">
                                        {{ $selectedEbook['description'] ?? 'Deskripsi untuk e-book ini belum tersedia. Silakan baca langsung untuk mengetahui isi dari buku ini.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Footer Actions -->
                <div class="p-6 border-t border-slate-200 bg-slate-50/50">
                    <div class="flex flex-col sm:flex-row gap-3 sm:justify-between">
                        <!-- Tombol Kiri: Lihat Kutipan -->
                        <button wire:click="showCitation()" 
                                class="px-6 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-colors duration-200 font-medium flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Lihat Sitasi
                        </button>

                        <!-- Tombol Kanan: Download dan Baca -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            @if($selectedEbook['file'])
                                <button wire:click="downloadEbook()"
                                        class="px-6 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-colors duration-200 font-medium flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Unduh E-book
                                </button>
                                <a href="{{ url('read', $selectedEbook['slug']) }}" 
                                class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-sky-600 to-cyan-600 text-white hover:from-sky-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 shadow-sm hover:shadow-md transition-all duration-200 font-medium text-center flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    Baca Sekarang
                                </a>
                            @else
                                <button disabled 
                                        class="px-6 py-2.5 rounded-lg bg-slate-200 text-slate-500 cursor-not-allowed font-medium">
                                    File tidak tersedia
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Sitasi -->
    @if($showCitationModal && $selectedEbook)
        <div x-data="{
            copied: false,
            copyCitation() {
                // Dapatkan citation text dari PHP
                const citationText = `{!! $this->getCitationText($citationStyle, $selectedEbook) !!}`;
                
                console.log('Copying text:', citationText); // Debug
                
                // Modern Clipboard API
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(citationText).then(() => {
                        this.copied = true;
                        setTimeout(() => this.copied = false, 2000);
                    }).catch(err => {
                        console.error('Failed to copy: ', err);
                        this.fallbackCopy(citationText);
                    });
                } else {
                    this.fallbackCopy(citationText);
                }
            },
            fallbackCopy(text) {
                const textArea = document.createElement('textarea');
                textArea.value = text;
                textArea.style.position = 'fixed';
                textArea.style.left = '-999999px';
                textArea.style.top = '-999999px';
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                
                try {
                    const successful = document.execCommand('copy');
                    if (successful) {
                        this.copied = true;
                        setTimeout(() => this.copied = false, 2000);
                    } else {
                        console.error('Fallback copy failed');
                        alert('Gagal menyalin teks. Silakan copy manual: ' + text);
                    }
                } catch (err) {
                    console.error('Fallback: Failed to copy text: ', err);
                    alert('Gagal menyalin teks. Silakan copy manual: ' + text);
                }
                
                document.body.removeChild(textArea);
            }
        }" 
        x-show="true" 
        x-cloak 
        class="fixed inset-0 flex items-center justify-center bg-black/60 z-50 p-4">
            <div @click.away="$wire.closeCitationModal()" 
                class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full flex flex-col max-h-[85vh] overflow-hidden">

                <!-- Header Modal Sitasi -->
                <div class="relative p-6 border-b border-slate-200 bg-gradient-to-r from-emerald-50 to-green-50">
                    <button wire:click="closeCitationModal()" 
                            class="absolute top-4 right-4 p-2 text-slate-400 hover:text-slate-600 hover:bg-white/50 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <h2 class="text-xl font-bold text-slate-900 pr-8">Sitasi E-Book</h2>
                    <p class="text-sm text-slate-600 mt-1">{{ $selectedEbook['title'] }}</p>
                </div>

                <!-- Body Modal Sitasi -->
                <div class="flex-1 overflow-y-auto p-6">
                    <!-- Style Selector -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-slate-700 mb-3">Pilih Gaya Sitasi:</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['apa', 'chicago', 'mla'] as $style)
                                <button 
                                    wire:click="$set('citationStyle', '{{ $style }}')"
                                    class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 capitalize {{ $citationStyle === $style ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                                    {{ $style }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Citation Display -->
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ strtoupper($citationStyle) }} Style</span>
                            <button 
                                @click="copyCitation()"
                                :class="{ 'text-green-600': copied, 'text-emerald-600 hover:text-emerald-700': !copied }"
                                class="font-medium flex items-center gap-1 transition-colors text-xs">
                                <template x-if="!copied">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </template>
                                <template x-if="copied">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </template>
                                <span x-text="copied ? 'Tersalin!' : 'Salin'"></span>
                            </button>
                        </div>
                        <div class="prose prose-sm max-w-none">
                            <p class="text-slate-700 leading-relaxed">
                                {!! $this->generateCitation($citationStyle, $selectedEbook) !!}
                            </p>
                        </div>
                    </div>

                    <!-- Preview for all styles -->
                    <div class="mt-6 space-y-4">
                        <h3 class="text-sm font-semibold text-slate-700">Pratinjau Gaya Lain:</h3>
                        @foreach(['apa', 'chicago', 'mla'] as $style)
                            @if($style !== $citationStyle)
                                <div class="border border-slate-200 rounded-lg p-3 hover:border-slate-300 transition-colors">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-medium text-slate-600 capitalize">{{ $style }} Style</span>
                                        <button 
                                            wire:click="$set('citationStyle', '{{ $style }}')"
                                            class="text-xs text-sky-600 hover:text-sky-700 font-medium">
                                            Gunakan
                                        </button>
                                    </div>
                                    <p class="text-xs text-slate-600 leading-relaxed">
                                        {!! $this->generateCitation($style, $selectedEbook) !!}
                                    </p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Footer Modal Sitasi -->
                <div class="p-6 border-t border-slate-200 bg-slate-50/50">
                    <div class="flex justify-end gap-3">
                        <button wire:click="backToDetail()" 
                                class="px-6 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-colors duration-200 font-medium flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali ke Detail
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>