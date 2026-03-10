<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Details</title>
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
                    <h4>Product Details</h4>
                    <p class="text-muted mb-0">View product information</p>
                </div>
                <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i> Back to Products
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body text-center">
                        @if($product->image)
                        <img src="{{ asset('storage/products/' . $product->image) }}"
                             alt="{{ $product->title }}" class="img-fluid rounded" style="max-width: 100%;">
                        @else
                        <div class="text-center py-5">
                            <i class="bi bi-image" style="font-size: 4rem; color: #cbd5e1;"></i>
                            <p class="mt-2 text-muted">No image available</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-4">{{ $product->title }}</h3>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Price</label>
                                    <p class="fs-4 fw-bold text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Stock</label>
                                    <p>
                                        @if($product->stock > 0)
                                        <span class="badge bg-success">{{ $product->stock }} available</span>
                                        @else
                                        <span class="badge bg-danger">Out of stock</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label>Description</label>
                            <p class="text-muted">{{ $product->description }}</p>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary">
                                <i class="bi bi-pencil me-2"></i> Edit Product
                            </a>
                            <form action="{{ route('product.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash me-2"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

