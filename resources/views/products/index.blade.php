<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Management</title>
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
                    <h4>Product Management</h4>
                    <p class="text-muted mb-0">Manage your products</p>
                </div>
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-arrow-left me-2"></i> Back to Dashboard
                    </a>
                    <a href="{{ route('product.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i> Add Product
                    </a>
                </div>
            </div>
        </div>

        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/products/' . $product->image) }}"
                                     class="product-thumb" alt="{{ $product->title }}">
                            </td>
                            <td><strong>{{ $product->title }}</strong></td>
                            <td>{{ Str::limit($product->description, 50) }}</td>
                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>
                                @if($product->stock > 0)
                                <span class="badge bg-success">{{ $product->stock }} in stock</span>
                                @else
                                <span class="badge bg-danger">Out of stock</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('product.show', $product->id) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form onsubmit="return confirm('Are you sure?')" action="{{ route('product.destroy', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="bi bi-box-seam"></i>
                                    <h4>No Products Found</h4>
                                    <p>Start adding products to your store.</p>
                                    <a href="{{ route('product.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-2"></i> Add Product
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination">
                {{ $products->links() }}
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

