<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4>Customer Portal</h4>
        <p>Shopping Cart</p>
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
                <a href="{{ route('customer.cart') }}" class="nav-link active">
                    <i class="bi bi-cart"></i> My Cart
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
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4>My Shopping Cart</h4>
                    <p>{{ $cartItems->count() }} items in your cart</p>
                </div>
            </div>
        </div>

        @if($cartItems->count() > 0)
        <div class="row">
            <div class="col-md-8">
                @foreach($cartItems as $item)
                <div class="cart-item">
                    @if($item->product && $item->product->image)
                    <img src="{{ asset('storage/products/' . $item->product->image) }}"
                         alt="{{ $item->product->title }}">
                    @else
                    <img src="https://via.placeholder.com/100" alt="No Image">
                    @endif

                    <div class="cart-item-info">
                        <h5>{{ $item->product->title ?? 'Product' }}</h5>
                        <div class="price">Rp {{ number_format($item->product->price ?? 0, 0, ',', '.') }}</div>
                    </div>

                    <div class="quantity-control">
                        <form action="{{ route('cart.update', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="number" name="quantity" value="{{ $item->quantity }}"
                                   min="1" max="99" class="form-control"
                                   onchange="this.form.submit()">
                        </form>
                    </div>

                    <div class="item-total">
                        <div class="fw-bold">Rp {{ number_format(($item->product->price ?? 0) * $item->quantity, 0, ',', '.') }}</div>
                    </div>

                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
                @endforeach

                <div class="mt-3">
                    <a href="{{ route('customer.products') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-2"></i> Continue Shopping
                    </a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="summary-card">
                    <h5>Order Summary</h5>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('customer.checkout') }}" class="btn btn-primary w-100 mt-3">
                        <i class="bi bi-lock me-2"></i> Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
        @else
        <div class="info-card">
            <div class="empty-state">
                <i class="bi bi-cart-x"></i>
                <h4>Your Cart is Empty</h4>
                <p>Looks like you haven't added any items to your cart yet.</p>
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

