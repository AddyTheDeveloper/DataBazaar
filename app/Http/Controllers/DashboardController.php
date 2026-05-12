<?php

namespace App\Http\Controllers;

use App\Models\MarketData;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * User dashboard with personal stats, recent submissions, and charts.
     */
    public function index()
    {
        $user = auth()->user();

        // User stats
        $totalEntries = (float)(string)$user->marketData()->count();
        $approvedEntries = (float)(string)$user->marketData()->approved()->count();
        $pendingEntries = (float)(string)$user->marketData()->pending()->count();
        $avgPrice = (float)(string)$user->marketData()->avg('price');

        // Recent submissions
        $recentData = $user->marketData()
            ->with('category')
            ->latest('created_at')
            ->take(5)
            ->get();

        // User's price trends (last 30 days)
        $priceTrends = $user->marketData()
            ->where('date', '>=', now()->subDays(30))
            ->orderBy('date')
            ->get()
            ->groupBy(function($item) {
                return Carbon::parse($item->date)->format('Y-m-d');
            })
            ->map(function($group, $date) {
                return (object)[
                    'trend_date' => $date,
                    'avg_price' => (float)(string)$group->avg('price')
                ];
            })
            ->values();

        // Category breakdown for user's data (Manual count/filter for MongoDB compatibility)
        $categoryBreakdown = Category::all()->map(function ($category) use ($user) {
            $category->market_data_count = (float)(string)MarketData::where('user_id', $user->id)
                ->where('category_id', $category->id)
                ->count();
            return $category;
        })->filter(function ($category) {
            return $category->market_data_count > 0;
        })->values();

        return view('dashboard', compact(
            'totalEntries', 'approvedEntries', 'pendingEntries', 'avgPrice',
            'recentData', 'priceTrends', 'categoryBreakdown'
        ));
    }
}
