@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}">
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 400px;">
                    <span class="text-muted">No image available</span>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <h1 class="mb-3">{{ $product->name }}</h1>
            <p class="text-muted mb-4">{{ $product->description }}</p>
            
            <div class="mb-4">
                <h3 class="mb-0">${{ number_format($product->price, 2) }}</h3>
                <span class="badge bg-{{ $product->quantity > 0 ? 'success' : 'danger' }}">
                    {{ $product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                </span>
                <p class="text-muted mt-2">Available: {{ $product->quantity }}</p>
            </div>

            @if($product->quantity > 0)
                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="items[0][product_id]" value="{{ $product->id }}">
                    
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity:</label>
                        <input type="number" class="form-control" id="quantity" 
                               name="items[0][quantity]" value="1" min="1" max="{{ $product->quantity }}">
                    </div>

                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method:</label>
                        <select class="form-select" id="payment_method" name="payment_method" required>
                            <option value="cash">Cash</option>
                            <option value="credit_card">Credit Card</option>
                            <option value="bank_transfer">Bank Transfer</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="comments" class="form-label">Comments (Optional):</label>
                        <textarea class="form-control" id="comments" name="comments" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Place Order</button>
                </form>
            @else
                <button class="btn btn-secondary w-100" disabled>Out of Stock</button>
            @endif

            <div class="mt-4">
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Products
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 