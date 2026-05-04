<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'market_data_id',
    ];

    /**
     * Get the user who created this bookmark.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the market data entry that was bookmarked.
     */
    public function marketData(): BelongsTo
    {
        return $this->belongsTo(MarketData::class);
    }
}
