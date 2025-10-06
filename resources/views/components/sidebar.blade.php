<!-- Tombol Melayang untuk Membuka Sidebar -->
<button x-show="!sidebarOpen" @click="sidebarOpen = true" x-transition class="fixed bottom-4 left-4 z-50 w-12 h-12 bg-sky-600 text-white rounded-full shadow-lg hover:bg-sky-700 focus:outline-none">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
</button>

<!-- Admin Sidebar -->
<div x-show="sidebarOpen" x-transition class="hidden lg:block w-64 bg-white border-r border-slate-200 min-h-screen">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-slate-900">Admin</h3>
            <!-- Tombol untuk Menutup Sidebar -->
            <button @click="sidebarOpen = false" class="p-2 rounded-lg hover:bg-slate-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <nav class="space-y-2">
            <a href="/admin/dashboard" class="flex items-center gap-3 px-3 py-2 rounded-lg
           {{ request()->is('admin/dashboard') ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-sky-50 hover:text-sky-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                </svg>
                Dashboard
            </a>
            <a href="/admin/ebooks" class="flex items-center gap-3 px-3 py-2 rounded-lg 
            {{ Route::is('admin.ebooks.*') ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-sky-50 hover:text-sky-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Kelola Ebook
            </a>
            <a href="/admin/categories" class="flex items-center gap-3 px-3 py-2 rounded-lg
            {{ Route::is('admin.categories.*') ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-sky-50 hover:text-sky-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                </svg>
                Kelola Kategori
            </a>
            <a href="/admin/users" class="flex items-center gap-3 px-3 py-2 rounded-lg 
            {{ Route::is('admin.users.*') ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-sky-50 hover:text-sky-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
                Kelola Pengguna
            </a>
        </nav>
    </div>
</div>

<!-- Mobile Admin Sidebar -->
<div x-cloak x-show="sidebarOpen" x-transition class="lg:hidden fixed inset-0 z-40">
    <div class="fixed inset-0 bg-white/30 backdrop-blur-sm" @click="sidebarOpen=false"></div>
    <div class="fixed top-0 left-0 w-64 h-full bg-white shadow-lg">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-slate-900">Menu Admin</h3>
                <button @click="sidebarOpen=false" class="p-2 rounded-lg hover:bg-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <nav class="space-y-2">
                <a href="/admin/dashboard" class="flex items-center gap-3 px-3 py-2 rounded-lg 
                {{ request()->is('admin/dashboard') ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-sky-50 hover:text-sky-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                    Dashboard
                </a>
                <a href="/admin/ebooks" class="flex items-center gap-3 px-3 py-2 rounded-lg 
                {{ Route::is('admin.ebooks.*') ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-sky-50 hover:text-sky-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Kelola Ebook
                </a>
                <a href="/admin/categories" class="flex items-center gap-3 px-3 py-2 rounded-lg 
                {{ Route::is('admin.categories.*') ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-sky-50 hover:text-sky-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                    </svg>
                    Kelola Kategori
                </a>
                <a href="/admin/users" class="flex items-center gap-3 px-3 py-2 rounded-lg 
                {{ Route::is('admin.users.*') ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-sky-50 hover:text-sky-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>

                    Kelola Pengguna
                </a>
            </nav>
        </div>
    </div>
</div>