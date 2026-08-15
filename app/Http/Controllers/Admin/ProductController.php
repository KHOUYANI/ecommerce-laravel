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
            'name'         => 'required|string|max:255',
            'category_id'  => 'required',
            'base_price'   => 'required|numeric|min:0',
            'description'  => 'required|string',
            'image'        => 'nullable|image|max:4096',
            'images.*'     => 'nullable|image|max:4096',
            'image_url'    => 'nullable|url',
            'gallery_urls' => 'nullable|string',
        ]);

        $gallery = [];

        // 1. معالجة رابط الصورة المباشر إن وجد
        if ($request->filled('image_url')) {
            $gallery[] = $request->image_url;
        }

        // 2. معالجة صورة واحدة مرفوعة
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('products', $filename, 'public');
            $gallery[] = '/storage/products/' . $filename;
        }

        // 3. معالجة عدة صور مرفوعة دفعة واحدة من البيسي
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file->isValid()) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('products', $filename, 'public');
                    $gallery[] = '/storage/products/' . $filename;
                }
            }
        }

        // 4. معالجة الروابط الإضافية
        if ($request->filled('gallery_urls')) {
            $urls = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $request->gallery_urls))));
            foreach ($urls as $url) {
                if (!empty($url) && !in_array($url, $gallery)) {
                    $gallery[] = $url;
                }
            }
        }

        $gallery = array_values(array_unique($gallery));
        $mainImageUrl = count($gallery) > 0 ? $gallery[0] : null;

        $product = Product::create([
            'category_id'    => $request->category_id,
            'name'           => $request->name,
            'slug'           => Str::slug($request->name) . '-' . rand(1000, 9999),
            'description'    => $request->description,
            'base_price'     => $request->base_price,
            'image_url'      => $mainImageUrl,
            'gallery_images' => $gallery,
            'sku'            => $request->sku ?? ('SKU-' . strtoupper(Str::random(6))),
            'is_active'      => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'تمت إضافة المنتج مع جميع الصور بنجاح!');
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