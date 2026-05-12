<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'categories';

    protected $fillable = ['name'];

    /**
     * Get all market data in this category.
     */
    public function marketData(): HasMany
    {
        return $this->hasMany(MarketData::class);
    }
}
