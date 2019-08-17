<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::oldest('name')->paginate(25);
        return view('products.index', compact('products'));
    }

    public function update(Product $product)
    {
        $data = request()->validate([
            'price' => 'integer'
        ]);

        return response()->json($product->update($data));
    }
}
