@extends('layouts.app')

@section('content')

    <div class="flex flex-col h-screen">
        <!-- Header -->
        <div class="flex items-center justify-between px-4 py-3 border-b border-slate-200 bg-white shadow-sm">
            <h1 class="text-lg font-semibold text-slate-800 truncate">
                {{ $ebook->title }}
            </h1>
            <div class="flex items-center space-x-2">
                <a href="{{ session('reader_referrer', route('katalog')) }}" 
                   class="px-3 py-2 text-sm rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200">
                    ← Kembali
                </a>
            </div>
        </div>

        <!-- Reader -->
        <div class="flex-1 overflow-hidden bg-slate-50">
            <iframe src="{{ asset('storage/' . $ebook->ebook_file_path) }}" 
                    class="w-full h-full border-0"
                    title="Ebook Reader"></iframe>
        </div>
    </div>
@endsection