<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .fw-bold { font-weight: bold; }
        .mb-4 { margin-bottom: 20px; }
        .mb-1 { margin-bottom: 5px; }
        .mb-0 { margin-bottom: 0; }
        .row {
            display: block;
            clear: both;
        }
        .col-md-6 {
            width: 48%;
            float: left;
        }
        .col-md-6.text-end {
            float: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
        }
        .totals {
            width: 300px;
            float: right;
        }
        .totals td {
            border: none;
        }
        .border-top {
            border-top: 1px solid #ddd;
            padding-top: 20px;
            margin-top: 20px;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>
    <div class="text-center mb-4">
        <h2 style="margin-bottom: 5px;">INVOICE</h2>
        <p style="color: #666; margin-bottom: 0;">Order #{{ $order->id }}</p>
        <p style="color: #666;">{{ $order->created_at->format('F d, Y') }}</p>
    </div>

    <div class="row mb-4 clearfix">
        <div class="col-md-6">
            <h4>From</h4>
            <p class="mb-1">Mini Project Store</p>
            <p class="mb-1">123 Store Street</p>
            <p class="mb-0">store@example.com</p>
        </div>
        <div class="col-md-6 text-end">
            <h4>To</h4>
            <p class="mb-1">{{ $order->buyer->name }}</p>
            <p class="mb-0">{{ $order->buyer->email }}</p>
        </div>
    </div>

    <table class="mb-4">
        <thead>
            <tr>
                <th>Item</th>
                <th style="text-align: center;">Quantity</th>
                <th style="text-align: right;">Price</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td style="text-align: center;">{{ $item->quantity }}</td>
                <td style="text-align: right;">${{ number_format($item->price, 2) }}</td>
                <td style="text-align: right;">${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td style="text-align: right;">Subtotal:</td>
            <td style="text-align: right;">${{ number_format($order->total_amount, 2) }}</td>
        </tr>
        <tr>
            <td style="text-align: right;">Discount (10%):</td>
            <td style="text-align: right;">-${{ number_format($order->discount, 2) }}</td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold;">Total:</td>
            <td style="text-align: right; font-weight: bold;">${{ number_format($order->total_amount - $order->discount, 2) }}</td>
        </tr>
    </table>

    <div style="clear: both;"></div>

    <div class="border-top clearfix">
        <div class="col-md-6">
            <h4>Payment Method</h4>
            <p>{{ ucfirst($order->payment_method) }}</p>
        </div>
        <div class="col-md-6 text-end">
            <h4>Payment Status</h4>
            <p>{{ ucfirst($order->payment_status) }}</p>
        </div>
    </div>

    @if($order->comments)
    <div class="border-top">
        <h4>Order Comments</h4>
        <p>{{ $order->comments }}</p>
    </div>
    @endif
</body>
</html>
