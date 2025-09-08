<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku - PANDORA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, nav, .btn { font-family: 'Poppins', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100">

    {{-- Navbar --}}
   <!-- Navbar -->
    <nav class="bg-white shadow-md px-6 py-4 flex justify-between items-center relative z-50" x-data="{ mobileOpen:false }">
        <!-- Left: Logo -->
        <div class="text-2xl font-bold text-[#3A6D8C]">PANDORA</div>

        <!-- Middle: Menu (desktop only) -->
        <div class="hidden md:flex space-x-6">
            <a href="/" class="text-gray-700 hover:text-[#3A6D8C]">Beranda</a>
            <a href="/katalog" class="text-gray-700 hover:text-[#3A6D8C]">Katalog</a>
            <a href="/tentang" class="text-gray-700 hover:text-[#3A6D8C]">Tentang</a>
        </div>

        <!-- Right: Auth + Burger -->
        <div class="flex items-center space-x-4">
            @guest
                <!-- Login (desktop) -->
                <a href="/login" class="hidden md:block text-[#E9B44C] font-medium hover:underline">Login</a>
            @else
                <!-- Avatar + Dropdown (desktop) -->
                <div x-data="{ open: false }" class="hidden md:block relative">
                    <button @click="open = !open" class="flex items-center focus:outline-none">
                        <img src="{{ Auth::user()->profile_picture ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" 
                            alt="Profile" class="w-10 h-10 rounded-full border-2 border-[#3A6D8C]">
                    </button>
                    <div x-cloak x-show="open" @click.outside="open = false"
                        x-transition
                        class="absolute right-0 mt-2 w-40 bg-white shadow-lg rounded-lg py-2 z-50">
                        <a href="/dashboard" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                        <a href="/profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profil</a>
                        <form action="/logout" method="POST">@csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            @endguest

            <!-- Burger (mobile) -->
            <button type="button" class="md:hidden text-gray-700" @click="mobileOpen=!mobileOpen" aria-label="Toggle menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Overlay (mobile) -->
        <div x-cloak x-show="mobileOpen" @click="mobileOpen=false"
            class="fixed inset-0 bg-black/30 md:hidden z-40"></div>

        <!-- Mobile Menu -->
        <div x-cloak x-show="mobileOpen" x-transition.origin.top.right
            class="md:hidden absolute top-full inset-x-0 bg-white border-t shadow-lg z-50">
            <div class="px-6 py-4 space-y-3">
                <a href="/" class="block px-2 py-2 rounded hover:bg-gray-100">Beranda</a>
                <a href="/katalog" class="block px-2 py-2 rounded hover:bg-gray-100">Katalog</a>
                <a href="/tentang" class="block px-2 py-2 rounded hover:bg-gray-100">Tentang</a>
                <div class="border-t my-2"></div>

                @guest
                    <a href="/login" class="block px-2 py-2 rounded bg-[#3A6D8C] text-white text-center hover:bg-[#2C546C]">
                        Login
                    </a>
                @else
                    <div class="flex items-center space-x-3 px-2 py-2">
                        <img src="{{ Auth::user()->profile_picture ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}"
                            alt="Profile" class="w-10 h-10 rounded-full border-2 border-[#3A6D8C]">
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                            <a href="/dashboard" class="text-sm text-[#3A6D8C] hover:underline">Dashboard</a>
                        </div>
                    </div>
                    <a href="/profile" class="block px-2 py-2 rounded hover:bg-gray-100">Profil</a>
                    <form action="/logout" method="POST" class="px-2">@csrf
                        <button type="submit" class="w-full px-3 py-2 rounded hover:bg-gray-100 text-left">Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Header -->
    <section class="bg-white shadow-sm py-8 text-center">
        <h1 class="text-3xl font-bold text-[#3A6D8C]">Judul Buku</h1>
        <p class="text-gray-600">Oleh Penulis Buku</p>
    </section>

    <!-- Detail Buku -->
    <section class="max-w-6xl mx-auto px-6 py-12 grid md:grid-cols-3 gap-10" x-data="{ openCitation: false }">
        <!-- Cover -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="h-80 bg-gray-200 flex items-center justify-center">
                <span class="text-gray-400">Cover Buku</span>
            </div>
        </div>

        <!-- Info Buku -->
        <div class="md:col-span-2 space-y-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Judul Buku</h2>
                <p class="text-gray-600">Penulis: <span class="font-medium">Nama Penulis</span></p>
                <p class="text-gray-600">Tahun Terbit: <span class="font-medium">2024</span></p>
                <p class="text-gray-600">Kategori: <span class="font-medium">Sejarah</span></p>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Ringkasan</h3>
                <p class="text-gray-700 leading-relaxed">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.  
                    Buku ini membahas tentang ... (isi ringkasan singkat).  
                    Dengan gaya bahasa yang ringan, buku ini cocok untuk pembaca umum maupun pelajar.
                </p>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex flex-wrap gap-4">
                <a href="/read/1"
                    class="bg-[#3A6D8C] text-white px-6 py-3 rounded-lg font-medium hover:bg-[#2C546C]">
                    📖 Baca Sekarang
                </a>
                <a href="/download/1"
                    class="bg-[#E9B44C] text-gray-900 px-6 py-3 rounded-lg font-medium hover:bg-[#D49C3D]">
                    ⬇️ Unduh PDF
                </a>
            </div>

            <!-- Tombol Kutipan -->
            <button @click="openCitation = true"
                class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg font-medium hover:bg-gray-300">
                📑 Lihat Kutipan
            </button>
        </div>

        <!-- Modal Kutipan -->
        <div x-cloak 
            x-show="openCitation" 
            x-transition.opacity.duration.300ms
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            
            <div @click.away="openCitation = false" 
                x-transition.scale.duration.300ms
                class="bg-white rounded-xl shadow-lg w-96 p-6 relative">
                
                <button @click="openCitation = false"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                    ✖
                </button>

                <h3 class="text-lg font-semibold text-gray-800 mb-4">Kutipan Otomatis</h3>

                <div class="space-y-4 text-sm">
                    <div>
                        <h4 class="font-medium text-gray-700">APA</h4>
                        <p class="bg-gray-100 border rounded p-2">
                            Penulis, N. (2024). <i>Judul Buku</i>. PANDORA Digital Library.
                        </p>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-700">MLA</h4>
                        <p class="bg-gray-100 border rounded p-2">
                            Penulis, Nama. <i>Judul Buku</i>. PANDORA Digital Library, 2024.
                        </p>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-700">Chicago</h4>
                        <p class="bg-gray-100 border rounded p-2">
                            Penulis, Nama. <i>Judul Buku</i>. PANDORA Digital Library, 2024.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Rekomendasi Buku -->
    <section class="max-w-6xl mx-auto px-6 pb-12">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Rekomendasi Buku Lain</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @for ($i = 1; $i <= 4; $i++)
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition overflow-hidden">
                <div class="h-40 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-400">Cover</span>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800 truncate">Judul {{$i}}</h3>
                    <p class="text-sm text-gray-600">Penulis {{$i}}</p>
                    <a href="/detail/{{$i}}"
                        class="mt-3 inline-block bg-[#3A6D8C] text-white px-4 py-2 rounded-lg text-sm hover:bg-[#2C546C]">
                        Detail
                    </a>
                </div>
            </div>
            @endfor
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#3A6D8C] text-white mt-auto">
        <div class="max-w-6xl mx-auto px-6 py-8 grid md:grid-cols-3 gap-6">
            <div>
                <h3 class="text-lg font-semibold mb-2">PANDORA</h3>
                <p class="text-sm text-gray-200">
                    Perpustakaan Digital Domain Publik Ramah Pengguna.  
                    Akses bacaan gratis, legal, dan mudah untuk semua.
                </p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-2">Navigasi</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="/" class="hover:underline">Beranda</a></li>
                    <li><a href="/katalog" class="hover:underline">Katalog</a></li>
                    <li><a href="/tentang" class="hover:underline">Tentang</a></li>
                    <li><a href="/login" class="hover:underline">Login</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-2">Kontak</h3>
                <p class="text-sm text-gray-200">Email: support@pandora.id</p>
                <p class="text-sm text-gray-200">Jl. Raya Semarang – Demak, Jawa Tengah</p>
            </div>
        </div>
        <div class="bg-[#2C546C] text-center text-sm py-3">
            © {{ date('Y') }} PANDORA. Semua Hak Cipta Bebas (Domain Publik).
        </div>
    </footer>

</body>
</html>