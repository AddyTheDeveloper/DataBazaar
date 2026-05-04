<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="darkMode" :class="{ 'dark': dark }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'DataBazaar') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex bg-slate-50 dark:bg-slate-950">

            {{-- Left Panel: Branding --}}
            <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-slate-900">
                <div class="absolute inset-0 bg-gradient-to-br from-primary-600/90 via-primary-800/80 to-slate-900"></div>
                <div class="absolute inset-0 bg-grid opacity-10"></div>

                {{-- Floating Decorative Elements --}}
                <div class="absolute top-1/4 left-1/4 w-72 h-72 bg-primary-500/20 rounded-full blur-3xl animate-pulse-soft"></div>
                <div class="absolute bottom-1/4 right-1/4 w-56 h-56 bg-accent-500/15 rounded-full blur-3xl animate-pulse-soft" style="animation-delay: 1.5s"></div>

                <div class="relative z-10 flex flex-col justify-center px-12 xl:px-20">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-sm border border-white/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <span class="text-xl font-bold text-white">DataBazaar</span>
                    </div>

                    <h1 class="text-4xl xl:text-5xl font-bold text-white leading-tight mb-6">
                        Market intelligence,<br>
                        <span class="text-primary-300">simplified.</span>
                    </h1>
                    <p class="text-lg text-primary-100/70 leading-relaxed max-w-md">Submit, explore, and analyze market pricing data from across the country. Join thousands of contributors.</p>

                    <div class="mt-12 flex items-center gap-6">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-white">98+</p>
                            <p class="text-xs text-primary-200/60 mt-1">Data Entries</p>
                        </div>
                        <div class="w-px h-10 bg-white/10"></div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-white">35+</p>
                            <p class="text-xs text-primary-200/60 mt-1">Products</p>
                        </div>
                        <div class="w-px h-10 bg-white/10"></div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-white">10</p>
                            <p class="text-xs text-primary-200/60 mt-1">Cities</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Panel: Form --}}
            <div class="flex-1 flex flex-col items-center justify-center px-6 py-12">
                <div class="lg:hidden flex items-center gap-2.5 mb-10">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-primary-600 to-accent-500 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <span class="text-lg font-bold text-slate-900 dark:text-white">DataBazaar</span>
                </div>

                <div class="w-full max-w-[400px]">
                    {{ $slot }}
                </div>

                <p class="mt-12 text-xs text-slate-400 dark:text-slate-500">© {{ date('Y') }} DataBazaar</p>
            </div>
        </div>
    </body>
</html>
