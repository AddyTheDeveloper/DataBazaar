<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">User Management</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Manage platform users</p>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card p-4 mb-6">
                <form method="GET" action="{{ route('admin.users') }}" class="flex gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..." class="form-input-custom text-sm flex-1">
                    <button type="submit" class="btn-primary btn-sm">Search</button>
                </form>
            </div>
            <div class="card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead><tr><th>User</th><th>Email</th><th>Role</th><th>Entries</th><th>Status</th><th>Joined</th><th class="text-right">Actions</th></tr></thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white text-xs font-semibold shadow-inner-light">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                        <span class="font-medium text-slate-900 dark:text-white">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="text-xs text-slate-500">{{ $user->email }}</td>
                                <td><span class="badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
                                <td class="tabular-nums">{{ $user->market_data_count }}</td>
                                <td>@if($user->is_blocked)<span class="badge badge-rejected">Blocked</span>@else<span class="badge badge-approved">Active</span>@endif</td>
                                <td class="text-xs text-slate-400 tabular-nums">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="text-right">
                                    @if(!$user->isAdmin())
                                    <div class="flex items-center justify-end gap-1.5">
                                        @if($user->is_blocked)
                                        <form method="POST" action="{{ route('admin.users.unblock', $user) }}">@csrf @method('PATCH')<button class="text-[11px] font-semibold text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 rounded-lg px-2.5 py-1 transition-colors">Unblock</button></form>
                                        @else
                                        <form method="POST" action="{{ route('admin.users.block', $user) }}">@csrf @method('PATCH')<button class="text-[11px] font-semibold text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-500/10 rounded-lg px-2.5 py-1 transition-colors">Block</button></form>
                                        @endif
                                        <form method="POST" action="{{ route('admin.users.delete', $user) }}" onsubmit="return confirm('Delete user {{ $user->name }}?')">@csrf @method('DELETE')<button class="text-[11px] font-semibold text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg px-2.5 py-1 transition-colors">Delete</button></form>
                                    </div>
                                    @else
                                    <span class="text-xs text-slate-400">—</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-slate-200/60 dark:border-slate-700/50">{{ $users->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
