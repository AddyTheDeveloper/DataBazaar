<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">Dashboard</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Welcome back, {{ auth()->user()->name }}</p>
            </div>
            <a href="{{ route('market-data.create') }}" class="btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                New Entry
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Stats --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 stagger-children">
                @php
                    $dashStats = [
                        ['value' => number_format((float)$totalEntries), 'label' => 'Total Entries', 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'bg' => 'bg-primary-50 dark:bg-primary-500/10', 'text' => 'text-primary-600 dark:text-primary-400'],
                        ['value' => number_format((float)$approvedEntries), 'label' => 'Approved', 'icon' => 'M5 13l4 4L19 7', 'bg' => 'bg-emerald-50 dark:bg-emerald-500/10', 'text' => 'text-emerald-600 dark:text-emerald-400'],
                        ['value' => number_format((float)$pendingEntries), 'label' => 'Pending', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'bg' => 'bg-amber-50 dark:bg-amber-500/10', 'text' => 'text-amber-600 dark:text-amber-400'],
                        ['value' => '₹'.number_format((float)($avgPrice ?? 0), 0), 'label' => 'Avg Price', 'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6', 'bg' => 'bg-violet-50 dark:bg-violet-500/10', 'text' => 'text-violet-600 dark:text-violet-400'],
                    ];
                @endphp
                @foreach($dashStats as $s)
                    <div class="stats-card">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">{{ $s['label'] }}</span>
                            <div class="w-9 h-9 rounded-xl {{ $s['bg'] }} flex items-center justify-center">
                                <svg class="w-4.5 h-4.5 {{ $s['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $s['icon'] }}"/></svg>
                            </div>
                        </div>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">{{ $s['value'] }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Charts --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
                <div class="lg:col-span-2 card p-6">
                    <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-4">Your Price Trends (30 Days)</h3>
                    @if($priceTrends->isNotEmpty())
                    <div class="h-[240px]"><canvas id="userPriceTrend"></canvas></div>
                    @else
                    <div class="h-[240px] flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-10 h-10 text-slate-300 dark:text-slate-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            <p class="text-sm text-slate-400 dark:text-slate-500">No price data yet</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Submit entries to see trends</p>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card p-6">
                    <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-4">Category Breakdown</h3>
                    @if($categoryBreakdown->isNotEmpty() && $categoryBreakdown->sum('market_data_count') > 0)
                    <div class="h-[240px]"><canvas id="userCategoryChart"></canvas></div>
                    @else
                    <div class="h-[240px] flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-10 h-10 text-slate-300 dark:text-slate-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                            <p class="text-sm text-slate-400 dark:text-slate-500">No categories yet</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Recent Submissions --}}
            <div class="mt-8 card">
                <div class="px-6 py-5 border-b border-slate-200/60 dark:border-slate-700/50 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300">Recent Submissions</h3>
                    <a href="{{ route('market-data.index') }}" class="text-xs font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400">View all →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr><th>Product</th><th>Price</th><th>Category</th><th>Status</th><th>Date</th><th></th></tr>
                        </thead>
                        <tbody>
                            @forelse($recentData as $item)
                            <tr>
                                <td class="font-medium text-slate-900 dark:text-white">{{ $item->product_name }}</td>
                                <td class="font-semibold text-primary-600 dark:text-primary-400">₹{{ number_format((float)$item->price, 2) }}</td>
                                <td><span class="badge badge-approved">{{ $item->category->name }}</span></td>
                                <td><span class="badge badge-{{ $item->status }}">{{ ucfirst($item->status) }}</span></td>
                                <td class="text-slate-500">{{ $item->date->format('d M Y') }}</td>
                                <td><a href="{{ route('market-data.edit', $item) }}" class="text-xs font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400">Edit</a></td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center py-12 text-slate-400">No submissions yet. <a href="{{ route('market-data.create') }}" class="text-primary-600 hover:underline">Add your first</a></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4 stagger-children">
                @php
                    $actions = [
                        ['route' => 'market-data.create', 'title' => 'New Entry', 'desc' => 'Submit market price data', 'icon' => 'M12 6v6m0 0v6m0-6h6m-6 0H6', 'bg' => 'bg-primary-50 dark:bg-primary-500/10', 'text' => 'text-primary-600 dark:text-primary-400'],
                        ['route' => 'market-data.upload.form', 'title' => 'Bulk Upload', 'desc' => 'Import data via CSV', 'icon' => 'M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12', 'bg' => 'bg-accent-50 dark:bg-accent-500/10', 'text' => 'text-accent-600 dark:text-accent-400'],
                        ['route' => 'market-data.export.csv', 'title' => 'Export CSV', 'desc' => 'Download your data', 'icon' => 'M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'bg' => 'bg-violet-50 dark:bg-violet-500/10', 'text' => 'text-violet-600 dark:text-violet-400'],
                    ];
                @endphp
                @foreach($actions as $a)
                <a href="{{ route($a['route']) }}" class="card-hover p-5 flex items-center gap-4 group">
                    <div class="w-11 h-11 rounded-xl {{ $a['bg'] }} flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-5 h-5 {{ $a['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $a['icon'] }}"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-slate-900 dark:text-white">{{ $a['title'] }}</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $a['desc'] }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    @if($priceTrends->isNotEmpty() || ($categoryBreakdown->isNotEmpty() && $categoryBreakdown->sum('market_data_count') > 0))
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDark = document.documentElement.classList.contains('dark');
        const gridColor = isDark ? 'rgba(148,163,184,0.06)' : 'rgba(0,0,0,0.04)';
        Chart.defaults.font.family = 'Inter';
        Chart.defaults.color = isDark ? '#94a3b8' : '#64748b';

        @if($priceTrends->isNotEmpty())
        new Chart(document.getElementById('userPriceTrend'), {
            type: 'line',
            data: { labels: {!! json_encode($priceTrends->pluck('trend_date')) !!}, datasets: [{ label: 'Avg Price', data: {!! json_encode($priceTrends->pluck('avg_price')) !!}, borderColor: '#2563eb', backgroundColor: isDark ? 'rgba(37,99,235,0.08)' : 'rgba(37,99,235,0.06)', fill: true, tension: 0.4, borderWidth: 2, pointRadius: 0, pointHoverRadius: 5 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: false, grid: { color: gridColor, drawBorder: false }, ticks: { callback: v=>'₹'+v, font: { size: 11 } }, border: { display: false } }, x: { grid: { display: false }, ticks: { maxTicksLimit: 8, font: { size: 11 } }, border: { display: false } } }, interaction: { intersect: false, mode: 'index' } }
        });
        @endif

        @if($categoryBreakdown->isNotEmpty() && $categoryBreakdown->sum('market_data_count') > 0)
        const catData = {!! json_encode($categoryBreakdown) !!};
        const colors = ['#2563eb','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899','#14b8a6','#f97316','#6366f1','#84cc16'];
        new Chart(document.getElementById('userCategoryChart'), {
            type: 'doughnut',
            data: { labels: catData.map(c=>c.name), datasets: [{ data: catData.map(c=>c.market_data_count), backgroundColor: colors, borderWidth: 0 }] },
            options: { responsive: true, maintainAspectRatio: false, cutout: '70%', plugins: { legend: { position: 'bottom', labels: { boxWidth: 8, padding: 12, font: { size: 10 }, usePointStyle: true, pointStyle: 'circle' } } } }
        });
        @endif
    });
    </script>
    @endif
</x-app-layout>
