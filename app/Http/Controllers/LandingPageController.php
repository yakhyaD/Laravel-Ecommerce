<?php

namespace App\Http\Controllers;

use App\Models\Product;


class LandingPageController extends Controller
{
    public function index()
    {
        $products = Product::where('featured', true)->inRandomOrder()->take(8)->get();

        return view('landing-page')->with('products', $products);
    }
}
