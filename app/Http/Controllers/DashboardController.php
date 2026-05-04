<?php

namespace App\Http\Controllers;

use App\Models\MarketData;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * User dashboard with personal stats, recent submissions, and charts.
     */
    public function index()
    {
        $user = auth()->user();

        // User stats
        $totalEntries = $user->marketData()->count();
        $approvedEntries = $user->marketData()->approved()->count();
        $pendingEntries = $user->marketData()->pending()->count();
        $avgPrice = $user->marketData()->avg('price');

        // Recent submissions
        $recentData = $user->marketData()
            ->with('category')
            ->latest('created_at')
            ->take(5)
            ->get();

        // User's price trends (last 30 days)
        $priceTrends = $user->marketData()
            ->where('date', '>=', now()->subDays(30))
            ->select(DB::raw('DATE(date) as trend_date'), DB::raw('AVG(price) as avg_price'))
            ->groupBy('trend_date')
            ->orderBy('trend_date')
            ->get();

        // Category breakdown for user's data
        $categoryBreakdown = Category::whereHas('marketData', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->withCount(['marketData' => function ($q) use ($user) {
            $q->where('user_id', $user->id);
        }])->get();

        return view('dashboard', compact(
            'totalEntries', 'approvedEntries', 'pendingEntries', 'avgPrice',
            'recentData', 'priceTrends', 'categoryBreakdown'
        ));
    }
}
