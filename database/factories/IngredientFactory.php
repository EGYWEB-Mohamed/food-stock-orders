<?php

namespace Database\Factories;

use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientFactory extends Factory
{
    protected $model = Ingredient::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2,true),
            'stock_grams' => $this->faker->randomNumber(5,true),
            'alert_sent' => false
        ];
    }
}
