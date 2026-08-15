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
        $products = Product::with('category')->latest()->paginate(15);
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
            'image'       => 'nullable|image|max:3072',
            'images.*'    => 'nullable|image|max:3072',
            'image_url'   => 'nullable|url',
        ]);

        // 1. معالجة الصورة الرئيسية
        $imageUrl = $request->image_url;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('products', $filename, 'public');
            $imageUrl = '/storage/products/' . $filename;
        }

        // 2. معالجة صور المعرض الإضافية
        $gallery = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('products', $filename, 'public');
                $gallery[] = '/storage/products/' . $filename;
            }
        }
        if ($request->gallery_urls) {
            $urls = array_filter(array_map('trim', explode("\n", $request->gallery_urls)));
            $gallery = array_merge($gallery, $urls);
        }

        if (!$imageUrl && count($gallery) > 0) {
            $imageUrl = $gallery[0];
        }

        Product::create([
            'category_id'    => $request->category_id,
            'name'           => $request->name,
            'slug'           => Str::slug($request->name) . '-' . rand(1000, 9999),
            'description'    => $request->description,
            'base_price'     => $request->base_price,
            'image_url'      => $imageUrl,
            'gallery_images' => count($gallery) > 0 ? json_encode($gallery) : null,
            'sku'            => $request->sku ?? ('SKU-' . strtoupper(Str::random(6))),
            'is_active'      => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'تمت إضافة المنتج بنجاح!');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = Category::firstOrCreate(
            ['name' => $request->name],
            ['slug' => Str::slug($request->name) . '-' . rand(100, 999)]
        );

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'category' => $category]);
        }

        return redirect()->back()->with('success', 'تمت إضافة القسم بنجاح!');
    }
}