<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4>Customer Portal</h4>
        <p>Shopping Dashboard</p>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('customer.dashboard') }}" class="nav-link">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customer.products') }}" class="nav-link">
                    <i class="bi bi-bag-check"></i> Browse Products
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customer.cart') }}" class="nav-link">
                    <i class="bi bi-cart"></i> My Cart
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customer.orders') }}" class="nav-link active">
                    <i class="bi bi-receipt"></i> My Orders
                </a>
            </li>
        </ul>

        <div class="mt-5 pt-4 border-top border-secondary">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4>My Orders</h4>
                    <p>Track and manage your orders</p>
                </div>
                <a href="{{ route('customer.products') }}" class="btn btn-primary">
                    <i class="bi bi-bag-plus me-2"></i> Continue Shopping
                </a>
            </div>
        </div>

        <!-- Orders List -->
        @if(isset($orders) && $orders->count() > 0)
            @foreach($orders as $order)
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <div class="order-id">Order #{{ $order->order_number }}</div>
                        <div class="order-date">
                            <i class="bi bi-calendar me-1"></i>
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                    <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                </div>

                <div class="order-items">
                    @foreach($order->items->take(3) as $item)
                        @if($item->product && $item->product->image)
                        <img src="{{ asset('storage/products/' . $item->product->image) }}"
                             alt="{{ $item->product_name }}"
                             class="order-item-thumb">
                        @else
                        <img src="https://via.placeholder.com/60" alt="No Image" class="order-item-thumb">
                        @endif
                    @endforeach
                    @if($order->items->count() > 3)
                    <div class="order-item-count">
                        +{{ $order->items->count() - 3 }} more
                    </div>
                    @endif
                </div>

                <div class="order-footer">
                    <div class="order-total">
                        <span>Total: </span>
                        Rp {{ number_format($order->amount, 0, ',', '.') }}
                    </div>
                    <a href="{{ route('customer.order-detail', $order->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-eye me-1"></i> View Details
                    </a>
                </div>
            </div>
            @endforeach

            <!-- Pagination -->
            @if($orders->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links() }}
            </div>
            @endif
        @else
        <div class="info-card">
            <div class="empty-state">
                <i class="bi bi-bag-x"></i>
                <h4>No Orders Yet</h4>
                <p>You haven't placed any orders yet. Start shopping to see your orders here!</p>
                <a href="{{ route('customer.products') }}" class="btn btn-primary">
                    <i class="bi bi-bag-check me-2"></i> Browse Products
                </a>
            </div>
        </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

