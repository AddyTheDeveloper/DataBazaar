@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="darkMode" :class="{ 'dark': dark }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="DataBazaar — Explore, analyze, and share market data.">
        <title>{{ $title ? $title . ' — ' : '' }}{{ config('app.name', 'DataBazaar') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white dark:bg-slate-950">
        <div class="min-h-screen flex flex-col transition-colors duration-300">

            {{-- Navbar --}}
            <nav x-data="{ mobileOpen: false }" class="sticky top-0 z-50 border-b border-slate-200/60 dark:border-slate-800 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl backdrop-saturate-150">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <div class="flex items-center gap-8">
                            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-primary-600 to-accent-500 flex items-center justify-center shadow-sm shadow-primary-600/20 group-hover:shadow-md group-hover:shadow-primary-600/30 transition-shadow duration-300">
                                    <svg class="w-4.5 h-4.5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                </div>
                                <span class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">DataBazaar</span>
                            </a>
                            <div class="hidden sm:flex items-center gap-1">
                                <a href="{{ route('home') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('home') ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-500/10' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">Home</a>
                                <a href="{{ route('public.explore') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('public.explore') ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-500/10' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">Explore</a>
                            </div>
                        </div>
                        <div class="hidden sm:flex items-center gap-3">
                            <button onclick="document.querySelector('[x-data=\'darkMode\']').__x.$data.toggle()"
                                    class="w-9 h-9 rounded-xl flex items-center justify-center text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-200">
                                <svg class="w-[18px] h-[18px] dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                                <svg class="w-[18px] h-[18px] hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            </button>
                            @auth
                                <a href="{{ route('dashboard') }}" class="btn-primary btn-sm">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">Sign In</a>
                                <a href="{{ route('register') }}" class="btn-primary btn-sm">Get Started</a>
                            @endauth
                        </div>
                        <button @click="mobileOpen = !mobileOpen" class="sm:hidden w-9 h-9 rounded-xl flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            <svg class="w-5 h-5" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path :class="{'hidden': mobileOpen}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/><path :class="{'hidden': !mobileOpen}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
                <div :class="{'block': mobileOpen, 'hidden': !mobileOpen}" class="hidden sm:hidden border-t border-slate-200/60 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-3 space-y-1">
                    <a href="{{ route('home') }}" class="block px-3 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">Home</a>
                    <a href="{{ route('public.explore') }}" class="block px-3 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">Explore</a>
                    @guest<a href="{{ route('login') }}" class="block px-3 py-2 text-sm font-medium text-primary-600 rounded-lg hover:bg-primary-50">Sign In</a>@endguest
                </div>
            </nav>

            <main class="flex-1 page-enter">{{ $slot }}</main>

            {{-- Footer --}}
            <footer class="border-t border-slate-200/60 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 mt-auto">
                <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                        <div class="md:col-span-2">
                            <div class="flex items-center gap-2.5 mb-4">
                                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-primary-600 to-accent-500 flex items-center justify-center">
                                    <svg class="w-4.5 h-4.5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                </div>
                                <span class="text-lg font-bold text-slate-900 dark:text-white">DataBazaar</span>
                            </div>
                            <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed max-w-sm">Open market intelligence platform. Submit, explore, and analyze price data across India.</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-4">Platform</h4>
                            <ul class="space-y-2.5">
                                <li><a href="{{ route('home') }}" class="text-sm text-slate-600 dark:text-slate-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Home</a></li>
                                <li><a href="{{ route('public.explore') }}" class="text-sm text-slate-600 dark:text-slate-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Explore Data</a></li>
                                <li><a href="{{ route('register') }}" class="text-sm text-slate-600 dark:text-slate-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Create Account</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-4">Resources</h4>
                            <ul class="space-y-2.5">
                                <li><a href="{{ route('login') }}" class="text-sm text-slate-600 dark:text-slate-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Sign In</a></li>
                                <li><span class="text-sm text-slate-400 dark:text-slate-500">REST API</span></li>
                                <li><span class="text-sm text-slate-400 dark:text-slate-500">CSV Export</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="mt-12 pt-8 border-t border-slate-200/60 dark:border-slate-800">
                        <p class="text-center text-xs text-slate-400 dark:text-slate-500">© {{ date('Y') }} DataBazaar · Built with Laravel</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
