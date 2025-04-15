<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class ProductController extends Controller
{
    public function index()
    {
        if (Auth::user()->isSeller()) {
            $products = Product::where('seller_id', Auth::id())->paginate(9);
            $activities = UserActivity::with('user')
                ->latest()
                ->take(5)
                ->get();
            return view('seller.dashboard', compact('products', 'activities'));
        } else {
            $products = Product::where('quantity', '>', 0)->paginate(9);
            return view('products.index', compact('products'));
        }
    }
    public function show(Product $product)
    {
        if ($product->quantity <= 0) {
            return redirect()->route('products.index')
                ->with('error', 'This product is currently out of stock.');
        }

        return view('products.show', compact('product'));
    }

    public function create()
    {
        return view('products.create');
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
            return redirect()->route('seller.dashboard')
                ->with('error', 'You are not authorized to edit this product.');
        }

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->seller_id !== Auth::id()) {
            return redirect()->route('seller.dashboard')
                ->with('error', 'You are not authorized to update this product.');
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
            return redirect()->route('seller.dashboard')
                ->with('error', 'You are not authorized to delete this product.');
        }
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('seller.dashboard')
            ->with('success', 'Product deleted successfully!');
    }
} 
