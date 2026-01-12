<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Dashboard')</title>

    <style>[x-cloak]{display:none!important;}</style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('js/indonesia-location.js') }}"></script>
</head>
<body class="bg-slate-50 h-screen overflow-hidden">
    <div class="drawer lg:drawer-open h-screen">
        <input id="my-drawer" type="checkbox" class="drawer-toggle" />

        <div class="drawer-content flex flex-col h-screen">
            <!-- Navbar -->
            <div class="w-full navbar bg-white/90 backdrop-blur shadow-sm border-b border-slate-200 sticky top-0 z-50">
                <div class="flex-none lg:hidden">
                    <label for="my-drawer" aria-label="open sidebar" class="btn btn-square btn-ghost text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </label>
                </div>
                <div class="flex-1 px-2 mx-2"></div>
                <div class="flex-none">
                    <div class="mr-4 md:mr-8 flex items-center gap-2">
                        <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="flex items-center gap-2">
                            <div class="btn btn-ghost btn-circle avatar placeholder">
                                <div class="bg-blue-600 text-white rounded-full w-10">
                                    <span class="text-sm font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="hidden sm:flex flex-col items-start leading-tight">
                                <p class="text-sm font-semibold text-slate-900">{{ Auth::user()->email }}</p>
                                <span class="text-xs font-medium text-slate-500">{{ ucfirst(str_replace('_',' ', Auth::user()->role)) }}</span>
                            </div>
                        </div>
                        <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow-lg bg-white rounded-lg w-56 border border-slate-100">
                            <li class="menu-title px-4 py-2">
                                <span class="text-slate-900 font-semibold">{{ Auth::user()->name }}</span>
                                <span class="text-xs text-slate-500">{{ Auth::user()->email }}</span>
                            </li>
                            <div class="divider my-1"></div>
                            <li>
                                <a href="{{ route('home') }}" class="text-slate-700 hover:bg-sky-50 hover:text-sky-700 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                    </svg>
                                    Beranda
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-red-600 hover:bg-red-50 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                                    </svg>
                                    Logout
                                </a>
                            </li>
                        </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page content -->
            <div class="p-4 lg:p-8 flex-1 overflow-y-auto">
                @if(session('success'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show" x-transition class="mb-4 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-900 shadow-sm">
                        <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.172 7.707 8.879a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <div class="flex-1 text-sm font-semibold">{{ session('success') }}</div>
                    </div>
                @endif

                @if(session('error'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2500)" x-show="show" x-transition class="mb-4 flex items-start gap-3 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-900 shadow-sm">
                        <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-rose-100 text-rose-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9 7a1 1 0 112 0v4a1 1 0 11-2 0V7zm1 8a1.25 1.25 0 110-2.5A1.25 1.25 0 0110 15z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <div class="flex-1 text-sm font-semibold">{{ session('error') }}</div>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>

        <div class="drawer-side z-40">
            <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
            <div class="w-80 h-screen overflow-y-auto bg-white text-slate-900 border-r border-slate-200 shadow-lg">
                <!-- Logo/Brand Section -->
                <div class="p-6 border-b border-slate-200">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('storage/tut-wuri-handayani-kemdikdasmen-masafidhan.svg') }}" alt="Tut Wuri Handayani" class="h-12 w-12 object-contain">
                        <div class="leading-tight">
                            <h2 class="text-[17px] font-semibold text-slate-900">{{ config('app.name', 'SIPM') }}</h2>
                        </div>
                    </div>
                </div>

                <!-- Menu Section -->
                <div class="p-4">
                    <p class="text-xs font-semibold text-slate-500 mb-3 px-2">Navigasi utama</p>
                    <ul class="flex flex-col gap-1 text-sm text-slate-700 font-semibold">
                        @yield('sidebar')
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</body>
</html>
