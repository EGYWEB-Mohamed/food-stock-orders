<?php

namespace App\Services;

use App\Models\IngredientConsume;
use Carbon\Carbon;

class ConsumedIngredient
{
    public function sumConsumed($IngredientID, Carbon $afterCertainDate = null): int
    {
        return IngredientConsume::with('product.orders')
                                ->where('ingredient_id', $IngredientID)
                                ->when($afterCertainDate, function ($query) use ($afterCertainDate) {
                                    $query->where('created_at', '>=', $afterCertainDate);
                                })
                                ->sum('consumed_grams');
    }
}
