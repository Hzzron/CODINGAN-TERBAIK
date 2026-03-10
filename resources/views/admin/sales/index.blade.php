<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales Report - Admin Panel</title>
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
                    <h4>Sales Report</h4>
                    <p class="text-muted mb-0">Track your store performance</p>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <h3>Total Revenue</h3>
                <p>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="bi bi-cart-check"></i>
                </div>
                <h3>Total Orders</h3>
                <p>{{ $totalOrders }}</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="bi bi-box-seam"></i>
                </div>
                <h3>Products Sold</h3>
                <p>{{ $totalProductsSold }}</p>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-filter me-2"></i> Filter Orders
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.report.sales') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-filter"></i> Filter
                        </button>
                        <a href="{{ route('admin.report.sales') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td><strong>#{{ $order->order_number }}</strong></td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                            <td>Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
                            <td class="text-uppercase">{{ str_replace('_', ' ', $order->payment_method) }}</td>
                            <td>
                                <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <h4>No Orders Found</h4>
                                    <p>No orders found for the selected period.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

