<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">Explore</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Browse and filter market data</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('market-data.export.csv', request()->query()) }}" class="btn-ghost btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    CSV
                </a>
                <a href="{{ route('market-data.create') }}" class="btn-primary btn-sm">+ New</a>
            </div>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('import_errors'))
            <div class="mb-6 card p-4 border-l-4 border-amber-400">
                <h4 class="text-sm font-semibold text-amber-800 dark:text-amber-200 mb-1">Import Warnings</h4>
                <ul class="text-xs text-amber-700 dark:text-amber-300 space-y-0.5">@foreach(session('import_errors') as $err)<li>• {{ $err }}</li>@endforeach</ul>
            </div>
            @endif

            {{-- Filters --}}
            <div class="card p-5 mb-6">
                <form method="GET" action="{{ route('market-data.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-7 gap-3 items-end">
                    <div class="lg:col-span-2"><input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="form-input-custom text-sm"></div>
                    <div><select name="category" class="form-input-custom text-sm"><option value="">All Categories</option>@foreach($categories as $cat)<option value="{{ $cat->id }}" {{ request('category')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>@endforeach</select></div>
                    <div><select name="location" class="form-input-custom text-sm"><option value="">All Locations</option>@foreach($locations as $loc)<option value="{{ $loc }}" {{ request('location')==$loc?'selected':'' }}>{{ $loc }}</option>@endforeach</select></div>
                    <div><select name="sort_by" class="form-input-custom text-sm"><option value="created_at" {{ request('sort_by')=='created_at'?'selected':'' }}>Latest</option><option value="price" {{ request('sort_by')=='price'?'selected':'' }}>Price</option><option value="date" {{ request('sort_by')=='date'?'selected':'' }}>Date</option></select></div>
                    <div><select name="direction" class="form-input-custom text-sm"><option value="desc" {{ request('direction')=='desc'?'selected':'' }}>Desc</option><option value="asc" {{ request('direction')=='asc'?'selected':'' }}>Asc</option></select></div>
                    <div class="flex gap-2"><button type="submit" class="btn-primary btn-sm flex-1">Filter</button><a href="{{ route('market-data.index') }}" class="btn-ghost btn-sm">Reset</a></div>
                </form>
            </div>

            {{-- Table --}}
            <div class="card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead><tr><th>Product</th><th>Price</th><th>Category</th><th>Location</th><th>Date</th><th>Status</th><th>By</th><th class="text-right">Actions</th></tr></thead>
                        <tbody>
                            @forelse($data as $item)
                            <tr>
                                <td><a href="{{ route('market-data.show', $item) }}" class="font-medium text-slate-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 transition-colors">{{ $item->product_name }}</a></td>
                                <td class="font-semibold text-primary-600 dark:text-primary-400 tabular-nums">₹{{ number_format($item->price, 2) }}</td>
                                <td><span class="badge badge-approved">{{ $item->category->name }}</span></td>
                                <td>{{ $item->location }}</td>
                                <td class="tabular-nums">{{ $item->date->format('d M Y') }}</td>
                                <td><span class="badge badge-{{ $item->status }}">{{ ucfirst($item->status) }}</span></td>
                                <td class="text-xs text-slate-400">{{ $item->user->name }}</td>
                                <td class="text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <form method="POST" action="{{ route('bookmarks.toggle', $item) }}" class="inline">@csrf
                                            <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors" title="Bookmark">
                                                @if(in_array($item->id, $bookmarkedIds))
                                                <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                                                @else
                                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                                                @endif
                                            </button>
                                        </form>
                                        @if($item->user_id === auth()->id() || auth()->user()->isAdmin())
                                        <a href="{{ route('market-data.edit', $item) }}" class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors" title="Edit">
                                            <svg class="w-4 h-4 text-slate-400 hover:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form method="POST" action="{{ route('market-data.destroy', $item) }}" class="inline" onsubmit="return confirm('Delete this entry?')">@csrf @method('DELETE')
                                            <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors" title="Delete">
                                                <svg class="w-4 h-4 text-slate-400 hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center py-16 text-slate-400">No data found. <a href="{{ route('market-data.create') }}" class="text-primary-600 hover:underline">Add your first entry</a></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-slate-200/60 dark:border-slate-700/50">{{ $data->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
