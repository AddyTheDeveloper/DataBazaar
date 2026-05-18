<?php

namespace App\Http\Controllers;

use App\Models\MarketData;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IntelligenceController extends Controller
{
    /**
     * Display the Price Comparison & Trend Analysis dashboard.
     */
    public function index(Request $request)
    {
        // 1. Fetch all unique approved product names using raw MongoDB distinct query
        $products = collect(MarketData::raw()->distinct('product_name', ['status' => 'approved']))
            ->sort()
            ->values();

        $selectedProduct = $request->get('product');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        // Check if selected product exists in the list
        if ($selectedProduct && !$products->contains($selectedProduct)) {
            $selectedProduct = null;
        }

        $intelligenceData = null;

        if ($selectedProduct) {
            // 2. Fetch all approved market data for this product
            $query = MarketData::approved()->where('product_name', $selectedProduct);

            if ($dateFrom) {
                $query->where('date', '>=', Carbon::parse($dateFrom));
            }
            if ($dateTo) {
                $query->where('date', '<=', Carbon::parse($dateTo));
            }

            $entries = $query->orderBy('date', 'asc')->get();

            if ($entries->isNotEmpty()) {
                // Group by location (state/city)
                $groupedByLocation = $entries->groupBy('location');
                
                $locationsData = collect();
                
                foreach ($groupedByLocation as $location => $locEntries) {
                    // Sort items by date descending (most recent first)
                    $sortedEntries = $locEntries->sortByDesc('date')->values();
                    
                    $current = $sortedEntries[0];
                    $previous = $sortedEntries->count() > 1 ? $sortedEntries[1] : null;

                    $currentPrice = (float)$current->price;
                    $previousPrice = $previous ? (float)$previous->price : null;
                    
                    $difference = $previousPrice !== null ? $currentPrice - $previousPrice : 0.0;
                    $percentageChange = $previousPrice ? ($difference / $previousPrice) * 100 : 0.0;

                    $locationsData->put($location, (object)[
                        'location' => $location,
                        'current_price' => $currentPrice,
                        'previous_price' => $previousPrice,
                        'difference' => $difference,
                        'percentage_change' => $percentageChange,
                        'last_updated' => Carbon::parse($current->date)->format('d M Y'),
                        'trend' => $difference > 0 ? 'rising' : ($difference < 0 ? 'dropping' : 'stable')
                    ]);
                }

                // Sort by current price ascending
                $locationsData = $locationsData->sortBy('current_price')->values();

                // 3. Compute Smart Analytics Insights
                $cheapest = $locationsData->first();
                $expensive = $locationsData->last();
                
                $currentPrices = $locationsData->pluck('current_price')->toArray();
                $avgPrice = count($currentPrices) > 0 ? array_sum($currentPrices) / count($currentPrices) : 0.0;

                // Price Volatility calculation (Coefficient of Variation)
                $volatility = 'Stable';
                $cv = 0.0;
                $pricesCount = count($currentPrices);
                
                if ($pricesCount > 1 && $avgPrice > 0) {
                    $variance = 0.0;
                    foreach ($currentPrices as $p) {
                        $variance += pow($p - $avgPrice, 2);
                    }
                    $stdDev = sqrt($variance / ($pricesCount - 1));
                    $cv = $stdDev / $avgPrice;
                    
                    if ($cv < 0.10) {
                        $volatility = 'Stable';
                    } elseif ($cv <= 0.25) {
                        $volatility = 'Moderate';
                    } else {
                        $volatility = 'High';
                    }
                }

                // 4. Hike/Drop Weekly calculations for alert banner
                // Get general trend in average prices over time
                $dailyAvgs = $entries->groupBy(function($item) {
                    return Carbon::parse($item->date)->format('Y-m-d');
                })->map(function($group) {
                    return (float)$group->avg('price');
                })->sortKeys();

                $dates = $dailyAvgs->keys()->toArray();
                $avgPrices = $dailyAvgs->values()->toArray();

                $bannerHikeText = "";
                $bannerHikeType = 'neutral'; // 'up', 'down', 'neutral'
                
                if (count($avgPrices) > 1) {
                    $pricesCount = count($avgPrices);
                    $latestAvg = $avgPrices[$pricesCount - 1];
                    $prevAvg = $avgPrices[$pricesCount - 2];
                    $bannerDiff = $latestAvg - $prevAvg;
                    $bannerPercent = $prevAvg > 0 ? ($bannerDiff / $prevAvg) * 100 : 0;
                    
                    if ($bannerDiff > 0) {
                        $bannerHikeText = sprintf("Price increased by %.1f%% (₹%.2f) compared to the previous observation.", $bannerPercent, $bannerDiff);
                        $bannerHikeType = 'up';
                    } elseif ($bannerDiff < 0) {
                        $bannerHikeText = sprintf("Price dropped by %.1f%% (₹%.2f) compared to the previous observation.", abs($bannerPercent), abs($bannerDiff));
                        $bannerHikeType = 'down';
                    } else {
                        $bannerHikeText = "Price remained completely stable compared to the last observation.";
                        $bannerHikeType = 'neutral';
                    }
                }

                // 5. Structure Chart Datasets
                // Daily Min / Max / Avg ranges for Area Chart
                $dailyMinMax = $entries->groupBy(function($item) {
                    return Carbon::parse($item->date)->format('Y-m-d');
                })->map(function($group) {
                    return (object)[
                        'min' => (float)$group->min('price'),
                        'max' => (float)$group->max('price'),
                        'avg' => (float)$group->avg('price'),
                    ];
                })->sortKeys();

                // Detailed Multi-series State trends
                $uniqueLocations = $locationsData->pluck('location')->toArray();
                $stateTrends = [];
                
                foreach ($uniqueLocations as $loc) {
                    $stateEntries = $entries->where('location', $loc);
                    $stateTrends[$loc] = $stateEntries->groupBy(function($item) {
                        return Carbon::parse($item->date)->format('Y-m-d');
                    })->map(function($group) {
                        return (float)$group->avg('price');
                    })->sortKeys()->toArray();
                }

                $intelligenceData = (object)[
                    'product_name' => $selectedProduct,
                    'locations_data' => $locationsData,
                    'cheapest' => $cheapest,
                    'expensive' => $expensive,
                    'avg_price' => $avgPrice,
                    'volatility' => $volatility,
                    'cv_percentage' => $cv * 100,
                    'banner_text' => $bannerHikeText,
                    'banner_type' => $bannerHikeType,
                    // Chart fields
                    'dates' => $dates,
                    'avg_prices' => $avgPrices,
                    'min_prices' => $dailyMinMax->pluck('min')->toArray(),
                    'max_prices' => $dailyMinMax->pluck('max')->toArray(),
                    'state_trends' => $stateTrends,
                ];
            }
        }

        return view('public.intelligence', compact('products', 'selectedProduct', 'intelligenceData', 'dateFrom', 'dateTo'));
    }

    /**
     * Provide autocomplete suggestions as a lightweight JSON response.
     */
    public function suggestions(Request $request)
    {
        $query = $request->get('query', '');

        if (strlen($query) < 1) {
            return response()->json([]);
        }

        // Native MongoDB regex distinct query
        $matching = collect(MarketData::raw()->distinct('product_name', [
            'status' => 'approved',
            'product_name' => new \MongoDB\BSON\Regex($query, 'i')
        ]))->sort()->values()->take(10);

        return response()->json($matching);
    }
}
