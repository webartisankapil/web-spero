<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cart;
use App\Models\Product;
use Auth;

class CartController extends Controller
{
    public function index()
    {
      return view('layouts.main', ['component' => 'shoppingCart']);
    }

    public function countItems()
    {
      $user_id = Auth::id();
      $items = 0;
      $cart = Cart::where('user_id', $user_id);
      if ($cart->count()) {
          $items = $cart->sum('quantity');
      }
      return response()->json(['items' => $items], 200);
    }

    public function add(Request $request)
    {
      if ($request->has('productId')) {
        $product_id = $request->productId;
        $user_id = Auth::id();
        $product = Product::find($product_id);
        $cart    = new Cart;

        $exists = $cart->where([
                          'product_id' => $product_id,
                          'user_id'    => $user_id,
                        ])->first();

        if ($exists) {
            $exist_quantity = $exists->quantity;
            $exist_total    = $exists->total;
            if ($product->quantity > $exist_quantity) {
                $exists->update([
                  'quantity' => $exist_quantity + 1,
                  'total'    => $exist_total + $product->price,
                ]);
            } else {
                return response()->json(['message' => 'You cannot add more than available quantity'], 422);
            }

        } else {
          $cart->create([
            'user_id'    =>$user_id,
            'product_id' => $product_id,
            'quantity'   => 1,
            'total'      => $product->price
          ]);
        }

        return response()->json(['message' => 'success'], 200);

      }
    }

    public function getItems()
    {
      $user_id = Auth::id();
      $cart = Cart::where('user_id', $user_id);
      $subtotal = $cart->sum('quantity');
      $quantity = $cart->sum('total');
      $items = $cart->with('product')->get();
      return response()->json(['items' => $items, 'subtotal' => $subtotal, 'quantity' => $quantity], 200);
    }

    public function removeItem(Request $request)
    {
      $id = $request->cartId;
      Cart::find($id)->delete();
      return response()->json(['message' => 'succesfully removed'], 204);
    }

    public function updateItem(Request $request)
    {
      $id = $request->id;
      $quantity = $request->quantity;
      $item = Cart::find($id);
      $product = Product::find($item->product_id);
      $price = $product->price * $quantity;
      $item->update(['quantity' => $quantity, 'total' => $price]);
      return response()->json(['message' => 'success'], 200);
    }
}
