<header x-data="{ mobileOpen:false, userMenu:false }" class="sticky top-0 w-full z-50 backdrop-blur bg-white/80 border-b border-slate-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-16 flex items-center justify-between">
            <!-- Brand -->
            <div class="flex items-center gap-4">
                @if(request()->routeIs('login') || request()->routeIs('register'))
                    <!-- Tombol kembali ke beranda (hanya muncul di login/register) -->
                    <a href="/" class="text-sm text-slate-600 hover:text-sky-700">← Kembali ke Beranda</a>
                @else
                    <!-- Logo normal -->
                    <a href="/" class="flex items-center gap-2">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-sky-500 to-cyan-600 grid place-items-center text-white font-bold">P</div>
                        <span class="text-xl font-bold text-slate-900">PANDORA</span>
                    </a>
                @endif
            </div>

            <!-- Nav menu (desktop) -->
            @if(!request()->routeIs('welcome') && !request()->routeIs('login') && !request()->routeIs('register'))
                <nav class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="hover:text-sky-700">Beranda</a>
                    <a href="{{ route('katalog') }}" class="hover:text-sky-700">Katalog</a>
                    <a href="{{ route('tentang') }}" class="hover:text-sky-700">Tentang</a>
                </nav>
            @endif

            <!-- Right side -->
            <div class="flex items-center gap-3">
                {{-- Jika halaman welcome --}}
                @if(request()->routeIs('welcome'))
                    @auth
                        <!-- User sudah login -->
                        <a href="{{ route('home') }}" class="px-4 py-2 text-sm font-medium rounded-md text-white bg-sky-600 hover:bg-sky-700 shadow-sm">
                            Beranda
                        </a>
                    @else
                        <!-- User belum login -->
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium rounded-md text-white bg-sky-600 hover:bg-sky-700 shadow-sm">
                            Masuk
                        </a>
                    @endauth
                @else
                    {{-- Halaman selain welcome --}}
                    @auth
                        <!-- Profile dropdown -->
                        <div class="hidden md:block relative" x-data="{ open:false }">
                            <button @click="open=!open" class="flex items-center gap-2">
                                <img src="{{ 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=0EA5E9&color=ffffff' }}" 
                                    alt="Avatar" class="w-10 h-10 rounded-full border border-sky-200">
                            </button>
                            <div x-cloak x-show="open" @click.outside="open=false" x-transition
                                class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg ring-1 ring-slate-200 p-1">
                                <div class="px-3 py-2 text-sm text-slate-600">
                                    Halo, <span class="font-medium text-slate-800">{{ Auth::user()->name }}</span>
                                </div>
                                    <a href="{{ route('profile') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-50">Pengaturan Profil</a>
                                @if (Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-50">Dashboard Admin</a>
                                @endif
                                <form action="/logout" method="POST" class="mt-1">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-3 py-2 rounded-lg hover:bg-slate-50 text-red-600">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth

                    @if (!request()->routeIs('login') && !request()->routeIs('register'))
                        <!-- Mobile menu button -->
                        <button @click="mobileOpen=!mobileOpen" class="md:hidden p-2 rounded-lg hover:bg-slate-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <!-- Mobile Drawer (selain welcome) -->
    @if(!request()->routeIs('welcome') && !request()->routeIs('login') && !request()->routeIs('register'))
        <div x-cloak x-show="mobileOpen" x-transition class="md:hidden border-t border-slate-200 bg-white">
            <div class="px-4 py-4 space-y-2">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-50">Beranda</a>
                <a href="{{ route('katalog') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-50">Katalog</a>
                <a href="{{ route('tentang') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-50">Tentang</a>
                <div class="border-t my-2"></div>
                @auth
                    <div class="flex items-center gap-3 px-1 py-2">
                        <img src="{{ 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=0EA5E9&color=ffffff' }}" 
                            alt="Avatar" class="w-10 h-10 rounded-full border border-sky-200">
                        <div>
                            <div class="text-sm font-medium text-slate-800">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-slate-500">{{ ucfirst(Auth::user()->role) }}</div>
                        </div>
                    </div>
                    <a href="{{ route('profile') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-50">Pengaturan Profil</a>
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-50">Dashboard Admin</a>                        
                    @endif
                    <form action="/logout" method="POST" class="pt-1">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 rounded-lg hover:bg-slate-50 text-red-600">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    @endif
</header>