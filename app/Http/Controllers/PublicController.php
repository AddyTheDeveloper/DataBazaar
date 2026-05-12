<?php

namespace App\Http\Controllers;

use App\Models\MarketData;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PublicController extends Controller
{
    /**
     * Public home page with approved data summary and charts.
     */
    public function home()
    {
        $totalProducts = (float)(string)MarketData::approved()->distinct('product_name')->count('product_name');
        $totalLocations = (float)(string)MarketData::approved()->distinct('location')->count('location');
        $totalEntries = (float)(string)MarketData::approved()->count();
        $avgPrice = (float)(string)MarketData::approved()->avg('price');

        $recentData = MarketData::approved()
            ->with(['category', 'user'])
            ->latest('date')
            ->take(6)
            ->get();

        // Price trends for chart (last 30 days)
        $priceTrends = MarketData::approved()
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

        // Category distribution (Manual count for MongoDB compatibility)
        $categoryStats = Category::all()->map(function ($category) {
            $category->market_data_count = (float)(string)MarketData::approved()
                ->where('category_id', $category->id)
                ->count();
            return $category;
        });

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
