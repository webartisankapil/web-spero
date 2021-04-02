<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
      return view('layouts.main');
    }

    public function getProducts(Request $request)
    {
        $products = Product::paginate(15);
        return response()->json(['products' => $products]);
    }

    public function show($id)
    {
       $product = Product::find($id);
       return response()->json(['product' => $product]);
    }
}
