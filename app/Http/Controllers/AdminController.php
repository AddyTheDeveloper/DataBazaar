<?php

namespace App\Http\Controllers;

use App\Models\MarketData;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Admin analytics dashboard.
     */
    public function dashboard()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalEntries = MarketData::count();
        $pendingEntries = MarketData::pending()->count();
        $approvedEntries = MarketData::approved()->count();
        $avgPrice = MarketData::approved()->avg('price');

        // Submissions over time (last 30 days)
        $submissionTrends = MarketData::where('created_at', '>=', now()->subDays(30))
            ->select(DB::raw('DATE(created_at) as trend_date'), DB::raw('COUNT(*) as count'))
            ->groupBy('trend_date')
            ->orderBy('trend_date')
            ->get();

        // Top products by submission count
        $topProducts = MarketData::approved()
            ->select('product_name', DB::raw('COUNT(*) as count'), DB::raw('AVG(price) as avg_price'))
            ->groupBy('product_name')
            ->orderByDesc('count')
            ->take(10)
            ->get();

        // Category distribution
        $categoryStats = Category::withCount(['marketData' => function ($q) {
            $q->where('status', 'approved');
        }])->get();

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
        $locations = MarketData::distinct()->pluck('location')->sort()->values();

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
        $query = User::withCount('marketData');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

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
