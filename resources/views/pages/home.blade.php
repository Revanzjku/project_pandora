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
    <section class="py-8 sm:py-10 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between gap-4 mb-6">
                <div>
                    <h2 class="heading text-xl sm:text-2xl font-semibold text-slate-900">Terbaru untuk Anda</h2>
                    <p class="text-sm text-slate-600">Jelajahi koleksi e-book domain publik pilihan kami.</p>
                </div>
                <a href="/katalog" class="hidden sm:inline-flex text-sm text-sky-700 hover:text-sky-800">Lihat semua →</a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6">
                @php $hasEbooks = isset($ebooks) && count($ebooks) > 0; @endphp
                @if($hasEbooks)
                    @foreach($ebooks as $ebook)
                        <a href="{{ url('/detail/'.$ebook->id) }}" class="group bg-white rounded-xl ring-1 ring-slate-200 hover:ring-sky-200 shadow-sm hover:shadow transition overflow-hidden flex flex-col">
                            <div class="relative aspect-[3/4] bg-slate-100">
                                <img src="{{ $ebook->cover_url ?? 'https://placehold.co/300x400?text=Cover' }}" alt="{{ $ebook->title }}" class="absolute inset-0 h-full w-full object-cover">
                            </div>
                            <div class="p-3 sm:p-4 flex-1 flex flex-col">
                                <h3 class="text-sm sm:text-base font-semibold text-slate-900 line-clamp-2 group-hover:text-sky-700">{{ $ebook->title }}</h3>
                                <p class="mt-1 text-xs text-slate-500 line-clamp-1">{{ $ebook->author ?? 'Anonim' }}</p>
                                <div class="mt-3 inline-flex items-center gap-1 text-xs text-sky-700">
                                    Baca sekarang
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    @for ($i = 1; $i <= 10; $i++)
                        <div class="bg-white rounded-xl ring-1 ring-slate-200 shadow-sm overflow-hidden animate-pulse">
                            <div class="aspect-[3/4] bg-slate-100"></div>
                            <div class="p-4 space-y-2">
                                <div class="h-4 bg-slate-100 rounded w-4/5"></div>
                                <div class="h-3 bg-slate-100 rounded w-2/5"></div>
                            </div>
                        </div>
                    @endfor
                @endif
            </div>

            <div class="mt-8 sm:hidden text-center">
                <a href="/katalog" class="inline-flex items-center px-4 py-2 rounded-lg bg-sky-600 text-white text-sm hover:bg-sky-700">Lihat semua</a>
            </div>
        </div>
    </section>

    <x-footer />
@endsection