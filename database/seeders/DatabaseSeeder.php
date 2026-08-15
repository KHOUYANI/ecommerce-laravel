<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Créer un Compte Admin
        User::create([
            'name' => 'Admin Mohamed',
            'email' => 'admin@codstore.ma',
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);

        // 2. Créer des Catégories
        $catElectronics = Category::create([
            'name' => 'Électronique & High-Tech',
            'slug' => 'electronique-high-tech',
            'description' => 'Produits technologiques et accessoires innovants',
        ]);

        $catFashion = Category::create([
            'name' => 'Mode & Vêtements',
            'slug' => 'mode-vetements',
            'description' => 'Collection moderne pour hommes et femmes',
        ]);

        // 3. Créer un Produit Électronique
        $prodWatch = Product::create([
            'category_id' => $catElectronics->id,
            'name' => 'Smartwatch Ultra Pro Max',
            'slug' => 'smartwatch-ultra-pro-max',
            'description' => 'Montre intelligente avec écran AMOLED, suivi santé 24/7 et étanchéité IP68.',
            'base_price' => 299.00,
            'sku' => 'SW-ULTRA-01',
            'is_active' => true,
        ]);

        // Variantes du Produit 1
        $varWatchBlack = ProductVariant::create([
            'product_id' => $prodWatch->id,
            'size' => '49mm',
            'color' => 'Noir',
            'additional_price' => 0,
            'stock_quantity' => 50,
        ]);

        $varWatchSilver = ProductVariant::create([
            'product_id' => $prodWatch->id,
            'size' => '49mm',
            'color' => 'Argent',
            'additional_price' => 30.00,
            'stock_quantity' => 25,
        ]);

        // 4. Créer un Produit Mode
        $prodHoodie = Product::create([
            'category_id' => $catFashion->id,
            'name' => 'Hoodie Oversized Premium Cotton',
            'slug' => 'hoodie-oversized-premium',
            'description' => 'Sweat à capuche oversize 100% coton lourd de haute qualité.',
            'base_price' => 249.00,
            'sku' => 'HD-OVS-02',
            'is_active' => true,
        ]);

        // Variantes du Produit 2
        $varHoodieM = ProductVariant::create([
            'product_id' => $prodHoodie->id,
            'size' => 'M',
            'color' => 'Noir',
            'additional_price' => 0,
            'stock_quantity' => 40,
        ]);

        $varHoodieL = ProductVariant::create([
            'product_id' => $prodHoodie->id,
            'size' => 'L',
            'color' => 'Noir',
            'additional_price' => 0,
            'stock_quantity' => 30,
        ]);



        OrderItem::create([
            'order_id' => $order1->id,
            'product_variant_id' => $varWatchBlack->id,
            'quantity' => 1,
            'unit_price' => 299.00,
        ]);

        $order2 = Order::create([
            'tracking_number' => 'COD-' . strtoupper(Str::random(8)),
            'customer_name' => 'Fatima Ezzahra',
            'customer_phone' => '0678901234',
            'city' => 'Rabat',
            'address' => 'Agdal, Avenue de France',
            'total_amount' => 249.00,
            'status' => 'confirme',
            'admin_notes' => 'Commande confirmée par téléphone.',
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_variant_id' => $varHoodieM->id,
            'quantity' => 1,
            'unit_price' => 249.00,
        ]);
    }
}