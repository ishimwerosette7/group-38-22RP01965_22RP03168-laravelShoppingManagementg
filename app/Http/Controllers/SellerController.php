<?php
namespace App\Http\Controllers;
use App\Models\UserActivity;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class SellerController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $seller = Auth::user();
        $totalProducts = Product::where('seller_id', $seller->id)->count();
        $totalOrders = Order::whereHas('items.product', function($query) use ($seller) {
            $query->where('seller_id', $seller->id);
        })->count();
        
        $totalRevenue = Order::whereHas('items.product', function($query) use ($seller) {
            $query->where('seller_id', $seller->id);
        })->sum('total_amount');

        $products = Product::where('seller_id', $seller->id)
            ->latest()
            ->paginate(10);

        $activities = UserActivity::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('seller.dashboard', compact(
            'totalProducts', 
            'totalOrders', 
            'totalRevenue', 
            'products',
            'activities'
        ));
    }
    public function create()
    {
        return view('seller.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:shoes,clothes',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = new Product($validated);
        $product->seller_id = Auth::id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->save();

        return redirect()->route('seller.dashboard')
            ->with('success', 'Product added successfully!');
    }

    public function edit(Product $product)
    {
        if ($product->seller_id !== Auth::id()) {
            abort(403);
        }

        return view('seller.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->seller_id !== Auth::id()) {
            abort(403);
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:shoes,clothes',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);

        return redirect()->route('seller.dashboard')
            ->with('success', 'Product updated successfully!');
    }
    public function destroy(Product $product)
    {
        if ($product->seller_id !== Auth::id()) {
            abort(403);
        }
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('seller.dashboard')
            ->with('success', 'Product deleted successfully!');
    }
    public function allProducts()
    {
        $products = Product::with('seller')
            ->select('products.*', DB::raw('(SELECT COUNT(*) FROM order_items WHERE order_items.product_id = products.id) as total_orders'))
            ->latest()
            ->paginate(12);
        return view('seller.products.all', compact('products'));
    }
}
