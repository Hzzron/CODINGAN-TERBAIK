<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')
            ->orderBy('created_at','desc')
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.product','user')
            ->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,canceled',
            'payment_status' => 'required|in:unpaid,paid',
        ]);

        $order = Order::findOrFail($id);

        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
        ]);

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order updated successfully.');
    }
}
