<?php

namespace App\Observers;

use App\Models\Ingredient;
use Carbon\Carbon;

class IngredientObserver
{
    public function created(Ingredient $ingredient): void
    {

    }

    public function updating(Ingredient $ingredient): void
    {
        if ($ingredient->isDirty('stock_grams')) {
            $ingredient->last_stock_update_date = Carbon::now();
            $ingredient->alert_sent = false;
        }
    }
    public function updated(Ingredient $ingredient): void
    {
    }

    public function deleted(Ingredient $ingredient): void
    {
    }

    public function restored(Ingredient $ingredient): void
    {
    }

    public function forceDeleted(Ingredient $ingredient): void
    {
    }
}
