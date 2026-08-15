<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة منتج جديد | MED EXPRESS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Tajawal', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800">

    <header class="bg-slate-900 text-white sticky top-0 z-40 shadow-md">
        <div class="max-w-4xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="bg-emerald-500 text-slate-900 font-black px-2 py-0.5 rounded text-sm">M</span>
                <h1 class="text-lg font-black text-emerald-400">إضافة منتج جديد إلى المتجر</h1>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-200 px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 border border-slate-700">
                <span>⬅️</span>
                <span>الرجوع للطلبيات</span>
            </a>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-6 py-8">
        
        @if(session('success'))
            <div class="bg-emerald-50 border-r-4 border-emerald-500 p-4 rounded-xl mb-6 shadow-sm text-emerald-800 font-bold text-xs flex items-center gap-2">
                <span>✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

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

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- اسم المنتج والقسم --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">اسم المنتج * :</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="مثال: ساعة ذكية فاخرة Ultra Pro" required 
                               class="w-full border @error('name') border-rose-500 bg-rose-50 @else border-slate-300 @enderror rounded-xl p-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none transition">
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-xs font-bold text-slate-700">القسم (Catégorie) * :</label>
                            <button type="button" onclick="document.getElementById('addCategoryModal').classList.remove('hidden')" class="text-xs text-emerald-600 hover:text-emerald-700 font-bold flex items-center gap-1 bg-emerald-50 hover:bg-emerald-100 px-2 py-0.5 rounded-lg border border-emerald-200 transition">
                                <span>➕</span>
                                <span>إضافة قسم جديد</span>
                            </button>
                        </div>
                        <select name="category_id" id="categorySelect" required class="w-full border border-slate-300 rounded-xl p-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                            <option value="" disabled selected>-- اختر القسم المناسب --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- الأسعار والمخزون --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">ثمن البيع (MAD) * :</label>
                        <input type="number" step="0.01" name="base_price" value="{{ old('base_price') }}" placeholder="249.00" required 
                               class="w-full border @error('base_price') border-rose-500 bg-rose-50 @else border-slate-300 @enderror rounded-xl p-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">الثمن قبل التخفيض (اختياري):</label>
                        <input type="number" step="0.01" name="compare_price" value="{{ old('compare_price') }}" placeholder="399.00" 
                               class="w-full border border-slate-300 rounded-xl p-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">رمز المنتج (SKU اختياري):</label>
                        <input type="text" name="sku" value="{{ old('sku') }}" placeholder="مثال: WATCH-01" 
                               class="w-full border border-slate-300 rounded-xl p-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                </div>

                {{-- المقاس واللون والمخزون --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">الكمية فالمخزون (Stock) * :</label>
                        <input type="number" name="stock" value="{{ old('stock', 50) }}" min="1" required 
                               class="w-full border border-slate-300 rounded-xl p-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">المقاسات المتاحة (اختياري):</label>
                        <input type="text" name="size" value="{{ old('size') }}" placeholder="Standard أو S, M, L" 
                               class="w-full border border-slate-300 rounded-xl p-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">الألوان المتاحة (اختياري):</label>
                        <input type="text" name="color" value="{{ old('color') }}" placeholder="أسود، كحلي، برتقالي" 
                               class="w-full border border-slate-300 rounded-xl p-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                </div>

                {{-- 📸 قسم الصور المتعددة التفاعلي --}}
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="font-bold text-xs text-slate-800 flex items-center gap-2">
                            <span>📸</span>
                            <span>صور المنتج (الرئيسية + صور المعرض)</span>
                        </h3>
                        <span class="text-[10px] text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full font-bold">يدعم اختيار صور متعددة</span>
                    </div>

                    {{-- مربع الرفع السريع مع السحب والإفلات --}}
                    <div class="relative border-2 border-dashed border-slate-300 hover:border-emerald-500 bg-white rounded-2xl p-6 text-center transition cursor-pointer group">
                        <input type="file" name="images[]" id="imagesInput" accept="image/*" multiple 
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="space-y-2">
                            <span class="text-3xl block group-hover:scale-110 transition-transform">🖼️</span>
                            <div class="text-xs font-bold text-slate-700">
                                اضغط هنا لاختيار عدة صور، أو اسحب الصور وضعها هنا مباشرة
                            </div>
                            <p class="text-[11px] text-slate-400 font-normal">
                                اضغط وابقَ ضاغطاً على زر <kbd class="bg-slate-100 border px-1 rounded text-slate-600 font-mono">Ctrl</kbd> لتحديد عدة صور دفعة واحدة
                            </p>
                        </div>
                    </div>

                    {{-- روابط صور مباشرة --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">رابط صورة رئيسية مباشر (اختياري):</label>
                            <input type="url" name="image_url" value="{{ old('image_url') }}" placeholder="https://images.unsplash.com/..." 
                                   class="w-full border border-slate-300 rounded-xl p-2.5 text-xs outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">روابط صور إضافية (رابط فكل سطر):</label>
                            <textarea name="gallery_urls" rows="1" placeholder="https://image1.jpg&#10;https://image2.jpg" 
                                      class="w-full border border-slate-300 rounded-xl p-2 text-xs outline-none focus:ring-2 focus:ring-emerald-500 font-mono bg-white"></textarea>
                        </div>
                    </div>

                    {{-- معاينة فورية للصور المختارة مع إمكانية الحذف --}}
                    <div id="previewContainer" class="hidden pt-3 border-t border-slate-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-slate-700" id="selectedCount">الصور المختارة (0):</span>
                        </div>
                        <div id="imageGrid" class="grid grid-cols-3 sm:grid-cols-6 gap-3"></div>
                    </div>
                </div>

                {{-- الوصف --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2">وصف ومميزات المنتج * :</label>
                    <textarea name="description" rows="4" placeholder="اكتب تفاصيل ومواصفات المنتج وعروض التوصيل هنا..." required 
                              class="w-full border border-slate-300 rounded-xl p-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none leading-relaxed">{{ old('description') }}</textarea>
                </div>

                {{-- تفعيل المنتج فالمتجر --}}
                <div class="flex items-center gap-3 bg-emerald-50 p-4 rounded-xl border border-emerald-200">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }} 
                           class="w-5 h-5 text-emerald-600 rounded focus:ring-emerald-500 cursor-pointer">
                    <label for="is_active" class="text-xs font-bold text-emerald-900 cursor-pointer">
                        تفعيل ونشر المنتج مباشرة فالمتجر ليظهر للزبائن للطلب
                    </label>
                </div>

                {{-- زر الإرسال --}}
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 rounded-xl shadow-lg transition duration-200 text-sm flex items-center justify-center gap-2">
                    <span>🚀</span>
                    <span>حفظ ونشر المنتج في المتجر</span>
                </button>
            </form>
        </div>
    </main>

    {{-- ➕ Modal إضافة قسم جديد --}}
    <div id="addCategoryModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-2xl p-6 max-w-sm w-full space-y-4 shadow-2xl border border-slate-200">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-black text-slate-900 text-sm">➕ إضافة قسم (Catégorie) جديد</h3>
                <button type="button" onclick="document.getElementById('addCategoryModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-700 font-bold text-lg">✕</button>
            </div>
            
            <form action="{{ route('admin.categories.quickStore') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">اسم القسم الجديد:</label>
                    <input type="text" name="name" placeholder="مثال: إلكترونيات وهواتف" required class="w-full border border-slate-300 rounded-xl p-3 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl text-xs transition">
                    حفظ القسم فوراً ✅
                </button>
            </form>
        </div>
    </div>

    {{-- Script معاينة الصور المتعددة المتقدم --}}
    <script>
        const imagesInput = document.getElementById('imagesInput');
        const previewContainer = document.getElementById('previewContainer');
        const imageGrid = document.getElementById('imageGrid');
        const selectedCount = document.getElementById('selectedCount');

        imagesInput.addEventListener('change', function(e) {
            imageGrid.innerHTML = '';
            const files = Array.from(e.target.files);
            
            if (files.length > 0) {
                previewContainer.classList.remove('hidden');
                selectedCount.innerText = `الصور المختارة (${files.length}):`;

                files.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const div = document.createElement('div');
                        div.className = 'relative group rounded-xl overflow-hidden border border-slate-200 aspect-square bg-slate-100';
                        div.innerHTML = `
                            <img src="${event.target.result}" class="w-full h-full object-cover">
                            <span class="absolute bottom-1 right-1 bg-slate-900/80 text-white text-[9px] px-1.5 py-0.5 rounded font-mono">
                                ${index === 0 ? 'رئيسية' : '#' + (index + 1)}
                            </span>
                        `;
                        imageGrid.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                });
            } else {
                previewContainer.classList.add('hidden');
            }
        });
    </script>
</body>
</html>