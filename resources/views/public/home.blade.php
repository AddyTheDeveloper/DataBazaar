<x-public-layout>
    <x-slot name="title">Market Databank Platform</x-slot>

    {{-- Hero --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-primary-50/50 via-white to-white dark:from-primary-950/30 dark:via-slate-950 dark:to-slate-950"></div>
        <div class="absolute inset-0 bg-grid opacity-40 dark:opacity-20"></div>
        <div class="absolute top-20 left-1/4 w-96 h-96 bg-primary-400/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-1/4 w-80 h-80 bg-accent-400/8 rounded-full blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-24 lg:pt-28 lg:pb-32">
            <div class="max-w-3xl mx-auto text-center">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary-50 dark:bg-primary-500/10 border border-primary-200/60 dark:border-primary-500/20 mb-8 animate-fade-in">
                    <div class="w-1.5 h-1.5 rounded-full bg-accent-500 animate-pulse-soft"></div>
                    <span class="text-xs font-semibold text-primary-700 dark:text-primary-400 tracking-wide">{{ number_format($totalEntries) }} data entries and growing</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-[1.1] animate-slide-up">
                    Market intelligence,
                    <span class="gradient-text">made simple.</span>
                </h1>

                <p class="mt-6 text-lg sm:text-xl text-slate-600 dark:text-slate-400 leading-relaxed max-w-2xl mx-auto animate-slide-up" style="animation-delay: 0.1s">
                    Submit, explore, and analyze market pricing data from across the country. Real-time trends, exportable reports, and community-driven insights.
                </p>

                <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4 animate-slide-up" style="animation-delay: 0.2s">
                    <a href="{{ route('public.explore') }}" class="btn-primary btn-lg w-full sm:w-auto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Explore Data
                    </a>
                    <a href="{{ route('register') }}" class="btn-secondary btn-lg w-full sm:w-auto">
                        Start Contributing
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 stagger-children">
            @php
                $stats = [
                    ['value' => number_format($totalEntries), 'label' => 'Data Entries', 'color' => 'primary'],
                    ['value' => number_format($totalProducts), 'label' => 'Products Tracked', 'color' => 'accent'],
                    ['value' => number_format($totalLocations), 'label' => 'Locations', 'color' => 'violet'],
                    ['value' => '₹'.number_format($avgPrice ?? 0, 0), 'label' => 'Avg Price', 'color' => 'amber'],
                ];
            @endphp
            @foreach($stats as $stat)
                <div class="card p-6 text-center">
                    <p class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ $stat['value'] }}</p>
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mt-1.5 uppercase tracking-wider">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Charts --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20">
        <div class="text-center mb-12">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white tracking-tight">Market Trends</h2>
            <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm">Real-time price movements across the platform</p>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="card p-6">
                <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-4">Price Trends (30 Days)</h3>
                <div class="h-[280px]"><canvas id="priceTrendsChart"></canvas></div>
            </div>
            <div class="card p-6">
                <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-4">Category Distribution</h3>
                <div class="h-[280px]"><canvas id="categoryChart"></canvas></div>
            </div>
        </div>
    </section>

    {{-- Recent Data --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20">
        <div class="flex items-end justify-between mb-8">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white tracking-tight">Latest Submissions</h2>
                <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">Recently approved market data</p>
            </div>
            <a href="{{ route('public.explore') }}" class="btn-secondary btn-sm hidden sm:inline-flex">View All</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 stagger-children">
            @forelse($recentData as $item)
                <div class="card-hover p-6 group">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <h3 class="font-semibold text-slate-900 dark:text-white truncate group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">{{ $item->product_name }}</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $item->category->name }}</p>
                        </div>
                        <span class="text-lg font-bold text-primary-600 dark:text-primary-400 whitespace-nowrap">₹{{ number_format($item->price, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between mt-5 pt-4 border-t border-slate-100 dark:border-slate-700/50">
                        <div class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            {{ $item->location }}
                        </div>
                        <span class="text-xs text-slate-400 dark:text-slate-500">{{ $item->date->format('d M Y') }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-3 card p-12 text-center">
                    <p class="text-slate-400 dark:text-slate-500">No data available yet. Be the first to contribute!</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- CTA --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20">
        <div class="relative overflow-hidden rounded-3xl bg-slate-900 dark:bg-slate-800 p-12 sm:p-16">
            <div class="absolute inset-0 bg-gradient-to-br from-primary-600/20 via-transparent to-accent-500/10"></div>
            <div class="absolute top-0 right-0 w-80 h-80 bg-primary-500/10 rounded-full blur-3xl"></div>
            <div class="absolute inset-0 bg-grid opacity-5"></div>

            <div class="relative text-center max-w-xl mx-auto">
                <h2 class="text-3xl font-bold text-white tracking-tight">Ready to share market insights?</h2>
                <p class="text-slate-400 mt-4 leading-relaxed">Join our growing community of contributors building the most comprehensive market database.</p>
                <a href="{{ route('register') }}" class="btn-primary btn-lg mt-8 inline-flex">
                    Create Free Account
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isDark = document.documentElement.classList.contains('dark');
            const gridColor = isDark ? 'rgba(148,163,184,0.06)' : 'rgba(0,0,0,0.04)';
            const textColor = isDark ? '#94a3b8' : '#64748b';

            Chart.defaults.font.family = 'Inter';
            Chart.defaults.color = textColor;

            new Chart(document.getElementById('priceTrendsChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($priceTrends->pluck('trend_date')) !!},
                    datasets: [{
                        label: 'Avg Price (₹)',
                        data: {!! json_encode($priceTrends->pluck('avg_price')) !!},
                        borderColor: '#2563eb',
                        backgroundColor: isDark ? 'rgba(37,99,235,0.08)' : 'rgba(37,99,235,0.06)',
                        fill: true, tension: 0.4, borderWidth: 2,
                        pointBackgroundColor: '#2563eb', pointBorderColor: isDark ? '#1e293b' : '#fff',
                        pointBorderWidth: 2, pointRadius: 0, pointHoverRadius: 5,
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: false, grid: { color: gridColor, drawBorder: false }, ticks: { callback: v => '₹'+v, font: { size: 11 } }, border: { display: false } },
                        x: { grid: { display: false }, ticks: { maxTicksLimit: 8, font: { size: 11 } }, border: { display: false } }
                    },
                    interaction: { intersect: false, mode: 'index' },
                }
            });

            const catData = {!! json_encode($categoryStats) !!};
            const colors = ['#2563eb','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899','#14b8a6','#f97316','#6366f1','#84cc16'];
            new Chart(document.getElementById('categoryChart'), {
                type: 'doughnut',
                data: {
                    labels: catData.map(c => c.name),
                    datasets: [{ data: catData.map(c => c.market_data_count), backgroundColor: colors, borderWidth: 0, hoverOffset: 6 }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false, cutout: '70%',
                    plugins: { legend: { position: 'right', labels: { boxWidth: 10, padding: 14, font: { size: 11 }, usePointStyle: true, pointStyle: 'circle' } } }
                }
            });
        });
    </script>
</x-public-layout>
