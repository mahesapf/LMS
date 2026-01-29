<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Sistem Informasi Penjaminan Mutu')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Indonesia Location Data - Load first -->
    <script src="{{ asset('js/indonesia-location.js') }}"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        html, body {
            overflow-x: hidden;
            position: relative;
            width: 100%;
            height: 100%;
        }
        body {
            overflow-y: auto;
            min-height: 100vh;
        }

        /* Only apply touch restrictions to auth pages */
        body.auth-page {
            overscroll-behavior: none;
            touch-action: pan-y;
            overflow: hidden;
        }

        /* Override Tailwind CSS for auth back button */
        .auth-card-header .btn-outline-secondary,
        .auth-card-header .btn-outline-secondary i,
        .auth-card-header .btn-outline-secondary .bi {
            color: #374151 !important;
        }

        .auth-card-header .btn-outline-secondary:hover,
        .auth-card-header .btn-outline-secondary:hover i,
        .auth-card-header .btn-outline-secondary:hover .bi {
            color: #1f2937 !important;
        }
    </style>
    @stack('styles')
</head>
<body @if(isset($hideNavbar) && $hideNavbar) class="auth-page" @endif class="flex flex-col min-h-screen">
    <div id="app" class="flex flex-col min-h-screen">
        @if (!isset($hideNavbar) || !$hideNavbar)
        <nav class="sticky top-0 z-40 border-b border-slate-200 bg-white/90 backdrop-blur" x-data="{ open: false }">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3">
                <div class="flex items-center gap-3">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/tut-wuri-handayani-kemdikdasmen-masafidhan.svg') }}" alt="Tut Wuri Handayani" class="h-10 w-10 object-contain">
                        <span class="text-base font-semibold text-slate-900">{{ config('app.name', 'SIPM') }}</span>
                    </a>
                </div>
                <div class="flex items-center gap-6">
                    <div class="hidden items-center gap-4 text-sm font-semibold text-slate-700 lg:flex">
                        <a href="{{ route('home') }}" class="hover:text-sky-700">Beranda</a>
                        <a href="{{ route('activities.index') }}" class="hover:text-sky-700">Kegiatan</a>
                        <a href="#" class="hover:text-sky-700">Panduan & FAQ</a>
                    </div>
                    <div class="hidden lg:flex items-center gap-2">
                        @guest
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Login</a>
                            @endif
                        @else
                            <div class="relative" x-data="{ dd: false }">
                                <button @click="dd = !dd" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                    <span class="hidden md:inline">{{ Auth::user()->name }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.189l3.71-3.96a.75.75 0 111.08 1.04l-4.25 4.53a.75.75 0 01-1.08 0l-4.25-4.53a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                                </button>
                                <div x-show="dd" x-cloak @click.away="dd=false" class="absolute right-0 mt-2 w-48 rounded-lg border border-slate-200 bg-white shadow-lg">
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Dashboard</a>
                                    <div class="border-t border-slate-100"></div>
                                    <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-50"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>
                    <button class="inline-flex items-center lg:hidden" @click="open = !open" aria-label="Toggle navigation">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
            <div x-show="open" x-cloak class="lg:hidden border-t border-slate-200 bg-white shadow-sm" x-transition>
                <div class="space-y-2 px-4 py-3 text-sm font-semibold text-slate-700">
                    <a href="{{ route('home') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-50">Beranda</a>
                    <a href="{{ route('activities.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-50">Kegiatan</a>
                    <a href="#" class="block rounded-lg px-3 py-2 hover:bg-slate-50">Panduan & FAQ</a>
                    @guest
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="block rounded-lg px-3 py-2 border border-slate-200 hover:bg-slate-50">Login</a>
                        @endif
                    @else
                        <a href="{{ route('dashboard') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-50">Dashboard</a>
                        <a href="{{ route('logout') }}" class="block rounded-lg px-3 py-2 text-rose-600 hover:bg-rose-50"
                           onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                            Logout
                        </a>
                        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @endguest
                </div>
            </div>
        </nav>
        @endif

        <main class="{{ isset($hideNavbar) && $hideNavbar ? '' : 'flex-1' }}">
            @yield('content')
        </main>
    </div>
</body>
</html>
