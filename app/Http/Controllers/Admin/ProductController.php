<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required',
            'base_price'  => 'required|numeric|min:0',
            'description' => 'required|string',
            'image'       => 'nullable|image|max:2048',
            'image_url'   => 'nullable|url',
        ]);

        $imageUrl = $request->image_url;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $imageUrl = '/storage/' . $path;
        }

        Product::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name) . '-' . rand(1000, 9999),
            'description' => $request->description,
            'base_price'  => $request->base_price,
            'image_url'   => $imageUrl,
            'sku'         => $request->sku ?? ('SKU-' . strtoupper(Str::random(6))),
            'is_active'   => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'تمت إضافة ونشر المنتج بنجاح!');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = Category::firstOrCreate(
            ['name' => $request->name],
            ['slug' => Str::slug($request->name) . '-' . rand(100, 999), 'is_active' => 1]
        );

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'category' => $category]);
        }

        return redirect()->back()->with('success', 'تمت إضافة القسم بنجاح!');
    }
}