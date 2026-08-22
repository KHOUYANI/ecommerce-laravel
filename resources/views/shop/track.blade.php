<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('تتبع طلبيتك') }} | MED EXPRESS</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;700;800;900&family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: {{ app()->getLocale() == 'ar' ? "'Tajawal', sans-serif" : "'Plus Jakarta Sans', sans-serif" }}; 
            background-color: #FAFAFB;
            color: #0F172A;
        }
        .font-brand { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        .track-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 2rem;
            box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.04);
            transition: all 0.3s ease;
        }
        .track-card:hover {
            box-shadow: 0 20px 40px -10px rgba(16, 185, 129, 0.08);
        }

        .cta-btn {
            background-color: #0F172A;
            color: #FFFFFF;
            transition: all 0.25s ease;
        }
        .cta-btn:hover {
            background-color: #059669;
            box-shadow: 0 10px 25px -5px rgba(5, 150, 105, 0.35);
        }
    </style>
</head>
<body class="antialiased selection:bg-emerald-500 selection:text-white pb-12">

    <!-- Top Announcement Bar -->
    <div class="bg-emerald-900 text-white text-[11px] font-bold py-2.5 px-4 sticky top-0 z-50 shadow-sm">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>{{ __('بوابة التتبع المباشر لطلبيات متجر MED EXPRESS') }}</span>
            </div>
            <a href="https://wa.me/212773271042" target="_blank" class="text-emerald-200 hover:text-white transition flex items-center gap-1 font-bold text-xs">
                <span>💬 {{ __('دعم واتساب 7/7') }}</span>
            </a>
        </div>
    </div>

    <!-- Header Navigation -->
    <header class="bg-white/95 backdrop-blur-md border-b border-slate-200 sticky top-9 z-40">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 flex justify-between items-center">
            
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-slate-900 flex items-center justify-center text-white font-black text-xl font-brand shadow-sm">
                    M
                </div>
                <div>
                    <a href="{{ route('shop.index') }}" class="font-black text-2xl text-slate-900 tracking-tight block leading-none font-brand">
                        MED<span class="text-emerald-600">EXPRESS</span>
                    </a>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Tracking Portal</span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <!-- Language Switcher -->
                <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-xl text-[10px] font-bold">
                    <a href="{{ route('lang.switch', 'ar') }}" class="px-2 py-0.5 rounded-lg transition {{ app()->getLocale() == 'ar' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">AR</a>
                    <a href="{{ route('lang.switch', 'fr') }}" class="px-2 py-0.5 rounded-lg transition {{ app()->getLocale() == 'fr' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">FR</a>
                    <a href="{{ route('lang.switch', 'en') }}" class="px-2 py-0.5 rounded-lg transition {{ app()->getLocale() == 'en' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">EN</a>
                </div>

                <a href="{{ route('shop.index') }}" class="text-slate-600 hover:text-emerald-600 text-xs font-bold transition flex items-center gap-1">
                    <span>{{ __('الرجوع للمتجر') }} 🛍️</span>
                </a>
            </div>

        </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 sm:px-6 py-12 space-y-8">

        <!-- 🔍 Tracking Input Box -->
        <div class="track-card p-6 sm:p-10 space-y-6 text-center">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl font-black mx-auto shadow-inner">
                📦
            </div>

            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900">{{ __('تتبع مسار شحنتك المباشر') }}</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1.5">{{ __('أدخل رقم الهاتف الذي قمت بالطلب به أو كود التتبع لمعرفة حالة طردك') }}</p>
            </div>

            @if(session('error'))
                <div class="bg-red-50 text-red-600 border border-red-200 text-xs font-bold p-3.5 rounded-2xl">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('shop.findOrder') }}" method="POST" class="space-y-3">
                @csrf
                <div class="relative">
                    <input type="text" name="search_term" value="{{ request('search_term') }}" placeholder="{{ __('أدخل رقم الهاتف (06XXXXXXXX) أو كود الطلب (COD-XXXXX)...') }}" required class="w-full bg-slate-50 border border-slate-300 rounded-2xl px-5 py-4 text-xs sm:text-sm font-bold text-slate-900 placeholder-slate-400 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 shadow-sm transition text-center font-mono">
                </div>

                <button type="submit" class="w-full cta-btn font-black py-4 rounded-2xl text-xs sm:text-sm transition active:scale-95 shadow-md flex items-center justify-center gap-2">
                    <span>{{ __('بحث وتتبع الشحنة الآن 🚀') }}</span>
                </button>
            </form>
        </div>

        <!-- 📦 Order Result View -->
        @if(isset($order) && $order)
            @php
                $cleanPhone = preg_replace('/[^0-9]/', '', $order->customer_phone);
                if (str_starts_with($cleanPhone, '0')) {
                    $cleanPhone = '212' . substr($cleanPhone, 1);
                }
                $whatsappChangeMsg = "Bonjour / السلام عليكم، أنا الزبون " . $order->customer_name . " بخصوص طلبيتي رقم (" . $order->tracking_number . ")، أريد تعديل وقت أو عنوان التوصيل وشكراً.";
            @endphp

            <div class="track-card p-6 sm:p-8 space-y-6">
                
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 border-b border-slate-100 pb-4">
                    <div>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">{{ __('معلومات الطلبية') }}</span>
                        <h2 class="text-xl font-black text-slate-900 font-mono">{{ $order->tracking_number }}</h2>
                    </div>
                    
                    <span class="px-3.5 py-1 rounded-full text-xs font-black
                        {{ $order->status == 'nouveau' ? 'bg-amber-100 text-amber-800' : '' }}
                        {{ $order->status == 'confirme' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $order->status == 'en_livraison' ? 'bg-purple-100 text-purple-800' : '' }}
                        {{ $order->status == 'livre' ? 'bg-emerald-100 text-emerald-800' : '' }}
                        {{ $order->status == 'annule' ? 'bg-red-100 text-red-800' : '' }}
                    ">
                        @if($order->status == 'nouveau') ⚡ {{ __('قيد المعالجة المبدئية') }} @endif
                        @if($order->status == 'confirme') 📞 {{ __('تم التأكيد وجاري التجهيز') }} @endif
                        @if($order->status == 'en_livraison') 🚚 {{ __('الطرد مع الموزع وفي الطريق إليك') }} @endif
                        @if($order->status == 'livre') ✓ {{ __('تم الاستلام بنجاح') }} @endif
                        @if($order->status == 'annule') ❌ {{ __('ملغاة') }} @endif
                    </span>
                </div>

                <!-- 🛤️ Visual Progress Stepper -->
                <div class="space-y-4 text-xs font-bold relative {{ app()->getLocale() == 'ar' ? 'pr-6 before:right-2' : 'pl-6 before:left-2' }} before:content-[''] before:absolute before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
                    
                    <!-- Step 1 -->
                    <div class="relative flex items-start gap-3">
                        <span class="absolute {{ app()->getLocale() == 'ar' ? '-right-6' : '-left-6' }} top-0.5 w-4 h-4 rounded-full bg-emerald-500 border-2 border-white flex items-center justify-center text-[9px] text-white">✓</span>
                        <div>
                            <div class="text-slate-900">{{ __('تم تسجيل طلبك بالمتجر بنجاح') }}</div>
                            <span class="text-[10px] text-slate-400 font-normal font-mono">{{ $order->created_at->format('Y-m-d H:i') }}</span>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative flex items-start gap-3">
                        <span class="absolute {{ app()->getLocale() == 'ar' ? '-right-6' : '-left-6' }} top-0.5 w-4 h-4 rounded-full {{ in_array($order->status, ['confirme', 'en_livraison', 'livre']) ? 'bg-blue-500 text-white' : 'bg-slate-200 text-slate-400' }} border-2 border-white flex items-center justify-center text-[9px]">
                            {{ in_array($order->status, ['confirme', 'en_livraison', 'livre']) ? '✓' : '2' }}
                        </span>
                        <div>
                            <div class="text-slate-900">{{ __('تم تأكيد الطلب وتغليف الطرد للشحن') }}</div>
                            <span class="text-[10px] text-slate-400 font-normal">{{ __('المستودع اللوجستي المركزي') }}</span>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative flex items-start gap-3">
                        <span class="absolute {{ app()->getLocale() == 'ar' ? '-right-6' : '-left-6' }} top-0.5 w-4 h-4 rounded-full {{ in_array($order->status, ['en_livraison', 'livre']) ? 'bg-purple-500 text-white' : 'bg-slate-200 text-slate-400' }} border-2 border-white flex items-center justify-center text-[9px]">
                            {{ in_array($order->status, ['en_livraison', 'livre']) ? '✓' : '3' }}
                        </span>
                        <div>
                            <div class="text-slate-900">{{ __('الشحنة في طريق التوصيل مع موزع مدينتك') }}</div>
                            <span class="text-[10px] text-emerald-600 font-bold">📍 {{ __('الوجهة:') }} {{ $order->city }}</span>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="relative flex items-start gap-3">
                        <span class="absolute {{ app()->getLocale() == 'ar' ? '-right-6' : '-left-6' }} top-0.5 w-4 h-4 rounded-full {{ $order->status == 'livre' ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-400' }} border-2 border-white flex items-center justify-center text-[9px]">
                            {{ $order->status == 'livre' ? '✓' : '4' }}
                        </span>
                        <div>
                            <div class="text-slate-900">{{ __('تسليم الطرد وفحص السلعة والدفع نقداً') }}</div>
                            <span class="text-[10px] text-slate-400 font-normal">{{ __('الدفع عند الاستلام:') }} {{ $order->total_amount }} DH</span>
                        </div>
                    </div>

                </div>

                <!-- 🛍️ Order Items Summary -->
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-2 text-xs">
                    <h3 class="font-black text-slate-900">{{ __('محتوى الطلبية:') }}</h3>
                    @foreach($order->items as $item)
                        <div class="flex justify-between items-center text-slate-700">
                            <span>• {{ $item->variant->product->name ?? 'منتج' }} (x{{ $item->quantity }})</span>
                            <span class="font-mono font-black">{{ $item->unit_price * $item->quantity }} DH</span>
                        </div>
                    @endforeach
                    <div class="border-t border-slate-200 pt-2 flex justify-between items-center font-black text-sm text-slate-900">
                        <span>{{ __('المبلغ الإجمالي للدفع عند الاستلام:') }}</span>
                        <span class="text-emerald-600 font-black text-base">{{ $order->total_amount }} DH</span>
                    </div>
                </div>

                <!-- 💬 Self Service Action -->
                <div class="pt-2">
                    <a href="https://wa.me/212773271042?text={{ rawurlencode($whatsappChangeMsg) }}" target="_blank" class="w-full bg-[#25D366] hover:bg-[#20ba59] text-white font-black py-3.5 rounded-2xl text-xs flex items-center justify-center gap-2 transition shadow-sm active:scale-95">
                        <span>💬 {{ __('تواصل معنا لتعديل العنوان أو وقت الاستلام') }}</span>
                    </a>
                </div>

            </div>
        @endif

    </main>

    <!-- Footer -->
    <footer class="text-center text-xs text-slate-400 space-y-2">
        <p>{{ __('جميع الحقوق محفوظة') }} © {{ date('Y') }} MED EXPRESS</p>
    </footer>

</body>
</html>