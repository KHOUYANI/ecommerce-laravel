<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تم تأكيد طلبك بنجاح 🎉 | MED EXPRESS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Tajawal', sans-serif; }</style>

    @php
        $fbPixel = \App\Models\Setting::get('fb_pixel_id');
        $tiktokPixel = \App\Models\Setting::get('tiktok_pixel_id');
    @endphp

    @if($fbPixel)
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '{{ $fbPixel }}');
    fbq('track', 'Purchase', { value: {{ $order->total_amount }}, currency: 'MAD' });
    </script>
    @endif

    @if($tiktokPixel)
    <script>
    !function (w, d, t) {
      w.TiktokAnalyticsObject=t;var tt=w[t]=w[t]||[];tt.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],tt.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<tt.methods.length;i++)tt.setAndDefer(tt,tt.methods[i]);tt.instance=function(t){for(var e=tt._i[t]||[],n=0;n<tt.methods.length;n++)tt.setAndDefer(e,tt.methods[n]);return e};tt.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";tt._i=tt._i||{},tt._i[e]=[],tt._i[e]._u=i,tt._t=tt._t||{},tt._t[e]=+new Date,tt._o=tt._o||{},tt._o[e]=n||{};var o=document.createElement("script");o.type="text/javascript",o.async=!0,o.src=i+"?sdkid="+e+"&lib="+t;var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(o,a)};
      tt.load('{{ $tiktokPixel }}');
      tt.page();
      ttq.track('CompletePayment', { value: {{ $order->total_amount }}, currency: 'MAD' });
    }(window, document, 'ttq');
    </script>
    @endif
</head>
<body class="bg-slate-100 text-slate-800 antialiased py-8 px-4">

    <div class="max-w-2xl mx-auto space-y-6">

        @if(session('upsell_added'))
            <div class="bg-emerald-500 text-white p-4 rounded-2xl shadow font-black text-center text-xs animate-bounce">
                🎉 {{ session('upsell_added') }}
            </div>
        @endif

        <!-- Thank You Main Card -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200 text-center space-y-4">
            <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-3xl mx-auto shadow-inner">
                ✓
            </div>
            
            <div>
                <span class="text-xs bg-emerald-100 text-emerald-800 font-bold px-3 py-1 rounded-full">تم تسجيل طلبك بنجاح</span>
                <h1 class="text-2xl font-black text-slate-900 mt-2">شكراً لك يا {{ $order->customer_name }}!</h1>
                <p class="text-xs text-slate-400 mt-1">سيتصل بك فريق التوصيل قريباً لتأكيد موعد استلام الطلبية.</p>
            </div>

            <!-- Tracking Code Box -->
            <div class="bg-slate-50 border border-slate-200 p-4 rounded-2xl flex justify-between items-center text-xs">
                <span class="text-slate-500 font-bold">كود تتبع الطلبية الخاص بك:</span>
                <span class="font-mono font-black text-emerald-600 bg-emerald-50 px-3 py-1 rounded-xl text-sm border border-emerald-200" dir="ltr">
                    {{ $order->tracking_number }}
                </span>
            </div>

            <!-- WhatsApp Instant Confirmation Button -->
            @php
                $confMsg = "السلام عليكم، أنا الزبون " . $order->customer_name . "، قمت بطلب المنتج للتو بكود تتبع " . $order->tracking_number . " بمبلغ " . $order->total_amount . " DH. أؤكد طلبيتي للشحن وشكراً.";
            @endphp
            <a href="https://wa.me/212773271042?text={{ rawurlencode($confMsg) }}" target="_blank" class="w-full bg-[#25D366] hover:bg-[#20ba59] text-white font-black py-3.5 rounded-2xl shadow-md transition flex items-center justify-center gap-2 text-xs">
                <span>💬 اضغط هنا لتأكيد طلبك فوراً عبر الواتساب وتسريع الشحن</span>
            </a>

            <!-- Order Summary -->
            <div class="border-t border-slate-100 pt-4 text-right space-y-2 text-xs">
                <h3 class="font-black text-slate-900 mb-2">تفاصيل الطلبية:</h3>
                @foreach($order->items as $item)
                    <div class="flex justify-between items-center text-slate-600 bg-slate-50 p-3 rounded-xl">
                        <span class="font-bold">• {{ $item->variant->product->name ?? 'منتج' }} (x{{ $item->quantity }})</span>
                        <span class="font-mono font-black text-slate-900">{{ $item->unit_price * $item->quantity }} DH</span>
                    </div>
                @endforeach
                <div class="border-t pt-2 flex justify-between items-center font-black text-sm text-slate-900">
                    <span>المجموع الإجمالي للدفع عند الاستلام:</span>
                    <span class="text-emerald-600 font-black text-base">{{ $order->total_amount }} DH</span>
                </div>
            </div>
        </div>

        <!-- 🎁 1-Click Post-Purchase Native Order Upsell -->
        @if(isset($upsellProduct) && $upsellProduct)
            <div class="bg-gradient-to-r from-amber-500 to-amber-600 text-white rounded-3xl p-6 sm:p-8 shadow-xl space-y-4 relative overflow-hidden">
                <span class="bg-white/20 text-white font-black text-[10px] px-3 py-1 rounded-full uppercase tracking-wider">
                    ⚡ عرض خاص جداً قبل مغادرة الصفحة (خصم 40%)
                </span>
                <div class="flex flex-col sm:flex-row items-center gap-5 pt-2">
                    <div class="w-24 h-24 bg-white rounded-2xl p-2 shrink-0 flex items-center justify-center overflow-hidden">
                        @if($upsellProduct->image_url)
                            <img src="{{ asset('storage/' . $upsellProduct->image_url) }}" class="w-full h-full object-cover rounded-xl">
                        @else
                            <span class="text-3xl">🎁</span>
                        @endif
                    </div>
                    <div class="text-center sm:text-right flex-1">
                        <h3 class="text-lg font-black">{{ $upsellProduct->name }}</h3>
                        <p class="text-xs text-amber-100 mt-1 leading-relaxed">{{ Str::limit($upsellProduct->description, 75) }}</p>
                        <div class="flex items-center justify-center sm:justify-start gap-3 mt-2">
                            <span class="text-2xl font-black">{{ round($upsellProduct->base_price * 0.6) }} DH</span>
                            <span class="text-xs line-through text-amber-200">{{ $upsellProduct->base_price }} DH</span>
                            <span class="bg-white text-amber-600 font-black text-[10px] px-2 py-0.5 rounded-md">وفر 40%</span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('order.upsell', $order->tracking_number) }}" method="POST">
                    @csrf
                    <input type="hidden" name="variant_id" value="{{ $upsellProduct->variants->first()->id }}">
                    <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-black py-4 rounded-2xl shadow-lg transition duration-200 text-xs flex items-center justify-center gap-2 mt-2">
                        <span>➕ أضف هذا العرض إلى طلبيتي بضغطة زر واحدة (بدون إعادة إدخال المعلومات)</span>
                    </button>
                </form>
            </div>
        @endif

        <div class="text-center">
            <a href="{{ route('shop.index') }}" class="text-xs font-bold text-slate-500 hover:text-emerald-600 transition">
                الرجوع إلى المتجر الرئيسي 🛍️
            </a>
        </div>

    </div>

</body>
</html>