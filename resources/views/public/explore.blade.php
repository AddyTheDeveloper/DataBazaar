<x-public-layout title="Explore Market Data">
    <section class="relative overflow-hidden border-b border-white/60 dark:border-white/10">
        <div class="absolute inset-0 bg-[linear-gradient(180deg,#f8fafc_0%,#eef6ff_100%)] dark:bg-[linear-gradient(180deg,#020617_0%,#0f172a_100%)]"></div>
        <div class="absolute inset-0 bg-grid opacity-35 dark:opacity-15"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-primary-600 dark:text-primary-300">Open explorer</p>
                    <h1 class="mt-2 text-3xl sm:text-4xl font-extrabold text-slate-950 dark:text-white tracking-tight">Approved market data</h1>
                    <p class="mt-3 text-sm sm:text-base text-slate-600 dark:text-slate-300 max-w-2xl">Search products, compare locations, and scan recent approved price observations.</p>
                </div>
                <div class="glass-card p-4 min-w-[220px]">
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Results</p>
                    <p class="mt-1 text-2xl font-bold text-slate-950 dark:text-white">{{ number_format($data->total()) }}</p>
                </div>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="glass-card p-5 mb-6">
            <form method="GET" action="{{ route('public.explore') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3 items-end">
                <div class="lg:col-span-2">
                    <label class="form-label" for="search">Search</label>
                    <input id="search" type="text" name="search" value="{{ request('search') }}" placeholder="Product name" class="form-input-custom text-sm">
                </div>
                <div>
                    <label class="form-label" for="category">Category</label>
                    <select id="category" name="category" class="form-input-custom text-sm">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="location">Location</label>
                    <select id="location" name="location" class="form-input-custom text-sm">
                        <option value="">All Locations</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="sort_by">Sort</label>
                    <select id="sort_by" name="sort_by" class="form-input-custom text-sm">
                        <option value="date" {{ request('sort_by') == 'date' ? 'selected' : '' }}>Date</option>
                        <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Price</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="btn-primary btn-sm flex-1">Filter</button>
                    <a href="{{ route('public.explore') }}" class="btn-ghost btn-sm">Reset</a>
                </div>
            </form>
        </div>

        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr><th>Product</th><th>Price</th><th>Category</th><th>Location</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                            <tr>
                                <td class="font-medium text-slate-950 dark:text-white">{{ $item->product_name }}</td>
                                <td class="font-semibold text-primary-600 dark:text-primary-300 tabular-nums">&#8377;{{ number_format((float) $item->price, 2) }}</td>
                                <td><span class="badge badge-approved">{{ $item->category->name }}</span></td>
                                <td>{{ $item->location }}</td>
                                <td class="tabular-nums">{{ $item->date->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-12 text-slate-400">No data matched your filters.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-slate-200/60 dark:border-white/10">{{ $data->links() }}</div>
        </div>
    </div>
</x-public-layout>
