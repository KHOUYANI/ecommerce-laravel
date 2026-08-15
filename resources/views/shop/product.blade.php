<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->name }} | MED EXPRESS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Tajawal', sans-serif; }
        html { scroll-behavior: smooth; }
        .pulse-record {
            animation: pulse-red 1.5s infinite;
        }
        @keyframes pulse-red {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.6); }
            70% { box-shadow: 0 0 0 12px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }
    </style>

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
    fbq('track', 'PageView');
    fbq('track', 'ViewContent', { content_name: '{{ $product->name }}', value: {{ $product->base_price }}, currency: 'MAD' });
    </script>
    @endif

    @if($tiktokPixel)
    <script>
    !function (w, d, t) {
      w.TiktokAnalyticsObject=t;var tt=w[t]=w[t]||[];tt.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],tt.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<tt.methods.length;i++)tt.setAndDefer(tt,tt.methods[i]);tt.instance=function(t){for(var e=tt._i[t]||[],n=0;n<tt.methods.length;n++)tt.setAndDefer(e,tt.methods[n]);return e};tt.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";tt._i=tt._i||{},tt._i[e]=[],tt._i[e]._u=i,tt._t=tt._t||{},tt._t[e]=+new Date,tt._o=tt._o||{},tt._o[e]=n||{};var o=document.createElement("script");o.type="text/javascript",o.async=!0,o.src=i+"?sdkid="+e+"&lib="+t;var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(o,a)};
      tt.load('{{ $tiktokPixel }}');
      tt.page();
      ttq.track('ViewContent', { content_name: '{{ $product->name }}', value: {{ $product->base_price }}, currency: 'MAD' });
    }(window, document, 'ttq');
    </script>
    @endif
</head>
<body class="bg-slate-100 text-slate-800 antialiased relative pb-24 md:pb-0">

    <header class="bg-white sticky top-0 z-50 border-b border-slate-200 shadow-sm">
        <div class="max-w-5xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('shop.index') }}" class="text-xs font-bold text-slate-600 hover:text-emerald-600 flex items-center gap-1 transition">
                <span>➡️</span> <span>الرجوع للمتجر</span>
            </a>
            <span class="font-black text-slate-900 text-base">MED <span class="text-emerald-600">EXPRESS</span></span>
            <span class="text-[11px] font-bold bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-full">توصيل مجاني 🚚</span>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
            
            <!-- Showcase & Reviews -->
            <div class="md:col-span-7 bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-200 space-y-6">
                
                <div class="bg-amber-50 border border-amber-200 p-3.5 rounded-2xl flex justify-between items-center text-xs font-bold text-amber-900">
                    <span>⚡ ينتهي التخفيض الخاص خلال:</span>
                    <span id="countdownTimer" class="font-mono bg-amber-200 text-amber-950 px-2.5 py-1 rounded-lg">04:22:15</span>
                </div>

                <div class="h-80 bg-slate-50 rounded-2xl flex items-center justify-center overflow-hidden border">
                    @if($product->image_url)
                        <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="text-8xl">
                            @if(str_contains(strtolower($product->name), 'watch')) ⌚ 
                            @elseif(str_contains(strtolower($product->name), 'hoodie')) 👕 
                            @else 📦 @endif
                        </div>
                    @endif
                </div>

                <div>
                    <span class="text-xs font-black text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">{{ $product->category->name ?? 'منتج مميز' }}</span>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mt-2">{{ $product->name }}</h1>
                    <div class="flex items-center gap-3 mt-3">
                        <span class="text-3xl font-black text-emerald-600">{{ $product->base_price }} DH</span>
                        <span class="text-sm line-through text-slate-400 font-bold">{{ $product->base_price + 100 }} DH</span>
                        <span class="bg-red-500 text-white text-[11px] font-black px-2 py-0.5 rounded-md">تخفيض 35%</span>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-4">
                    <h3 class="font-bold text-sm text-slate-900 mb-2">مميزات وتفاصيل المنتج:</h3>
                    <p class="text-slate-600 text-xs sm:text-sm leading-relaxed whitespace-pre-line">{{ $product->description }}</p>
                </div>

                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/60 space-y-2 text-xs font-bold text-slate-700">
                    <div class="flex items-center gap-2 text-emerald-700">✔ الدفع نقدًا عند استلام المنتج ومراجعته</div>
                    <div class="flex items-center gap-2 text-emerald-700">✔ شحن سريع لجميع مدن المغرب مجانًا</div>
                    <div class="flex items-center gap-2 text-emerald-700">✔ ضمان الجودة واستبدال فوري عند أي مشكل</div>
                </div>

                <!-- Reviews Section -->
                <div class="border-t border-slate-200 pt-6 space-y-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="font-black text-lg text-slate-900">آراء وتقييمات الزبناء ({{ $product->reviews->count() }})</h3>
                            <div class="flex items-center gap-1 text-amber-400 text-sm mt-0.5">
                                ★★★★★ <span class="text-xs font-bold text-slate-600 mr-1">4.9 / 5 تقييم ممتاز</span>
                            </div>
                        </div>
                        <button type="button" onclick="document.getElementById('reviewFormBox').classList.toggle('hidden')" class="bg-slate-900 hover:bg-black text-white text-xs font-bold px-3.5 py-2 rounded-xl transition">
                            ✍️ أضف رأيك
                        </button>
                    </div>

                    @if(session('review_success'))
                        <div class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold p-3.5 rounded-2xl">
                            ✅ {{ session('review_success') }}
                        </div>
                    @endif

                    <div id="reviewFormBox" class="hidden bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-3">
                        <h4 class="font-bold text-xs text-slate-800">شارك تجربتك مع المنتج:</h4>
                        <form action="{{ route('product.review', $product->id) }}" method="POST" class="space-y-3 text-xs font-bold">
                            @csrf
                            <div class="grid grid-cols-2 gap-3">
                                <input type="text" name="reviewer_name" placeholder="اسمك الكامل" required class="bg-white border rounded-xl p-2.5 outline-none">
                                <input type="text" name="reviewer_city" placeholder="مدينتك (مثال: طنجة)" class="bg-white border rounded-xl p-2.5 outline-none">
                            </div>
                            <div>
                                <label class="block text-slate-600 mb-1">التقييم:</label>
                                <select name="rating" class="bg-white border rounded-xl p-2 text-amber-500 font-bold w-full">
                                    <option value="5">⭐⭐⭐⭐⭐ ممتاز جداً (5/5)</option>
                                    <option value="4">⭐⭐⭐⭐ جيد جداً (4/5)</option>
                                    <option value="3">⭐⭐⭐ متوسط (3/5)</option>
                                </select>
                            </div>
                            <textarea name="comment" rows="2" placeholder="اكتب تعليقك ورأيك في جودة المنتج وسرعة التوصيل..." required class="w-full bg-white border rounded-xl p-2.5 outline-none"></textarea>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-black px-5 py-2.5 rounded-xl transition text-xs">
                                نشر التقييم 🚀
                            </button>
                        </form>
                    </div>

                    <div class="space-y-3">
                        @forelse($product->reviews as $review)
                            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/80 space-y-1.5">
                                <div class="flex justify-between items-center">
                                    <div class="font-black text-slate-900 text-xs flex items-center gap-2">
                                        <span>{{ $review->reviewer_name }}</span>
                                        <span class="text-[10px] text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-md font-bold">✓ مشتري موثوق</span>
                                    </div>
                                    <span class="text-amber-400 text-xs">{{ str_repeat('★', $review->rating) }}</span>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed">{{ $review->comment }}</p>
                                <span class="text-[10px] text-slate-400 block font-mono">📍 {{ $review->reviewer_city }} • {{ $review->created_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 text-center py-4">كن أول من يقيّم هذا المنتج الرائع!</p>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Formulaire COD Express Pro + Voice Note Order + Bundles -->
            <div id="checkoutFormSection" class="md:col-span-5 bg-white p-6 sm:p-8 rounded-3xl shadow-xl border-2 border-emerald-500 sticky top-20">
                <div class="text-center mb-4">
                    <span class="text-xs bg-emerald-100 text-emerald-800 font-bold px-3 py-1 rounded-full">استمارة الطلب السريع</span>
                    <h2 class="text-xl font-black text-slate-900 mt-2">املأ معلوماتك لإتمام الطلب 👇</h2>
                    <p class="text-[11px] text-slate-400 mt-1">الدفع عند الاستلام مع فحص المنتج قبل الأداء</p>
                </div>

                <!-- 🎙️ Voice Note Order Box -->
                <div class="bg-slate-900 text-white p-4 rounded-2xl mb-4 space-y-2 border border-slate-700">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-emerald-400 flex items-center gap-1.5">
                            <span>🎙️</span>
                            <span>معكاز تكتب؟ اطلب بصوتك في 5 ثوانٍ</span>
                        </span>
                        <span id="recordTimer" class="text-[10px] font-mono bg-slate-800 px-2 py-0.5 rounded text-red-400 hidden">00:00</span>
                    </div>
                    
                    <button type="button" id="voiceRecordBtn" onclick="toggleVoiceRecording()" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-black py-2.5 rounded-xl text-xs flex items-center justify-center gap-2 transition shadow">
                        <span>🎙️ اضغط هنا للتسجيل الصوتي (قل اسمك ومدينتك)</span>
                    </button>
                    
                    <div id="voiceStatusMsg" class="text-[10px] text-slate-300 hidden text-center"></div>
                </div>

                <!-- 🚚 Interactive Free Shipping Progress Bar -->
                <div class="bg-slate-50 p-3 rounded-2xl border border-slate-200 mb-4">
                    <div class="flex justify-between items-center text-[11px] font-bold mb-1.5">
                        <span id="shippingBarText" class="text-emerald-700">🚚 شحن مجاني مفعل لطلبك!</span>
                        <span id="shippingBarPercent" class="text-emerald-600 font-black">100%</span>
                    </div>
                    <div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden">
                        <div id="shippingProgressBar" class="bg-emerald-500 h-full rounded-full transition-all duration-500" style="width: 100%"></div>
                    </div>
                </div>

                <!-- 🟢 Fast WhatsApp Order Button -->
                <form action="{{ route('order.whatsappQuick') }}" method="POST" class="mb-4">
                    @csrf
                    <input type="hidden" name="variant_id" value="{{ $product->variants->first()->id ?? 1 }}">
                    <button type="submit" class="w-full bg-[#25D366] hover:bg-[#20ba59] text-white font-black py-3 rounded-2xl shadow-md transition flex items-center justify-center gap-2 text-xs">
                        <span>💬 اطلب مباشرة عبر الواتساب في ثوانٍ</span>
                    </button>
                </form>

                <div class="flex items-center my-4">
                    <div class="flex-1 border-t border-slate-200"></div>
                    <span class="px-3 text-[10px] text-slate-400 font-bold">أو املأ الاستمارة هنا</span>
                    <div class="flex-1 border-t border-slate-200"></div>
                </div>

                @if(session('error'))
                    <div class="bg-red-50 text-red-600 border border-red-200 text-xs font-bold p-3 rounded-xl mb-4">
                        ⚠️ {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('order.checkout') }}" method="POST" class="space-y-4 text-xs font-bold">
                    @csrf

                    <!-- 🎁 Quantity Bundles Radio Boxes -->
                    <div>
                        <label class="block text-slate-700 mb-2">اختر العرض المناسب لك (توفير أكبر):</label>
                        <div class="space-y-2">
                            <label class="bundle-card border-2 border-emerald-500 bg-emerald-50/50 p-3 rounded-2xl flex items-center justify-between cursor-pointer transition">
                                <div class="flex items-center gap-2.5">
                                    <input type="radio" name="bundle_option" value="1" checked class="w-4 h-4 text-emerald-600" onchange="selectBundle(1, 1)">
                                    <div>
                                        <span class="font-black text-slate-900 text-xs block">قطعة واحدة (1 حبة)</span>
                                        <span class="text-[10px] text-slate-400 font-normal">سعر القطعة العادي</span>
                                    </div>
                                </div>
                                <span class="font-black text-emerald-700 text-sm">{{ $product->base_price }} DH</span>
                            </label>

                            <label class="bundle-card border border-slate-200 bg-white p-3 rounded-2xl flex items-center justify-between cursor-pointer hover:border-emerald-500 transition relative">
                                <span class="absolute -top-2 left-4 bg-emerald-600 text-white text-[9px] font-black px-2 py-0.5 rounded-full">الأكثر طلباً ⭐</span>
                                <div class="flex items-center gap-2.5">
                                    <input type="radio" name="bundle_option" value="2" class="w-4 h-4 text-emerald-600" onchange="selectBundle(2, 0.85)">
                                    <div>
                                        <span class="font-black text-slate-900 text-xs block">قطعتين (2 حبات) - خصم 15%</span>
                                        <span class="text-[10px] text-emerald-600 font-bold">وفر {{ round($product->base_price * 2 * 0.15) }} DH + توصيل مجاني</span>
                                    </div>
                                </div>
                                <span class="font-black text-emerald-700 text-sm">{{ round($product->base_price * 2 * 0.85) }} DH</span>
                            </label>

                            <label class="bundle-card border border-slate-200 bg-white p-3 rounded-2xl flex items-center justify-between cursor-pointer hover:border-emerald-500 transition relative">
                                <span class="absolute -top-2 left-4 bg-amber-500 text-white text-[9px] font-black px-2 py-0.5 rounded-full">أفضل توفير 🎁</span>
                                <div class="flex items-center gap-2.5">
                                    <input type="radio" name="bundle_option" value="3" class="w-4 h-4 text-emerald-600" onchange="selectBundle(3, 0.75)">
                                    <div>
                                        <span class="font-black text-slate-900 text-xs block">3 قطع (3 حبات) - خصم 25%</span>
                                        <span class="text-[10px] text-amber-600 font-bold">وفر {{ round($product->base_price * 3 * 0.25) }} DH + هدية خاصة</span>
                                    </div>
                                </div>
                                <span class="font-black text-emerald-700 text-sm">{{ round($product->base_price * 3 * 0.75) }} DH</span>
                            </label>
                        </div>
                        <input type="hidden" id="qtyInput" name="quantity" value="1">
                    </div>

                    <div>
                        <label class="block text-slate-700 mb-1.5">اختر المقاس / اللون:</label>
                        <select id="variantSelect" name="variant_id" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-3 text-xs font-bold focus:ring-2 focus:ring-emerald-500 outline-none" onchange="updateLivePrice()">
                            @foreach($product->variants as $variant)
                                <option value="{{ $variant->id }}" data-price="{{ $product->base_price + $variant->additional_price }}">
                                    {{ $variant->size ? 'مقاس: ' . $variant->size : '' }} 
                                    {{ $variant->color ? '- لون: ' . $variant->color : '' }}
                                    ({{ $product->base_price + $variant->additional_price }} DH)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-slate-700 mb-1.5">الاسم والنسب الكامل:</label>
                        <input type="text" id="customer_name_input" name="customer_name" placeholder="مثال: يوسف الإدريسي" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-3 text-xs font-bold focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-slate-700 mb-1.5">رقم الهاتف (الواتساب):</label>
                        <input type="tel" id="customer_phone_input" name="customer_phone" placeholder="06XXXXXXXX" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-3 text-xs font-bold focus:ring-2 focus:ring-emerald-500 outline-none text-left font-mono" dir="ltr">
                    </div>

                    <div>
                        <label class="block text-slate-700 mb-1.5">المدينة (Moroccan Cities):</label>
                        <select id="citySelect" name="city" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-3 text-xs font-bold focus:ring-2 focus:ring-emerald-500 outline-none" onchange="updateLivePrice()">
                            <option value="">-- اختر مدينتك لحساب الشحن --</option>
                            <option value="Casablanca" data-shipping="0">الدار البيضاء (توصيل مجاني 0 DH)</option>
                            <option value="Rabat" data-shipping="0">الرباط (توصيل مجاني 0 DH)</option>
                            <option value="Azrou" data-shipping="0">أزرو (توصيل فوري مجاني 0 DH)</option>
                            <option value="Fès" data-shipping="15">فاس (15 DH)</option>
                            <option value="Meknès" data-shipping="15">مكناس (15 DH)</option>
                            <option value="Marrakech" data-shipping="20">مراكش (20 DH)</option>
                            <option value="Tanger" data-shipping="20">طنجة (20 DH)</option>
                            <option value="Agadir" data-shipping="25">أكادير (25 DH)</option>
                            <option value="Oujda" data-shipping="25">وجدة (25 DH)</option>
                            <option value="Laâyoune" data-shipping="35">العيون (35 DH)</option>
                            <option value="Autre Ville" data-shipping="25">مدينة أخرى (25 DH)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-slate-700 mb-1.5">العنوان بالتفصيل (الحي / رقم المنزل):</label>
                        <textarea id="address_textarea" name="address" rows="2" placeholder="الحي، الإقامة، رقم الباب أو قرب مكان معروف..." required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-3 text-xs font-bold focus:ring-2 focus:ring-emerald-500 outline-none"></textarea>
                    </div>

                    <!-- Coupon Input Section -->
                    <div class="bg-slate-50 p-3 rounded-2xl border border-slate-200">
                        <label class="block text-slate-700 mb-1 text-[11px]">عندك كود خصم أو برومو؟</label>
                        <div class="flex gap-2">
                            <input type="text" id="coupon_input" name="coupon_code" placeholder="أدخل الكود (مثال: PROMO50)" class="w-full bg-white border border-slate-300 rounded-xl px-3 py-2 text-xs uppercase font-mono font-bold outline-none">
                            <button type="button" onclick="applyCoupon()" class="bg-slate-900 hover:bg-black text-white px-4 py-2 rounded-xl text-xs font-bold shrink-0">
                                تطبيق
                            </button>
                        </div>
                        <div id="coupon_msg" class="text-[11px] font-bold mt-1.5 hidden"></div>
                    </div>

                    <!-- Live Total Price Breakdown Card -->
                    <div class="bg-slate-900 text-white p-4 rounded-2xl space-y-1.5 shadow-inner">
                        <div class="flex justify-between text-slate-300 text-[11px]">
                            <span>ثمن المنتجات:</span>
                            <span id="subtotalDisplay" class="font-bold">0.00 DH</span>
                        </div>
                        <div class="flex justify-between text-slate-300 text-[11px]">
                            <span>مصاريف الشحن والتوصيل:</span>
                            <span id="shippingDisplay" class="font-bold text-emerald-400">مجاني (0 DH)</span>
                        </div>
                        <div id="discountRow" class="flex justify-between text-emerald-400 text-[11px] hidden">
                            <span>خصم الكوبون / الباقة:</span>
                            <span id="discountDisplay" class="font-bold">-0.00 DH</span>
                        </div>
                        <div class="border-t border-slate-700 pt-1.5 flex justify-between items-center">
                            <span class="font-black text-xs">المجموع النهائي للدفع عند الاستلام:</span>
                            <span id="finalTotalDisplay" class="text-lg font-black text-emerald-400">0.00 DH</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-emerald-600/30 hover:shadow-none transition duration-200 text-sm flex items-center justify-center gap-2">
                        <span>تأكيد الطلب الآن 🛍️</span>
                    </button>
                </form>
            </div>

        </div>
    </main>

    <!-- 📱 Sticky Buy-Now Mobile Bar -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur border-t border-slate-200 p-3 flex items-center justify-between shadow-2xl">
        <div>
            <span class="text-[10px] text-slate-400 font-bold block">السعر الإجمالي:</span>
            <span class="text-base font-black text-emerald-600">{{ $product->base_price }} DH</span>
        </div>
        <a href="#checkoutFormSection" class="bg-emerald-600 hover:bg-emerald-700 text-white font-black px-6 py-3 rounded-xl text-xs shadow-lg shadow-emerald-600/30 flex items-center gap-2 transition active:scale-95">
            <span>اطلب الآن 🚀</span>
        </a>
    </div>

    <!-- Live Social Proof Notification Popup -->
    <div id="socialProofPopup" class="fixed bottom-20 md:bottom-6 right-6 z-50 bg-white/95 backdrop-blur border border-slate-200 p-3.5 rounded-2xl shadow-2xl flex items-center gap-3 transition-all duration-500 translate-y-24 opacity-0 max-w-sm">
        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0">
            🛍️
        </div>
        <div class="text-xs">
            <p class="font-black text-slate-900"><span id="buyerName">يوسف من كازا</span> اشترى للتو</p>
            <p class="text-[11px] text-slate-500 truncate max-w-[200px]">{{ $product->name }}</p>
            <span class="text-[9px] text-emerald-600 font-bold" id="buyerTime">منذ دقيقتين ⚡</span>
        </div>
    </div>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/212773271042?text={{ rawurlencode('السلام عليكم، بغيت نسول على هاد المنتج: ' . $product->name) }}" target="_blank" class="fixed bottom-20 md:bottom-6 left-6 z-50 bg-[#25D366] hover:bg-[#20ba59] text-white w-12 h-12 md:w-14 md:h-14 rounded-full flex items-center justify-center text-2xl md:text-3xl shadow-2xl hover:scale-110 transition-all duration-300">
        💬
    </a>

    <!-- Scripts -->
    <script>
        let selectedQty = 1;
        let bundleDiscountRate = 1;
        let couponDiscount = 0;
        let couponType = 'fixed';

        function selectBundle(qty, rate) {
            selectedQty = qty;
            bundleDiscountRate = rate;
            document.getElementById('qtyInput').value = qty;

            document.querySelectorAll('.bundle-card').forEach(card => {
                card.classList.remove('border-emerald-500', 'bg-emerald-50/50');
                card.classList.add('border-slate-200', 'bg-white');
            });

            const currentRadio = document.querySelector(`input[name="bundle_option"][value="${qty}"]`);
            if (currentRadio) {
                const parent = currentRadio.closest('.bundle-card');
                parent.classList.remove('border-slate-200', 'bg-white');
                parent.classList.add('border-emerald-500', 'bg-emerald-50/50');
            }

            updateLivePrice();
        }

        function updateLivePrice() {
            const variantSelect = document.getElementById('variantSelect');
            const citySelect = document.getElementById('citySelect');

            const basePrice = parseFloat(variantSelect?.options[variantSelect.selectedIndex]?.dataset.price || {{ $product->base_price }});
            
            let shipping = 0;
            if(citySelect && citySelect.selectedIndex > 0) {
                shipping = parseFloat(citySelect.options[citySelect.selectedIndex]?.dataset.shipping || 0);
            }

            if (selectedQty >= 2) {
                shipping = 0;
            }

            const rawSubtotal = basePrice * selectedQty;
            const subtotal = rawSubtotal * bundleDiscountRate;

            let discount = rawSubtotal - subtotal;

            if (couponDiscount > 0) {
                const cDisc = (couponType === 'percent') ? (subtotal * (couponDiscount / 100)) : couponDiscount;
                discount += cDisc;
            }

            if (discount > 0) {
                document.getElementById('discountRow')?.classList.remove('hidden');
                document.getElementById('discountDisplay').innerText = `-${discount.toFixed(2)} DH`;
            } else {
                document.getElementById('discountRow')?.classList.add('hidden');
            }

            const total = Math.max(0, subtotal + shipping - (couponDiscount > 0 ? (couponType === 'percent' ? subtotal * (couponDiscount / 100) : couponDiscount) : 0));

            // Dynamic Shipping Progress Bar calculation
            const freeShippingThreshold = {{ $product->base_price * 1.5 }};
            const shippingBarText = document.getElementById('shippingBarText');
            const shippingBarPercent = document.getElementById('shippingBarPercent');
            const shippingProgressBar = document.getElementById('shippingProgressBar');

            if (subtotal >= freeShippingThreshold || selectedQty >= 2) {
                shippingBarText.innerText = "🎉 مبروك! لقد حصلت على شحن سريع مجاني لطلبك!";
                shippingBarPercent.innerText = "100%";
                shippingProgressBar.style.width = "100%";
                shippingProgressBar.className = "bg-emerald-500 h-full rounded-full transition-all duration-500";
            } else {
                const remaining = (freeShippingThreshold - subtotal).toFixed(0);
                const percent = Math.min(100, Math.round((subtotal / freeShippingThreshold) * 100));
                shippingBarText.innerText = `🚚 باقي ليك ${remaining} DH فقط للاستفادة من الشحن المجاني!`;
                shippingBarPercent.innerText = `${percent}%`;
                shippingProgressBar.style.width = `${percent}%`;
                shippingProgressBar.className = "bg-amber-500 h-full rounded-full transition-all duration-500";
            }

            document.getElementById('subtotalDisplay').innerText = subtotal.toFixed(2) + ' DH';
            document.getElementById('shippingDisplay').innerText = shipping === 0 ? 'مجاني (0 DH)' : shipping.toFixed(2) + ' DH';
            document.getElementById('finalTotalDisplay').innerText = total.toFixed(2) + ' DH';
        }

        function applyCoupon() {
            const code = document.getElementById('coupon_input').value.trim();
            const msg = document.getElementById('coupon_msg');
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if(!code) return;

            fetch("{{ route('coupon.check') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": token
                },
                body: JSON.stringify({ code: code })
            })
            .then(res => res.json())
            .then(data => {
                msg.classList.remove('hidden', 'text-red-500', 'text-emerald-600');
                if(data.valid) {
                    couponDiscount = parseFloat(data.value);
                    couponType = data.type;
                    msg.classList.add('text-emerald-600');
                    msg.innerText = `✅ تم تفعيل الكود بنجاح! خصم: ${data.value} ${data.type === 'fixed' ? 'DH' : '%'}`;
                    updateLivePrice();
                } else {
                    couponDiscount = 0;
                    msg.classList.add('text-red-500');
                    msg.innerText = `❌ ${data.message || 'الكود غير صحيح'}`;
                    updateLivePrice();
                }
            })
            .catch(() => {
                msg.classList.remove('hidden', 'text-emerald-600');
                msg.classList.add('text-red-500');
                msg.innerText = '❌ كود غير صحيح أو منتهي الصلاحية.';
            });
        }

        function captureLead() {
            const phoneInput = document.getElementById('customer_phone_input');
            const nameInput = document.getElementById('customer_name_input');
            const cityInput = document.getElementById('citySelect');
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            const phone = phoneInput?.value?.replace(/[^0-9]/g, '');
            if(phone && phone.length >= 9) {
                fetch("{{ route('lead.save') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": token
                    },
                    body: JSON.stringify({
                        phone: phone,
                        name: nameInput?.value || 'زبون مهتم',
                        city: cityInput?.value || 'غير محددة',
                        product_id: {{ $product->id }}
                    })
                })
                .then(res => res.json())
                .then(data => console.log('Lead Saved:', data))
                .catch(err => console.error('Lead error:', err));
            }
        }

        document.getElementById('customer_phone_input')?.addEventListener('blur', captureLead);
        document.getElementById('customer_phone_input')?.addEventListener('input', function() {
            if(this.value.replace(/[^0-9]/g, '').length >= 10) captureLead();
        });
        document.getElementById('customer_name_input')?.addEventListener('blur', captureLead);
        document.getElementById('citySelect')?.addEventListener('change', function() {
            updateLivePrice();
            captureLead();
        });

        // 🎙️ Voice Note Recording Function
        let mediaRecorder;
        let audioChunks = [];
        let isRecording = false;
        let recordInterval;
        let seconds = 0;

        async function toggleVoiceRecording() {
            const btn = document.getElementById('voiceRecordBtn');
            const timerEl = document.getElementById('recordTimer');
            const statusEl = document.getElementById('voiceStatusMsg');
            const addressInput = document.getElementById('address_textarea');

            if (!isRecording) {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                    mediaRecorder = new MediaRecorder(stream);
                    audioChunks = [];

                    mediaRecorder.ondataavailable = event => {
                        audioChunks.push(event.data);
                    };

                    mediaRecorder.onstop = () => {
                        statusEl.classList.remove('hidden');
                        statusEl.innerHTML = "✅ تم تسجيل طلبك الصوتي بنجاح ومرفق مع طلبيتك!";
                        addressInput.value = (addressInput.value ? addressInput.value + " " : "") + "[تم إرفاق تسجيل صوتي للعنوان مع الطلب]";
                    };

                    mediaRecorder.start();
                    isRecording = true;
                    seconds = 0;
                    timerEl.classList.remove('hidden');
                    btn.classList.add('bg-red-600', 'pulse-record');
                    btn.classList.remove('bg-emerald-600');
                    btn.innerText = "⏹️ إيقاف وحفظ التسجيل الصوتي";

                    recordInterval = setInterval(() => {
                        seconds++;
                        timerEl.innerText = `00:${seconds < 10 ? '0' : ''}${seconds}`;
                    }, 1000);

                } catch (err) {
                    alert("المرجو السماح للمتصفح بالوصول للمايكروفون للتسجيل الصوتي.");
                }
            } else {
                mediaRecorder.stop();
                isRecording = false;
                clearInterval(recordInterval);
                timerEl.classList.add('hidden');
                btn.classList.remove('bg-red-600', 'pulse-record');
                btn.classList.add('bg-emerald-600');
                btn.innerText = "🔄 إعادة تسجيل رسالة صوتية أخرى";
            }
        }

        // Live Social Proof Simulation
        const fakeBuyers = [
            { name: 'محمد من الرباط', time: 'منذ دقيقة واحدة' },
            { name: 'ياسين من الدار البيضاء', time: 'منذ 3 دقائق' },
            { name: 'فاطمة الزهراء من مراكش', time: 'منذ 6 دقائق' },
            { name: 'أمين من طنجة', time: 'منذ دقيقتين' },
            { name: 'هدى من أكادير', time: 'منذ 5 دقائق' },
            { name: 'طارق من مكناس', time: 'منذ 4 دقائق' }
        ];

        function showSocialProof() {
            const popup = document.getElementById('socialProofPopup');
            if(!popup) return;
            const buyer = fakeBuyers[Math.floor(Math.random() * fakeBuyers.length)];
            
            document.getElementById('buyerName').innerText = buyer.name;
            document.getElementById('buyerTime').innerText = `${buyer.time} ⚡`;

            popup.classList.remove('translate-y-24', 'opacity-0');
            popup.classList.add('translate-y-0', 'opacity-100');

            setTimeout(() => {
                popup.classList.remove('translate-y-0', 'opacity-100');
                popup.classList.add('translate-y-24', 'opacity-0');
            }, 4500);
        }

        setInterval(showSocialProof, 9000);
        setTimeout(showSocialProof, 2500);

        document.addEventListener('DOMContentLoaded', updateLivePrice);
    </script>
</body>
</html>