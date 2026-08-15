<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>إدارة المنتجات وتتبع المخزون | MED EXPRESS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Tajawal', sans-serif; }
        .font-en { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased selection:bg-emerald-500 selection:text-white">

    <!-- Header -->
    <header class="bg-slate-900 text-white sticky top-0 z-40 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex flex-wrap justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <span class="bg-emerald-500 text-slate-900 font-black px-2.5 py-1 rounded-lg text-sm font-en">M</span>
                <div>
                    <h1 class="text-base sm:text-lg font-black text-emerald-400">إدارة المنتجات وتتبع المخزون الحي</h1>
                    <span class="text-[10px] text-slate-400">لوحة تحكم المتجر الإلكتروني</span>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.orders.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-200 px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5 border border-slate-700">
                    <span>⬅️</span>
                    <span>الرجوع للطلبيات</span>
                </a>
                <a href="{{ route('admin.products.create') }}" class="bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2.5 rounded-xl text-xs font-black transition flex items-center gap-1.5 shadow-lg shadow-emerald-600/30">
                    <span>➕</span>
                    <span>إضافة منتج جديد</span>
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-8 space-y-6">

        <!-- Flash Success Messages -->
        @if(session('success'))
            <div class="bg-emerald-50 border-r-4 border-emerald-500 p-4 rounded-2xl shadow-sm text-emerald-800 font-bold text-xs flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span>✅</span>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold">✕</button>
            </div>
        @endif

        <!-- Products Table Card -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            
            <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-50/50">
                <div class="flex items-center gap-2">
                    <span class="text-lg">📦</span>
                    <h2 class="font-black text-slate-900 text-sm">قائمة المنتجات المعروضة ({{ $products->total() }})</h2>
                </div>
                
                <div class="text-xs text-slate-500 font-medium">
                    يمكنك تعديل المنتجات، إخفاؤها، أو حذفها نهائياً
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 text-[11px] font-black text-slate-500 border-b border-slate-200">
                            <th class="p-4 text-center w-20">صورة المنتج</th>
                            <th class="p-4">اسم المنتج والصنف</th>
                            <th class="p-4 text-center">السعر الأساسي</th>
                            <th class="p-4 text-center">الصور الإضافية</th>
                            <th class="p-4 text-center">حالة التوفر</th>
                            <th class="p-4 text-center">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs font-bold">
                        @forelse($products as $product)
                            @php
                                $imgSrc = $product->image_url;
                                if ($imgSrc && !str_starts_with($imgSrc, 'http') && !str_starts_with($imgSrc, '/storage/')) {
                                    $imgSrc = '/storage/' . $imgSrc;
                                }

                                $galleryCount = 0;
                                if (!empty($product->gallery_images)) {
                                    $decoded = is_array($product->gallery_images) ? $product->gallery_images : json_decode($product->gallery_images, true);
                                    if (is_array($decoded)) {
                                        $galleryCount = count($decoded);
                                    }
                                }
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition">
                                
                                <!-- Product Image Thumbnail -->
                                <td class="p-4 text-center">
                                    <div class="w-14 h-14 mx-auto rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 flex items-center justify-center p-1 relative shadow-sm">
                                        @if($imgSrc)
                                            <img src="{{ $imgSrc }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="w-full h-full object-contain"
                                                 onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800';">
                                        @else
                                            <span class="text-2xl">📦</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Name & Category -->
                                <td class="p-4">
                                    <div class="space-y-1">
                                        <a href="{{ route('shop.product', $product->slug ?? $product->id) }}" target="_blank" class="font-black text-slate-900 hover:text-emerald-600 transition block text-sm line-clamp-1" title="{{ $product->name }}">
                                            {{ $product->name }} ↗
                                        </a>
                                        <div class="flex items-center gap-2">
                                            <span class="bg-slate-100 text-slate-600 text-[10px] px-2 py-0.5 rounded-md font-bold">
                                                {{ $product->category->name ?? 'بدون قسم' }}
                                            </span>
                                            @if($product->sku)
                                                <span class="text-[10px] font-mono text-slate-400 font-normal">
                                                    SKU: {{ $product->sku }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Base Price -->
                                <td class="p-4 text-center font-en font-black text-slate-900 text-sm">
                                    {{ number_format($product->base_price, 2) }} <span class="text-xs font-sans text-emerald-600">DH</span>
                                </td>

                                <!-- Multi-Images Badge -->
                                <td class="p-4 text-center">
                                    @if($galleryCount > 1)
                                        <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold px-2 py-0.5 rounded-full font-en">
                                            <span>📸</span>
                                            <span>{{ $galleryCount }} صور</span>
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-[11px] font-normal">صورة واحدة</span>
                                    @endif
                                </td>

                                <!-- Status Badge -->
                                <td class="p-4 text-center">
                                    @if($product->is_active)
                                        <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-800 text-[10px] font-black px-2.5 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span>معروض للبيع</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-slate-200 text-slate-600 text-[10px] font-black px-2.5 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            <span>مخفي</span>
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="p-4 text-center">
                                    <div class="inline-flex items-center justify-center gap-2">
                                        
                                        <!-- زر التعديل -->
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-200 p-1.5 px-2.5 rounded-xl text-xs font-bold transition flex items-center gap-1">
                                            <span>✏️</span>
                                            <span>تعديل</span>
                                        </a>

                                        <!-- إخفاء / إظهار -->
                                        <form action="{{ route('admin.products.toggle', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-xs font-bold px-3 py-1.5 rounded-xl border transition {{ $product->is_active ? 'bg-slate-900 hover:bg-slate-800 text-white border-slate-900' : 'bg-emerald-600 hover:bg-emerald-700 text-white border-emerald-600' }}">
                                                {{ $product->is_active ? 'إخفاء' : 'إظهار' }}
                                            </button>
                                        </form>

                                        <!-- حذف -->
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('⚠️ هل أنت متأكد من حذف المنتج ({{ $product->name }}) نهائياً؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 hover:border-rose-300 p-1.5 px-2.5 rounded-xl text-xs font-bold transition flex items-center gap-1">
                                                <span>🗑️</span>
                                                <span class="hidden sm:inline">مسح</span>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center text-slate-400 font-normal">
                                    <span class="text-4xl block mb-2">📦</span>
                                    <p class="text-sm font-bold text-slate-700">لا يوجد أي منتج حالياً</p>
                                    <a href="{{ route('admin.products.create') }}" class="text-xs text-emerald-600 font-bold hover:underline mt-1 inline-block">
                                        + أضف أول منتج إلى المتجر الآن
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $products->links() }}
                </div>
            @endif

        </div>

    </main>

</body>
</html>