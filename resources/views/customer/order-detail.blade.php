<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Detail - #{{ $order->order_number }}</title>
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
                    <h4>Order Details</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customer.orders') }}">My Orders</a></li>
                            <li class="breadcrumb-item active">#{{ $order->order_number }}</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('customer.orders') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i> Back to Orders
                </a>
            </div>
        </div>

        <!-- Status Timeline -->
        <div class="info-card">
            <h5><i class="bi bi-truck"></i> Order Status</h5>
            <div class="status-timeline">
                <div class="timeline-step {{ in_array($order->status, ['pending', 'processing', 'shipped', 'completed']) ? 'completed' : '' }} {{ $order->status == 'pending' ? 'active' : '' }}">
                    <div class="step-icon"><i class="bi bi-check"></i></div>
                    <p>Order Placed</p>
                </div>
                <div class="timeline-step {{ in_array($order->status, ['processing', 'shipped', 'completed']) ? 'completed' : '' }} {{ $order->status == 'processing' ? 'active' : '' }}">
                    <div class="step-icon"><i class="bi bi-gear"></i></div>
                    <p>Processing</p>
                </div>
                <div class="timeline-step {{ in_array($order->status, ['shipped', 'completed']) ? 'completed' : '' }} {{ $order->status == 'shipped' ? 'active' : '' }}">
                    <div class="step-icon"><i class="bi bi-box-seam"></i></div>
                    <p>Shipped</p>
                </div>
                <div class="timeline-step {{ $order->status == 'completed' ? 'completed active' : '' }}">
                    <div class="step-icon"><i class="bi bi-check-circle"></i></div>
                    <p>Delivered</p>
                </div>
            </div>
        </div>

        <!-- Order Info & Shipping -->
        <div class="row">
            <div class="col-md-6">
                <div class="info-card">
                    <h5><i class="bi bi-receipt"></i> Order Information</h5>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Order Number</label>
                            <p>#{{ $order->order_number }}</p>
                        </div>
                        <div class="info-item">
                            <label>Date Placed</label>
                            <p>{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="info-item">
                            <label>Status</label>
                            <p><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></p>
                        </div>
                        <div class="info-item">
                            <label>Payment Method</label>
                            <p class="text-uppercase">{{ str_replace('_', ' ', $order->payment_method) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-card">
                    <h5><i class="bi bi-truck"></i> Shipping Details</h5>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Recipient Name</label>
                            <p>{{ $order->shipping_name }}</p>
                        </div>
                        <div class="info-item">
                            <label>Phone Number</label>
                            <p>{{ $order->shipping_phone }}</p>
                        </div>
                        <div class="info-item" style="grid-column: span 2;">
                            <label>Shipping Address</label>
                            <p>{{ $order->shipping_address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="info-card">
            <h5><i class="bi bi-bag"></i> Order Items</h5>
            <table class="order-table">
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
                        <td>
                            <div class="product-info">
                                @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/products/' . $item->product->image) }}" alt="{{ $item->product->title }}">
                                @else
                                <img src="https://via.placeholder.com/60" alt="No Image">
                                @endif
                                <div>
                                    <h6>{{ $item->product_name ?? 'Product' }}</h6>
                                    <p>SKU: {{ $item->product_sku ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </td>
                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="text-end" style="font-weight: 600;">
                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total-row">
                <div class="d-flex">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($order->amount, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>
                <div class="d-flex">
                    <span>Tax</span>
                    <span>Rp 0</span>
                </div>
                <div class="d-flex fw-bold">
                    <span>Grand Total</span>
                    <span class="grand-total">Rp {{ number_format($order->amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

