<?php

namespace App\Http\Controllers;

use App\Models\MarketData;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Admin analytics dashboard.
     */
    public function dashboard()
    {
        $totalUsers = (float)(string)User::where('role', 'user')->count();
        $totalEntries = (float)(string)MarketData::count();
        $pendingEntries = (float)(string)MarketData::pending()->count();
        $approvedEntries = (float)(string)MarketData::approved()->count();
        $avgPrice = (float)(string)MarketData::approved()->avg('price');

        // Submissions over time (last 30 days)
        $rawTrends = MarketData::where('created_at', '>=', now()->subDays(30))
            ->get()
            ->groupBy(function($item) {
                return Carbon::parse($item->created_at)->format('Y-m-d');
            });

        $submissionTrends = collect();
        for ($i = 29; $i >= 0; $i--) {
            $dateString = now()->subDays($i)->format('Y-m-d');
            $group = $rawTrends->get($dateString);
            $submissionTrends->push((object)[
                'trend_date' => $dateString,
                'count' => $group ? (float)(string)$group->count() : 0.0,
                'short_date' => now()->subDays($i)->format('d M')
            ]);
        }

        // Top products by submission count
        $topProducts = MarketData::approved()
            ->get()
            ->groupBy('product_name')
            ->map(function($group, $name) {
                return (object)[
                    'product_name' => $name,
                    'count' => (float)(string)$group->count(),
                    'avg_price' => (float)(string)$group->avg('price')
                ];
            })
            ->sortByDesc('count')
            ->take(10)
            ->values();

        // Category distribution (Manual count for MongoDB compatibility)
        $categoryStats = Category::all()->map(function ($category) {
            $category->market_data_count = (float)(string)MarketData::approved()
                ->where('category_id', $category->id)
                ->count();
            return $category;
        });

        // Recent activity
        $recentEntries = MarketData::with(['user', 'category'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalEntries', 'pendingEntries', 'approvedEntries', 'avgPrice',
            'submissionTrends', 'topProducts', 'categoryStats', 'recentEntries'
        ));
    }

    /**
     * View all market data with approve/reject actions.
     */
    public function manageData(Request $request)
    {
        $query = MarketData::with(['user', 'category']);

        $query->filter($request->only(['search', 'category', 'location', 'date_from', 'date_to', 'status']));
        $query->sorted($request->input('sort_by'), $request->input('direction', 'desc'));

        $data = $query->paginate(20)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $locations = collect(MarketData::raw()->distinct('location'))->sort()->values();

        return view('admin.data', compact('data', 'categories', 'locations'));
    }

    /**
     * Approve a market data entry.
     */
    public function approveData(MarketData $marketData)
    {
        $marketData->update(['status' => 'approved']);

        return back()->with('success', "Entry '{$marketData->product_name}' approved.");
    }

    /**
     * Reject a market data entry.
     */
    public function rejectData(MarketData $marketData)
    {
        $marketData->update(['status' => 'rejected']);

        return back()->with('success', "Entry '{$marketData->product_name}' rejected.");
    }

    /**
     * List all users with management options.
     */
    public function manageUsers(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        
        // Manual count for the current page of users
        foreach ($users as $user) {
            $user->market_data_count = (float)(string)MarketData::where('user_id', $user->id)->count();
        }

        return view('admin.users', compact('users'));
    }

    /**
     * Block a user.
     */
    public function blockUser(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot block an admin user.');
        }

        $user->update(['is_blocked' => true]);

        return back()->with('success', "User '{$user->name}' has been blocked.");
    }

    /**
     * Unblock a user.
     */
    public function unblockUser(User $user)
    {
        $user->update(['is_blocked' => false]);

        return back()->with('success', "User '{$user->name}' has been unblocked.");
    }

    /**
     * Delete a user and their data.
     */
    public function deleteUser(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot delete an admin user.');
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }
}
