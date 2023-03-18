<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Artesaos\SEOTools\Facades\SEOTools;

class HomeController extends Controller
{
    public function index()
    {
        SEOTools::setTitle('All Products');
        $products = Product::with(['ingredients'])->paginate();

        return view('front.home', compact('products'));
    }
}
