<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class OrderController extends Controller
{
    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.products')
                ->with('error', 'Your cart is empty!');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('customer.checkout', compact('cartItems', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_address' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'payment_method' => 'required|string',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.products')
                ->with('error', 'Your cart is empty!');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        DB::beginTransaction();

        try {

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_name' => 'ORD-' . time() . '-' . Auth::id(),
                'amount' => $total,
                'status' => 'pending',
                'shipping_name' => $request->shipping_name,
                'shipping_address' => $request->shipping_address,
                'shipping_phone' => $request->shipping_phone,
                'payment_method' => $request->payment_method,
                'payment_status' => 'unpaid',
            ]);

            foreach ($cartItems as $item) {

                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                $product = $item->product;
                $product->stock -= $item->quantity;
                $product->save();
            }

            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

return redirect()->route('customer.checkout.confirmation', $order->id);

        } catch (\Exception $e) {

            DB::rollBack();

            // Log the actual error for debugging
            // Log::error('Checkout failed: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Checkout failed! Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function confirmation($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->with('items.product')
            ->firstOrFail();

        return view('customer.order-confirmation', compact('order'));
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.orders', compact('orders'));
    }

    public function orderDetail($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->with('items.product')
            ->firstOrFail();

        return view('customer.order-detail', compact('order'));
    }
}

