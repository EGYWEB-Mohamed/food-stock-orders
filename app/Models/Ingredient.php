<?php

namespace App\Models;

use App\Services\ConsumedIngredient;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = ['last_stock_update_date' => 'datetime','alert_sent' => 'boolean'];

    public function ConsumedPercentage(): Attribute
    {
        return Attribute::get(function () {
            return round(100 - ($this->ConsumedLogic() / $this->stock_grams) * 100,2);
        });
    }

    public function ConsumedLogic()
    {
        return (new ConsumedIngredient())->sumConsumed($this->id,$this->last_stock_update_date);

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
