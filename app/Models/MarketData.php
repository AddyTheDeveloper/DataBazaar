<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class MarketData extends Model
{
    use HasFactory;

    protected $table = 'market_data';

    protected $fillable = [
        'user_id',
        'product_name',
        'price',
        'category_id',
        'location',
        'date',
        'status',
        'share_token',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'date' => 'date',
        ];
    }

    /**
     * Get the user who submitted this data.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category of this data.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the bookmarks for this data.
     */
    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * Scope: only approved entries.
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope: only pending entries.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: filter by various criteria.
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        if (!empty($filters['search'])) {
            $query->where('product_name', 'like', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        if (!empty($filters['location'])) {
            $query->where('location', $filters['location']);
        }

        if (!empty($filters['date_from'])) {
            $query->where('date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('date', '<=', $filters['date_to']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query;
    }

    /**
     * Scope: sort by field.
     */
    public function scopeSorted(Builder $query, ?string $sortBy = null, string $direction = 'desc'): Builder
    {
        $allowedSorts = ['price', 'date', 'product_name', 'created_at'];
        $sortBy = in_array($sortBy, $allowedSorts) ? $sortBy : 'created_at';
        $direction = in_array($direction, ['asc', 'desc']) ? $direction : 'desc';

        return $query->orderBy($sortBy, $direction);
    }

    /**
     * Generate a unique share token.
     */
    public function generateShareToken(): string
    {
        $token = bin2hex(random_bytes(32));
        $this->update(['share_token' => $token]);
        return $token;
    }
}
