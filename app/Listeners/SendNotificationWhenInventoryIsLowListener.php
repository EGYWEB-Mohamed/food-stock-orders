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
        if ($event->ingredient->consumed_percentage <= config('setting.lowest_stock_percentage') and !$event->ingredient->alert_sent) {
            Mail::to(config('setting.merchant_mail'))
                ->queue(new LowIngredientMail($event->ingredient));
            $event->ingredient->update([
                'alert_sent' => true
            ]);
        }
    }
}
