<?php

use App\Http\Controllers\HomeController;
use App\Models\IngredientConsume;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return redirect(\route('filament.auth.login'));
});
// Public Routes
Route::get('/', [HomeController::class, 'index'])
     ->name('home');
Route::group(['middleware' => 'filamentAuth'], function () {
    Route::post('createOrder/{product}', [HomeController::class, 'checkout'])
         ->name('checkout');
});
Route::get('/test', function () {
    $IngredientID = 1;
    $after = '2023-03-17 13:30:46';
//    $order = Order::query()
//                  ->with('ingredientConsumes')
//                  ->whereHas('ingredientConsumes',function (Builder $builder) use ($IngredientID) {
//                      $builder->where('ingredient_id',$IngredientID);
//                  })
//                  ->when('2023-03-17 13:30:46',function ($query) {
//                      $query->where('created_at','>=','2023-03-17 13:30:46');
//                  })
//                  ->whereHas('product.ingredients',function (Builder $builder) use ($IngredientID) {
//                      $builder->where('ingredient_id',$IngredientID);
//                  })
//                  ->hasIngredient($IngredientID)
//                  ->get();
    $ingredient = IngredientConsume::with('product.orders')
                                   ->whereHas('product.orders', function (Builder $builder) use ($after) {
                                       $builder->where('created_at', '<=', $after);
                                   })
                                   ->where('ingredient_id', $IngredientID)
                                   ->sum('consumed_grams');
    dd($ingredient);
});
