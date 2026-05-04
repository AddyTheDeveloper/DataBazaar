<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">Bookmarks</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Your saved market data entries</p>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($bookmarks->isEmpty())
                <div class="card p-16 text-center">
                    <svg class="w-12 h-12 text-slate-300 dark:text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-1">No bookmarks yet</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Save entries from the Explore page to see them here.</p>
                    <a href="{{ route('market-data.index') }}" class="btn-primary">Browse Data</a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 stagger-children">
                    @foreach($bookmarks as $bookmark)
                    @php $item = $bookmark->marketData; @endphp
                    <div class="card-hover p-6 group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <a href="{{ route('market-data.show', $item) }}" class="font-semibold text-slate-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors truncate block">{{ $item->product_name }}</a>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $item->category->name }}</p>
                            </div>
                            <span class="text-lg font-bold text-primary-600 dark:text-primary-400 tabular-nums whitespace-nowrap">₹{{ number_format($item->price, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between mt-5 pt-4 border-t border-slate-100 dark:border-slate-700/50">
                            <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>{{ $item->location }}
                            </div>
                            <form method="POST" action="{{ route('bookmarks.toggle', $item) }}">@csrf
                                <button class="text-xs font-medium text-red-500 hover:text-red-700 transition-colors">Remove</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
