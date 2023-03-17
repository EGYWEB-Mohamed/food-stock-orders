<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->seed();
        $user = User::first();
        $this->actingAs($user);
    }
    public function test_is_there_burger_product_with_its_ingredients()
    {
        $burger = Product::find(1);
        $this->assertModelExists($burger);
        $ingredients = [
            1 => ['grams_quantity' => 150],
            2 => ['grams_quantity' => 30],
            3 => ['grams_quantity' => 20],
        ];
        foreach ($ingredients as $key => $ingredient) {
            $this->assertDatabaseHas('ingredient_product',[
                'ingredient_id' => $key,
                'product_id' => $burger->id,
                'grams_quantity' => $ingredient['grams_quantity'],
            ]);
        }
    }
}
