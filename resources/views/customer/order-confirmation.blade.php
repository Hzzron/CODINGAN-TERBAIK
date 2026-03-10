<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }

        .confirmation-wrapper {
            width: 100%;
            max-width: 500px;
        }

        .confirmation-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            animation: scaleIn 0.5s ease-out 0.2s both;
            box-shadow: 0 10px 30px rgba(34, 197, 94, 0.4);
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }

        .success-icon i {
            font-size: 50px;
            color: white;
        }

        .confirmation-card h2 {
            color: #1f2937;
            font-weight: 700;
            margin-bottom: 8px;
            font-size: 1.8rem;
        }

        .confirmation-card .subtitle {
            color: #6b7280;
            margin-bottom: 30px;
            font-size: 1rem;
        }

        .order-details {
            background: #f9fafb;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            text-align: left;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-row .label {
            color: #6b7280;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .detail-row .value {
            color: #1f2937;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .detail-row.total {
            border-top: 2px solid #e5e7eb;
            margin-top: 10px;
            padding-top: 20px;
        }

        .detail-row.total .label,
        .detail-row.total .value {
            font-size: 1.1rem;
            font-weight: 700;
            color: #667eea;
        }

        .btn-group {
            display: flex;
            gap: 15px;
            flex-direction: column;
        }

        .btn-home {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 15px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
            color: white;
            text-decoration: none;
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 15px 30px;
            border: 2px solid #e5e7eb;
            color: #6b7280;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline:hover {
            background: #f9fafb;
            border-color: #667eea;
            color: #667eea;
            text-decoration: none;
        }

        .order-id {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }

        .payment-badge {
            display: inline-block;
            padding: 5px 12px;
            background: #e0e7ff;
            color: #4338ca;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: capitalize;
        }
    </style>
</head>
<body>
    <div class="confirmation-wrapper">
        <div class="confirmation-card">
            <div class="success-icon">
                <i class="bi bi-check-lg"></i>
            </div>
            <h2>Payment Successful!</h2>
            <p class="subtitle">Thank you for your order</p>

            <div class="order-details">
                <div class="detail-row">
                    <span class="label">Order Number</span>
                    <span class="value order-id">{{ $order->order_name }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Date</span>
                    <span class="value">{{ $order->created_at->format('D M Y, H:i') }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Payment Method</span>
                    <span class="payment-badge">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Status</span>
                    <span class="badge badge-pending">{{ ucfirst($order->payment_status) }}</span>
                </div>
                <div class="detail-row total">
                    <span class="label">Total Amount</span>
                    <span class="value">Rp {{ number_format($order->amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="btn-group">
                <a href="{{ route('customer.products') }}" class="btn-home">
                    <i class="bi bi-bag"></i> Continue Shopping
                </a>
                <a href="{{ route('customer.orders') }}" class="btn-outline">
                    <i class="bi bi-clock-history"></i> View Order History
                </a>
            </div>
        </div>
    </div>
</body>
</html>
