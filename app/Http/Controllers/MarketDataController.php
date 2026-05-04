<?php

namespace App\Http\Controllers;

use App\Models\MarketData;
use App\Models\Category;
use App\Http\Requests\StoreMarketDataRequest;
use App\Http\Requests\UpdateMarketDataRequest;
use App\Http\Requests\CsvUploadRequest;
use App\Mail\DataSubmissionConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MarketDataController extends Controller
{
    /**
     * Display the Explore Bazaar page with filters and search.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = MarketData::with(['category', 'user']);

        // Admin sees all, users see their own + approved
        if (!$user->isAdmin()) {
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('status', 'approved');
            });
        }

        $query->filter($request->only(['search', 'category', 'location', 'date_from', 'date_to', 'status']));
        $query->sorted($request->input('sort_by'), $request->input('direction', 'desc'));

        $data = $query->paginate(15)->withQueryString();

        $categories = Category::orderBy('name')->get();
        $locations = MarketData::distinct()->pluck('location')->sort()->values();

        return view('market-data.index', compact('data', 'categories', 'locations'));
    }

    /**
     * Show the form for creating new market data.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('market-data.create', compact('categories'));
    }

    /**
     * Store new market data entry.
     */
    public function store(StoreMarketDataRequest $request)
    {
        $data = MarketData::create([
            'user_id' => auth()->id(),
            'product_name' => $request->product_name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'location' => $request->location,
            'date' => $request->date,
            'status' => 'pending',
        ]);

        // Send confirmation email
        try {
            Mail::to(auth()->user()->email)->send(new DataSubmissionConfirmation($data));
        } catch (\Exception $e) {
            // Don't fail the request if email fails
            \Log::warning('Failed to send submission confirmation email: ' . $e->getMessage());
        }

        return redirect()->route('market-data.index')
            ->with('success', 'Market insight submitted successfully! It will be visible once approved.');
    }

    /**
     * Display the specified market data entry.
     */
    public function show(MarketData $marketData)
    {
        $user = auth()->user();

        // Check access: own data, approved, or admin
        if ($marketData->user_id !== $user->id && $marketData->status !== 'approved' && !$user->isAdmin()) {
            abort(403, 'You do not have access to this entry.');
        }

        $marketData->load(['category', 'user']);

        // Get price comparison for same product across locations
        $priceComparison = MarketData::approved()
            ->where('product_name', $marketData->product_name)
            ->where('id', '!=', $marketData->id)
            ->select('location', 'price', 'date')
            ->orderBy('date', 'desc')
            ->take(10)
            ->get();

        // Price trend for this product
        $priceTrend = MarketData::approved()
            ->where('product_name', $marketData->product_name)
            ->orderBy('date')
            ->select('date', 'price', 'location')
            ->get();

        return view('market-data.show', compact('marketData', 'priceComparison', 'priceTrend'));
    }

    /**
     * Show the form for editing market data.
     */
    public function edit(MarketData $marketData)
    {
        $user = auth()->user();

        if ($marketData->user_id !== $user->id && !$user->isAdmin()) {
            abort(403, 'You can only edit your own data.');
        }

        $categories = Category::orderBy('name')->get();
        return view('market-data.edit', compact('marketData', 'categories'));
    }

    /**
     * Update the specified market data.
     */
    public function update(UpdateMarketDataRequest $request, MarketData $marketData)
    {
        $marketData->update([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'location' => $request->location,
            'date' => $request->date,
            'status' => auth()->user()->isAdmin() ? $marketData->status : 'pending',
        ]);

        return redirect()->route('market-data.index')
            ->with('success', 'Market data updated successfully.');
    }

    /**
     * Remove the specified market data.
     */
    public function destroy(MarketData $marketData)
    {
        $user = auth()->user();

        if ($marketData->user_id !== $user->id && !$user->isAdmin()) {
            abort(403, 'You can only delete your own data.');
        }

        $marketData->delete();

        return redirect()->route('market-data.index')
            ->with('success', 'Market data deleted successfully.');
    }

    /**
     * Export filtered data as CSV.
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        $query = MarketData::approved()->with(['category', 'user']);
        $query->filter($request->only(['search', 'category', 'location', 'date_from', 'date_to']));
        $query->sorted($request->input('sort_by'), $request->input('direction', 'desc'));

        $data = $query->get();

        $response = new StreamedResponse(function () use ($data) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Product', 'Price', 'Category', 'Location', 'Date', 'Submitted By']);

            foreach ($data as $row) {
                fputcsv($handle, [
                    $row->product_name,
                    $row->price,
                    $row->category->name,
                    $row->location,
                    $row->date->format('Y-m-d'),
                    $row->user->name,
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="databazaar-export-' . now()->format('Y-m-d') . '.csv"');

        return $response;
    }

    /**
     * Export filtered data as JSON.
     */
    public function exportJson(Request $request)
    {
        $query = MarketData::approved()->with(['category', 'user']);
        $query->filter($request->only(['search', 'category', 'location', 'date_from', 'date_to']));
        $query->sorted($request->input('sort_by'), $request->input('direction', 'desc'));

        $data = $query->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'product_name' => $item->product_name,
                'price' => (float) $item->price,
                'category' => $item->category->name,
                'location' => $item->location,
                'date' => $item->date->format('Y-m-d'),
                'submitted_by' => $item->user->name,
            ];
        });

        return response()->json([
            'exported_at' => now()->toIso8601String(),
            'total' => $data->count(),
            'data' => $data,
        ])->header('Content-Disposition', 'attachment; filename="databazaar-export-' . now()->format('Y-m-d') . '.json"');
    }

    /**
     * Generate a shareable link for market data.
     */
    public function share(MarketData $marketData)
    {
        $user = auth()->user();

        if ($marketData->user_id !== $user->id && !$user->isAdmin()) {
            abort(403);
        }

        if (!$marketData->share_token) {
            $marketData->generateShareToken();
        }

        $shareUrl = route('shared.view', $marketData->share_token);

        return back()->with('success', 'Share link generated!')
                     ->with('share_url', $shareUrl);
    }

    /**
     * View shared data via public token (no auth required).
     */
    public function publicView(string $token)
    {
        $marketData = MarketData::where('share_token', $token)
            ->with(['category', 'user'])
            ->firstOrFail();

        // Price comparison data
        $priceComparison = MarketData::approved()
            ->where('product_name', $marketData->product_name)
            ->where('id', '!=', $marketData->id)
            ->select('location', 'price', 'date')
            ->orderBy('date', 'desc')
            ->take(10)
            ->get();

        return view('public.shared', compact('marketData', 'priceComparison'));
    }

    /**
     * Show CSV upload form.
     */
    public function uploadForm()
    {
        return view('market-data.upload');
    }

    /**
     * Process CSV upload for bulk import.
     */
    public function uploadCsv(CsvUploadRequest $request)
    {
        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');

        $header = fgetcsv($handle); // Skip header row
        $imported = 0;
        $errors = [];
        $lineNum = 1;

        $categories = Category::pluck('id', 'name')->toArray();

        while (($row = fgetcsv($handle)) !== false) {
            $lineNum++;

            if (count($row) < 5) {
                $errors[] = "Row {$lineNum}: Insufficient columns.";
                continue;
            }

            [$productName, $price, $categoryName, $location, $date] = $row;

            // Find or skip category
            $categoryId = $categories[$categoryName] ?? null;
            if (!$categoryId) {
                $errors[] = "Row {$lineNum}: Unknown category '{$categoryName}'.";
                continue;
            }

            // Validate price
            if (!is_numeric($price) || $price <= 0) {
                $errors[] = "Row {$lineNum}: Invalid price '{$price}'.";
                continue;
            }

            // Validate date
            try {
                $parsedDate = \Carbon\Carbon::parse($date);
                if ($parsedDate->isFuture()) {
                    $errors[] = "Row {$lineNum}: Date cannot be in the future.";
                    continue;
                }
            } catch (\Exception $e) {
                $errors[] = "Row {$lineNum}: Invalid date '{$date}'.";
                continue;
            }

            MarketData::create([
                'user_id' => auth()->id(),
                'product_name' => trim($productName),
                'price' => (float) $price,
                'category_id' => $categoryId,
                'location' => trim($location),
                'date' => $parsedDate->toDateString(),
                'status' => 'pending',
            ]);

            $imported++;
        }

        fclose($handle);

        $message = "{$imported} entries imported successfully.";
        if (!empty($errors)) {
            $message .= ' ' . count($errors) . ' rows had errors.';
        }

        return redirect()->route('market-data.index')
            ->with('success', $message)
            ->with('import_errors', $errors);
    }
}
