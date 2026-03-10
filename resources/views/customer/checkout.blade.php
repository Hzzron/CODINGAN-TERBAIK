<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet">
</head>
<body>
    <div class="checkout-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4>Checkout</h4>
                    <p class="text-muted mb-0">Complete your order</p>
                </div>
                <a href="{{ route('customer.cart') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i> Back to Cart
                </a>
            </div>
        </div>

        <!-- Error/Success Messages -->
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('customer.checkout.process') }}" method="POST" id="checkout-form">
            @csrf
            <div class="checkout-grid">
                <!-- Left Column - Forms -->
                <div class="form-section">
                    <!-- Shipping Information -->
                    <div class="section-title">
                        <i class="bi bi-truck"></i> Shipping Information
                    </div>
                    <div class="form-grup">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="shipping_name" class="form-control"
                               required value="{{ Auth::user()->name ?? '' }}">
                    </div>
                    <div class="form-grup">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="shipping_phone" class="form-control"
                               required placeholder="081234567890">
                    </div>
                    <div class="form-grup">
                        <label class="form-label">Shipping Address</label>
                        <textarea name="shipping_address" class="form-control" rows="4"
                                  required placeholder="Complete address including street, city, postal code"></textarea>
                    </div>

                    <!-- Payment Method -->
                    <div class="section-title" style="margin-top: 30px;">
                        <i class="bi bi-credit-card"></i> Payment Method
                    </div>
                    <div class="payment-methods">
                        <label class="payment-option selected">
                            <input type="radio" name="payment_method" value="bank_transfer" checked>
                            <i class="bi bi-bank text-primary"></i>
                            <span>Bank Transfer</span>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="COD">
                            <i class="bi bi-cash text-success"></i>
                            <span>COD</span>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="e_wallet">
                            <i class="bi bi-wallet2 text-warning"></i>
                            <span>E-Wallet</span>
                        </label>
                    </div>
                </div>

                <!-- Right Column - Order Summary -->
                <div class="summary-card">
                    <div class="section-title">
                        <i class="bi bi-receipt"></i> Order Summary
                    </div>

                    @foreach($cartItems as $item)
                        <div class="summary-row" style="border-bottom: 1px solid #f1f5f9; padding-bottom: 10px; margin-bottom: 10px;">
                            <div>
                                <strong>{{ $item->product->title ?? 'Product' }}</strong>
                                <div class="text-muted small">Qty: {{ $item->quantity }}</div>
                            </div>
                            <span>Rp {{ number_format(($item->product->price ?? 0) * $item->quantity, 0, ',', '.') }}</span>
                        </div>
                    @endforeach

                    <div class="summary-row total">
                        <span>Total</span>
                        <span>Rp {{ number_format($total ?? 0, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" class="btn-confirm">
                        Place Order <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Simple click handler for visual selection
        document.querySelectorAll('.payment-option').forEach(function(option) {
            option.addEventListener('click', function() {
                document.querySelectorAll('.payment-option').forEach(function(opt) {
                    opt.classList.remove('selected');
                });
                this.classList.add('selected');
            });
        });
    </script>
</body>
</html>

