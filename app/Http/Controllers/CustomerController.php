<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Cart;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Get order statistics
        $totalOrders = Order::where('user_id', $user->id)->count();
        $totalSpent = Order::where('user_id', $user->id)->where('status', '!=', 'cancelled')->sum('amount');
        $pendingOrders = Order::where('user_id', $user->id)->whereIn('status', ['pending', 'processing'])->count();

        // Get cart count
        $cartCount = Cart::where('user_id', $user->id)->sum('quantity');

        // Get recent orders (last 5)
        $recentOrders = Order::where('user_id', $user->id)
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('customer.dashboard', [
            'totalOrders' => $totalOrders,
            'totalSpent' => $totalSpent,
            'pendingOrders' => $pendingOrders,
            'cartCount' => $cartCount,
            'recentOrders' => $recentOrders
        ]);
    }
}

