<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@ehsanelectronics.com',
            'phone' => '03001234567',
            'city' => 'Lahore',
            'password' => Hash::make('password'),
            'role' => UserRole::Admin,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Ali Customer',
            'email' => 'customer@ehsanelectronics.com',
            'phone' => '03007654321',
            'city' => 'Karachi',
            'password' => Hash::make('password'),
            'role' => UserRole::Customer,
            'email_verified_at' => now(),
        ]);

        $categories = [
            ['name' => 'Mobile Phones', 'slug' => 'mobile-phones'],
            ['name' => 'Laptops', 'slug' => 'laptops'],
            ['name' => 'Audio', 'slug' => 'audio'],
            ['name' => 'Accessories', 'slug' => 'accessories'],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        $products = [
            [
                'title' => 'Wireless Bluetooth Headphones',
                'slug' => 'wireless-bluetooth-headphones',
                'description' => 'Premium noise-cancelling wireless headphones with 30-hour battery life. Perfect for daily use in Pakistan.',
                'price' => 14999,
                'sale_price' => 11999,
                'stock' => 50,
                'category_id' => 3,
                'is_featured' => true,
                'image_path' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&h=800&fit=crop',
            ],
            [
                'title' => 'Smart Watch Pro',
                'slug' => 'smart-watch-pro',
                'description' => 'Advanced fitness tracking smartwatch with heart rate monitor, GPS, and water resistance.',
                'price' => 29999,
                'sale_price' => null,
                'stock' => 30,
                'category_id' => 4,
                'is_featured' => true,
                'image_path' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&h=800&fit=crop',
            ],
            [
                'title' => 'Power Bank 20000mAh',
                'slug' => 'power-bank-20000mah',
                'description' => 'Fast charging dual USB power bank with LED display. Ideal for travel across Pakistan.',
                'price' => 4999,
                'sale_price' => 3999,
                'stock' => 100,
                'category_id' => 4,
                'is_featured' => true,
                'image_path' => 'https://images.unsplash.com/photo-1609091839311-b2988f2bdba9?w=800&h=800&fit=crop',
            ],
            [
                'title' => 'Wireless Mouse',
                'slug' => 'wireless-mouse',
                'description' => 'Ergonomic wireless mouse with silent clicks and long battery life.',
                'price' => 2499,
                'sale_price' => null,
                'stock' => 80,
                'category_id' => 4,
                'is_featured' => false,
                'image_path' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=800&h=800&fit=crop',
            ],
            [
                'title' => 'Mechanical Keyboard RGB',
                'slug' => 'mechanical-keyboard-rgb',
                'description' => 'Gaming mechanical keyboard with RGB backlight and blue switches.',
                'price' => 8999,
                'sale_price' => 7499,
                'stock' => 40,
                'category_id' => 4,
                'is_featured' => true,
                'image_path' => 'https://images.unsplash.com/photo-1511467687858-23d96c32e4ae?w=800&h=800&fit=crop',
            ],
            [
                'title' => 'USB-C Hub 7-in-1',
                'slug' => 'usb-c-hub-7-in-1',
                'description' => 'Expand your laptop with HDMI, USB 3.0, SD card reader and more.',
                'price' => 5999,
                'sale_price' => null,
                'stock' => 60,
                'category_id' => 2,
                'is_featured' => false,
                'image_path' => 'https://images.unsplash.com/photo-1625948515291-69613efd103f?w=800&h=800&fit=crop',
            ],
            [
                'title' => 'Bluetooth Speaker Mini',
                'slug' => 'bluetooth-speaker-mini',
                'description' => 'Portable waterproof Bluetooth speaker with deep bass and 12-hour playtime.',
                'price' => 6999,
                'sale_price' => 5499,
                'stock' => 75,
                'category_id' => 3,
                'is_featured' => true,
                'image_path' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=800&h=800&fit=crop',
            ],
            [
                'title' => 'Laptop Stand Aluminum',
                'slug' => 'laptop-stand-aluminum',
                'description' => 'Adjustable aluminum laptop stand for better posture and cooling.',
                'price' => 3499,
                'sale_price' => null,
                'stock' => 45,
                'category_id' => 2,
                'is_featured' => true,
                'image_path' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=800&h=800&fit=crop',
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
