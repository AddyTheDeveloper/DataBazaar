<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('market-data.index') }}" class="w-9 h-9 rounded-xl flex items-center justify-center border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors"><svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">{{ $marketData->product_name }}</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">{{ $marketData->category->name }}</p>
                </div>
            </div>
            <span class="badge badge-{{ $marketData->status }}">{{ ucfirst($marketData->status) }}</span>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="card p-8">
                        <div class="flex items-start justify-between mb-8">
                            <div>
                                <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">{{ $marketData->product_name }}</h1>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $marketData->category->name }}</p>
                            </div>
                            <span class="text-3xl font-extrabold text-primary-600 dark:text-primary-400 tabular-nums">₹{{ number_format($marketData->price, 2) }}</span>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            @php $details = [['l'=>'Location','v'=>$marketData->location],['l'=>'Date','v'=>$marketData->date->format('d M Y')],['l'=>'Submitted by','v'=>$marketData->user->name],['l'=>'Added','v'=>$marketData->created_at->diffForHumans()]]; @endphp
                            @foreach($details as $d)
                            <div class="bg-slate-50 dark:bg-slate-700/30 rounded-xl p-4"><span class="text-[11px] font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">{{ $d['l'] }}</span><p class="text-sm font-semibold text-slate-900 dark:text-white mt-1.5">{{ $d['v'] }}</p></div>
                            @endforeach
                        </div>
                    </div>
                    @if($priceTrend->count() > 1)
                    <div class="card p-6">
                        <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-4">Price History</h3>
                        <div class="h-[220px]"><canvas id="priceTrendChart"></canvas></div>
                    </div>
                    @endif
                </div>
                <div class="space-y-6">
                    @if($marketData->user_id === auth()->id() || auth()->user()->isAdmin())
                    <div class="card p-5 space-y-2.5">
                        <a href="{{ route('market-data.edit', $marketData) }}" class="btn-primary w-full justify-center">Edit Entry</a>
                        <form method="POST" action="{{ route('market-data.share', $marketData) }}">@csrf<button type="submit" class="btn-accent w-full justify-center">Generate Share Link</button></form>
                        <form method="POST" action="{{ route('market-data.destroy', $marketData) }}" onsubmit="return confirm('Are you sure you want to delete this entry?')">@csrf @method('DELETE')<button type="submit" class="btn-danger w-full justify-center">Delete</button></form>
                    </div>
                    @endif
                    @if($priceComparison->isNotEmpty())
                    <div class="card p-5">
                        <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-4">Price Comparison</h3>
                        <div class="space-y-2.5">
                            @foreach($priceComparison as $comp)
                            <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/30 rounded-xl">
                                <div><p class="text-sm font-medium text-slate-900 dark:text-white">{{ $comp->location }}</p><p class="text-[11px] text-slate-500 mt-0.5">{{ \Carbon\Carbon::parse($comp->date)->format('d M Y') }}</p></div>
                                <span class="text-sm font-bold tabular-nums {{ $comp->price > $marketData->price ? 'text-red-500' : 'text-emerald-500' }}">₹{{ number_format($comp->price, 2) }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if($priceTrend->count() > 1)
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDark = document.documentElement.classList.contains('dark');
        Chart.defaults.font.family = 'Inter'; Chart.defaults.color = isDark ? '#94a3b8' : '#64748b';
        new Chart(document.getElementById('priceTrendChart'), {
            type: 'line',
            data: { labels: {!! json_encode($priceTrend->pluck('date')->map(fn($d) => $d->format('d M'))) !!}, datasets: [{ data: {!! json_encode($priceTrend->pluck('price')) !!}, borderColor: '#2563eb', backgroundColor: isDark?'rgba(37,99,235,0.08)':'rgba(37,99,235,0.06)', fill: true, tension: 0.4, borderWidth: 2, pointRadius: 0, pointHoverRadius: 5 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { grid: { color: isDark?'rgba(148,163,184,0.06)':'rgba(0,0,0,0.04)', drawBorder: false }, ticks: { callback: v=>'₹'+v, font: { size: 11 } }, border: { display: false } }, x: { grid: { display: false }, border: { display: false } } } }
        });
    });
    </script>
    @endif
</x-app-layout>
