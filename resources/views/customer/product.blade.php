<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Products</title>
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
                <a href="{{ route('customer.products') }}" class="nav-link active">
                    <i class="bi bi-bag-check"></i> Browse Products
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customer.cart') }}" class="nav-link">
                    <i class="bi bi-cart"></i> My Cart
                    @if(isset($cartCount) && $cartCount > 0)
                    <span class="badge bg-danger">{{ $cartCount }}</span>
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
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4>Browse Products</h4>
                    <p>{{ $products->count() }} products available</p>
                </div>
                <a href="{{ route('customer.cart') }}" class="btn btn-outline-primary position-relative">
                    <i class="bi bi-cart"></i> My Cart
                    @if(isset($cartCount) && $cartCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $cartCount }}
                    </span>
                    @endif
                </a>
            </div>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
        <div class="product-grid">
            @foreach($products as $product)
            <div class="product-card">
                @if($product->image)
                <img src="{{ asset('storage/products/' . $product->image) }}"
                     alt="{{ $product->title }}"
                     class="product-image">
                @else
                <div class="product-image bg-light d-flex align-items-center justify-content-center">
                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                </div>
                @endif

                <div class="product-body">
                    <h5 class="product-title">{{ $product->title }}</h5>
                    <p class="product-description">{{ $product->description }}</p>
                    <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    <div class="product-stock {{ $product->stock > 0 ? 'in-stock' : 'out-of-stock' }}">
                        <i class="bi {{ $product->stock > 0 ? 'bi-check-circle' : 'bi-x-circle' }}"></i>
                        {{ $product->stock > 0 ? 'In Stock (' . $product->stock . ' available)' : 'Out of Stock' }}
                    </div>

                    @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100 mt-3">
                            <i class="bi bi-cart-plus me-2"></i> Add to Cart
                        </button>
                    </form>
                    @else
                    <button class="btn btn-secondary w-100 mt-3" disabled>
                        <i class="bi bi-cart-x me-2"></i> Out of Stock
                    </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @if($products->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
        @endif
        @else
        <div class="page-header">
            <div class="empty-state">
                <i class="bi bi-bag-x"></i>
                <h4>No Products Available</h4>
                <p class="text-muted">There are no products available at the moment.</p>
            </div>
        </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

