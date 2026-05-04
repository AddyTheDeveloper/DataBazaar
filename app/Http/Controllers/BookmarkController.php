<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\MarketData;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    /**
     * Toggle bookmark on a market data entry.
     */
    public function toggle(MarketData $marketData)
    {
        $user = auth()->user();

        $existing = Bookmark::where('user_id', $user->id)
            ->where('market_data_id', $marketData->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return back()->with('success', 'Bookmark removed.');
        }

        Bookmark::create([
            'user_id' => $user->id,
            'market_data_id' => $marketData->id,
        ]);

        return back()->with('success', 'Entry bookmarked!');
    }

    /**
     * View all bookmarked entries.
     */
    public function index()
    {
        $bookmarks = auth()->user()->bookmarks()
            ->with(['marketData.category', 'marketData.user'])
            ->latest()
            ->paginate(15);

        return view('bookmarks.index', compact('bookmarks'));
    }
}
