@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Browse Products</h1>

    @if(session('error'))
        <div class="alert alert-danger mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="h5 mb-0">${{ number_format($product->price, 2) }}</span>
                            <span class="badge bg-{{ $product->quantity > 0 ? 'success' : 'danger' }}">
                                {{ $product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                            </span>
                        </div>
                        <p class="text-muted small mb-3">Available: {{ $product->quantity }}</p>
                        
                        @if($product->quantity > 0)
                            <form action="{{ route('orders.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="items[0][product_id]" value="{{ $product->id }}">
                                <div class="mb-3">
                                    <label for="quantity{{ $product->id }}" class="form-label">Quantity:</label>
                                    <input type="number" class="form-control" id="quantity{{ $product->id }}" 
                                           name="items[0][quantity]" value="1" min="1" max="{{ $product->quantity }}">
                                </div>
                                <div class="mb-3">
                                    <label for="payment_method{{ $product->id }}" class="form-label">Payment Method:</label>
                                    <select class="form-select" id="payment_method{{ $product->id }}" name="payment_method" required>
                                        <option value="cash">Cash</option>
                                        <option value="credit_card">Credit Card</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="comments{{ $product->id }}" class="form-label">Comments (Optional):</label>
                                    <textarea class="form-control" id="comments{{ $product->id }}" name="comments" rows="2"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Place Order</button>
                            </form>
                        @else
                            <button class="btn btn-secondary w-100" disabled>Out of Stock</button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <p class="text-muted mb-0">No products available.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    @if($products->hasPages())
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection 