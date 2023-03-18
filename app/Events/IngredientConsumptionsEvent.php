<?php

namespace App\Events;

use App\Models\Ingredient;
use App\Models\Order;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IngredientConsumptionsEvent
{
    use Dispatchable,SerializesModels;

    public function __construct(public Ingredient $ingredient, public Order $order)
    {
    }
}
