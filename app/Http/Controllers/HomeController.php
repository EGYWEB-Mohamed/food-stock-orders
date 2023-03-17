<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Artesaos\SEOTools\Facades\SEOTools;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    public function index()
    {
        SEOTools::setTitle('All Products');
        $products = Product::with(['ingredients'])->paginate();
        return view('front.home',compact('products'));
    }

    public function checkout(Product $product)
    {
        $order = $product->orders()->create([
            'user_id' => auth()->id()
        ]);
        Alert::success('Success', "Order Had Been Created Successfully ( $order->reference_number )");
        return redirect()->route('home');
    }
}
