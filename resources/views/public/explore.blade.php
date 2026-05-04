<x-public-layout title="Explore Market Data">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight">Explore Market Data</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Browse and filter approved market price data</p>
        </div>

        <div class="card p-5 mb-6">
            <form method="GET" action="{{ route('public.explore') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3 items-end">
                <div class="lg:col-span-2"><input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="form-input-custom text-sm"></div>
                <div><select name="category" class="form-input-custom text-sm"><option value="">All Categories</option>@foreach($categories as $cat)<option value="{{ $cat->id }}" {{ request('category')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>@endforeach</select></div>
                <div><select name="location" class="form-input-custom text-sm"><option value="">All Locations</option>@foreach($locations as $loc)<option value="{{ $loc }}" {{ request('location')==$loc?'selected':'' }}>{{ $loc }}</option>@endforeach</select></div>
                <div><select name="sort_by" class="form-input-custom text-sm"><option value="date" {{ request('sort_by')=='date'?'selected':'' }}>Date</option><option value="price" {{ request('sort_by')=='price'?'selected':'' }}>Price</option></select></div>
                <div class="flex gap-2"><button type="submit" class="btn-primary btn-sm flex-1">Filter</button><a href="{{ route('public.explore') }}" class="btn-ghost btn-sm">Reset</a></div>
            </form>
        </div>

        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead><tr><th>Product</th><th>Price</th><th>Category</th><th>Location</th><th>Date</th></tr></thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr>
                            <td class="font-medium text-slate-900 dark:text-white">{{ $item->product_name }}</td>
                            <td class="font-semibold text-primary-600 dark:text-primary-400 tabular-nums">₹{{ number_format($item->price, 2) }}</td>
                            <td><span class="badge badge-approved">{{ $item->category->name }}</span></td>
                            <td>{{ $item->location }}</td>
                            <td class="tabular-nums">{{ $item->date->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-12 text-slate-400">No data available yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-slate-200/60 dark:border-slate-700/50">{{ $data->links() }}</div>
        </div>
    </div>
</x-public-layout>
