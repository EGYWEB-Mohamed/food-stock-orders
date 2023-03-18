<?php

namespace App\Http\Controllers;

use App\Models\Product;
use RealRashid\SweetAlert\Facades\Alert;

class CheckoutController extends Controller
{
    public function __invoke(Product $product)
    {
        $order = $product->orders()
                         ->create([
                             'user_id' => auth()->id(),
                         ]);
        Alert::success('Success', "Order Had Been Created Successfully ( $order->reference_number )");

        return redirect()->route('home');
    }
}
