<?php

namespace App\Services;

use App\Models\IngredientConsume;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ConsumedIngredient
{
    public function sumConsumed($IngredientID, Carbon $afterCertainDate = null): int
    {
        return IngredientConsume::with('product.orders')
                                ->when($afterCertainDate, function ($query) use ($afterCertainDate) {
                                    $query->whereHas('product.orders',
                                        function (Builder $builder) use ($afterCertainDate) {
                                            $builder->where('created_at', '>=', $afterCertainDate);
                                        });
                                })
                                ->where('ingredient_id', $IngredientID)
                                ->sum('consumed_grams');
    }
}
