@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Buyer Dashboard</h3>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Quick Actions</h5>
                                </div>
                                <div class="card-body">
                                    <a href="{{ route('products.index') }}" class="btn btn-primary mb-2 w-100">Browse Products</a>
                                    <a href="{{ route('orders.index') }}" class="btn btn-secondary mb-2 w-100">View Orders</a>
                                    <a href="{{ route('user-activities.index') }}" class="btn btn-info mb-2 w-100">View Activity</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Recent Orders</h5>
                                </div>
                                <div class="card-body">
                                    @if($orders->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Order ID</th>
                                                        <th>Date</th>
                                                        <th>Total Amount</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($orders as $order)
                                                        <tr>
                                                            <td>#{{ $order->id }}</td>
                                                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                                            <td>${{ number_format($order->total_amount, 2) }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ $order->payment_status === 'pending' ? 'warning' : ($order->payment_status === 'completed' ? 'success' : 'danger') }}">
                                                                    {{ ucfirst($order->payment_status) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">View Details</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <p class="text-muted mb-3">You haven't placed any orders yet.</p>
                                            <a href="{{ route('products.index') }}" class="btn btn-primary">Start Shopping</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Available Products</h5>
                                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary">View All</a>
                                </div>
                                <div class="card-body">
                                    @if($products->count() > 0)
                                        <div class="row">
                                            @foreach($products as $product)
                                                <div class="col-md-4 mb-4">
                                                    <div class="card h-100">
                                                        @if($product->image)
                                                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                                                <span class="text-muted">No image available</span>
                                                            </div>
                                                        @endif
                                                        <div class="card-body">
                                                            <h5 class="card-title">{{ $product->name }}</h5>
                                                            <p class="card-text text-muted">{{ Str::limit($product->description, 100) }}</p>
                                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                                <span class="h5 mb-0">${{ number_format($product->price, 2) }}</span>
                                                                <span class="badge bg-{{ $product->quantity > 0 ? 'success' : 'danger' }}">
                                                                    {{ $product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                                                                </span>
                                                            </div>
                                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary w-100">View Details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $products->links() }}
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <p class="text-muted mb-3">No products available at the moment.</p>
                                            <p class="text-muted">Please check back later.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
