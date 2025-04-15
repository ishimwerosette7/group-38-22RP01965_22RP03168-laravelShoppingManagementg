@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Seller Dashboard</h3>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Quick Actions</h5>
                                </div>
                                <div class="card-body">
                                    <a href="{{ route('seller.products.create') }}" class="btn btn-primary mb-2">Add New Product</a>
                                    <a href="{{ route('seller.products.all') }}" class="btn btn-success mb-2">View All Products</a>
                                    <a href="{{ route('user-activities.index') }}" class="btn btn-info mb-2">View User Activities</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Recent User Activities</h5>
                                </div>
                                <div class="card-body">
                                    @if($activities->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>User</th>
                                                        <th>Action</th>
                                                        <th>Time</th>
                                                        <th>Details</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($activities as $activity)
                                                        <tr>
                                                            <td>{{ $activity->user->name }}</td>
                                                            <td>{{ $activity->action }}</td>
                                                            <td>{{ $activity->login_time ? $activity->login_time->format('Y-m-d H:i:s') : 'N/A' }}</td>
                                                            <td>{{ $activity->details }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p>No recent user activities.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Your Products</h5>
                                </div>
                                <div class="card-body">
                                    @if($products->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Image</th>
                                                        <th>Name</th>
                                                        <th>Type</th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($products as $product)
                                                        <tr>
                                                            <td>
                                                                @if($product->image)
                                                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                                                         alt="{{ $product->name }}" 
                                                                         style="max-width: 50px;">
                                                                @else
                                                                    No image
                                                                @endif
                                                            </td>
                                                            <td>{{ $product->name }}</td>
                                                            <td>{{ ucfirst($product->type) }}</td>
                                                            <td>${{ number_format($product->price, 2) }}</td>
                                                            <td>{{ $product->quantity }}</td>
                                                            <td>
                                                                <a href="{{ route('seller.products.edit', $product) }}" class="btn btn-sm btn-primary">Edit</a>
                                                                <form action="{{ route('seller.products.destroy', $product) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p>No products found.</p>
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
