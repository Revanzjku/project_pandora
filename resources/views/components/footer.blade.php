<footer class="mt-8 border-t border-slate-200 bg-white">
    @auth
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
    @endauth
    <div class="bg-slate-50 text-center text-sm text-slate-600 py-4">© {{ date('Y') }} PANDORA. Domain Publik — Bebas Hak Cipta.</div>
</footer>