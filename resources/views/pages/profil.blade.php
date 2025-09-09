@extends('layouts.app')
@section('content')
    <x-navbar />
        <!-- Main Content -->
        <main class="py-4 sm:py-6 lg:py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Mobile Profile Header -->
                <div class="lg:hidden mb-6">
                    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
                        <div class="flex items-center gap-4">
                            <img src="{{ Auth::user()->profile_picture ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->first_name).'&background=0EA5E9&color=ffffff&size=80' }}" 
                                alt="Profile Picture" class="w-16 h-16 rounded-full border-4 border-sky-200">
                            <div class="flex-1">
                                <h2 class="heading text-lg font-semibold text-slate-900">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</h2>
                                <p class="text-sm text-slate-500">{{ Auth::user()->username ?? 'username' }}</p>
                            </div>
                            <form action="/logout" method="POST">
                                @csrf
                                <button type="submit" class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 transition-colors text-sm">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-8">
                    <!-- Sidebar -->
                    <aside class="lg:col-span-1">
                        <!-- Desktop Sidebar -->
                        <div class="hidden lg:block bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6 sticky top-24">
                            <!-- Profile Header -->
                            <div class="text-center mb-6">
                                <img src="{{ Auth::user()->profile_picture ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->first_name).'&background=0EA5E9&color=ffffff&size=120' }}" 
                                    alt="Profile Picture" class="w-20 h-20 mx-auto rounded-full border-4 border-sky-200 mb-4">
                                <h2 class="heading text-lg font-semibold text-slate-900">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</h2>
                                <p class="text-sm text-slate-500 mt-1">{{ Auth::user()->username ?? 'username' }}</p>
                            </div>

                            <!-- Logout Button -->
                            <form action="/logout" method="POST" class="mb-6">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 transition-colors">
                                    Logout
                                </button>
                            </form>

                            <!-- Navigation Menu -->
                            <nav class="space-y-2">
                                <a href="/profile" class="flex items-center gap-3 px-3 py-2 rounded-lg bg-sky-50 text-sky-700 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Profile Saya
                                </a>
                                <a href="/profile/settings" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50 text-slate-600 hover:text-sky-700 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    Pengaturan Akun
                                </a>
                                <a href="/profile/history" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50 text-slate-600 hover:text-sky-700 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Riwayat
                                </a>
                            </nav>
                        </div>

                        <!-- Mobile Navigation Tabs -->
                        <div class="lg:hidden bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-4 mb-6">
                            <nav class="flex space-x-1">
                                <a href="/profile" class="flex-1 flex items-center justify-center gap-2 px-3 py-2 rounded-lg bg-sky-50 text-sky-700 font-medium text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span class="hidden xs:inline">Profile</span>
                                </a>
                                <a href="/profile/settings" class="flex-1 flex items-center justify-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-50 text-slate-600 hover:text-sky-700 transition-colors text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="hidden xs:inline">Settings</span>
                                </a>
                                <a href="/profile/history" class="flex-1 flex items-center justify-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-50 text-slate-600 hover:text-sky-700 transition-colors text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="hidden xs:inline">History</span>
                                </a>
                            </nav>
                        </div>
                    </aside>

                    <!-- Main Content -->
                    <div class="lg:col-span-3">
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6 sm:p-8">
                            <!-- Header -->
                            <div class="mb-8">
                                <h1 class="heading text-2xl sm:text-3xl font-bold text-slate-900">Profile Saya</h1>
                                <p class="text-slate-600 mt-2">Kelola informasi profil dan pengaturan akun Anda.</p>
                            </div>

                            <!-- Profile Form -->
                            <form action="/profile" method="POST" class="space-y-6 sm:space-y-8">
                                @csrf
                                @method('PUT')
                                
                                <!-- Profile Picture & Name Section -->
                                <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 items-start">
                                    <!-- Profile Picture -->
                                    <div class="flex-shrink-0 mx-auto sm:mx-0">
                                        <img src="{{ Auth::user()->profile_picture ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->first_name).'&background=0EA5E9&color=ffffff&size=120' }}" 
                                            alt="Profile Picture" class="w-20 h-20 sm:w-24 sm:h-24 rounded-full border-4 border-sky-200">
                                        <button type="button" class="mt-3 text-sm text-sky-600 hover:text-sky-700 font-medium block mx-auto sm:mx-0">
                                            Ubah Foto
                                        </button>
                                    </div>

                                    <!-- Name Fields -->
                                    <div class="flex-1 w-full grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label for="first_name" class="block text-sm font-medium text-slate-700 mb-2">Nama Depan</label>
                                            <input type="text" id="first_name" name="first_name" 
                                                value="{{ Auth::user()->first_name }}"
                                                class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 focus:outline-none transition-colors text-sm sm:text-base"
                                                placeholder="Masukkan nama depan">
                                        </div>
                                        <div>
                                            <label for="last_name" class="block text-sm font-medium text-slate-700 mb-2">Nama Belakang</label>
                                            <input type="text" id="last_name" name="last_name" 
                                                value="{{ Auth::user()->last_name }}"
                                                class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 focus:outline-none transition-colors text-sm sm:text-base"
                                                placeholder="Masukkan nama belakang">
                                        </div>
                                    </div>
                                </div>

                                <!-- Bio Section -->
                                <div>
                                    <label for="bio" class="block text-sm font-medium text-slate-700 mb-2">Bio</label>
                                    <textarea id="bio" name="bio" rows="4" 
                                        class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 focus:outline-none transition-colors resize-none text-sm sm:text-base"
                                        placeholder="Ceritakan sedikit tentang diri Anda...">{{ Auth::user()->bio }}</textarea>
                                </div>

                                <!-- Save Button -->
                                <div class="flex justify-center sm:justify-end">
                                    <button type="submit" 
                                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 rounded-xl bg-gradient-to-r from-sky-600 to-cyan-600 text-white font-semibold hover:from-sky-700 hover:to-cyan-700 transition-all duration-200 shadow-lg hover:shadow-xl text-sm sm:text-base">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    <x-footer />
@endsection