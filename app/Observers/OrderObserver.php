<?php

namespace App\Observers;

use App\Events\IngredientConsumptionsEvent;
use App\Models\Order;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class OrderObserver
{
    public function creating(Order $order): void
    {
        $order->reference_number = IdGenerator::generate(['table' => 'orders',
            'field' => 'reference_number',
            'length' => 15,
            'prefix' => 'O-'.date('ymd'),
        ]);
        $order->cost = $order->product->price;
    }

    public function created(Order $order): void
    {
        foreach ($order->product->ingredients as $ingredient) {
            $order->ingredientConsumes()->create([
                'ingredient_id' => $ingredient->id,
                'product_id' => $order->product_id,
                'ingredient_stock_grams' => $ingredient->stock_grams,
                'consumed_grams' => $order->product->ingredients->find($ingredient->id)->pivot->grams_quantity,
            ]);
            event(new IngredientConsumptionsEvent($ingredient, $order));
        }
    }

    public function updated(Order $order): void
    {
    }

    public function deleted(Order $order): void
    {
    }

    public function restored(Order $order): void
    {
    }

    public function forceDeleted(Order $order): void
    {
    }
}
