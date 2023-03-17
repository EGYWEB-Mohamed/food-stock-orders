<?php

namespace App\Listeners;

use App\Events\IngredientDecreasesEvent;
use App\Mail\LowIngredientMail;
use Illuminate\Support\Facades\Mail;

class SendNotificationWhenInventoryIsLowListener
{
    public function __construct()
    {
    }

    public function handle(IngredientDecreasesEvent $event): void
    {
        $event->order->ingredientConsumes()->create([
            'ingredient_id' => $event->ingredient->id,
            'product_id' => $event->order->product_id,
            'ingredient_stock_grams' => $event->ingredient->stock_grams,
            'consumed_grams' => $event->order->product->ingredients->find($event->ingredient->id)->pivot->grams_quantity,
        ]);

        if ($event->ingredient->consumed_percentage <= config('setting.lowest_stock_percentage') and ! $event->ingredient->alert_sent) {
            Mail::to(config('setting.merchant_mail'))
                ->queue(new LowIngredientMail($event->ingredient));
            $event->ingredient->update([
                'alert_sent' => true,
            ]);
        }
    }
}
