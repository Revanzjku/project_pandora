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
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" name="q" placeholder="Cari judul, penulis, atau kata kunci" class="w-full bg-transparent focus:outline-none text-slate-700 placeholder-slate-400">
                            <button class="inline-flex whitespace-nowrap items-center px-3 py-2 rounded-lg bg-sky-600 text-white text-sm hover:bg-sky-700">Cari</button>
                        </div>
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
                            <h2 class="heading text-lg font-semibold mb-6 text-slate-900">Filter & Urutkan</h2>
                            <div class="space-y-6">
                                <div>
                                    <h3 class="font-medium text-slate-700 mb-3">Kategori</h3>
                                    <ul class="space-y-2 text-sm">
                                        <li><a href="#" class="block px-3 py-2 rounded-lg hover:bg-slate-50 text-slate-600 hover:text-sky-700">Novel</a></li>
                                        <li><a href="#" class="block px-3 py-2 rounded-lg hover:bg-slate-50 text-slate-600 hover:text-sky-700">Sejarah</a></li>
                                        <li><a href="#" class="block px-3 py-2 rounded-lg hover:bg-slate-50 text-slate-600 hover:text-sky-700">Ilmiah</a></li>
                                        <li><a href="#" class="block px-3 py-2 rounded-lg hover:bg-slate-50 text-slate-600 hover:text-sky-700">Puisi</a></li>
                                    </ul>
                                </div>
                                <div>
                                    <h3 class="font-medium text-slate-700 mb-3">Urutkan</h3>
                                    <select class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 focus:outline-none">
                                        <option>Terbaru</option>
                                        <option>Terpopuler</option>
                                        <option>A-Z</option>
                                        <option>Z-A</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </aside>

                    <!-- Grid Buku -->
                    <div class="lg:col-span-3">
                        <div class="flex items-center justify-between gap-4 mb-6">
                            <div>
                                <h2 class="heading text-xl sm:text-2xl font-semibold text-slate-900">Semua E-Book</h2>
                                <p class="text-sm text-slate-600 mt-1">Menampilkan 12 dari 1,234 e-book tersedia</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                            @for ($i = 1; $i <= 12; $i++)
                            <a href="/detail/{{$i}}" class="group bg-white rounded-xl ring-1 ring-slate-200 hover:ring-sky-200 shadow-sm hover:shadow transition overflow-hidden flex flex-col">
                                <div class="relative aspect-[3/4] bg-slate-100">
                                    <div class="absolute inset-0 bg-gradient-to-br from-slate-200 to-slate-300 flex items-center justify-center">
                                        <span class="text-slate-500 text-sm">Cover {{$i}}</span>
                                    </div>
                                </div>
                                <div class="p-3 sm:p-4 flex-1 flex flex-col">
                                    <h3 class="text-sm sm:text-base font-semibold text-slate-900 line-clamp-2 group-hover:text-sky-700">Judul Buku {{$i}}</h3>
                                    <p class="mt-1 text-xs text-slate-500 line-clamp-1">Penulis {{$i}}</p>
                                    <div class="mt-3 inline-flex items-center gap-1 text-xs text-sky-700">Baca sekarang
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </div>
                                </div>
                            </a>
                            @endfor
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8 flex justify-center">
                            <nav class="flex items-center gap-2">
                                <button class="px-3 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 disabled:opacity-50" disabled>←</button>
                                <button class="px-3 py-2 rounded-lg bg-sky-600 text-white">1</button>
                                <button class="px-3 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50">2</button>
                                <button class="px-3 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50">3</button>
                                <button class="px-3 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50">→</button>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <x-footer />
@endsection
