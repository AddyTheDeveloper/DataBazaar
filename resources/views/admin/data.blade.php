<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">Data Moderation</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Approve or reject submissions</p>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card p-4 mb-6">
                <form method="GET" action="{{ route('admin.data') }}" class="flex flex-wrap gap-3 items-end">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="form-input-custom text-sm w-44">
                    <select name="status" class="form-input-custom text-sm w-36"><option value="">All Status</option><option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option><option value="approved" {{ request('status')=='approved'?'selected':'' }}>Approved</option><option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Rejected</option></select>
                    <select name="category" class="form-input-custom text-sm w-40"><option value="">All Categories</option>@foreach($categories as $cat)<option value="{{ $cat->id }}" {{ request('category')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>@endforeach</select>
                    <button type="submit" class="btn-primary btn-sm">Filter</button>
                    <a href="{{ route('admin.data') }}" class="btn-ghost btn-sm">Reset</a>
                </form>
            </div>
            <div class="card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead><tr><th>Product</th><th>Price</th><th>Category</th><th>Location</th><th>User</th><th>Date</th><th>Status</th><th class="text-right">Actions</th></tr></thead>
                        <tbody>
                            @forelse($data as $item)
                            <tr>
                                <td class="font-medium text-slate-900 dark:text-white">{{ $item->product_name }}</td>
                                <td class="font-semibold text-primary-600 dark:text-primary-400 tabular-nums">₹{{ number_format($item->price, 2) }}</td>
                                <td><span class="badge badge-approved">{{ $item->category->name }}</span></td>
                                <td>{{ $item->location }}</td>
                                <td class="text-xs text-slate-400">{{ $item->user->name }}</td>
                                <td class="tabular-nums">{{ $item->date->format('d M Y') }}</td>
                                <td><span class="badge badge-{{ $item->status }}">{{ ucfirst($item->status) }}</span></td>
                                <td class="text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        @if($item->status !== 'approved')
                                        <form method="POST" action="{{ route('admin.data.approve', $item) }}">@csrf @method('PATCH')<button class="btn-sm text-[11px] font-semibold text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 rounded-lg px-2.5 py-1 transition-colors">Approve</button></form>
                                        @endif
                                        @if($item->status !== 'rejected')
                                        <form method="POST" action="{{ route('admin.data.reject', $item) }}">@csrf @method('PATCH')<button class="btn-sm text-[11px] font-semibold text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg px-2.5 py-1 transition-colors">Reject</button></form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center py-12 text-slate-400">No entries found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-slate-200/60 dark:border-slate-700/50">{{ $data->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
