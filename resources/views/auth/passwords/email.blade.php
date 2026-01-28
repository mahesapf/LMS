<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ __('Lupa Password') }} - {{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
                @layer base{*,:after,:before,::backdrop{box-sizing:border-box;border:0 solid;margin:0;padding:0}}
                body{line-height:1.5;font-family:ui-sans-serif,system-ui,sans-serif}
                @layer utilities{
                    .flex{display:flex}
                    .flex-col{flex-direction:column}
                    .items-center{align-items:center}
                    .justify-center{justify-content:center}
                    .gap-6{gap:1.5rem}
                    .min-h-screen{min-height:100vh}
                    .p-6{padding:1.5rem}
                    .pt-8{padding-top:2rem}
                    .mb-4{margin-bottom:1rem}
                    .mb-6{margin-bottom:1.5rem}
                    .mb-8{margin-bottom:2rem}
                    .text-center{text-align:center}
                    .rounded-lg{border-radius:0.5rem}
                    .border{border-width:1px}
                    .border-gray-200{border-color:#e5e7eb}
                    .bg-white{background-color:#ffffff}
                    .bg-gradient-to-b{background-image:linear-gradient(to bottom, var(--tw-gradient-stops))}
                    .from-white{--tw-gradient-from:#ffffff}
                    .to-gray-50{--tw-gradient-to:#f9fafb}
                    .shadow-lg{box-shadow:0 10px 15px -3px rgba(0,0,0,.1)}
                    .dark\:bg-gray-900{background-color:#111827}
                    .dark\:border-gray-700{border-color:#374151}
                    .dark\:text-white{color:#ffffff}
                    .dark\:text-gray-300{color:#d1d5db}
                    .text-gray-600{color:#4b5563}
                    .text-gray-700{color:#374151}
                    .text-blue-600{color:#2563eb}
                    .hover\:text-blue-700:hover{color:#1d4ed8}
                    .font-semibold{font-weight:600}
                    .text-2xl{font-size:1.5rem;line-height:2rem}
                    .text-lg{font-size:1.125rem;line-height:1.75rem}
                    .text-sm{font-size:0.875rem;line-height:1.25rem}
                    .leading-relaxed{line-height:1.625}
                    .w-full{width:100%}
                    .max-w-2xl{max-width:42rem}
                    .mx-auto{margin-left:auto;margin-right:auto}
                    .py-12{padding-top:3rem;padding-bottom:3rem}
                    .px-8{padding-left:2rem;padding-right:2rem}
                }
            </style>
        @endif
    </head>
    <body class="bg-gradient-to-b from-white to-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300">
        <div class="flex flex-col items-center justify-center min-h-screen p-6">
            <div class="w-full max-w-2xl">
                <!-- Header -->
                <div class="mb-8 text-center pt-8">
                    <a href="{{ route('home') }}" class="inline-block mb-6">
                        <img src="{{ asset('storage/tut-wuri-handayani-kemdikdasmen-masafidhan.svg') }}" alt="Logo" class="h-12 w-auto">
                    </a>
                </div>

                <!-- Main Card -->
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg overflow-hidden">
                    <div class="py-12 px-8">
                        <!-- Lock Icon -->
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Title -->
                        <h1 class="text-2xl font-semibold text-center text-gray-900 dark:text-white mb-4">
                            {{ __('Lupa Password?') }}
                        </h1>

                        <!-- Description -->
                        <p class="text-center text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                            Untuk keamanan akun Anda, fitur reset password telah dinonaktifkan.
                        </p>

                        <!-- Contact Section -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 mb-8">
                            <h2 class="text-lg font-semibold text-center text-gray-900 dark:text-white mb-4">
                                {{ __('Hubungi Customer Service Kami') }}
                            </h2>
                            
                            <div class="space-y-3 text-sm">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span class="text-gray-600 dark:text-gray-300">
                                        <strong>{{ __('Telepon:') }}</strong> <span id="phone">+62 (belum tersedia)</span>
                                    </span>
                                </div>
                                
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-gray-600 dark:text-gray-300">
                                        <strong>{{ __('Email:') }}</strong> <span id="email">cs@example.com</span>
                                    </span>
                                </div>
                                
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-gray-600 dark:text-gray-300">
                                        <strong>{{ __('Jam Operasional:') }}</strong> <span id="hours">Senin - Jumat, 08:00 - 17:00</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Helpful Info -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 mb-8 text-sm text-gray-600 dark:text-gray-400">
                            <p class="leading-relaxed">
                                {{ __('Tim CS kami siap membantu Anda untuk mereset password dan mengatasi masalah lainnya. Hubungi kami melalui salah satu saluran komunikasi di atas.') }}
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-4 justify-center">
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                {{ __('Kembali ke Login') }}
                            </a>
                            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors font-medium text-sm">
                                {{ __('Beranda') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-8 text-sm text-gray-500 dark:text-gray-400">
                    <p>{{ config('app.name') }} - {{ date('Y') }}</p>
                </div>
            </div>
        </div>
    </body>
</html>
