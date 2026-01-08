<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Learning Management System">

        <title>{{ config('app.name', 'LMS') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-50 font-sans antialiased">
        <div class="min-h-screen flex flex-col">
            <!-- Header Navigation -->
            <header class="border-b border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800">
                <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                    <!-- Logo -->
                    <div class="text-2xl font-bold text-sky-600 dark:text-sky-400">
                        LMS
                    </div>

                    <!-- Navigation Links -->
                    <div class="flex items-center gap-4">
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="px-4 py-2 rounded-lg text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors"
                            >
                                Dashboard
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button
                                    type="submit"
                                    class="px-4 py-2 rounded-lg bg-sky-600 text-white hover:bg-sky-700 transition-colors font-medium"
                                >
                                    Logout
                                </button>
                            </form>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="px-4 py-2 rounded-lg text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors"
                            >
                                Login
                            </a>
                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="px-4 py-2 rounded-lg bg-sky-600 text-white hover:bg-sky-700 transition-colors font-medium"
                                >
                                    Register
                                </a>
                            @endif
                        @endauth
                    </div>
                </nav>
            </header>

            <!-- Main Content -->
            <main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-12 lg:py-20">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Section -->
                    <div class="space-y-6">
                        <div class="space-y-3">
                            <h1 class="text-4xl lg:text-5xl font-bold text-slate-900 dark:text-slate-50 leading-tight">
                                Learning Management System
                            </h1>
                            <p class="text-xl text-slate-600 dark:text-slate-400">
                                Streamline your educational journey with our comprehensive platform for course management, assessment, and student tracking.
                            </p>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            @auth
                                <a
                                    href="{{ url('/dashboard') }}"
                                    class="inline-flex items-center justify-center px-6 py-3 rounded-lg bg-sky-600 text-white hover:bg-sky-700 transition-colors font-semibold shadow-lg hover:shadow-xl"
                                >
                                    Go to Dashboard
                                </a>
                            @else
                                <a
                                    href="{{ route('login') }}"
                                    class="inline-flex items-center justify-center px-6 py-3 rounded-lg bg-sky-600 text-white hover:bg-sky-700 transition-colors font-semibold shadow-lg hover:shadow-xl"
                                >
                                    Sign In
                                </a>
                                @if (Route::has('register'))
                                    <a
                                        href="{{ route('register') }}"
                                        class="inline-flex items-center justify-center px-6 py-3 rounded-lg border-2 border-sky-600 text-sky-600 dark:text-sky-400 dark:border-sky-400 hover:bg-sky-50 dark:hover:bg-slate-800 transition-colors font-semibold"
                                    >
                                        Create Account
                                    </a>
                                @endif
                            @endauth
                        </div>

                        <!-- Features List -->
                        <div class="pt-8 space-y-4">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-50">
                                Key Features
                            </h3>
                            <ul class="space-y-3 text-slate-700 dark:text-slate-300">
                                <li class="flex items-start gap-3">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center mt-0.5">
                                        <svg class="h-4 w-4 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                    <span>Course management and enrollment tracking</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center mt-0.5">
                                        <svg class="h-4 w-4 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                    <span>Assessment and grade management</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center mt-0.5">
                                        <svg class="h-4 w-4 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                    <span>Real-time progress tracking and reporting</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Right Section - Hero Image -->
                    <div class="relative">
                        <div class="aspect-square rounded-2xl bg-gradient-to-br from-sky-100 dark:from-sky-900 to-emerald-100 dark:to-emerald-900 p-8 flex items-center justify-center">
                            <!-- Placeholder for illustration -->
                            <div class="text-center">
                                <svg class="w-32 h-32 mx-auto text-sky-600 dark:text-sky-400 mb-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C6.228 6.253 2 10.537 2 15.75c0 5.213 4.228 9.5 10 9.5s10-4.287 10-9.5c0-5.213-4.228-9.497-10-9.497z"></path>
                                </svg>
                                <p class="text-slate-600 dark:text-slate-400 font-medium">
                                    Start learning today
                                </p>
                            </div>
                        </div>

                        <!-- Decorative shapes -->
                        <div class="absolute top-0 right-0 w-24 h-24 bg-sky-200 dark:bg-sky-800 rounded-full blur-3xl opacity-20 -z-10"></div>
                        <div class="absolute bottom-0 left-0 w-24 h-24 bg-emerald-200 dark:bg-emerald-800 rounded-full blur-3xl opacity-20 -z-10"></div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="border-t border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Column 1 -->
                        <div>
                            <h4 class="font-semibold text-slate-900 dark:text-slate-50 mb-4">
                                About LMS
                            </h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400">
                                A comprehensive learning management system designed to enhance educational experiences.
                            </p>
                        </div>

                        <!-- Column 2 -->
                        <div>
                            <h4 class="font-semibold text-slate-900 dark:text-slate-50 mb-4">
                                Quick Links
                            </h4>
                            <ul class="space-y-2 text-sm">
                                @auth
                                    <li>
                                        <a href="{{ url('/dashboard') }}" class="text-sky-600 dark:text-sky-400 hover:underline">
                                            Dashboard
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ route('login') }}" class="text-sky-600 dark:text-sky-400 hover:underline">
                                            Login
                                        </a>
                                    </li>
                                    @if (Route::has('register'))
                                        <li>
                                            <a href="{{ route('register') }}" class="text-sky-600 dark:text-sky-400 hover:underline">
                                                Register
                                            </a>
                                        </li>
                                    @endif
                                @endauth
                            </ul>
                        </div>

                        <!-- Column 3 -->
                        <div>
                            <h4 class="font-semibold text-slate-900 dark:text-slate-50 mb-4">
                                Support
                            </h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400">
                                Need help? Contact our support team for assistance.
                            </p>
                        </div>
                    </div>

                    <!-- Bottom Section -->
                    <div class="border-t border-slate-200 dark:border-slate-700 mt-8 pt-8">
                        <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-slate-600 dark:text-slate-400">
                            <p>&copy; {{ date('Y') }} Learning Management System. All rights reserved.</p>
                            <div class="flex gap-6">
                                <a href="#" class="hover:text-sky-600 dark:hover:text-sky-400 transition-colors">Privacy Policy</a>
                                <a href="#" class="hover:text-sky-600 dark:hover:text-sky-400 transition-colors">Terms of Service</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
