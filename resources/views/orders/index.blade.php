@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">My Orders</h1>

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

    @if($orders->isEmpty())
        <div class="card">
            <div class="card-body">
                <p class="text-muted mb-0">You haven't placed any orders yet.</p>
            </div>
        </div>
    @else
        <div class="row">
            @foreach($orders as $order)
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('orders.invoice', $order) }}" class="btn btn-sm btn-secondary" target="_blank">
                                        <i class="fas fa-eye"></i> View Invoice
                                    </a>
                                    <a href="{{ route('orders.download-invoice', $order) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-download"></i> Download Invoice
                                    </a>
                                </div>
                                <div>
                                    <h5 class="card-title">Order #{{ $order->id }}</h5>
                                    <p class="text-muted">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                                </div>
                                <div class="text-end">
                                    <h5 class="mb-0">${{ number_format($order->total_amount, 2) }}</h5>
                                    <span class="badge bg-{{ $order->payment_status === 'pending' ? 'warning' : 'success' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="border-top pt-3">
                                <h6 class="mb-3">Items:</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th class="text-end">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->items as $item)
                                                <tr>
                                                    <td>{{ $item->product->name }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td class="text-end">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @if($order->comments)
                                <div class="border-top pt-3 mt-3">
                                    <h6 class="mb-2">Comments:</h6>
                                    <p class="text-muted mb-0">{{ $order->comments }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection 