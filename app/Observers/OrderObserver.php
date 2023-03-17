<?php

namespace App\Observers;

use App\Events\IngredientDecreasesEvent;
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
        $order->load(['product']);
        foreach ($order->product->ingredients as $ingredient) {
            event(new IngredientDecreasesEvent($ingredient, $order));
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
