<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
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
                <a href="{{ route('customer.dashboard') }}" class="nav-link active">
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
                    @if(isset($cartCount) && $cartCount > 0)
                    <span class="badge bg-danger ms-2">{{ $cartCount }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customer.orders') }}" class="nav-link">
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
        <!-- Welcome Card -->
        <div class="welcome-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2>Welcome back, {{ Auth::user()->name }}! 👋</h2>
                    <p>Here's what's happening with your orders and shopping.</p>
                </div>
                <div class="text-end">
                    <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center"
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-person-fill" style="font-size: 1.8rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="bi bi-bag"></i>
                </div>
                <h6>Total Orders</h6>
                <h3>{{ $totalOrders ?? 0 }}</h3>
            </div>
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <h6>Total Spent</h6>
                <h3>Rp {{ number_format($totalSpent ?? 0, 0, ',', '.') }}</h3>
            </div>
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="bi bi-cart3"></i>
                </div>
                <h6>Cart Items</h6>
                <h3>{{ $cartCount ?? 0 }}</h3>
            </div>
            <div class="stat-card">
                <div class="stat-icon info">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h6>Pending Orders</h6>
                <h3>{{ $pendingOrders ?? 0 }}</h3>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="section-title">
            <i class="bi bi-lightning"></i> Quick Actions
        </div>
        <div class="quick-actions">
            <a href="{{ route('customer.products') }}" class="action-card">
                <div class="action-icon shop">
                    <i class="bi bi-bag-check"></i>
                </div>
                <div class="action-text">
                    <h6>Shop Now</h6>
                    <p>Browse our products</p>
                </div>
            </a>
            <a href="{{ route('customer.cart') }}" class="action-card">
                <div class="action-icon cart">
                    <i class="bi bi-cart"></i>
                </div>
                <div class="action-text">
                    <h6>View Cart</h6>
                    <p>{{ $cartCount ?? 0 }} items in cart</p>
                </div>
            </a>
            <a href="{{ route('customer.orders') }}" class="action-card">
                <div class="action-icon orders">
                    <i class="bi bi-receipt"></i>
                </div>
                <div class="action-text">
                    <h6>My Orders</h6>
                    <p>Track your orders</p>
                </div>
            </a>
        </div>

        <!-- Recent Orders -->
        <div class="recent-orders-card mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="section-title mb-0">
                    <i class="bi bi-clock-history"></i> Recent Orders
                </div>
                <a href="{{ route('customer.orders') }}" class="btn btn-sm btn-outline-primary">
                    View All <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            @if(isset($recentOrders) && $recentOrders->count() > 0)
                @foreach($recentOrders as $order)
                <div class="order-item">
                    <div class="order-icon">
                        <i class="bi bi-bag-check"></i>
                    </div>
                    <div class="order-info">
                        <h6>Order #{{ $order->order_number }}</h6>
<p>{{ $order->created_at->format('d M Y') }} • {{ $order->items->count() }} items</p>
                    </div>
                    <div class="order-amount">
                        <h6>Rp {{ number_format($order->amount, 0, ',', '.') }}</h6>
                        <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                    </div>
                    <a href="{{ route('customer.order-detail', $order->id) }}" class="btn btn-sm btn-outline-secondary ms-3">
                        <i class="bi bi-eye"></i>
                    </a>
                </div>
                @endforeach
            @else
                <div class="empty-state">
                    <i class="bi bi-bag-x"></i>
                    <h4>No orders yet. Start shopping!</h4>
                    <a href="{{ route('customer.products') }}" class="btn btn-primary">
                        <i class="bi bi-bag-check me-2"></i> Browse Products
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

