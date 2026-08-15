<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة المنتجات والمخزون | MED EXPRESS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Tajawal', sans-serif; }</style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased">

    <header class="bg-slate-900 text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-base font-black text-emerald-400">إدارة المنتجات وتتبع المخزون الحي</h1>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.products.create') }}" class="bg-emerald-600 hover:bg-emerald-500 text-white px-3.5 py-2 rounded-xl text-xs font-bold transition shadow">
                    ➕ إضافة منتج جديد
                </a>
                <a href="{{ route('admin.orders.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-200 px-3.5 py-2 rounded-xl text-xs font-bold transition">
                    ⬅️ الرجوع للطلبيات
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8">

        @if(session('success'))
            <div class="mb-6 bg-emerald-500 text-white px-4 py-3 rounded-2xl shadow font-bold text-xs">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-right text-xs">
                    <thead class="bg-slate-50 text-slate-600 border-b">
                        <tr>
                            <th class="p-4 font-bold">صورة المنتج</th>
                            <th class="p-4 font-bold">اسم المنتج والصنف</th>
                            <th class="p-4 font-bold">السعر الأساسي</th>
                            <th class="p-4 font-bold">المخزون والأنواع (Variants & Stock)</th>
                            <th class="p-4 font-bold">حالة التوفر</th>
                            <th class="p-4 font-bold text-center">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($products as $product)
                            @php
                                $totalStock = $product->variants->sum('stock_quantity');
                            @endphp
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-4">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 border overflow-hidden flex items-center justify-center">
                                        @if($product->image_url)
                                            <img src="{{ asset('storage/' . $product->image_url) }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-xl">📦</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="font-black text-slate-900 text-sm">{{ $product->name }}</div>
                                    <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded font-bold">
                                        {{ $product->category->name ?? 'صنف عام' }}
                                    </span>
                                </td>
                                <td class="p-4 font-black text-slate-900 text-sm">
                                    {{ $product->base_price }} DH
                                </td>
                                <td class="p-4">
                                    <div class="space-y-1">
                                        @foreach($product->variants as $variant)
                                            <div class="flex items-center gap-2 text-[11px]">
                                                <span class="font-mono text-slate-500 font-bold">[{{ $variant->sku }}]</span>
                                                <span class="text-slate-800">{{ $variant->size ?? '' }} {{ $variant->color ?? '' }}</span>
                                                
                                                <!-- 🚨 Live Stock Badges -->
                                                @if($variant->stock_quantity == 0)
                                                    <span class="bg-red-100 text-red-700 font-bold px-2 py-0.5 rounded text-[10px]">نفد المخزون (0)</span>
                                                @elseif($variant->stock_quantity <= 5)
                                                    <span class="bg-amber-100 text-amber-800 font-bold px-2 py-0.5 rounded text-[10px]">⚠️ قليل ({{ $variant->stock_quantity }})</span>
                                                @else
                                                    <span class="bg-emerald-100 text-emerald-800 font-bold px-2 py-0.5 rounded text-[10px]">متوفر ({{ $variant->stock_quantity }})</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="p-4">
                                    @if($product->is_active)
                                        <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-lg font-bold text-[11px]">
                                            معروض للبيع 🟢
                                        </span>
                                    @else
                                        <span class="bg-slate-100 text-slate-500 border border-slate-200 px-2.5 py-1 rounded-lg font-bold text-[11px]">
                                            مخفي ⚪
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    <form action="{{ route('admin.products.toggle', $product->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-slate-800 hover:bg-black text-white px-3 py-1.5 rounded-xl font-bold text-xs transition">
                                            {{ $product->is_active ? 'إخفاء' : 'إظهار' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-400 font-bold">لا توجد منتجات حالياً</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t">
                {{ $products->links() }}
            </div>
        </div>

    </main>

</body>
</html>