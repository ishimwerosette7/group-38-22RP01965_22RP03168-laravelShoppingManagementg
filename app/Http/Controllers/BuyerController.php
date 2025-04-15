<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
    public function dashboard()
    {
        $products = Product::where('quantity', '>', 0)
            ->with('seller')
            ->latest()
            ->paginate(6);

        $orders = Auth::user()->orders()
            ->with(['items.product'])
            ->latest()
            ->take(5)
            ->get();

        return view('buyer.dashboard', compact('products', 'orders'));
    }
} 