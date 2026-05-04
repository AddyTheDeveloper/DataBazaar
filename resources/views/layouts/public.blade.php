<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="darkMode" :class="{ 'dark': dark }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="DataBazaar - Explore, analyze, and share market data. A modern platform for market intelligence.">

        <title>{{ isset($title) ? $title . ' — ' : '' }}{{ config('app.name', 'DataBazaar') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-50 dark:bg-gray-950 transition-colors duration-300">
            <!-- Public Navbar -->
            <nav class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-100 dark:border-gray-800 sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center space-x-8">
                            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                                <span class="text-2xl">📊</span>
                                <span class="text-xl font-bold gradient-text">DataBazaar</span>
                            </a>
                            <div class="hidden sm:flex items-center space-x-6">
                                <a href="{{ route('home') }}" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors {{ request()->routeIs('home') ? 'text-primary-600 dark:text-primary-400' : '' }}">Home</a>
                                <a href="{{ route('public.explore') }}" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors {{ request()->routeIs('public.explore') ? 'text-primary-600 dark:text-primary-400' : '' }}">Explore</a>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Dark Mode Toggle -->
                            <button @click="toggle()" class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                <svg x-show="!dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                                <svg x-show="dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            </button>

                            @auth
                                <a href="{{ route('dashboard') }}" class="btn-primary btn-sm">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary-600 transition-colors">Login</a>
                                <a href="{{ route('register') }}" class="btn-primary btn-sm">Sign Up Free</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="page-enter">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 mt-16">
                <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <div class="flex items-center space-x-2 mb-4">
                                <span class="text-2xl">📊</span>
                                <span class="text-xl font-bold gradient-text">DataBazaar</span>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Your gateway to market intelligence. Submit, explore, and share market data with the community.</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Quick Links</h3>
                            <ul class="space-y-2">
                                <li><a href="{{ route('home') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-primary-600">Home</a></li>
                                <li><a href="{{ route('public.explore') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-primary-600">Explore Data</a></li>
                                <li><a href="{{ route('register') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-primary-600">Join Free</a></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Platform</h3>
                            <ul class="space-y-2">
                                <li><a href="{{ route('login') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-primary-600">Login</a></li>
                                <li><span class="text-sm text-gray-500 dark:text-gray-400">API Access</span></li>
                                <li><span class="text-sm text-gray-500 dark:text-gray-400">CSV Export</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="mt-8 pt-8 border-t border-gray-100 dark:border-gray-800">
                        <p class="text-center text-sm text-gray-400 dark:text-gray-500">© {{ date('Y') }} DataBazaar. Market Databank Platform. Built with Laravel.</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
