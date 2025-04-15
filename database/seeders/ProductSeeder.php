<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Create a seller user if not exists
        $seller = User::firstOrCreate(
            ['email' => 'seller@example.com'],
            [
                'full_name' => 'Sample Seller',
                'password' => bcrypt('password'),
                'account_type' => 'seller',
                'phone_number' => '1234567890',
                'address' => '123 Seller Street',
                'business_name' => 'Sample Store',
                'business_type' => 'retail'
            ]
        );

        // Sample products
        $products = [
            [
                'name' => 'Nike Air Max',
                'type' => 'shoes',
                'description' => 'Comfortable running shoes with air cushioning',
                'price' => 120.00,
                'quantity' => 10,
                'image' => null,
            ],
            [
                'name' => 'Adidas Ultraboost',
                'type' => 'shoes',
                'description' => 'Premium running shoes with responsive boost technology',
                'price' => 180.00,
                'quantity' => 8,
                'image' => null,
            ],
            [
                'name' => 'Levi\'s 501 Jeans',
                'type' => 'clothes',
                'description' => 'Classic straight fit jeans',
                'price' => 80.00,
                'quantity' => 15,
                'image' => null,
            ],
            [
                'name' => 'H&M T-Shirt',
                'type' => 'clothes',
                'description' => 'Basic cotton t-shirt',
                'price' => 15.00,
                'quantity' => 20,
                'image' => null,
            ],
            [
                'name' => 'Puma RS-X',
                'type' => 'shoes',
                'description' => 'Retro-inspired sneakers with chunky design',
                'price' => 100.00,
                'quantity' => 12,
                'image' => null,
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['name' => $product['name']],
                array_merge($product, ['seller_id' => $seller->id])
            );
        }
    }
} 
