<?php

namespace App\Http\Controllers;

use App\Models\MarketData;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    /**
     * Public home page with approved data summary and charts.
     */
    public function home()
    {
        $totalProducts = MarketData::approved()->distinct('product_name')->count('product_name');
        $totalLocations = MarketData::approved()->distinct('location')->count('location');
        $totalEntries = MarketData::approved()->count();
        $avgPrice = MarketData::approved()->avg('price');

        $recentData = MarketData::approved()
            ->with(['category', 'user'])
            ->latest('date')
            ->take(6)
            ->get();

        // Price trends for chart (last 30 days, grouped by date)
        $priceTrends = MarketData::approved()
            ->where('date', '>=', now()->subDays(30))
            ->select(DB::raw('DATE(date) as trend_date'), DB::raw('AVG(price) as avg_price'))
            ->groupBy('trend_date')
            ->orderBy('trend_date')
            ->get();

        // Category distribution
        $categoryStats = Category::withCount(['marketData' => function ($q) {
            $q->where('status', 'approved');
        }])->get();

        return view('public.home', compact(
            'totalProducts', 'totalLocations', 'totalEntries', 'avgPrice',
            'recentData', 'priceTrends', 'categoryStats'
        ));
    }

    /**
     * Public data explorer (approved data only).
     */
    public function explore(Request $request)
    {
        $query = MarketData::approved()->with(['category', 'user']);

        $query->filter($request->only(['search', 'category', 'location', 'date_from', 'date_to']));
        $query->sorted($request->input('sort_by'), $request->input('direction', 'desc'));

        $data = $query->paginate(15)->withQueryString();

        $categories = Category::orderBy('name')->get();
        $locations = MarketData::approved()->distinct()->pluck('location')->sort()->values();

        return view('public.explore', compact('data', 'categories', 'locations'));
    }
}
