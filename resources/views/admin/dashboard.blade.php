<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-tight">
                    {{ __('Admin Analytics') }}
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Platform overview and activity metrics</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.data') }}" class="btn-secondary btn-sm flex items-center gap-1.5 shadow-sm">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    Data Moderation
                </a>
                <a href="{{ route('admin.users') }}" class="btn-ghost btn-sm flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    User Management
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Dynamic Pending Approvals Alert Banner -->
            @if($pendingEntries > 0)
            <div class="glass-card mb-8 border-l-4 border-amber-500 overflow-hidden relative stagger-children">
                <div class="absolute right-0 top-0 translate-x-1/4 -translate-y-1/4 w-64 h-64 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>
                <div class="p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-white">Pending Moderation Requests</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">There are <span class="font-semibold text-amber-600 dark:text-amber-400">{{ $pendingEntries }} submissions</span> waiting for your review. Please approve or reject them to update the public explorer.</p>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('admin.data', ['status' => 'pending']) }}" class="btn-accent btn-sm whitespace-nowrap shadow-md shadow-accent-600/10">
                            Review Submissions
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 stagger-children">
                @php 
                    $adminStats = [
                        [
                            'v' => number_format((float)$totalUsers), 
                            'l' => 'Total Users', 
                            'c' => 'text-primary-600 dark:text-primary-400',
                            'bg' => 'bg-primary-500/5',
                            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>'
                        ],
                        [
                            'v' => number_format((float)$totalEntries), 
                            'l' => 'Total Submissions', 
                            'c' => 'text-slate-700 dark:text-slate-300',
                            'bg' => 'bg-slate-500/5',
                            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>'
                        ],
                        [
                            'v' => number_format((float)$approvedEntries), 
                            'l' => 'Approved Insights', 
                            'c' => 'text-emerald-600 dark:text-emerald-400',
                            'bg' => 'bg-emerald-500/5',
                            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
                        ],
                        [
                            'v' => number_format((float)$pendingEntries), 
                            'l' => 'Pending Reviews', 
                            'c' => 'text-amber-600 dark:text-amber-400',
                            'bg' => 'bg-amber-500/5',
                            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
                        ],
                        [
                            'v' => '₹' . number_format((float)($avgPrice??0), 0), 
                            'l' => 'Average Price', 
                            'c' => 'text-violet-600 dark:text-violet-400',
                            'bg' => 'bg-violet-500/5',
                            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8h6m-5 0a3 3 0 110 6H9l3 3m-3-6h6m6 1a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
                        ]
                    ];
                @endphp
                @foreach($adminStats as $s)
                <div class="stats-card flex items-center justify-between p-5 relative overflow-hidden group">
                    <div class="absolute right-0 top-0 translate-x-1/3 -translate-y-1/3 w-16 h-16 {{ $s['bg'] }} rounded-full blur-xl pointer-events-none group-hover:scale-150 transition-all duration-300"></div>
                    <div class="text-left">
                        <p class="text-2xl font-black text-slate-900 dark:text-white tracking-tight tabular-nums">{{ $s['v'] }}</p>
                        <p class="text-[11px] font-semibold text-slate-400 dark:text-slate-500 mt-1 uppercase tracking-wider leading-tight">{{ $s['l'] }}</p>
                    </div>
                    <div class="p-3 {{ $s['bg'] }} {{ $s['c'] }} rounded-xl transition-all duration-300 group-hover:scale-110">
                        {!! $s['icon'] !!}
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Dashboard Charts & Tables -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
                <!-- Trend Chart Card -->
                <div class="glass-card p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                            Submission Trends
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">Daily data submissions over the last 30 days</p>
                    </div>
                    
                    <div class="relative h-64 mt-4 px-2">
                        <!-- Horizontal Grid Lines -->
                        <div class="absolute inset-0 flex flex-col justify-between pointer-events-none text-[10px] text-slate-300 dark:text-slate-700/50">
                            <div class="border-b border-dashed border-slate-200 dark:border-slate-800/80 w-full pb-1 flex justify-between"><span>Max</span></div>
                            <div class="border-b border-dashed border-slate-100 dark:border-slate-800/50 w-full pb-1"></div>
                            <div class="border-b border-dashed border-slate-100 dark:border-slate-800/50 w-full pb-1"></div>
                            <div class="border-b border-dashed border-slate-100 dark:border-slate-800/50 w-full pb-1"></div>
                            <div class="border-b border-slate-200 dark:border-slate-800 w-full pb-1"><span>0</span></div>
                        </div>

                        <!-- Bar Columns -->
                        <div class="absolute inset-0 flex items-end gap-1.5 pt-6 pb-2">
                            @php $maxTrend = $submissionTrends->max('count') ?: 1; @endphp
                            @foreach($submissionTrends as $t)
                            <div class="flex-1 bg-primary-500/20 dark:bg-primary-500/10 rounded-t hover:bg-primary-500/50 hover:shadow-lg hover:shadow-primary-500/10 transition-all group relative cursor-pointer" style="height: {{ max(($t->count / $maxTrend) * 100, 2) }}%">
                                <div class="opacity-0 group-hover:opacity-100 absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-900/90 dark:bg-slate-800/95 backdrop-blur text-white text-[10px] font-semibold py-1.5 px-2.5 rounded-lg border border-white/10 shadow-lg whitespace-nowrap pointer-events-none transition-all duration-150 z-20">
                                    {{ (int)$t->count }} submissions
                                    <div class="text-[8px] text-slate-300 font-normal mt-0.5">{{ $t->trend_date }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- X-Axis Labels -->
                    <div class="flex justify-between text-[10px] font-medium text-slate-400 dark:text-slate-500 mt-3 px-2 border-t border-slate-100 dark:border-slate-800/60 pt-2">
                        <span>{{ $submissionTrends->first()->short_date }}</span>
                        <span>{{ $submissionTrends[14]->short_date }}</span>
                        <span>{{ $submissionTrends->last()->short_date }}</span>
                    </div>
                </div>

                <!-- Recent Submissions Card -->
                <div class="glass-card p-6 flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Recent Submissions</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Latest market data entries submitted by users</p>
                        </div>
                        <a href="{{ route('admin.data') }}" class="btn-ghost btn-sm text-xs flex items-center gap-1">
                            View All
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left border-collapse">
                            <thead>
                                <tr class="text-slate-400 text-xs border-b border-slate-100 dark:border-slate-800/80 uppercase tracking-wider font-semibold">
                                    <th class="pb-3 text-left">Product</th>
                                    <th class="pb-3 text-left">Price</th>
                                    <th class="pb-3 text-left">Location</th>
                                    <th class="pb-3 text-left">Status</th>
                                    <th class="pb-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                                @forelse($recentEntries as $item)
                                <tr class="hover:bg-slate-50/40 dark:hover:bg-slate-800/20 transition-all">
                                    <td class="py-3 font-medium text-slate-900 dark:text-white">
                                        <div class="flex flex-col">
                                            <span>{{ $item->product_name }}</span>
                                            <span class="text-[10px] text-slate-400 font-normal mt-0.5">by {{ $item->user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 font-bold text-primary-600 dark:text-primary-400 tabular-nums">₹{{ number_format((float)$item->price, 2) }}</td>
                                    <td class="py-3 text-slate-600 dark:text-slate-400">{{ $item->location }}</td>
                                    <td class="py-3">
                                        <span class="badge badge-{{ $item->status }}">{{ ucfirst($item->status) }}</span>
                                    </td>
                                    <td class="text-right py-3">
                                        <div class="flex items-center justify-end gap-1.5">
                                            @if($item->status === 'pending')
                                            <form method="POST" action="{{ route('admin.data.approve', $item) }}" class="inline">@csrf @method('PATCH')
                                                <button class="text-emerald-600 hover:text-emerald-700 bg-emerald-500/5 hover:bg-emerald-500/10 p-1.5 rounded-md transition-colors" title="Approve">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.data.reject', $item) }}" class="inline">@csrf @method('PATCH')
                                                <button class="text-red-600 hover:text-red-700 bg-red-500/5 hover:bg-red-500/10 p-1.5 rounded-md transition-colors" title="Reject">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </button>
                                            </form>
                                            @else
                                            <span class="text-[11px] text-slate-400 italic">Actioned</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-slate-400">No recent submissions.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
