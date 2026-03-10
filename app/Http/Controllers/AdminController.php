<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('amount');

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalRevenue'
        ));
    }

    public function salesReport(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        $query = Order::with(['user', 'items.product'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        $totalRevenue = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('amount');

        $totalOrders = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->count();

        $totalProductsSold = OrderItem::whereHas('order', function ($q) use ($startDate, $endDate) {
            $q->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        })->sum('quantity');

        return view('admin.sales.index', compact(
            'orders',
            'totalRevenue',
            'totalOrders',
            'totalProductsSold',
            'startDate',
            'endDate'
        ));
    }
}
