@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">All Available Products</h1>
        <a href="{{ route('seller.dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back to Dashboard</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($product->image)
                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-400">No Image</span>
                </div>
            @endif
            
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $product->name }}</h3>
                <p class="text-gray-600 text-sm mb-2">{{ Str::limit($product->description, 100) }}</p>
                
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-700 font-medium">Price:</span>
                    <span class="text-green-600 font-bold">${{ number_format($product->price, 2) }}</span>
                </div>
                
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-700 font-medium">Stock:</span>
                    <span class="text-blue-600">{{ $product->quantity }} units</span>
                </div>
                
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-700 font-medium">Total Orders:</span>
                    <span class="text-purple-600">{{ $product->total_orders }}</span>
                </div>
                
                <div class="mt-3 pt-3 border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        Seller: {{ $product->seller->name }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection
