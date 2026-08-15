<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل المنتج | MED EXPRESS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Tajawal', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased selection:bg-emerald-500 selection:text-white">

    <header class="bg-slate-900 text-white sticky top-0 z-40 shadow-md">
        <div class="max-w-4xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="bg-emerald-500 text-slate-900 font-black px-2 py-0.5 rounded text-sm">M</span>
                <h1 class="text-lg font-black text-emerald-400">تعديل المنتج: {{ $product->name }}</h1>
            </div>
            <a href="{{ route('admin.products.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-200 px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 border border-slate-700">
                <span>⬅️</span>
                <span>الرجوع للمنتجات</span>
            </a>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-6 py-8">
        
        @if ($errors->any())
            <div class="bg-rose-50 border-r-4 border-rose-500 p-4 rounded-xl mb-6 shadow-sm">
                <div class="flex items-center gap-2 text-rose-700 font-bold text-sm mb-1">
                    <span>⚠️</span>
                    <span>يرجى تصحيح الأخطاء التالية:</span>
                </div>
                <ul class="list-disc list-inside text-xs text-rose-600 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $currentImages = [];
            if (!empty($product->gallery_images)) {
                $currentImages = is_array($product->gallery_images) ? $product->gallery_images : json_decode($product->gallery_images, true);
                if (!is_array($currentImages)) $currentImages = [];
            }
            if (empty($currentImages) && $product->image_url) {
                $currentImages[] = $product->image_url;
            }
        @endphp

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- الاسم والتصنيف -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">اسم المنتج * :</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required 
                               class="w-full border border-slate-300 rounded-xl p-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">القسم (Catégorie) * :</label>
                        <select name="category_id" required class="w-full border border-slate-300 rounded-xl p-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- السعر و SKU -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">ثمن البيع (MAD) * :</label>
                        <input type="number" step="0.01" name="base_price" value="{{ old('base_price', $product->base_price) }}" required 
                               class="w-full border border-slate-300 rounded-xl p-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">رمز المنتج (SKU):</label>
                        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" 
                               class="w-full border border-slate-300 rounded-xl p-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                </div>

                <!-- استعراض الصور الحالية المسجلة -->
                @if(count($currentImages) > 0)
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-2">
                        <label class="block text-xs font-bold text-slate-700">الصور الحالية للمنتج ({{ count($currentImages) }}):</label>
                        <div class="flex flex-wrap gap-3">
                            @foreach($currentImages as $idx => $cImg)
                                @php
                                    $showSrc = (!str_starts_with($cImg, 'http') && !str_starts_with($cImg, '/storage/')) ? '/storage/' . $cImg : $cImg;
                                @endphp
                                <div class="w-16 h-16 rounded-xl border border-slate-300 overflow-hidden bg-white p-1 relative shadow-sm">
                                    <img src="{{ $showSrc }}" class="w-full h-full object-contain" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800';">
                                    <span class="absolute bottom-0 right-0 bg-slate-900 text-white text-[8px] px-1 rounded-tl">#{{ $idx + 1 }}</span>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-[10px] text-slate-500">💡 هذه الصور ستبقى محفوظة كما هي ما لم تقم بإضافة صور جديدة بالأسفل.</p>
                    </div>
                @endif

                <!-- إضافة صور جديدة -->
                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-4">
                    <h3 class="font-bold text-xs text-slate-800">📸 إضافة أو تحديث الصور:</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white p-3.5 rounded-xl border border-slate-200">
                            <label class="block text-xs font-bold text-slate-700 mb-1">رفع صور جديدة من الجهاز:</label>
                            <input type="file" name="images[]" multiple accept="image/*" class="w-full text-xs p-1">
                        </div>

                        <div class="bg-white p-3.5 rounded-xl border border-slate-200">
                            <label class="block text-xs font-bold text-slate-700 mb-1">أو رابط صورة خارجي (Image URL):</label>
                            <input type="url" name="image_url" placeholder="https://images.unsplash.com/..." class="w-full border border-slate-300 rounded-lg p-2 text-xs outline-none">
                        </div>
                    </div>
                </div>

                <!-- الوصف -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2">وصف ومميزات المنتج * :</label>
                    <textarea name="description" rows="4" required class="w-full border border-slate-300 rounded-xl p-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none leading-relaxed">{{ old('description', $product->description) }}</textarea>
                </div>

                <!-- تفعيل المنتج -->
                <div class="flex items-center gap-3 bg-emerald-50 p-4 rounded-xl border border-emerald-200">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} 
                           class="w-5 h-5 text-emerald-600 rounded focus:ring-emerald-500 cursor-pointer">
                    <label for="is_active" class="text-xs font-bold text-emerald-900 cursor-pointer">
                        تفعيل ونشر المنتج في المتجر
                    </label>
                </div>

                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 rounded-xl shadow-lg transition duration-200 text-sm flex items-center justify-center gap-2">
                    <span>💾</span>
                    <span>حفظ التعديلات وتحديث المنتج</span>
                </button>
            </form>
        </div>
    </main>

</body>
</html>