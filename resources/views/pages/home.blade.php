@extends('layouts.app')
@section('content')
    <x-navbar />

    <!-- Welcome Section -->
    <section class="py-6 sm:py-8 lg:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">
                Selamat Datang Kembali, {{ Auth::user()->name }}!
            </h1>
            <p class="mt-2 text-slate-600 max-w-2xl mx-auto">
                Ayo mulai menjelajah koleksi buku dan e-book di PANDORA.  
                Temukan bacaan baru atau lanjutkan bacaan favoritmu.
            </p>
        </div>
    </section>

    <!-- Section Terbaru -->
    <section class="py-8 sm:py-10 lg:py-12" x-data="{ 
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
    </section>

    <x-footer />
@endsection