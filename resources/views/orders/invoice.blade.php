@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">INVOICE</h2>
                        <p class="text-muted mb-0">Order #{{ $order->id }}</p>
                        <p class="text-muted">{{ $order->created_at->format('F d, Y') }}</p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="fw-bold">From</h5>
                            <p class="mb-1">Mini Project Store</p>
                            <p class="mb-1">123 Store Street</p>
                            <p class="mb-0">store@example.com</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h5 class="fw-bold">To</h5>
                            <p class="mb-1">{{ $order->buyer->name }}</p>
                            <p class="mb-1">{{ $order->buyer->email }}</p>
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>Item</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">${{ number_format($item->price, 2) }}</td>
                                    <td class="text-end">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-md-5">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-end">Subtotal:</td>
                                    <td class="text-end">${{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-end">Discount (10%):</td>
                                    <td class="text-end">-${{ number_format($order->discount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-end fw-bold">Total:</td>
                                    <td class="text-end fw-bold">${{ number_format($order->total_amount - $order->discount, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="border-top pt-4 mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold">Payment Method</h6>
                                <p class="mb-0">{{ ucfirst($order->payment_method) }}</p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <h6 class="fw-bold">Payment Status</h6>
                                <p class="mb-0">{{ ucfirst($order->payment_status) }}</p>
                            </div>
                        </div>
                    </div>

                    @if($order->comments)
                    <div class="border-top pt-4 mt-4">
                        <h6 class="fw-bold">Order Comments</h6>
                        <p class="mb-0">{{ $order->comments }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('orders.download-invoice', $order) }}" class="btn btn-primary">
                    <i class="fas fa-download me-2"></i>Download PDF
                </a>
                <button onclick="window.print()" class="btn btn-secondary ms-2">
                    <i class="fas fa-print me-2"></i>Print
                </button>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, nav, footer {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    .container {
        max-width: 100% !important;
        width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }
}
</style>
@endsection
