<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
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

        // 1. رابط مباشر
        if ($request->filled('image_url')) {
            $gallery[] = $request->image_url;
        }

        // 2. صورة واحدة من الجهاز
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('products', $filename, 'public');
            $gallery[] = '/storage/products/' . $filename;
        }

        // 3. صور متعددة من الجهاز
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file->isValid()) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('products', $filename, 'public');
                    $gallery[] = '/storage/products/' . $filename;
                }
            }
        }

        // 4. روابط نصية إضافية
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

        Product::create([
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

        return redirect()->route('admin.products.index')->with('success', 'تمت إضافة ونشر المنتج بنجاح!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name'            => 'required|string|max:255',
            'category_id'     => 'required',
            'base_price'      => 'required|numeric|min:0',
            'description'     => 'required|string',
            'image'           => 'nullable|image|max:4096',
            'images.*'        => 'nullable|image|max:4096',
            'image_url'       => 'nullable|url',
            'existing_images' => 'nullable|array',
        ]);

        // 1. الاحتفاظ فقط بالصور التي لم يحذفها المستخدم
        $gallery = $request->input('existing_images', []);

        // 2. إضافة رابط مباشر جديد إن وجد
        if ($request->filled('image_url')) {
            if (!in_array($request->image_url, $gallery)) {
                $gallery[] = $request->image_url;
            }
        }

        // 3. رفع صورة واحدة جديدة إن وجدت
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('products', $filename, 'public');
            $gallery[] = '/storage/products/' . $filename;
        }

        // 4. رفع صور متعددة جديدة إن وجدت
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file->isValid()) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('products', $filename, 'public');
                    $gallery[] = '/storage/products/' . $filename;
                }
            }
        }

        // 5. روابط نصية إضافية
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

        $product->update([
            'category_id'    => $request->category_id,
            'name'           => $request->name,
            'description'    => $request->description,
            'base_price'     => $request->base_price,
            'image_url'      => $mainImageUrl,
            'gallery_images' => $gallery,
            'sku'            => $request->sku ?? $product->sku,
            'is_active'      => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'تم تعديل المنتج وتحديث الصور بنجاح!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image_url && str_starts_with($product->image_url, '/storage/products/')) {
            $path = str_replace('/storage/', '', $product->image_url);
            Storage::disk('public')->delete($path);
        }

        if (!empty($product->gallery_images) && is_array($product->gallery_images)) {
            foreach ($product->gallery_images as $gImg) {
                if ($gImg && str_starts_with($gImg, '/storage/products/')) {
                    $path = str_replace('/storage/', '', $gImg);
                    Storage::disk('public')->delete($path);
                }
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'تم حذف المنتج بنجاح نهائياً!');
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