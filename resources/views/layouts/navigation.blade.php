<nav x-data="{ open: false }" class="sticky top-0 z-50 border-b border-white/50 dark:border-white/10 bg-white/70 dark:bg-slate-950/70 backdrop-blur-2xl backdrop-saturate-150 shadow-sm shadow-slate-900/[0.03]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo + Nav Links --}}
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-primary-600 to-accent-500 flex items-center justify-center shadow-sm shadow-primary-600/20 group-hover:shadow-md group-hover:shadow-primary-600/30 transition-shadow duration-300">
                        <svg class="w-4.5 h-4.5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <span class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">DataBazaar</span>
                </a>

                <div class="hidden sm:flex items-center gap-1">
                    @php
                        $navItems = [
                            ['route' => 'dashboard', 'label' => 'Dashboard', 'match' => 'dashboard'],
                            ['route' => 'market-data.index', 'label' => 'Explore', 'match' => 'market-data.*'],
                            ['route' => 'public.intelligence', 'label' => 'Intelligence', 'match' => 'public.intelligence*'],
                            ['route' => 'market-data.create', 'label' => 'Submit', 'match' => 'market-data.create'],
                            ['route' => 'bookmarks.index', 'label' => 'Bookmarks', 'match' => 'bookmarks.*'],
                        ];
                    @endphp

                    @foreach($navItems as $item)
                        <a href="{{ route($item['route']) }}"
                           class="relative px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200
                                  {{ request()->routeIs($item['match'])
                                      ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-500/10'
                                      : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                           class="relative px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200
                                  {{ request()->routeIs('admin.*')
                                      ? 'text-violet-600 dark:text-violet-400 bg-violet-50 dark:bg-violet-500/10'
                                      : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                            Admin
                        </a>
                    @endif
                </div>
            </div>

            {{-- Right Side --}}
            <div class="hidden sm:flex items-center gap-2">
                {{-- Dark Mode --}}
                <button @click="$store.darkMode.toggle()"
                        class="w-9 h-9 rounded-xl flex items-center justify-center text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-200">
                    <svg class="w-[18px] h-[18px]" x-show="!$store.darkMode.on" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    <svg class="w-[18px] h-[18px]" x-show="$store.darkMode.on" x-cloak fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </button>

                {{-- User Dropdown --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2.5 pl-3 pr-2 py-1.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 bg-white dark:bg-slate-800 transition-all duration-200 group">
                            <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white text-xs font-semibold shadow-inner-light">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 max-w-[100px] truncate">{{ Auth::user()->name }}</span>
                            @if(Auth::user()->isAdmin())
                                <span class="badge badge-admin !py-0 !px-1.5 !text-[9px]">Admin</span>
                            @endif
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                        <x-dropdown-link :href="route('home')">Public Site</x-dropdown-link>
                        <div class="border-t border-slate-100 dark:border-slate-700 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Sign Out</x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Mobile Hamburger --}}
            <button @click="open = !open" class="sm:hidden w-9 h-9 rounded-xl flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <svg class="w-5 h-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t border-slate-200/60 dark:border-slate-800 bg-white dark:bg-slate-900">
        <div class="px-4 py-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('market-data.index')" :active="request()->routeIs('market-data.*')">Explore</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('public.intelligence')" :active="request()->routeIs('public.intelligence')">Intelligence</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('market-data.create')">Submit</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('bookmarks.index')">Bookmarks</x-responsive-nav-link>
            @if(auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.dashboard')">Admin</x-responsive-nav-link>
            @endif
        </div>
        <div class="px-4 py-3 border-t border-slate-200 dark:border-slate-700">
            <div class="mb-3">
                <p class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ Auth::user()->name }}</p>
                <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
            </div>
            <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>
            <button @click="$store.darkMode.toggle()" class="block w-full text-left px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <span x-show="!$store.darkMode.on">🌙 Dark Mode</span>
                <span x-show="$store.darkMode.on" x-cloak>☀️ Light Mode</span>
            </button>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Sign Out</x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>
