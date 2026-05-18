<x-public-layout>
    <x-slot name="title">Market Intelligence Platform</x-slot>

    <section class="relative isolate overflow-hidden border-b border-white/60 dark:border-white/10">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(37,99,235,0.16),transparent_32%),linear-gradient(180deg,#f8fafc_0%,#eef6ff_48%,#ffffff_100%)] dark:bg-[radial-gradient(circle_at_top_left,rgba(37,99,235,0.22),transparent_32%),linear-gradient(180deg,#020617_0%,#0f172a_52%,#020617_100%)]"></div>
        <div class="absolute inset-0 bg-grid opacity-35 dark:opacity-15"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-14 lg:pt-20 lg:pb-18">
            <div class="grid lg:grid-cols-[0.94fr_1.06fr] gap-10 lg:gap-14 items-center">
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full glass-card mb-6">
                        <span class="h-2 w-2 rounded-full bg-accent-500"></span>
                        <span class="text-xs font-semibold text-slate-700 dark:text-slate-200">{{ number_format((float) $totalEntries) }} verified market observations</span>
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-950 dark:text-white leading-[1.05]">
                        Market data that feels ready for decisions.
                    </h1>

                    <p class="mt-6 text-base sm:text-lg text-slate-600 dark:text-slate-300 leading-8 max-w-xl">
                        DataBazaar helps teams collect, review, explore, and export price intelligence with a calm workflow and clear analytics.
                    </p>

                    <div class="mt-8 flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('public.explore') }}" class="btn-primary btn-lg">
                            Explore Data
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="{{ route('register') }}" class="btn-secondary btn-lg">Start Contributing</a>
                    </div>

                    <div class="mt-10 grid grid-cols-3 gap-3 max-w-lg">
                        <div class="glass-card p-4">
                            <p class="text-2xl font-bold text-slate-950 dark:text-white">{{ number_format((float) $totalProducts) }}</p>
                            <p class="mt-1 text-xs font-medium text-slate-500 dark:text-slate-400">Products</p>
                        </div>
                        <div class="glass-card p-4">
                            <p class="text-2xl font-bold text-slate-950 dark:text-white">{{ number_format((float) $totalLocations) }}</p>
                            <p class="mt-1 text-xs font-medium text-slate-500 dark:text-slate-400">Locations</p>
                        </div>
                        <div class="glass-card p-4">
                            <p class="text-2xl font-bold text-slate-950 dark:text-white">&#8377;{{ number_format((float) ($avgPrice ?? 0), 0) }}</p>
                            <p class="mt-1 text-xs font-medium text-slate-500 dark:text-slate-400">Avg Price</p>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="glass-card overflow-hidden p-3">
                        <img src="{{ asset('images/hero-banner.png') }}" alt="DataBazaar analytics preview" class="aspect-[16/11] w-full rounded-lg object-cover">
                    </div>
                    <div class="absolute -bottom-5 left-5 right-5 glass-card p-4 hidden sm:block">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Latest signal</p>
                                <p class="mt-1 text-sm font-semibold text-slate-900 dark:text-white">
                                    @if($recentData->isNotEmpty())
                                        {{ $recentData->first()->product_name }} in {{ $recentData->first()->location }}
                                    @else
                                        Waiting for first approved submission
                                    @endif
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-slate-500 dark:text-slate-400">Current price</p>
                                <p class="mt-1 text-lg font-bold text-primary-600 dark:text-primary-300">
                                    @if($recentData->isNotEmpty())
                                        &#8377;{{ number_format((float) $recentData->first()->price, 2) }}
                                    @else
                                        --
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid lg:grid-cols-3 gap-5">
            @foreach([
                ['title' => 'Collect clean data', 'body' => 'Guided submissions, CSV import, status review, and validations keep contributions consistent.'],
                ['title' => 'Understand movement', 'body' => 'Trend charts, category distribution, comparisons, and filters turn raw prices into useful signals.'],
                ['title' => 'Share and export', 'body' => 'Export CSV or JSON, bookmark useful rows, and generate share links for specific observations.'],
            ] as $feature)
                <div class="glass-card p-6">
                    <h3 class="text-base font-semibold text-slate-950 dark:text-white">{{ $feature['title'] }}</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-600 dark:text-slate-400">{{ $feature['body'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="card p-6">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h2 class="text-lg font-bold text-slate-950 dark:text-white">Price Trends</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Average approved prices over the last 30 days</p>
                    </div>
                </div>
                <div class="h-[280px]"><canvas id="priceTrendsChart"></canvas></div>
            </div>

            <div class="card p-6">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h2 class="text-lg font-bold text-slate-950 dark:text-white">Category Mix</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Approved entries by category</p>
                    </div>
                </div>
                <div class="h-[280px]"><canvas id="categoryChart"></canvas></div>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-950 dark:text-white tracking-tight">Latest Approved Data</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Fresh market observations from contributors</p>
            </div>
            <a href="{{ route('public.explore') }}" class="btn-secondary btn-sm">View All</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($recentData as $item)
                <div class="card-hover p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <h3 class="font-semibold text-slate-950 dark:text-white truncate">{{ $item->product_name }}</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $item->category->name }}</p>
                        </div>
                        <span class="text-lg font-bold text-primary-600 dark:text-primary-300 whitespace-nowrap">&#8377;{{ number_format((float) $item->price, 2) }}</span>
                    </div>
                    <div class="mt-5 pt-4 border-t border-slate-200/70 dark:border-white/10 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                        <span>{{ $item->location }}</span>
                        <span>{{ $item->date->format('d M Y') }}</span>
                    </div>
                </div>
            @empty
                <div class="lg:col-span-3 card p-10 text-center text-sm text-slate-500 dark:text-slate-400">No approved data yet. Create an account to submit the first entry.</div>
            @endforelse
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isDark = document.documentElement.classList.contains('dark');
            const gridColor = isDark ? 'rgba(148,163,184,0.08)' : 'rgba(15,23,42,0.06)';
            const textColor = isDark ? '#94a3b8' : '#64748b';

            Chart.defaults.font.family = 'Inter';
            Chart.defaults.color = textColor;

            new Chart(document.getElementById('priceTrendsChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($priceTrends->pluck('trend_date')) !!},
                    datasets: [{
                        label: 'Avg Price',
                        data: {!! json_encode($priceTrends->pluck('avg_price')) !!},
                        borderColor: '#2563eb',
                        backgroundColor: isDark ? 'rgba(37,99,235,0.12)' : 'rgba(37,99,235,0.08)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2,
                        pointRadius: 0,
                        pointHoverRadius: 5,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: false, grid: { color: gridColor }, ticks: { callback: value => 'Rs ' + value, font: { size: 11 } }, border: { display: false } },
                        x: { grid: { display: false }, ticks: { maxTicksLimit: 8, font: { size: 11 } }, border: { display: false } }
                    },
                    interaction: { intersect: false, mode: 'index' },
                }
            });

            const catData = {!! json_encode($categoryStats) !!};
            new Chart(document.getElementById('categoryChart'), {
                type: 'doughnut',
                data: {
                    labels: catData.map(category => category.name),
                    datasets: [{
                        data: catData.map(category => category.market_data_count),
                        backgroundColor: ['#2563eb','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899','#14b8a6','#f97316','#6366f1','#84cc16'],
                        borderWidth: 0,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    plugins: { legend: { position: 'right', labels: { boxWidth: 10, padding: 14, font: { size: 11 }, usePointStyle: true, pointStyle: 'circle' } } }
                }
            });
        });
    </script>
</x-public-layout>
