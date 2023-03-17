<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Ingredient;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()
            ->create([
                'name'     => 'User',
                'email'    => 'admin@test.com',
                'password' => Hash::make(123456),
            ]);

        $ingredients = [
            [
                'name'        => 'Beef',
                'stock_grams' => '20000',
            ],
            [
                'name'        => 'Cheese',
                'stock_grams' => '5000',
            ],
            [
                'name'        => 'Onion',
                'stock_grams' => '1000',
            ],
            [
                'name'        => 'Chicken',
                'stock_grams' => '25000',
            ],
            [
                'name'        => 'Fries',
                'stock_grams' => '15000',
            ],
        ];
        Ingredient::insert($ingredients);

        $products = [
            [
                'name'  => 'Burger',
                'price' => 5
            ],
            [
                'name'  => 'Taco',
                'price' => 3
            ],
            [
                'name'  => 'Fried Chicken',
                'price' => 4
            ],
            [
                'name'  => 'Chicken Crepe',
                'price' => 6
            ],
        ];
        Product::insert($products);


        Product::find(1)->ingredients()->sync([
            1 => ['grams_quantity' => 150],
            2 => ['grams_quantity' => 30],
            3 => ['grams_quantity' => 20],
        ]);

        Product::find(2)->ingredients()->sync([
            4 => ['grams_quantity' => 250],
            5 => ['grams_quantity' => 50],
        ]);

        Product::find(3)->ingredients()->sync([
            4 => ['grams_quantity' => 500],
        ]);
        Product::find(4)->ingredients()->sync([
            3 => ['grams_quantity' => 50],
            4 => ['grams_quantity' => 380],
            5 => ['grams_quantity' => 130],
        ]);
    }
}
