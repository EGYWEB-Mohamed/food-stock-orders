<?php

namespace App\Services;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ConsumedIngredient
{
    public function sumConsumed($IngredientID,Carbon $afterCertainDate = null)
    {
        return Order::with(['product.ingredients'])
                    ->when($afterCertainDate,function ($query) use ($afterCertainDate) {
                        $query->where('created_at','>',$afterCertainDate);
                    })
                    ->whereHas('product.ingredients',function (Builder $builder) use ($IngredientID) {
                        $builder->where('ingredient_id',$IngredientID);
                    })
                    ->hasIngredient($IngredientID)
                    ->get()
                    ->sum(function ($items) use ($IngredientID) {
                        return $items->product->ingredients()
                                              ->where('id',$IngredientID)
                                              ->first()->pivot->grams_quantity;
                    });
    }
}
