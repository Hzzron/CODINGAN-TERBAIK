<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
class CartController extends Controller
{
    //
    public function index()
    {
        $cartItems = Cart::where('user_id',Auth::id())
        ->with('product')
        ->get();
        $total=$cartItems->sum(function($item)
        {
            return $item->product->price * $item->quantity;
        });

        return view('customer.cart',compact('cartItems','total'));
    }

    public function add(Request $request, $productId)
    {
        $product=Product::findOrFail($productId);
        $cartItem=Cart::where('user_id',Auth::id())
        ->where('product_id',$productId)
        ->first();
        if($cartItem)
        {
            $cartItem->quantity +=$request->input('quantity',1);
            $cartItem->save();
        }
        else
        {
            Cart::create([
                'user_id'=>Auth::id(),
                'product_id'=>$productId,
                'quantity'=>$request->input('quantity',1)
            ]);
        }
        return redirect()->back()->with('success','Product added to cart successfully!');
}
    public function update(Request $request, $cartId)
    {
        $cartItem=Cart::where('id',$cartId)
        ->where('user_id',Auth::id()
        )->firstOrFail();
        $cartItem->quantity=$request->input('quantity');
        $cartItem->save();
        return redirect()->back()->with('success','Cart updated successfully!');
    }

    public function remove($cartId)
    {
        $cartItem=Cart::where('id',$cartId)
        ->where('user_id',Auth::id())
        ->delete();
        return redirect()->back()->with('success','Product removed from cart successfully!');
    }
}
