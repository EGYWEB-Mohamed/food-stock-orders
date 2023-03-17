<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    protected $guarded = [];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function scopeHasIngredient($query, $ingredient_id)
    {
        return $query->whereHas('product', function ($q) use ($ingredient_id) {
            $q->whereHas('ingredients', function ($q) use ($ingredient_id) {
                $q->where('ingredients.id', $ingredient_id);
            });
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
