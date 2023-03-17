<?php

namespace App\Models;

use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $withCount = ['orders'];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class)
                    ->withPivot('grams_quantity');
    }

    public function getPrice(): string
    {
        return Money::USD($this->price,true)
                    ->format();
    }
}
