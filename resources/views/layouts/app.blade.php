<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? '— Perpustakaan Digital Domain Publik' }} - PANDORA</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, nav, .heading { font-family: 'Poppins', sans-serif; }
        [x-cloak] { display: none !important; }
        @media (min-width: 475px) {
            .xs\:inline { display: inline !important; }
        }
    </style>
    @livewireStyles
</head>
    <body class="bg-gradient-to-b from-white to-slate-50 text-slate-800" @if(Route::is('admin.*')) 
            x-data="{ sidebarOpen: false }"
        @endif>

        @yield('content')

        @livewireScripts
        @stack('scripts')
    </body>
</html>