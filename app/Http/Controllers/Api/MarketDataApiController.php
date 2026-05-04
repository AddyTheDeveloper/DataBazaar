<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MarketData;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MarketDataApiController extends Controller
{
    /**
     * GET /api/market-data
     * Returns paginated, filterable approved market data.
     */
    public function index(Request $request): JsonResponse
    {
        $query = MarketData::approved()->with(['category', 'user:id,name']);

        $query->filter($request->only(['search', 'category', 'location', 'date_from', 'date_to']));
        $query->sorted($request->input('sort_by'), $request->input('direction', 'desc'));

        $data = $query->paginate($request->input('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $data->items(),
            'pagination' => [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
            ],
        ]);
    }

    /**
     * POST /api/market-data
     * Create a new market data entry via API.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'date' => 'required|date|before_or_equal:today',
        ]);

        $data = MarketData::create([
            ...$validated,
            'user_id' => auth()->id() ?? 1,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Market data submitted successfully.',
            'data' => $data->load('category'),
        ], 201);
    }

    /**
     * GET /api/products
     * Returns unique product names from approved data.
     */
    public function products(): JsonResponse
    {
        $products = MarketData::approved()
            ->select('product_name')
            ->distinct()
            ->orderBy('product_name')
            ->pluck('product_name');

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }
}
