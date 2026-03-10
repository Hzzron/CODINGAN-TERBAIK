<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    @include('admin.sidebar')
    <div class="main-content">
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4>Welcome to Dashboard</h4>
                    <p class="text-muted mb-0">Manage your store</p>
                </div>
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <strong>{{ Auth::user()->name }}</strong>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline">
                            @csrf
                            <button type="submit" class="logout-btn">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="bi bi-box-seam"></i>
                </div>
                <h3>Total Products</h3>
                <p>{{ $totalProducts }}</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="bi bi-cart-check"></i>
                </div>
                <h3>Total Orders</h3>
                <p>{{ $totalOrders }}</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <h3>Total Revenue</h3>
                <p>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="quick-actions">
                <h3>Quick Actions</h3>
                <a href="{{ route('product.index') }}" class="action-btn">
                    <i class="bi bi-box-seam"></i>
                    Manage Products
                </a>
                <a href="{{ route('product.create') }}" class="action-btn">
                    <i class="bi bi-plus-circle"></i>
                    Add New Product
                </a>
                <a href="{{ route('admin.orders.index') }}" class="action-btn">
                    <i class="bi bi-cart-check"></i>
                    Manage Orders
                </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

