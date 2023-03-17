<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = ['last_stock_update_date' => 'datetime','alert_sent' => 'boolean'];
    protected $withCount = ['products'];
    public function ConsumedPercentage(): Attribute
    {
        return Attribute::get(function () {
            return round(100 - ($this->ConsumedLogic() / $this->stock_grams) * 100,2);
        });
    }

    public function ConsumedLogic()
    {
        $IngredientID = $this->id;
        return Order::with(['product.ingredients'])
                    ->where('created_at','>',$this->last_stock_update_date)
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

    public function ConsumedGrams(): Attribute
    {
        return Attribute::get(function () {
            return $this->ConsumedLogic();
        });
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
