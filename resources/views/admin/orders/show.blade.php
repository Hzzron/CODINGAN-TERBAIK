<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Detail - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
@include('admin.sidebar')
<div class="main-content">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4>Order Details</h4>
                <p class="text-muted mb-0">Order #{{ $order->order_number }}</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i> Back to Orders
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-person me-2"></i> Customer Information
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $order->user->name ?? 'No User' }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                    <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-truck me-2"></i> Shipping Information
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $order->shipping_name }}</p>
                    <p><strong>Phone:</strong> {{ $order->shipping_phone }}</p>
                    <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-bag me-2"></i> Order Items
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name ?? 'Product' }}</td>
                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="text-end">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                        <td class="text-end"><strong>Rp {{ number_format($order->amount, 0, ',', '.') }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="bi bi-pencil-square me-2"></i> Update Order Status
        </div>
        <div class="card-body">
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                @csrf
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Order Status</label>
                        <select name="status" class="form-control">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }} style="color: red;">Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-control">
                            <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i> Update Status
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

