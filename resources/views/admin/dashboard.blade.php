<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">Admin Overview</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Platform analytics and management</p>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 stagger-children">
                @php $adminStats = [['v'=>$totalUsers,'l'=>'Users','c'=>'primary'],['v'=>$totalEntries,'l'=>'Entries','c'=>'slate'],['v'=>$approvedEntries,'l'=>'Approved','c'=>'emerald'],['v'=>$pendingEntries,'l'=>'Pending','c'=>'amber'],['v'=>'₹'.number_format($avgPrice??0,0),'l'=>'Avg Price','c'=>'violet']]; @endphp
                @foreach($adminStats as $s)
                <div class="stats-card text-center">
                    <p class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight tabular-nums">{{ $s['v'] }}</p>
                    <p class="text-[11px] font-medium text-slate-500 dark:text-slate-400 mt-1 uppercase tracking-wider">{{ $s['l'] }}</p>
                </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
                <div class="card p-6"><h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-4">Submissions (30 Days)</h3><div class="h-[220px]"><canvas id="submissionChart"></canvas></div></div>
                <div class="card p-6"><h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-4">Categories</h3><div class="h-[220px]"><canvas id="adminCatChart"></canvas></div></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
                <a href="{{ route('admin.data') }}" class="card-hover p-5 flex items-center gap-4 group">
                    <div class="w-11 h-11 rounded-xl bg-primary-50 dark:bg-primary-500/10 flex items-center justify-center flex-shrink-0"><svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg></div>
                    <div><h4 class="text-sm font-semibold text-slate-900 dark:text-white">Moderate Data</h4><p class="text-xs text-slate-500 mt-0.5">@if($pendingEntries > 0)<span class="text-amber-600 font-medium">{{ $pendingEntries }} pending</span>@else All clear @endif</p></div>
                </a>
                <a href="{{ route('admin.users') }}" class="card-hover p-5 flex items-center gap-4 group">
                    <div class="w-11 h-11 rounded-xl bg-violet-50 dark:bg-violet-500/10 flex items-center justify-center flex-shrink-0"><svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg></div>
                    <div><h4 class="text-sm font-semibold text-slate-900 dark:text-white">Manage Users</h4><p class="text-xs text-slate-500 mt-0.5">{{ $totalUsers }} registered</p></div>
                </a>
                <a href="{{ route('market-data.export.csv') }}" class="card-hover p-5 flex items-center gap-4 group">
                    <div class="w-11 h-11 rounded-xl bg-accent-50 dark:bg-accent-500/10 flex items-center justify-center flex-shrink-0"><svg class="w-5 h-5 text-accent-600 dark:text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                    <div><h4 class="text-sm font-semibold text-slate-900 dark:text-white">Export Data</h4><p class="text-xs text-slate-500 mt-0.5">Download all data</p></div>
                </a>
            </div>

            <div class="mt-8 card">
                <div class="px-6 py-5 border-b border-slate-200/60 dark:border-slate-700/50"><h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300">Recent Activity</h3></div>
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead><tr><th>Product</th><th>Price</th><th>Location</th><th>Status</th><th>When</th><th class="text-right">Quick Actions</th></tr></thead>
                        <tbody>@foreach($recentEntries as $item)
                            <tr>
                                <td class="font-medium text-slate-900 dark:text-white">{{ $item->product_name }}</td>
                                <td class="font-semibold text-primary-600 dark:text-primary-400 tabular-nums">₹{{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->location }}</td>
                                <td><span class="badge badge-{{ $item->status }}">{{ ucfirst($item->status) }}</span></td>
                                <td class="text-xs text-slate-400">{{ $item->created_at->diffForHumans() }}</td>
                                <td class="text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        @if($item->status === 'pending')
                                            <form method="POST" action="{{ route('admin.data.approve', $item) }}">@csrf @method('PATCH')<button class="w-7 h-7 rounded-lg flex items-center justify-center text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 transition-colors" title="Approve"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></button></form>
                                            <form method="POST" action="{{ route('admin.data.reject', $item) }}">@csrf @method('PATCH')<button class="w-7 h-7 rounded-lg flex items-center justify-center text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors" title="Reject"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></form>
                                        @else
                                            <span class="text-[10px] font-bold text-slate-300 dark:text-slate-600 uppercase tracking-tighter">Processed</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDark = document.documentElement.classList.contains('dark');
        Chart.defaults.font.family = 'Inter'; Chart.defaults.color = isDark?'#94a3b8':'#64748b';
        new Chart(document.getElementById('submissionChart'), { type: 'bar', data: { labels: {!! json_encode($submissionTrends->pluck('trend_date')) !!}, datasets: [{ data: {!! json_encode($submissionTrends->pluck('count')) !!}, backgroundColor: isDark?'rgba(37,99,235,0.4)':'#2563eb', borderRadius: 8, maxBarThickness: 24 }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: isDark?'rgba(148,163,184,0.06)':'rgba(0,0,0,0.04)', drawBorder: false }, border: { display: false } }, x: { grid: { display: false }, ticks: { maxTicksLimit: 10, font: { size: 11 } }, border: { display: false } } } } });
        const catData = {!! json_encode($categoryStats) !!};
        const colors = ['#2563eb','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899','#14b8a6','#f97316','#6366f1','#84cc16'];
        new Chart(document.getElementById('adminCatChart'), { type: 'doughnut', data: { labels: catData.map(c=>c.name), datasets: [{ data: catData.map(c=>c.market_data_count), backgroundColor: colors, borderWidth: 0 }] }, options: { responsive: true, maintainAspectRatio: false, cutout: '70%', plugins: { legend: { position: 'right', labels: { boxWidth: 8, padding: 12, font: { size: 10 }, usePointStyle: true, pointStyle: 'circle' } } } } });
    });
    </script>
</x-app-layout>
