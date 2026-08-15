<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MED EXPRESS | تجربة التسوق الرائدة بالمغرب</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;700;800;900&family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            900: '#064e3b',
                            950: '#022c22',
                        },
                        dark: {
                            900: '#0B0F19',
                            950: '#05070D',
                        }
                    },
                    fontFamily: {
                        sans: ['Tajawal', 'sans-serif'],
                        en: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Tajawal', sans-serif; }
        .font-en { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Modern Glass & Depth */
        .glass-header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        
        .hero-gradient {
            background: radial-gradient(circle at 50% -20%, rgba(16, 185, 129, 0.15) 0%, rgba(248, 250, 252, 0) 70%);
        }

        .flagship-card {
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .flagship-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 30px 60px -15px rgba(15, 23, 42, 0.08), 0 0 0 1px rgba(16, 185, 129, 0.3);
        }

        .cta-glow {
            transition: all 0.3s ease;
        }
        .cta-glow:hover {
            box-shadow: 0 10px 30px -5px rgba(16, 185, 129, 0.45);
        }

        .pulse-ring {
            animation: pulse-ring 2.5s infinite;
        }
        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.6); }
            70% { box-shadow: 0 0 0 16px rgba(37, 211, 102, 0); }
            100% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0); }
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
    </script>
    @endif

    @if($tiktokPixel)
    <script>
    !function (w, d, t) {
      w.TiktokAnalyticsObject=t;var tt=w[t]=w[t]||[];tt.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],tt.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<tt.methods.length;i++)tt.setAndDefer(tt,tt.methods[i]);tt.instance=function(t){for(var e=tt._i[t]||[],n=0;n<tt.methods.length;n++)tt.setAndDefer(e,tt.methods[n]);return e};tt.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";tt._i=tt._i||{},tt._i[e]=[],tt._i[e]._u=i,tt._t=tt._t||{},tt._t[e]=+new Date,tt._o=tt._o||{},tt._o[e]=n||{};var o=document.createElement("script");o.type="text/javascript",o.async=!0,o.src=i+"?sdkid="+e+"&lib="+t;var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(o,a)};
      tt.load('{{ $tiktokPixel }}');
      tt.page();
    }(window, document, 'ttq');
    </script>
    @endif
</head>
<body class="bg-[#F8FAFC] text-slate-900 antialiased selection:bg-brand-500 selection:text-white">

    <!-- ⚡ Top Urgency Flash Bar -->
    <div class="bg-dark-900 text-white text-[11px] font-bold py-2.5 px-4 sticky top-0 z-50 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <span class="inline-block w-2 h-2 rounded-full bg-brand-500 animate-ping"></span>
                <span class="font-black text-brand-400">توصيل مجاني وسريع 24-48H</span>
                <span class="text-slate-400 hidden md:inline">| الدفع نقداً بعد استلام الطرد ومعاينة السلعة في يدك</span>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-1.5 text-slate-300 font-en">
                    <span class="text-brand-400">⚡ Flash Offer:</span>
                    <span id="headerTimer" class="bg-slate-800 px-2 py-0.5 rounded text-[10px] font-bold text-white tracking-widest">03:45:12</span>
                </div>
                <a href="{{ route('shop.track') }}" class="text-brand-400 hover:text-brand-300 font-bold transition flex items-center gap-1">
                    <span>تتبع الطلب</span>
                    <span>📦</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 🌟 Glassmorphic Navigation Header -->
    <header class="glass-header sticky top-[37px] z-40 border-b border-slate-200/80 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 py-4 flex justify-between items-center">
            
            <!-- Brand Logo -->
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-brand-600 to-teal-500 flex items-center justify-center text-white font-black text-xl font-en shadow-md shadow-brand-500/20">
                    M
                </div>
                <div>
                    <a href="{{ route('shop.index') }}" class="font-black text-2xl text-slate-900 tracking-tight block leading-none font-en">
                        MED<span class="text-brand-600">EXPRESS</span>
                    </a>
                    <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">Official Moroccan Store</span>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="hidden md:flex items-center gap-6 text-xs font-bold text-slate-600">
                <a href="#catalogSection" class="hover:text-brand-600 transition">كل المنتجات</a>
                <a href="#trustSection" class="hover:text-brand-600 transition">الضمان والتوصيل</a>
                <a href="#faqSection" class="hover:text-brand-600 transition">الأسئلة الشائعة</a>
            </div>

            <!-- Header Action Button -->
            <div class="flex items-center gap-3">
                <a href="#catalogSection" class="bg-slate-900 hover:bg-brand-600 text-white text-xs font-black px-5 py-2.5 rounded-full transition duration-300 cta-glow active:scale-95 flex items-center gap-2">
                    <span>تسوق الآن 🛍️</span>
                </a>
            </div>

        </div>
    </header>

    <main class="space-y-20 py-8">

        <!-- 🚀 Flagship Hero Banner Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-8 hero-gradient">
            <div class="bg-gradient-to-b from-white to-slate-50 border border-slate-200/80 rounded-[3rem] p-8 sm:p-16 relative overflow-hidden shadow-sm">
                
                <div class="max-w-3xl space-y-6 text-right relative z-10">
                    
                    <div class="inline-flex items-center gap-2.5 bg-brand-50 border border-brand-200/60 text-brand-700 px-4 py-1.5 rounded-full text-xs font-black">
                        <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                        <span>المنتجات الأصلية 100% مع ضمان المعاينة قبل الدفع</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-slate-950 tracking-tight leading-[1.15]">
                        تجربة تسوق عصرية <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-l from-brand-600 via-teal-600 to-slate-900">
                            بأعلى معايير الجودة والموثوقية.
                        </span>
                    </h1>

                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed max-w-xl font-medium">
                        نوفر لك أفضل المنتجات المختارة بدقة في السوق المغربي. استلم طردك عند باب منزلك، افحص جودته ومطابقته بنفسك، ثم ادفع نقداً بكل راحة واطمئنان.
                    </p>

                    <div class="pt-3 flex flex-wrap items-center gap-4">
                        <a href="#catalogSection" class="bg-brand-600 hover:bg-brand-700 text-white font-black px-8 py-4 rounded-full text-sm transition duration-300 cta-glow active:scale-95 flex items-center gap-2">
                            <span>اكتشف العروض المميزة 👇</span>
                        </a>
                        <div class="flex items-center gap-2 bg-white px-5 py-3 rounded-full border border-slate-200 text-xs text-slate-700 font-bold shadow-sm">
                            <span class="text-amber-400">★★★★★</span>
                            <span>4.9 / 5 (أكثر من 8,500 زبون راضٍ)</span>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- 🛡️ 4 Trust Highlights Section -->
        <section id="trustSection" class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                
                <div class="bg-white border border-slate-200/80 p-6 rounded-3xl space-y-2 shadow-sm">
                    <div class="w-12 h-12 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center text-2xl font-black">
                        🚚
                    </div>
                    <h3 class="font-black text-slate-900 text-base">توصيل سريع مجاني</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-normal">يصلك طلبك خلال 24 إلى 48 ساعة فقط لجميع المدن والقرى المغربية.</p>
                </div>

                <div class="bg-white border border-slate-200/80 p-6 rounded-3xl space-y-2 shadow-sm">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl font-black">
                        💵
                    </div>
                    <h3 class="font-black text-slate-900 text-base">الدفع عند الاستلام</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-normal">افتح الطرد وعاين السلعة وتأكد من سلامتها قبل أن تدفع أي درهم.</p>
                </div>

                <div class="bg-white border border-slate-200/80 p-6 rounded-3xl space-y-2 shadow-sm">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl font-black">
                        🛡️
                    </div>
                    <h3 class="font-black text-slate-900 text-base">ضمان الجودة 100%</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-normal">استبدال مجاني فوري لمدة 7 أيام في حالة وجود أي عيب أو مشكل.</p>
                </div>

                <div class="bg-white border border-slate-200/80 p-6 rounded-3xl space-y-2 shadow-sm">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl font-black">
                        💬
                    </div>
                    <h3 class="font-black text-slate-900 text-base">دعم واتساب 7/7</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-normal">فريق خدمة زبناء محترف ومستعد لمساعدتك والإجابة في ثوانٍ.</p>
                </div>

            </div>
        </section>

        <!-- 🛍️ Product Catalog & Instant Live Search -->
        <section id="catalogSection" class="max-w-7xl mx-auto px-4 sm:px-8 space-y-8">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 border-b border-slate-200 pb-6">
                <div>
                    <span class="text-xs font-black text-brand-600 bg-brand-50 px-3 py-1 rounded-full uppercase tracking-wider block mb-1">الكتالوج المباشر</span>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">المنتجات الأكثر مبيعاً اليوم 🔥</h2>
                </div>

                <!-- Instant Search Input -->
                <div class="w-full md:w-80">
                    <div class="relative">
                        <input type="text" id="productSearch" onkeyup="filterLiveCatalog()" placeholder="ابحث عن اسم المنتج..." class="w-full bg-white border border-slate-300 rounded-full px-5 py-3 text-xs text-slate-800 placeholder-slate-400 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 shadow-sm transition">
                        <span class="absolute left-4 top-3.5 text-xs text-slate-400">🔍</span>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div id="catalogGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($products as $product)
                    <div class="product-card flagship-card bg-white border border-slate-200/80 rounded-[2.5rem] p-5 flex flex-col justify-between" data-title="{{ strtolower($product->name) }}">
                        
                        <div class="space-y-4">
                            <!-- Image Frame -->
                            <div class="h-72 bg-slate-50 rounded-3xl overflow-hidden relative flex items-center justify-center border border-slate-100">
                                <span class="absolute top-3.5 right-3.5 bg-red-500 text-white text-[10px] font-black px-3 py-1 rounded-full shadow-sm z-10">
                                    تخفيض 35% 🔥
                                </span>

                                @php
                                    $imgSrc = $product->image_url;
                                    if ($imgSrc && !str_starts_with($imgSrc, 'http') && !str_starts_with($imgSrc, '/storage/')) {
                                        $imgSrc = '/storage/' . $imgSrc;
                                    }
                                @endphp

                                @if($imgSrc)
                                    <img src="{{ $imgSrc }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                         onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800';">
                                @else
                                    <div class="text-7xl">
                                        @if(str_contains(strtolower($product->name), 'watch')) ⌚ 
                                        @elseif(str_contains(strtolower($product->name), 'hoodie')) 👕 
                                        @else 📦 @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Details -->
                            <div class="space-y-2">
                                <span class="text-[11px] font-bold text-brand-700 bg-brand-50 px-3 py-0.5 rounded-full inline-block">
                                    {{ $product->category->name ?? 'منتج مميز' }}
                                </span>
                                
                                <h3 class="font-black text-xl text-slate-900 group-hover:text-brand-600 transition truncate">
                                    {{ $product->name }}
                                </h3>

                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed font-normal">
                                    {{ $product->description }}
                                </p>
                            </div>
                        </div>

                        <!-- Price & Action -->
                        <div class="border-t border-slate-100 pt-5 mt-5 space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-xs text-slate-400 line-through block font-bold">{{ $product->base_price + 100 }} DH</span>
                                    <span class="text-2xl font-black text-slate-900 font-en">{{ $product->base_price }} <span class="text-sm font-bold text-brand-600 font-sans">DH</span></span>
                                </div>
                                <div class="text-left text-xs font-bold text-amber-400">
                                    <span>★★★★★</span>
                                    <span class="block text-[10px] text-slate-400 font-normal">({{ $product->reviews->count() ?? 5 }} تقييم موثوق)</span>
                                </div>
                            </div>

                            <a href="{{ route('shop.product', $product->slug ?? $product->id) }}" class="w-full bg-slate-900 hover:bg-brand-600 text-white font-black py-4 rounded-2xl text-xs flex items-center justify-center gap-2 transition duration-300 cta-glow active:scale-95">
                                <span>اطلب الآن • الدفع عند الاستلام 🛍️</span>
                            </a>
                        </div>

                    </div>
                @empty
                    <div class="col-span-3 text-center py-20 bg-white rounded-[2.5rem] border border-slate-200">
                        <span class="text-4xl block mb-2">📦</span>
                        <h3 class="font-black text-slate-800 text-base">لا توجد منتجات معروضة حالياً</h3>
                        <p class="text-xs text-slate-400 mt-1">المرجو إضافة منتجات من لوحة التحكم</p>
                    </div>
                @endforelse
            </div>

        </section>

        <!-- ❓ Common FAQ Section -->
        <section id="faqSection" class="max-w-4xl mx-auto px-4 sm:px-8 space-y-6">
            <div class="text-center space-y-1">
                <span class="text-brand-600 text-xs font-bold uppercase tracking-wider">أسئلة شائعة</span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900">كل ما تحتاج معرفته قبل الطلب</h2>
            </div>

            <div class="space-y-3 text-xs">
                <div class="bg-white border border-slate-200/80 p-5 rounded-2xl space-y-1.5 shadow-sm">
                    <h4 class="font-black text-slate-900 text-sm">كيف تتم عملية الشراء والدفع؟</h4>
                    <p class="text-slate-600 leading-relaxed font-normal">العملية سهلة جداً: تختار المنتج، تملأ معلوماتك في الاستمارة (الاسم، الهاتف، المدينة). نتصل بك لتأكيد العنوان وشحن الطلبية. لا تدفع أي مبلغ حتى يصلك الطرد وتتفحصه بنفسك.</p>
                </div>

                <div class="bg-white border border-slate-200/80 p-5 rounded-2xl space-y-1.5 shadow-sm">
                    <h4 class="font-black text-slate-900 text-sm">كم يستغرق التوصيل؟</h4>
                    <p class="text-slate-600 leading-relaxed font-normal">يصلك الطلب خلال 24 إلى 48 ساعة فقط لمعظم المدن المغربية حتى باب منزلك أو مقر عملك.</p>
                </div>

                <div class="bg-white border border-slate-200/80 p-5 rounded-2xl space-y-1.5 shadow-sm">
                    <h4 class="font-black text-slate-900 text-sm">ماذا لو أردت استبدال المنتج؟</h4>
                    <p class="text-slate-600 leading-relaxed font-normal">نوفر ضمان استبدال مجاني وفوري لمدة 7 أيام عند وجود أي مشكل، يكفي التواصل مع فريق الدعم عبر الواتساب.</p>
                </div>
            </div>
        </section>

    </main>

    <!-- 🟢 Floating VIP WhatsApp Support Bubble -->
    <div class="fixed bottom-6 left-6 z-50">
        <a href="https://wa.me/212773271042?text={{ rawurlencode('السلام عليكم، بغيت نستفسر على المنتجات المتوفرة في المتجر') }}" target="_blank" class="w-16 h-16 rounded-full bg-[#25D366] hover:bg-[#20ba59] text-white flex items-center justify-center text-3xl shadow-2xl pulse-ring hover:scale-110 transition-all duration-300 relative">
            💬
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center shadow">1</span>
        </a>
    </div>

    <!-- 👑 Signature Developer Footer -->
    <footer class="bg-slate-950 text-white border-t border-slate-800 py-14 px-4 sm:px-8 mt-20">
        <div class="max-w-7xl mx-auto space-y-8 text-center">
            
            <div class="flex items-center justify-center gap-2">
                <div class="w-9 h-9 rounded-2xl bg-brand-500 flex items-center justify-center text-slate-950 font-black text-lg font-en">
                    M
                </div>
                <span class="font-black text-2xl tracking-tight text-white font-en">MED<span class="text-brand-400">EXPRESS</span></span>
            </div>

            <p class="text-xs text-slate-400 max-w-md mx-auto leading-relaxed font-normal">
                المنصة المغربية الرائدة للتسوق المباشر مع الدفع عند الاستلام وضمان الجودة والاحترافية في كل طلبية.
            </p>

            <div class="border-t border-slate-900 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <div>
                    جميع الحقوق محفوظة © {{ date('Y') }} MED EXPRESS
                </div>

                <!-- 🔥 Mohamed Khouyani Developer Badge -->
                <div class="inline-flex items-center gap-2.5 bg-slate-900 border border-slate-800 px-5 py-2.5 rounded-full shadow">
                    <span class="text-slate-400 font-normal">Engineered & Developed by</span>
                    <span class="font-black text-brand-400 font-en tracking-wider text-sm">Mohamed Khouyani</span>
                    <span class="text-brand-400">✨</span>
                </div>
            </div>

        </div>
    </footer>

    <!-- Instant Search & Timer Script -->
    <script>
        function filterLiveCatalog() {
            const query = document.getElementById('productSearch').value.toLowerCase().trim();
            const cards = document.querySelectorAll('.product-card');
            cards.forEach(card => {
                const title = card.getAttribute('data-title') || '';
                if (title.includes(query)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Live Countdown Clock
        let totalSeconds = 13512;
        setInterval(() => {
            totalSeconds--;
            if (totalSeconds < 0) totalSeconds = 14400;
            const h = String(Math.floor(totalSeconds / 3600)).padStart(2, '0');
            const m = String(Math.floor((totalSeconds % 3600) / 60)).padStart(2, '0');
            const s = String(totalSeconds % 60).padStart(2, '0');
            const el = document.getElementById('headerTimer');
            if (el) el.innerText = `${h}:${m}:${s}`;
        }, 1000);
    </script>

</body>
</html>