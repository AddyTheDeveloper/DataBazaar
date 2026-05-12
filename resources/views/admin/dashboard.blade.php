<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Admin Analytics') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 stagger-children">
                @php $adminStats = [['v'=>number_format((float)$totalUsers),'l'=>'Users','c'=>'primary'],['v'=>number_format((float)$totalEntries),'l'=>'Entries','c'=>'slate'],['v'=>number_format((float)$approvedEntries),'l'=>'Approved','c'=>'emerald'],['v'=>number_format((float)$pendingEntries),'l'=>'Pending','c'=>'amber'],['v'=>'₹'.number_format((float)($avgPrice??0),0),'l'=>'Avg Price','c'=>'violet']]; @endphp
                @foreach($adminStats as $s)
                <div class="stats-card text-center">
                     <p class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight tabular-nums">{{ $s['v'] }}</p>
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mt-1 uppercase tracking-wider">{{ $s['l'] }}</p>
                </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
                <div class="glass-panel p-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                        Submission Trends (Last 30 Days)
                    </h3>
                    <div class="h-64 flex items-end gap-1 px-2">
                        @php $maxTrend = $submissionTrends->max('count') ?: 1; @endphp
                        @foreach($submissionTrends as $t)
                        <div class="flex-1 bg-primary-500/20 dark:bg-primary-500/10 rounded-t-sm hover:bg-primary-500/40 transition-all group relative" style="height: {{ ($t->count / $maxTrend) * 100 }}%">
                            <div class="opacity-0 group-hover:opacity-100 absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[10px] py-1 px-2 rounded whitespace-nowrap pointer-events-none transition-opacity">
                                {{ $t->count }} on {{ $t->trend_date }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="glass-panel p-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6">Recent Submissions</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead>
                                <tr class="text-slate-500 border-b border-slate-100 dark:border-slate-700/50">
                                    <th class="pb-3 font-medium">Product</th>
                                    <th class="pb-3 font-medium">Price</th>
                                    <th class="pb-3 font-medium">Location</th>
                                    <th class="pb-3 font-medium">Status</th>
                                    <th class="pb-3 font-medium">Time</th>
                                </tr>
                            </thead>
                            <tbody>@foreach($recentEntries as $item)
                                <tr>
                                    <td class="font-medium text-slate-900 dark:text-white">{{ $item->product_name }}</td>
                                    <td class="font-semibold text-primary-600 dark:text-primary-400 tabular-nums">₹{{ number_format((float)$item->price, 2) }}</td>
                                    <td>{{ $item->location }}</td>
                                    <td><span class="badge badge-{{ $item->status }}">{{ ucfirst($item->status) }}</span></td>
                                    <td class="text-xs text-slate-400">{{ $item->created_at->diffForHumans() }}</td>
                                </tr>@endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
