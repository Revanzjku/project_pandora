<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang - PANDORA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, nav, .heading { font-family: 'Poppins', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gradient-to-b from-white to-slate-50 text-slate-800">

    <!-- Navbar -->
    <header x-data="{ mobileOpen:false, userMenu:false }" class="sticky top-0 w-full z-50 backdrop-blur bg-white/80 border-b border-slate-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-16 flex items-center justify-between">
                <!-- Brand -->
                <a href="/" class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-sky-500 to-cyan-600 grid place-items-center text-white font-bold">P</div>
                    <span class="text-xl font-bold text-slate-900">PANDORA</span>
                </a>

                <!-- Nav (desktop) -->
                <nav class="hidden md:flex items-center gap-8">
                    <a href="/" class="hover:text-sky-700">Beranda</a>
                    <a href="/katalog" class="hover:text-sky-700">Katalog</a>
                    <a href="/tentang" class="text-sky-700 font-medium">Tentang</a>
                </nav>

                <!-- Right (auth / cta) -->
                <div class="flex items-center gap-3">
                    @guest
                        <a href="/login" class="hidden md:inline-flex items-center px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50">Login</a>
                    @else
                        <div class="hidden md:block relative" x-data="{ open:false }">
                            <button @click="open=!open" class="flex items-center gap-2">
                                <img src="{{ Auth::user()->profile_picture ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=0EA5E9&color=ffffff' }}" alt="Avatar" class="w-10 h-10 rounded-full border border-sky-200">
                            </button>
                            <div x-cloak x-show="open" @click.outside="open=false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg ring-1 ring-slate-200 p-1">
                                <div class="px-3 py-2 text-sm text-slate-600">Halo, <span class="font-medium text-slate-800">{{ Auth::user()->name }}</span></div>
                                <a href="/dashboard" class="block px-3 py-2 rounded-lg hover:bg-slate-50">Dashboard</a>
                                <a href="/profile" class="block px-3 py-2 rounded-lg hover:bg-slate-50">Profil</a>
                                <form action="/logout" method="POST" class="mt-1">@csrf
                                    <button type="submit" class="w-full text-left px-3 py-2 rounded-lg hover:bg-slate-50 text-red-600">Logout</button>
                                </form>
                            </div>
                        </div>
                    @endguest

                    <!-- Burger -->
                    <button class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg hover:bg-slate-100" @click="mobileOpen=!mobileOpen" aria-label="Toggle menu">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer -->
        <div x-cloak x-show="mobileOpen" x-transition class="md:hidden border-t border-slate-200 bg-white">
            <div class="px-4 py-4 space-y-2">
                <a href="/" class="block px-3 py-2 rounded-lg hover:bg-slate-50">Beranda</a>
                <a href="/katalog" class="block px-3 py-2 rounded-lg hover:bg-slate-50">Katalog</a>
                <a href="/tentang" class="block px-3 py-2 rounded-lg bg-sky-50 text-sky-700">Tentang</a>
                <div class="border-t my-2"></div>
                @guest
                    <a href="/login" class="block px-3 py-2 rounded-lg bg-sky-600 text-white text-center hover:bg-sky-700">Login</a>
                @else
                    <div class="flex items-center gap-3 px-1 py-2">
                        <img src="{{ Auth::user()->profile_picture ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=0EA5E9&color=ffffff' }}" alt="Avatar" class="w-10 h-10 rounded-full border border-sky-200">
                        <div>
                            <div class="text-sm font-medium text-slate-800">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-slate-500">Pengguna</div>
                        </div>
                    </div>
                    <a href="/dashboard" class="block px-3 py-2 rounded-lg hover:bg-slate-50">Dashboard</a>
                    <a href="/profile" class="block px-3 py-2 rounded-lg hover:bg-slate-50">Profil</a>
                    <form action="/logout" method="POST" class="pt-1">@csrf
                        <button type="submit" class="w-full text-left px-3 py-2 rounded-lg hover:bg-slate-50 text-red-600">Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative overflow-hidden">
        <div aria-hidden="true" class="absolute inset-0 -z-10">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-200/40 blur-3xl rounded-full"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-sky-200/40 blur-3xl rounded-full"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="text-center">
                <h1 class="heading text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 leading-snug md:leading-snug lg:leading-normal xl:leading-relaxed max-w-2xl lg:max-w-3xl xl:max-w-4xl mx-auto">
                    Tentang PANDORA
                </h1>
                <p class="mt-4 text-slate-600 max-w-2xl mx-auto">
                    PANDORA adalah Perpustakaan Digital Domain Publik Ramah Pengguna yang menyediakan akses gratis dan legal ke berbagai koleksi e-book tanpa batas.
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-8 sm:py-10 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
            <!-- Visi & Misi -->
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="heading text-2xl sm:text-3xl font-bold text-slate-900 mb-6">Visi & Misi</h2>
                    <div class="space-y-4">
                        <div class="p-6 bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60">
                            <h3 class="heading text-lg font-semibold text-sky-700 mb-3">Visi</h3>
                            <p class="text-slate-600 leading-relaxed">
                                Menjadikan literasi digital lebih mudah diakses oleh semua orang, tanpa hambatan biaya maupun hak cipta.
                            </p>
                        </div>
                        <div class="p-6 bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60">
                            <h3 class="heading text-lg font-semibold text-sky-700 mb-3">Misi</h3>
                            <p class="text-slate-600 leading-relaxed">
                                Mengumpulkan dan menyediakan koleksi e-book domain publik yang beragam, sekaligus membangun platform yang ramah, sederhana, dan nyaman digunakan.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="aspect-[4/3] w-full rounded-2xl bg-gradient-to-br from-sky-100 to-cyan-100 ring-1 ring-slate-200 p-8">
                        <img src="{{ asset('pustaka_digital.jpeg') }}" alt="Ilustrasi Pustaka Digital" class="h-full w-full rounded-xl object-cover">
                    </div>
                </div>
            </div>

            <!-- Fitur Utama -->
            <div>
                <div class="text-center mb-12">
                    <h2 class="heading text-2xl sm:text-3xl font-bold text-slate-900 mb-4">Fitur Utama</h2>
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

            <!-- Tentang Proyek -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-8 sm:p-12 text-center">
                <h2 class="heading text-2xl sm:text-3xl font-bold text-slate-900 mb-6">Tentang Proyek</h2>
                <p class="text-slate-600 leading-relaxed max-w-3xl mx-auto text-lg">
                    PANDORA dikembangkan sebagai bagian dari proyek Ujian Akhir dengan tujuan memberikan solusi nyata dalam mendukung literasi digital di Indonesia.  
                    Semua fitur dirancang agar pengguna dapat dengan mudah mengakses pengetahuan tanpa terbatas waktu dan tempat.
                </p>
                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    <span class="px-4 py-2 rounded-full text-sm bg-sky-50 text-sky-700 ring-1 ring-sky-100">Laravel Framework</span>
                    <span class="px-4 py-2 rounded-full text-sm bg-emerald-50 text-emerald-700 ring-1 ring-emerald-100">Tailwind CSS</span>
                    <span class="px-4 py-2 rounded-full text-sm bg-indigo-50 text-indigo-700 ring-1 ring-indigo-100">Alpine.js</span>
                    <span class="px-4 py-2 rounded-full text-sm bg-purple-50 text-purple-700 ring-1 ring-purple-100">MySQL Database</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="mt-8 border-t border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid sm:grid-cols-3 gap-8">
            <div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-sky-500 to-cyan-600 grid place-items-center text-white font-bold">P</div>
                    <span class="text-lg font-semibold">PANDORA</span>
                </div>
                <p class="mt-3 text-sm text-slate-600">PerpustakaAN Digital dOmain publik Ramah penggunA. Akses bacaan gratis, legal, untuk semua.</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-slate-900">Navigasi</h3>
                <ul class="mt-3 space-y-2 text-sm">
                    <li><a href="/" class="hover:text-sky-700">Beranda</a></li>
                    <li><a href="/katalog" class="hover:text-sky-700">Katalog</a></li>
                    <li><a href="/tentang" class="hover:text-sky-700">Tentang</a></li>
                    <li>@guest <a href="/login" class="hover:text-sky-700">Login</a> @else <a href="/dashboard" class="hover:text-sky-700">Dashboard</a> @endguest</li>
                </ul>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-slate-900">Kontak</h3>
                <ul class="mt-3 space-y-2 text-sm text-slate-600">
                    <li>Email: support@pandora.id</li>
                    <li>Jl. Raya Semarang – Demak, Jawa Tengah</li>
                </ul>
            </div>
        </div>
        <div class="bg-slate-50 text-center text-sm text-slate-600 py-4">© {{ date('Y') }} PANDORA. Domain Publik — Bebas Hak Cipta.</div>
    </footer>

</body>
</html>