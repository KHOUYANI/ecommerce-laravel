<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعدادات المتجر والإعلانات | MED EXPRESS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Tajawal', sans-serif; }</style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased">

    <header class="bg-slate-900 text-white sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-base font-black text-emerald-400">إعدادات المتجر والتتبع (Marketing & Pixels)</h1>
            <a href="{{ route('admin.orders.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-200 px-3.5 py-2 rounded-xl text-xs font-bold transition">
                ⬅️ الرجوع للطلبيات
            </a>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-8 space-y-8">

        @if(session('success'))
            <div class="bg-emerald-500 text-white px-4 py-3 rounded-2xl shadow font-bold text-xs">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Marketing Pixels Config -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 space-y-4">
                <h2 class="text-base font-black text-slate-900 flex items-center gap-2">
                    <span>🎯</span> ربط بيكسل الإعلانات (Ad Pixels)
                </h2>
                <p class="text-xs text-slate-400">تتبع عمليات الشراء والزيارات لحملات Facebook و TikTok Ads تلقائياً</p>

                <form action="{{ route('admin.settings.save') }}" method="POST" class="space-y-4 text-xs font-bold">
                    @csrf
                    <div>
                        <label class="block text-slate-700 mb-1">Facebook Pixel ID:</label>
                        <input type="text" name="fb_pixel_id" value="{{ $fbPixel }}" placeholder="مثال: 123456789012345" class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-emerald-500 outline-none font-mono">
                    </div>

                    <div>
                        <label class="block text-slate-700 mb-1">TikTok Pixel ID:</label>
                        <input type="text" name="tiktok_pixel_id" value="{{ $tiktokPixel }}" placeholder="مثال: C6ABCD1234EF" class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-emerald-500 outline-none font-mono">
                    </div>

                    <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white py-3 rounded-xl font-black transition">
                        حفظ معرفات البيكسل 💾
                    </button>
                </form>
            </div>

            <!-- Coupons Manager -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 space-y-4">
                <h2 class="text-base font-black text-slate-900 flex items-center gap-2">
                    <span>🏷️</span> إضافة كود خصم جديد (Coupons)
                </h2>
                <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-3 text-xs font-bold">
                    @csrf
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 mb-1">رمز الكود:</label>
                            <input type="text" name="code" placeholder="PROMO20" required class="w-full border rounded-xl p-2.5 uppercase font-mono">
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1">نوع الخصم:</label>
                            <select name="type" class="w-full border rounded-xl p-2.5">
                                <option value="fixed">مبلغ ثابت (درهم)</option>
                                <option value="percent">نسبة مئوية (%)</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-slate-700 mb-1">قيمة الخصم:</label>
                        <input type="number" step="0.1" name="value" placeholder="50" required class="w-full border rounded-xl p-2.5">
                    </div>
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 rounded-xl font-black transition">
                        إنشاء الكود ➕
                    </button>
                </form>

                <div class="border-t pt-3">
                    <span class="text-xs font-bold text-slate-500 block mb-2">الأكواد الفعالة حالياً:</span>
                    <div class="flex flex-wrap gap-2">
                        @foreach($coupons as $coupon)
                            <span class="bg-slate-100 text-slate-800 text-[11px] font-mono font-bold px-3 py-1 rounded-lg border">
                                {{ $coupon->code }} ({{ $coupon->type == 'fixed' ? $coupon->value.' DH' : $coupon->value.'%' }})
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>