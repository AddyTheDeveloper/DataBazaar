<x-public-layout title="Market Price Intelligence System">
    {{-- Header / Hero Section --}}
    <section class="relative overflow-hidden border-b border-white/60 dark:border-white/10">
        <div class="absolute inset-0 bg-[linear-gradient(180deg,#f8fafc_0%,#eef6ff_100%)] dark:bg-[linear-gradient(180deg,#020617_0%,#0f172a_100%)]"></div>
        <div class="absolute inset-0 bg-grid opacity-35 dark:opacity-15"></div>
        
        @if(!$selectedProduct)
            {{-- Giant beautiful hero for empty state --}}
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
                <p class="text-xs font-semibold uppercase tracking-wider text-primary-600 dark:text-primary-400">Market Price Intelligence System</p>
                <h1 class="mt-3 text-4xl sm:text-5xl font-extrabold text-slate-950 dark:text-white tracking-tight leading-tight">
                    National Price Analytics & <span class="bg-gradient-to-r from-primary-600 to-accent-500 bg-clip-text text-transparent">Trend Portals</span>
                </h1>
                <p class="mt-4 text-sm sm:text-base text-slate-600 dark:text-slate-300 max-w-2xl mx-auto">
                    Track agricultural and commodity prices across Indian cities/states. Analyze percentage hikes, compare regions, and visualize market fluctuations with interactive charts.
                </p>

                {{-- Autocomplete Search Input powered by Alpine.js --}}
                <div x-data="{ 
                    query: '', 
                    suggestions: [], 
                    open: false,
                    loading: false,
                    fetchSuggestions() {
                        if (this.query.length < 1) {
                            this.suggestions = [];
                            this.open = false;
                            return;
                        }
                        this.loading = true;
                        fetch('{{ route('api.intelligence.suggestions') }}?query=' + encodeURIComponent(this.query))
                            .then(res => res.json())
                            .then(data => {
                                this.suggestions = data;
                                this.open = data.length > 0;
                                this.loading = false;
                            })
                            .catch(() => {
                                this.loading = false;
                            });
                    },
                    selectSuggestion(item) {
                        window.location.href = '{{ route('public.intelligence') }}?product=' + encodeURIComponent(item);
                    }
                }" class="relative max-w-lg mx-auto mt-8 z-40">
                    <div class="flex items-center glass-card p-1.5 shadow-lg border border-slate-200/80 dark:border-slate-800/80 bg-white/80 dark:bg-slate-900/80">
                        <div class="pl-3 text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input 
                            type="text" 
                            x-model="query" 
                            @input.debounce.250ms="fetchSuggestions()" 
                            @keydown.escape="open = false"
                            @keydown.enter="if (query.length > 0) { 
                                const matched = suggestions.find(s => s.toLowerCase() === query.trim().toLowerCase()) || suggestions[0] || query;
                                selectSuggestion(matched);
                            }"
                            @click.away="open = false"
                            placeholder="Search product (e.g. Tomatoes, Basmati Rice, Onions...)" 
                            class="w-full bg-transparent border-0 ring-0 focus:ring-0 text-sm font-medium text-slate-900 dark:text-white placeholder-slate-400 pl-2.5 py-2.5"
                        />
                        <div x-show="loading" class="pr-3" x-cloak>
                            <svg class="animate-spin h-5 w-5 text-primary-500" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>

                    {{-- Autocomplete Dropdown list --}}
                    <div 
                        x-show="open" 
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute left-0 right-0 mt-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-xl overflow-hidden text-left z-50 max-h-60 overflow-y-auto" 
                        x-cloak
                    >
                        <template x-for="item in suggestions" :key="item">
                            <button 
                                @click="selectSuggestion(item)"
                                class="w-full text-left px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800/60 border-b border-slate-100 dark:border-slate-800/30 last:border-b-0 transition-colors flex items-center justify-between"
                            >
                                <span x-text="item"></span>
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </template>
                    </div>
                </div>

                {{-- Popular Products tags --}}
                <div class="mt-5 flex flex-wrap justify-center items-center gap-2">
                    <span class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Popular:</span>
                    @foreach(['Basmati Rice', 'Tomatoes', 'Onions', 'Potatoes', 'Apples'] as $pop)
                        <a href="{{ route('public.intelligence', ['product' => $pop]) }}" class="px-3 py-1 text-xs font-semibold rounded-full bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-primary-500 dark:hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-400 text-slate-600 dark:text-slate-400 transition-all duration-200 shadow-sm cursor-pointer">
                            {{ $pop }}
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            {{-- Compact elegant header for active product state --}}
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-5 border-b border-slate-200/60 dark:border-slate-800/60">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold tracking-wide uppercase bg-primary-100 dark:bg-primary-500/15 text-primary-700 dark:text-primary-400 ring-1 ring-primary-600/10 dark:ring-primary-400/20">Active Commodity</span>
                            <span class="text-xs text-slate-400 dark:text-slate-500 font-medium">Real-time statistics & visual forecasting</span>
                        </div>
                        <h1 class="mt-2 text-3xl sm:text-4xl font-black text-slate-950 dark:text-white tracking-tight flex items-center gap-3">
                            {{ $selectedProduct }} <span class="bg-gradient-to-r from-primary-600 to-accent-500 bg-clip-text text-transparent">Price Analytics</span>
                        </h1>
                    </div>
                    <div>
                        <a href="{{ route('public.intelligence') }}" class="btn-secondary !py-2 !px-4 text-xs font-bold flex items-center gap-2 shadow-sm rounded-xl border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/80 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Back to Catalog
                        </a>
                    </div>
                </div>

                {{-- Dedicated Premium Controls Toolbar --}}
                <div class="glass-card p-4 shadow-md border border-slate-200/60 dark:border-slate-800/80 bg-white/70 dark:bg-slate-900/60 flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-5">
                    {{-- Left Side: Date Filters --}}
                    <div class="flex-1 flex flex-col sm:flex-row sm:items-center gap-3">
                        <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Filter Observations:
                        </span>
                        <form method="GET" action="{{ route('public.intelligence') }}" class="flex flex-wrap items-center gap-3">
                            <input type="hidden" name="product" value="{{ $selectedProduct }}">
                            
                            {{-- Premium Styled From Date --}}
                            <div class="flex items-center gap-2 bg-slate-100/60 dark:bg-slate-900/65 px-3 py-2 rounded-xl border border-slate-200/60 dark:border-slate-800 shadow-inner">
                                <span class="text-[10px] font-bold text-slate-450 dark:text-slate-500 uppercase tracking-wider">From</span>
                                <input type="date" name="date_from" value="{{ $dateFrom }}" class="bg-transparent border-0 p-0 focus:ring-0 text-xs font-semibold text-slate-700 dark:text-slate-200 w-28 h-5 focus:outline-none cursor-pointer">
                            </div>

                            {{-- Premium Styled To Date --}}
                            <div class="flex items-center gap-2 bg-slate-100/60 dark:bg-slate-900/65 px-3 py-2 rounded-xl border border-slate-200/60 dark:border-slate-800 shadow-inner">
                                <span class="text-[10px] font-bold text-slate-450 dark:text-slate-500 uppercase tracking-wider">To</span>
                                <input type="date" name="date_to" value="{{ $dateTo }}" class="bg-transparent border-0 p-0 focus:ring-0 text-xs font-semibold text-slate-700 dark:text-slate-200 w-28 h-5 focus:outline-none cursor-pointer">
                            </div>

                            <div class="flex items-center gap-1.5">
                                <button type="submit" class="btn-primary !py-2 !px-4 text-xs font-bold shadow-sm rounded-xl transition-all duration-200">
                                    Apply Filter
                                </button>
                                @if($dateFrom || $dateTo)
                                    <a href="{{ route('public.intelligence', ['product' => $selectedProduct]) }}" class="btn-secondary !py-2 !px-3 text-xs font-bold rounded-xl transition-all duration-200 flex items-center justify-center">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    {{-- Right Side: Fast Switcher Autocomplete --}}
                    <div x-data="{ 
                        query: '', 
                        suggestions: [], 
                        open: false,
                        loading: false,
                        fetchSuggestions() {
                            if (this.query.length < 1) {
                                    this.suggestions = [];
                                    this.open = false;
                                    return;
                                }
                                this.loading = true;
                                fetch('{{ route('api.intelligence.suggestions') }}?query=' + encodeURIComponent(this.query))
                                    .then(res => res.json())
                                    .then(data => {
                                        this.suggestions = data;
                                        this.open = data.length > 0;
                                        this.loading = false;
                                    })
                                    .catch(() => {
                                        this.loading = false;
                                    });
                            },
                            selectSuggestion(item) {
                                window.location.href = '{{ route('public.intelligence') }}?product=' + encodeURIComponent(item);
                            }
                        }" class="relative w-full md:w-64 z-40">
                        <div class="flex items-center bg-slate-100/60 dark:bg-slate-900/65 px-3 py-2 rounded-xl border border-slate-200/60 dark:border-slate-800 shadow-inner h-10">
                            <div class="text-slate-450 dark:text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input 
                                type="text" 
                                x-model="query" 
                                @input.debounce.250ms="fetchSuggestions()" 
                                @keydown.escape="open = false"
                                @keydown.enter="if (query.length > 0) { 
                                    const matched = suggestions.find(s => s.toLowerCase() === query.trim().toLowerCase()) || suggestions[0] || query;
                                    selectSuggestion(matched);
                                }"
                                @click.away="open = false"
                                placeholder="Switch product..." 
                                class="w-full bg-transparent border-0 ring-0 focus:ring-0 text-xs font-bold text-slate-800 dark:text-slate-200 placeholder-slate-450 dark:placeholder-slate-500 pl-2 py-0 focus:outline-none focus:border-0"
                            />
                            <div x-show="loading" class="pr-1" x-cloak>
                                <svg class="animate-spin h-3.5 w-3.5 text-primary-500" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>

                        {{-- Autocomplete Dropdown list --}}
                        <div 
                            x-show="open" 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute left-0 right-0 mt-1 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-xl overflow-hidden text-left z-50 max-h-56 overflow-y-auto" 
                            x-cloak
                        >
                            <template x-for="item in suggestions" :key="item">
                                <button 
                                    @click="selectSuggestion(item)"
                                    class="w-full text-left px-4 py-2.5 text-xs font-semibold text-slate-700 dark:text-slate-350 hover:bg-slate-50 dark:hover:bg-slate-800/60 border-b border-slate-100 dark:border-slate-800/30 last:border-b-0 transition-colors flex items-center justify-between"
                                >
                                    <span x-text="item"></span>
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>

    {{-- Main Portal Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        @if(!$selectedProduct)
            {{-- EMPTY STATE: Catalogs of Products & Explanations --}}
            <div class="stagger-children space-y-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="glass-card p-6 flex flex-col justify-between">
                        <div class="p-3 bg-primary-500/10 text-primary-600 dark:text-primary-400 rounded-xl w-fit">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <h3 class="font-bold text-lg text-slate-900 dark:text-white mt-4">Regional Comparison</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">See which states or cities currently offer the lowest and highest rates for any product nationwide.</p>
                    </div>
                    <div class="glass-card p-6 flex flex-col justify-between">
                        <div class="p-3 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl w-fit">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                        </div>
                        <h3 class="font-bold text-lg text-slate-900 dark:text-white mt-4">Interactive Trends</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">Plot interactive Line, Bar, and Area charts to identify price spikes, stability intervals, or regional anomalies.</p>
                    </div>
                    <div class="glass-card p-6 flex flex-col justify-between">
                        <div class="p-3 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-xl w-fit">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <h3 class="font-bold text-lg text-slate-900 dark:text-white mt-4">Hike & Drop Intelligence</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">Automatic standard deviation volatility rating and weekly percentage changes highlight high-risk items.</p>
                    </div>
                </div>

                {{-- Products Catalog Card --}}
                <div class="glass-card p-8">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2 flex items-center gap-2">
                        <svg class="w-5.5 h-5.5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        Approved Market Database Catalog
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">Select an active commodity or commodity subset below to explore real-time price dispersion:</p>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                        @forelse($products as $prod)
                            <a href="{{ route('public.intelligence', ['product' => $prod]) }}" class="flex items-center gap-2.5 p-3.5 rounded-xl border border-slate-200/60 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/40 hover:border-primary-500 dark:hover:border-primary-500 hover:bg-white dark:hover:bg-slate-900 hover:shadow-md transition-all duration-200 group text-left">
                                <div class="w-7 h-7 rounded-lg bg-primary-500/5 group-hover:bg-primary-500/10 text-primary-600 dark:text-primary-400 flex items-center justify-center text-xs font-bold transition-all duration-200">
                                    {{ strtoupper(substr($prod, 0, 1)) }}
                                </div>
                                <span class="text-xs font-semibold text-slate-700 dark:text-slate-300 group-hover:text-slate-950 dark:group-hover:text-white truncate">{{ $prod }}</span>
                            </a>
                        @empty
                            <div class="col-span-full text-center py-6 text-slate-400 text-sm">No approved product data available.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        @else
            {{-- ACTIVE PORTAL DASHBOARD --}}
            <div class="space-y-8">

                @if(!$intelligenceData)
                    {{-- Selected product exists but has no data for the chosen date range --}}
                    <div class="glass-card p-12 text-center">
                        <div class="p-4 bg-slate-100 dark:bg-slate-900 rounded-full w-fit mx-auto mb-4 text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">No Price Observations Found</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 max-w-md mx-auto">There are no approved price observations for <strong>{{ $selectedProduct }}</strong> during this specific date range. Please try selecting a wider interval or resetting the filters.</p>
                        <a href="{{ route('public.intelligence', ['product' => $selectedProduct]) }}" class="btn-secondary btn-sm mt-4 inline-block">Reset Date Range</a>
                    </div>
                @else
                    {{-- Dynamic Price Hike / Drop Alert Banner --}}
                    @if($intelligenceData->banner_text)
                        <div class="glass-card border-l-4 overflow-hidden relative shadow-sm
                            {{ $intelligenceData->banner_type === 'down' ? 'border-emerald-500 bg-emerald-500/[0.02]' : ($intelligenceData->banner_type === 'up' ? 'border-rose-500 bg-rose-500/[0.02]' : 'border-blue-500 bg-blue-500/[0.02]') }}">
                            <div class="absolute right-0 top-0 translate-x-1/4 -translate-y-1/4 w-32 h-32 rounded-full blur-2xl pointer-events-none
                                {{ $intelligenceData->banner_type === 'down' ? 'bg-emerald-500/5' : ($intelligenceData->banner_type === 'up' ? 'bg-rose-500/5' : 'bg-blue-500/5') }}"></div>
                            <div class="p-4.5 flex items-center gap-3.5">
                                <div class="p-2.5 rounded-lg text-sm font-bold
                                    {{ $intelligenceData->banner_type === 'down' ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : ($intelligenceData->banner_type === 'up' ? 'bg-rose-500/10 text-rose-600 dark:text-rose-400' : 'bg-blue-500/10 text-blue-600 dark:text-blue-400') }}">
                                    @if($intelligenceData->banner_type === 'down')
                                        📉 Price Drop
                                    @elseif($intelligenceData->banner_type === 'up')
                                        📈 Price Hike
                                    @else
                                        ➡️ Stable
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">National Price Activity Analysis</h4>
                                    <p class="text-xs text-slate-600 dark:text-slate-400 mt-0.5">{{ $intelligenceData->banner_text }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- 4-Metric Smart Analytics Grid --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        {{-- Cheapest Location --}}
                        <div class="stats-card flex items-center justify-between p-5 relative overflow-hidden group border-t-2 border-emerald-500/60 bg-white/80 dark:bg-slate-900/50">
                            <div class="absolute right-0 top-0 translate-x-1/3 -translate-y-1/3 w-20 h-20 bg-emerald-500/5 rounded-full blur-2xl pointer-events-none group-hover:scale-150 transition-all duration-300"></div>
                            <div class="text-left max-w-[75%]">
                                <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1">Cheapest Location</p>
                                <p class="text-2xl font-black text-slate-950 dark:text-white tracking-tight truncate tabular-nums">₹{{ number_format($intelligenceData->cheapest->current_price, 2) }}</p>
                                <p class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 mt-0.5 truncate flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    {{ $intelligenceData->cheapest->location }}
                                </p>
                            </div>
                            <div class="p-3 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl transition-all duration-300 group-hover:scale-110">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg>
                            </div>
                        </div>

                        {{-- Most Expensive Location --}}
                        <div class="stats-card flex items-center justify-between p-5 relative overflow-hidden group border-t-2 border-rose-500/60 bg-white/80 dark:bg-slate-900/50">
                            <div class="absolute right-0 top-0 translate-x-1/3 -translate-y-1/3 w-20 h-20 bg-rose-500/5 rounded-full blur-2xl pointer-events-none group-hover:scale-150 transition-all duration-300"></div>
                            <div class="text-left max-w-[75%]">
                                <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1">Premium Location</p>
                                <p class="text-2xl font-black text-slate-950 dark:text-white tracking-tight truncate tabular-nums">₹{{ number_format($intelligenceData->expensive->current_price, 2) }}</p>
                                <p class="text-xs font-semibold text-rose-600 dark:text-rose-400 mt-0.5 truncate flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                    {{ $intelligenceData->expensive->location }}
                                </p>
                            </div>
                            <div class="p-3 bg-rose-500/10 text-rose-600 dark:text-rose-400 rounded-xl transition-all duration-300 group-hover:scale-110">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            </div>
                        </div>

                        {{-- National Average --}}
                        <div class="stats-card flex items-center justify-between p-5 relative overflow-hidden group border-t-2 border-blue-500/60 bg-white/80 dark:bg-slate-900/50">
                            <div class="absolute right-0 top-0 translate-x-1/3 -translate-y-1/3 w-20 h-20 bg-blue-500/5 rounded-full blur-2xl pointer-events-none group-hover:scale-150 transition-all duration-300"></div>
                            <div class="text-left max-w-[75%]">
                                <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1">National Average</p>
                                <p class="text-2xl font-black text-slate-950 dark:text-white tracking-tight truncate tabular-nums">₹{{ number_format($intelligenceData->avg_price, 2) }}</p>
                                <p class="text-xs font-semibold text-blue-600 dark:text-blue-400 mt-0.5 truncate flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    Aggregated Value
                                </p>
                            </div>
                            <div class="p-3 bg-blue-500/10 text-blue-600 dark:text-blue-400 rounded-xl transition-all duration-300 group-hover:scale-110">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 8h6m-5 0a3 3 0 110 6H9l3 3m-3-6h6m6 1a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>

                        {{-- Volatility Indicator --}}
                        <div class="stats-card flex items-center justify-between p-5 relative overflow-hidden group border-t-2 border-violet-500/60 bg-white/80 dark:bg-slate-900/50">
                            <div class="absolute right-0 top-0 translate-x-1/3 -translate-y-1/3 w-20 h-20 bg-violet-500/5 rounded-full blur-2xl pointer-events-none group-hover:scale-150 transition-all duration-300"></div>
                            <div class="text-left max-w-[75%]">
                                <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1">Market Volatility</p>
                                <p class="text-2xl font-black text-slate-950 dark:text-white tracking-tight truncate">{{ $intelligenceData->volatility }}</p>
                                <p class="text-xs font-semibold text-violet-600 dark:text-violet-400 mt-0.5 truncate flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-violet-500"></span>
                                    CV: {{ number_format($intelligenceData->cv_percentage, 1) }}%
                                </p>
                            </div>
                            <div class="p-3 bg-violet-500/10 text-violet-600 dark:text-violet-400 rounded-xl transition-all duration-300 group-hover:scale-110">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Interactive Charts Panel --}}
                    <div x-data="priceIntelligence()" x-init="setTimeout(() => initChart(), 100)" class="glass-card p-6">
                        
                        {{-- Chart Tabs & Actions --}}
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-slate-100 dark:border-slate-800/80 mb-6">
                            <div class="flex items-center gap-1.5 p-1 bg-slate-100 dark:bg-slate-900 rounded-xl w-fit">
                                <button 
                                    @click="activeTab = 'line'; initChart()" 
                                    :class="activeTab === 'line' ? 'bg-white dark:bg-slate-850 text-slate-950 dark:text-white shadow-sm ring-1 ring-slate-200/40 dark:ring-slate-700/60' : 'text-slate-500 hover:text-slate-950 dark:hover:text-white'"
                                    class="px-3.5 py-1.5 text-xs font-bold rounded-lg transition-all flex items-center gap-1.5"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                                    Line Trend
                                </button>
                                <button 
                                    @click="activeTab = 'bar'; initChart()" 
                                    :class="activeTab === 'bar' ? 'bg-white dark:bg-slate-850 text-slate-950 dark:text-white shadow-sm ring-1 ring-slate-200/40 dark:ring-slate-700/60' : 'text-slate-500 hover:text-slate-950 dark:hover:text-white'"
                                    class="px-3.5 py-1.5 text-xs font-bold rounded-lg transition-all flex items-center gap-1.5"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                    Region Compare
                                </button>
                                <button 
                                    @click="activeTab = 'area'; initChart()" 
                                    :class="activeTab === 'area' ? 'bg-white dark:bg-slate-850 text-slate-950 dark:text-white shadow-sm ring-1 ring-slate-200/40 dark:ring-slate-700/60' : 'text-slate-500 hover:text-slate-950 dark:hover:text-white'"
                                    class="px-3.5 py-1.5 text-xs font-bold rounded-lg transition-all flex items-center gap-1.5"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    Fluctuations
                                </button>
                            </div>
                            
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">Auto-responsive Graphing</span>
                            </div>
                        </div>

                        {{-- Chart Workspace Canvas & State Control Grid --}}
                        <div class="flex flex-col lg:flex-row gap-6">
                            {{-- Chart Container --}}
                            <div class="flex-1 h-[380px] sm:h-[420px] relative">
                                <canvas id="intelChart"></canvas>
                            </div>

                            {{-- State Selection Checkbox Panel (Only relevant for Line series) --}}
                            <div x-show="activeTab === 'line'" class="w-full lg:w-64 glass-card p-5 flex flex-col justify-between" x-cloak>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-950 dark:text-white flex items-center gap-1.5 uppercase tracking-wider mb-2">
                                        <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                                        Compare Regions
                                    </h4>
                                    <p class="text-[10px] text-slate-500 dark:text-slate-400 mb-3.5">Check locations below to instantly plot their individual trends on the line chart:</p>
                                    
                                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-1 gap-2 max-h-56 overflow-y-auto pr-1">
                                        @foreach($intelligenceData->locations_data as $i => $item)
                                            <label class="flex items-center gap-2.5 cursor-pointer select-none py-1.5 px-2.5 rounded-lg hover:bg-slate-100/50 dark:hover:bg-slate-800/40 transition-all duration-200 border border-transparent hover:border-slate-200/40 dark:hover:border-slate-800">
                                                <input 
                                                    type="checkbox" 
                                                    value="{{ $item->location }}" 
                                                    @change="initChart()"
                                                    {{ $i < 2 ? 'checked' : '' }}
                                                    class="state-checkbox w-4 h-4 rounded border-slate-300 dark:border-slate-700 text-primary-600 focus:ring-primary-500 bg-white dark:bg-slate-800 transition-all cursor-pointer"
                                                >
                                                <span class="text-xs font-semibold text-slate-700 dark:text-slate-300 truncate">{{ $item->location }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="mt-4 pt-3.5 border-t border-slate-200/50 dark:border-slate-800/80 flex items-center justify-between gap-2">
                                    <button 
                                        @click="document.querySelectorAll('.state-checkbox').forEach(b => b.checked = true); initChart()"
                                        class="text-[10px] font-bold text-primary-600 dark:text-primary-400 hover:underline"
                                    >
                                        Check All
                                    </button>
                                    <button 
                                        @click="document.querySelectorAll('.state-checkbox').forEach(b => b.checked = false); initChart()"
                                        class="text-[10px] font-bold text-slate-400 dark:text-slate-500 hover:underline"
                                    >
                                        Clear All
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Region Price Comparison Table --}}
                    <div class="glass-card overflow-hidden">
                        <div class="px-6 py-4.5 border-b border-slate-100 dark:border-slate-800/80">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Price Comparison Metrics</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Cross-regional dispersion details, percentage differences, and trending indicators</p>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left border-collapse">
                                <thead>
                                    <tr class="text-slate-400 text-xs border-b border-slate-100 dark:border-slate-800 uppercase tracking-wider font-bold">
                                        <th class="py-4 px-6 text-left">State/City</th>
                                        <th class="py-4 px-6 text-left">Current Price</th>
                                        <th class="py-4 px-6 text-left">Previous Price</th>
                                        <th class="py-4 px-6 text-left">Price Difference</th>
                                        <th class="py-4 px-6 text-left">Trend Status</th>
                                        <th class="py-4 px-6 text-right">Last Updated</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                                    @foreach($intelligenceData->locations_data as $item)
                                        <tr class="hover:bg-slate-50/40 dark:hover:bg-slate-800/20 transition-all duration-150">
                                            <td class="py-4 px-6 font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                                <div class="w-2.5 h-2.5 rounded-full bg-primary-500/30 border border-primary-500/70"></div>
                                                {{ $item->location }}
                                            </td>
                                            <td class="py-4 px-6 font-black text-slate-950 dark:text-white tabular-nums">
                                                ₹{{ number_format($item->current_price, 2) }}
                                            </td>
                                            <td class="py-4 px-6 text-slate-500 dark:text-slate-400 tabular-nums">
                                                {{ $item->previous_price !== null ? '₹' . number_format($item->previous_price, 2) : '-' }}
                                            </td>
                                            <td class="py-4 px-6 tabular-nums">
                                                @if($item->previous_price === null)
                                                    <span class="text-xs text-slate-400 font-medium">New Record</span>
                                                @elseif($item->difference > 0)
                                                    <span class="text-xs font-bold text-rose-600 dark:text-rose-400">+₹{{ number_format($item->difference, 2) }} (+{{ number_format($item->percentage_change, 1) }}%)</span>
                                                @elseif($item->difference < 0)
                                                    <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">-₹{{ number_format(abs($item->difference), 2) }} (-{{ number_format(abs($item->percentage_change), 1) }}%)</span>
                                                @else
                                                    <span class="text-xs font-medium text-slate-400 dark:text-slate-500">No Change</span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-6">
                                                @if($item->previous_price === null || $item->trend === 'stable')
                                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold tracking-wide uppercase bg-slate-100 dark:bg-slate-800/60 text-slate-600 dark:text-slate-400 ring-1 ring-slate-600/10 dark:ring-slate-400/20">➡️ Stable</span>
                                                @elseif($item->trend === 'rising')
                                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold tracking-wide uppercase bg-rose-50 dark:bg-rose-500/10 text-rose-700 dark:text-rose-400 ring-1 ring-rose-600/10 dark:ring-rose-400/20">📈 Rising</span>
                                                @elseif($item->trend === 'dropping')
                                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold tracking-wide uppercase bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 ring-1 ring-emerald-600/10 dark:ring-emerald-400/20">📉 Dropping</span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-6 text-right text-xs text-slate-400 dark:text-slate-500 tabular-nums">
                                                {{ $item->last_updated }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>
        @endif

    </div>

    {{-- Load high-performance Chart.js from CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @if($selectedProduct && $intelligenceData)
    <script>
        function priceIntelligence() {
            return {
                activeTab: 'line',
                chart: null,
                initChart() {
                    const ctx = document.getElementById('intelChart').getContext('2d');
                    const dates = @json($intelligenceData->dates);
                    const avgPrices = @json($intelligenceData->avg_prices);
                    const minPrices = @json($intelligenceData->min_prices);
                    const maxPrices = @json($intelligenceData->max_prices);
                    const locations = @json($intelligenceData->locations_data->pluck('location'));
                    const currentPrices = @json($intelligenceData->locations_data->pluck('current_price'));
                    const stateTrends = @json($intelligenceData->state_trends);

                    if (this.chart) {
                        this.chart.destroy();
                    }

                    // Dynamic HSL colors for state lines
                    const getHSLColor = (index, total) => {
                        const h = (index * (360 / total)) % 360;
                        return `hsl(${h}, 70%, 50%)`;
                    };

                    if (this.activeTab === 'line') {
                        const datasets = [{
                            label: 'National Average',
                            data: avgPrices,
                            borderColor: '#4f46e5',
                            backgroundColor: 'rgba(79, 70, 229, 0.05)',
                            borderWidth: 3.5,
                            tension: 0.3,
                            fill: true,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: '#4f46e5',
                            pointBorderColor: '#4f46e5',
                            z: 10
                        }];

                        const checkboxes = document.querySelectorAll('.state-checkbox');
                        checkboxes.forEach((box, i) => {
                            if (box.checked) {
                                const locName = box.value;
                                if (stateTrends[locName]) {
                                    const stateData = dates.map(d => stateTrends[locName][d] || null);
                                    const color = getHSLColor(i, checkboxes.length);
                                    datasets.push({
                                        label: locName,
                                        data: stateData,
                                        borderColor: color,
                                        pointBackgroundColor: color,
                                        pointBorderColor: color,
                                        pointRadius: 5,
                                        pointHoverRadius: 7,
                                        borderWidth: 2,
                                        tension: 0.3,
                                        fill: false,
                                        spanGaps: true
                                    });
                                }
                            }
                        });

                        this.chart = new Chart(ctx, {
                            type: 'line',
                            data: { 
                                labels: dates.map(d => {
                                    const date = new Date(d);
                                    return date.toLocaleDateString('en-IN', { day: 'numeric', month: 'short' });
                                }), 
                                datasets: datasets 
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                interaction: { intersect: false, mode: 'index' },
                                plugins: { legend: { display: true, labels: { font: { family: 'Inter', weight: '500' } } } },
                                scales: {
                                    y: { grid: { color: 'rgba(156, 163, 175, 0.08)' }, ticks: { font: { family: 'Inter' } } },
                                    x: { grid: { color: 'rgba(156, 163, 175, 0.08)' }, ticks: { font: { family: 'Inter' } } }
                                }
                            }
                        });
                    } else if (this.activeTab === 'bar') {
                        const barColors = currentPrices.map((_, i) => getHSLColor(i, currentPrices.length));
                        this.chart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: locations,
                                datasets: [{
                                    label: 'Current Pricing (₹)',
                                    data: currentPrices,
                                    backgroundColor: barColors,
                                    borderRadius: 6,
                                    borderWidth: 0
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: { legend: { display: false } },
                                scales: {
                                    y: { grid: { color: 'rgba(156, 163, 175, 0.08)' } },
                                    x: { grid: { display: false } }
                                }
                            }
                        });
                    } else if (this.activeTab === 'area') {
                        this.chart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: dates.map(d => {
                                    const date = new Date(d);
                                    return date.toLocaleDateString('en-IN', { day: 'numeric', month: 'short' });
                                }),
                                datasets: [
                                    {
                                        label: 'Max Price',
                                        data: maxPrices,
                                        borderColor: 'rgba(239, 68, 68, 0.8)',
                                        backgroundColor: 'transparent',
                                        borderWidth: 1.5,
                                        tension: 0.3,
                                        fill: false,
                                        pointRadius: 4,
                                        pointHoverRadius: 6,
                                        pointBackgroundColor: 'rgba(239, 68, 68, 0.8)',
                                        pointBorderColor: 'rgba(239, 68, 68, 0.8)'
                                    },
                                    {
                                        label: 'Average Price',
                                        data: avgPrices,
                                        borderColor: 'rgba(79, 70, 229, 0.9)',
                                        backgroundColor: 'rgba(79, 70, 229, 0.06)',
                                        borderWidth: 3,
                                        tension: 0.3,
                                        fill: true,
                                        pointRadius: 5,
                                        pointHoverRadius: 7,
                                        pointBackgroundColor: 'rgba(79, 70, 229, 0.9)',
                                        pointBorderColor: 'rgba(79, 70, 229, 0.9)'
                                    },
                                    {
                                        label: 'Min Price',
                                        data: minPrices,
                                        borderColor: 'rgba(16, 185, 129, 0.8)',
                                        backgroundColor: 'transparent',
                                        borderWidth: 1.5,
                                        tension: 0.3,
                                        fill: false,
                                        pointRadius: 4,
                                        pointHoverRadius: 6,
                                        pointBackgroundColor: 'rgba(16, 185, 129, 0.8)',
                                        pointBorderColor: 'rgba(16, 185, 129, 0.8)'
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                interaction: { intersect: false, mode: 'index' },
                                plugins: { legend: { display: true } },
                                scales: {
                                    y: { grid: { color: 'rgba(156, 163, 175, 0.08)' } },
                                    x: { grid: { color: 'rgba(156, 163, 175, 0.08)' } }
                                }
                            }
                        });
                    }
                }
            };
        }
    </script>
    @endif
</x-public-layout>
