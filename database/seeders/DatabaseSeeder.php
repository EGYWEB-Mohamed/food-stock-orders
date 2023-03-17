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
                            'name' => 'User',
                            'email' => 'admin@test.com',
                            'is_admin' => true,
                            'password' => Hash::make(123456),
                        ]);

        Product::factory()->count(10)->create();
        Ingredient::factory()->count(5)->create();
    }
}
