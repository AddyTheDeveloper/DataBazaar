<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="darkMode" :class="{ 'dark': dark }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="DataBazaar — Market Databank Generation and Sharing Platform">
        <title>{{ isset($title) ? $title . ' — ' : '' }}{{ config('app.name', 'DataBazaar') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50 dark:bg-slate-950">
        <div class="min-h-screen flex flex-col transition-colors duration-300">
            @include('layouts.navigation')

            {{-- Toast Notifications --}}
            @if(session('success'))
            <div x-data="toast" x-show="show" x-cloak
                 x-transition:enter="transition ease-out duration-400"
                 x-transition:enter-start="opacity-0 translate-x-8"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 translate-x-8"
                 class="fixed top-20 right-6 z-[60] max-w-sm w-full">
                <div class="bg-white dark:bg-slate-800 border border-emerald-200 dark:border-emerald-500/20 rounded-2xl shadow-soft-lg p-4 flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-500/10 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900 dark:text-white">Success</p>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-0.5">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors p-0.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div x-data="toast" x-show="show" x-cloak
                 x-transition:enter="transition ease-out duration-400"
                 x-transition:enter-start="opacity-0 translate-x-8"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 translate-x-8"
                 class="fixed top-20 right-6 z-[60] max-w-sm w-full">
                <div class="bg-white dark:bg-slate-800 border border-red-200 dark:border-red-500/20 rounded-2xl shadow-soft-lg p-4 flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-red-100 dark:bg-red-500/10 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.072 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900 dark:text-white">Error</p>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-0.5">{{ session('error') }}</p>
                    </div>
                    <button @click="show = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors p-0.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
            </div>
            @endif

            @if(session('share_url'))
            <div x-data="{ show: true, copied: false }" x-show="show" x-cloak class="fixed top-20 right-6 z-[60] max-w-md w-full">
                <div class="bg-white dark:bg-slate-800 border border-primary-200 dark:border-primary-500/20 rounded-2xl shadow-soft-lg p-4">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-6 h-6 rounded-full bg-primary-100 dark:bg-primary-500/10 flex items-center justify-center"><svg class="w-3.5 h-3.5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg></div>
                        <p class="text-sm font-semibold text-slate-900 dark:text-white">Share Link Generated</p>
                        <button @click="show = false" class="ml-auto text-slate-400 hover:text-slate-600 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="text" value="{{ session('share_url') }}" id="shareUrl" readonly class="flex-1 text-xs bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg px-3 py-2 border-0 focus:ring-0 font-mono">
                        <button @click="navigator.clipboard.writeText(document.getElementById('shareUrl').value); copied = true; setTimeout(() => copied = false, 2000)"
                                class="btn-primary btn-sm whitespace-nowrap">
                            <span x-show="!copied">Copy</span>
                            <span x-show="copied" x-cloak>Copied!</span>
                        </button>
                    </div>
                </div>
            </div>
            @endif

            {{-- Page Header --}}
            @isset($header)
                <header class="border-b border-slate-200/60 dark:border-slate-800 bg-white/60 dark:bg-slate-900/60 backdrop-blur-xl">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- Page Content --}}
            <main class="flex-1 page-enter">
                {{ $slot }}
            </main>

            {{-- Footer --}}
            <footer class="border-t border-slate-200/60 dark:border-slate-800 mt-auto">
                <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-primary-600 to-accent-500 flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">DataBazaar</span>
                        </div>
                        <p class="text-xs text-slate-400 dark:text-slate-500">© {{ date('Y') }} DataBazaar. All rights reserved.</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
