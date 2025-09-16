@extends('layouts.app')
@section('content')
    <x-navbar />
        <div class="flex">
            <x-sidebar />

            <!-- Main Content -->
            <div class="flex-1 lg:ml-0">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <!-- Welcome Section -->
                    <div class="mb-8">
                        <h1 class="heading text-2xl sm:text-3xl font-bold text-slate-900 mb-2">
                            Halo, {{ Auth::user()->name }}! 👋
                        </h1>
                        <p class="text-slate-600">
                            Selamat datang di dashboard admin. Kelola sistem PANDORA dengan mudah.
                        </p>
                    </div>

                    <!-- Statistics Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Admin Statistics -->
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-600">Total Ebook</p>
                                    <p class="text-2xl font-bold text-slate-900">1,247</p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sky-500 to-cyan-600 grid place-items-center text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-600">Total Pengguna</p>
                                    <p class="text-2xl font-bold text-slate-900">2,341</p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 grid place-items-center text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-600">Download Hari Ini</p>
                                    <p class="text-2xl font-bold text-slate-900">89</p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 grid place-items-center text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-600">Aktivitas Hari Ini</p>
                                    <p class="text-2xl font-bold text-slate-900">156</p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-500 to-red-600 grid place-items-center text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- New Books Section -->
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-slate-900 mb-4">Buku Baru yang Ditambahkan</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @for ($i = 1; $i <= 6; $i++)
                                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-16 h-20 bg-slate-200 rounded-lg"></div>
                                        <div>
                                            <h3 class="text-sm font-bold text-slate-900">Judul Buku {{ $i }}</h3>
                                            <p class="text-xs text-slate-600">Penulis {{ $i }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <a href="#" class="text-sm text-sky-600 hover:underline">Lihat Detail</a>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                </div>
            </div>
        </div>
@endsection