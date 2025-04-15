<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.product', 'buyer'])
            ->where('buyer_id', Auth::id())
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'payment_method' => ['required', 'string', 'in:cash,credit_card,bank_transfer'],
            'comments' => ['nullable', 'string'],
        ]);

        $totalAmount = 0;
        $orderItems = [];

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            
            if ($product->quantity < $item['quantity']) {
                return back()->with('error', "Insufficient quantity for product: {$product->name}");
            }

            $totalAmount += $product->price * $item['quantity'];
            $orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ];

            // Update product quantity
            $product->decrement('quantity', $item['quantity']);
        }

        // Calculate discount (10%)
        $discount = $totalAmount * 0.1;
        $finalAmount = $totalAmount - $discount;

        $order = Order::create([
            'buyer_id' => Auth::id(),
            'total_amount' => $totalAmount,
            'discount' => $discount,
            'payment_method' => strtolower($request->payment_method),
            'payment_status' => 'pending',
            'comments' => $request->comments,
        ]);

        // Create order items
        foreach ($orderItems as $item) {
            $order->items()->create($item);
        }

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }

    public function show(Order $order)
    {
        if ($order->buyer_id !== Auth::id()) {
            abort(403);
        }

        return view('orders.show', compact('order'));
    }

    public function invoice(Order $order)
    {
        if ($order->buyer_id !== Auth::id()) {
            abort(403);
        }

        return view('orders.invoice', compact('order'));
    }

    public function downloadInvoice(Order $order)
    {
        if ($order->buyer_id !== Auth::id()) {
            abort(403);
        }

        $pdf = PDF::loadView('orders.invoice-pdf', compact('order'));
        
        return $pdf->download('invoice-' . $order->id . '.pdf');
    }
}