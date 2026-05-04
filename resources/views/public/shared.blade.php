<x-public-layout title="Shared Data - {{ $marketData->product_name }}">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="card p-8">
            <div class="flex items-center gap-2 mb-6">
                <div class="w-8 h-8 rounded-lg bg-accent-50 dark:bg-accent-500/10 flex items-center justify-center"><svg class="w-4 h-4 text-accent-600 dark:text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg></div>
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wider">Shared Entry</span>
            </div>

            <div class="flex items-start justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">{{ $marketData->product_name }}</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $marketData->category->name }}</p>
                </div>
                <span class="text-3xl font-extrabold text-primary-600 dark:text-primary-400 tabular-nums">₹{{ number_format($marketData->price, 2) }}</span>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-8">
                @php $details = [['l'=>'Location','v'=>$marketData->location],['l'=>'Date','v'=>$marketData->date->format('d M Y')],['l'=>'Submitted by','v'=>$marketData->user->name]]; @endphp
                @foreach($details as $d)
                <div class="bg-slate-50 dark:bg-slate-700/30 rounded-xl p-4"><span class="text-[11px] font-medium text-slate-500 uppercase tracking-wider">{{ $d['l'] }}</span><p class="text-sm font-semibold text-slate-900 dark:text-white mt-1.5">{{ $d['v'] }}</p></div>
                @endforeach
            </div>

            <div class="border-t border-slate-200/60 dark:border-slate-700/50 pt-6 text-center">
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Want to explore more market data?</p>
                <a href="{{ route('register') }}" class="btn-primary">Join DataBazaar</a>
            </div>
        </div>
    </div>
</x-public-layout>
