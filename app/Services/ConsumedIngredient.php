<?php

namespace App\Services;

use App\Models\IngredientConsume;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ConsumedIngredient
{
    /*
     * This method takes two parameters:
    $IngredientID: The ID of the ingredient whose consumption needs to be calculated.
    $afterCertainDate (optional): A Carbon instance representing a certain date. If provided, only the consumption data after this date will be considered in the calculation. Defaults to null.
    This method returns the total amount of the ingredient consumed, in grams, as an integer value. It achieves this by executing a query on the IngredientConsume model, filtering the data based on the provided parameters and aggregating the results using the sum method.
    If $afterCertainDate is provided, the method applies a filter on the related product.orders relationship, only considering orders created after this date.
    */
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
