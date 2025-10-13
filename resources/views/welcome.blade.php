@extends('layouts.app')
@section('content')
    <x-navbar />
    <section class="relative overflow-hidden">
        <div aria-hidden="true" class="absolute inset-0 -z-10">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-200/40 blur-3xl rounded-full"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-sky-200/40 blur-3xl rounded-full"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
            <div class="grid lg:grid-cols-2 gap-10 items-center">
                <div>
                    <h1 class="heading text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 leading-snug md:leading-snug lg:leading-normal xl:leading-relaxed max-w-2xl lg:max-w-3xl xl:max-w-4xl">
                        Akses Berbagai Buku Domain Publik dan Bebas Hak Cipta
                    </h1>
                    <p class="mt-4 text-slate-600 max-w-xl">Temukan ribuan e-book legal, mudah diakses, dan ramah pengguna. PANDORA dirancang mobile-first untuk pengalaman membaca terbaik di mana saja.</p>

                    <!-- Badges / Highlights -->
                    <div class="mt-6 flex flex-wrap gap-2">
                        <span class="px-3 py-1.5 rounded-full text-xs bg-sky-50 text-sky-700 ring-1 ring-sky-100">Domain Publik</span>
                        <span class="px-3 py-1.5 rounded-full text-xs bg-emerald-50 text-emerald-700 ring-1 ring-emerald-100">Gratis & Legal</span>
                        <span class="px-3 py-1.5 rounded-full text-xs bg-indigo-50 text-indigo-700 ring-1 ring-indigo-100">Mobile-First</span>
                    </div>
                </div>

                <!-- Illustration -->
                <div class="relative hidden lg:block">
                    <div class="aspect-[4/3] w-full rounded-2xl bg-gradient-to-br from-sky-100 to-cyan-100 ring-1 ring-slate-200 p-6">
                        <img src="{{ asset('ilustrasi.png') }}" alt="Ilustrasi Pustaka Digital" class="h-full w-full rounded-xl object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-8 sm:py-10 lg:py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="heading text-2xl sm:text-3xl font-bold text-slate-900 mb-4">Fitur Unggulan</h2>
                <p class="text-slate-600 max-w-2xl mx-auto">Platform yang dirancang khusus untuk memberikan pengalaman membaca terbaik dengan teknologi modern.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-8 text-center hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-sky-500 to-cyan-600 grid place-items-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="heading text-lg font-semibold text-slate-900 mb-3">Akses Cepat</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Cari e-book dengan mudah dan temukan bacaan favoritmu hanya dalam hitungan detik.</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-8 text-center hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 grid place-items-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h3 class="heading text-lg font-semibold text-slate-900 mb-3">Legal & Gratis</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Semua koleksi tersedia dalam domain publik, bebas hak cipta, dan gratis diakses.</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-8 text-center hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 grid place-items-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="heading text-lg font-semibold text-slate-900 mb-3">Mobile-First</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Desain responsif yang nyaman digunakan di semua perangkat, dari mobile hingga desktop.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-8 sm:py-10 lg:py-12 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="heading text-2xl sm:text-3xl font-bold text-slate-900 mb-4">Cara Menggunakan PANDORA</h2>
                <p class="text-slate-600 max-w-2xl mx-auto">Akses ribuan buku domain publik dengan mudah dalam 3 langkah sederhana.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-full bg-sky-100 grid place-items-center text-sky-700 text-xl font-bold">1</div>
                    <h3 class="heading text-lg font-semibold text-slate-900 mb-3">Daftar Akun</h3>
                    <p class="text-slate-600 text-sm">Buat akun gratis untuk mulai menjelajahi koleksi e-book kami.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-full bg-sky-100 grid place-items-center text-sky-700 text-xl font-bold">2</div>
                    <h3 class="heading text-lg font-semibold text-slate-900 mb-3">Jelajahi Katalog</h3>
                    <p class="text-slate-600 text-sm">Temukan buku yang Anda sukai dengan fitur pencarian dan kategori.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-full bg-sky-100 grid place-items-center text-sky-700 text-xl font-bold">3</div>
                    <h3 class="heading text-lg font-semibold text-slate-900 mb-3">Baca atau Unduh</h3>
                    <p class="text-slate-600 text-sm">Nikmati membaca langsung di browser atau unduh untuk dibaca offline.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-8 sm:py-10 lg:py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto"> 
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                    <div>
                        <div class="text-3xl font-bold text-sky-700">{{ $bookCount }}</div>
                        <div class="text-sm text-slate-600 mt-2">Judul Buku</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-sky-700">100%</div>
                        <div class="text-sm text-slate-600 mt-2">Gratis & Legal</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-sky-700">24/7</div>
                        <div class="text-sm text-slate-600 mt-2">Tersedia</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-sky-700">{{ $userCount }}</div> 
                        <div class="text-sm text-slate-600 mt-2">Pengguna Aktif</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-12 sm:py-16 lg:py-20 bg-gradient-to-r from-sky-500 to-cyan-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="heading text-2xl sm:text-3xl font-bold text-white mb-4">Siap Memulai Perjalanan Membaca Anda?</h2>
            <p class="text-sky-100 max-w-2xl mx-auto mb-8">Bergabunglah dengan ribuan pembaca yang telah menikmati akses gratis ke literatur domain publik berkualitas.</p>
            <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-white text-sky-700 rounded-lg hover:bg-slate-100 transition-colors font-medium shadow-md">Daftar Sekarang - Gratis</a>
        </div>
    </section>
    <x-footer />
@endsection