<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MED EXPRESS | تجربة التسوق الرائدة بالمغرب - الدفع عند الاستلام</title>
    
    <!-- Tailwind CSS Engine -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts: Tajawal & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,600;0,700;0,800;0,900;1,700&family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                            950: '#022c22',
                        },
                        dark: {
                            800: '#131c2e',
                            850: '#0e1626',
                            900: '#090e1a',
                            950: '#040711',
                        }
                    },
                    fontFamily: {
                        sans: ['Tajawal', 'sans-serif'],
                        en: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    boxShadow: {
                        'premium': '0 20px 50px -12px rgba(0, 0, 0, 0.07)',
                        'card-hover': '0 30px 60px -15px rgba(16, 185, 129, 0.18)',
                        'glow': '0 0 25px -5px rgba(16, 185, 129, 0.4)',
                    }
                }
            }
        }
    </script>

    <style>
        body { 
            font-family: 'Tajawal', sans-serif; 
            background-color: #F8FAFC;
            color: #0F172A;
        }
        .font-en { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        .glass-header {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        
        .hero-gradient {
            background-image: 
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.12) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(6, 182, 212, 0.08) 0px, transparent 40%),
                radial-gradient(at 50% 100%, rgba(16, 185, 129, 0.05) 0px, transparent 60%);
        }

        .flagship-card {
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .flagship-card:hover {
            transform: translateY(-8px);
        }

        .cta-glow {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.45);
            transition: all 0.3s ease;
        }
        .cta-glow:hover {
            box-shadow: 0 15px 35px -5px rgba(16, 185, 129, 0.65);
            transform: scale(1.02);
        }

        .pulse-ring {
            animation: pulse-ring 2.5s infinite;
        }
        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.6); }
            70% { box-shadow: 0 0 0 16px rgba(37, 211, 102, 0); }
            100% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0); }
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
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
<body class="selection:bg-brand-500 selection:text-white">

    <!-- ⚡ Top Urgency Flash Bar -->
    <div class="bg-dark-950 text-white text-[11px] font-bold py-2.5 px-4 sticky top-0 z-50 border-b border-white/10 shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <span class="inline-flex relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-500"></span>
                </span>
                <span class="font-black text-brand-400">توصيل مجاني وسريع 24-48H</span>
                <span class="text-slate-400 hidden md:inline">| الدفع نقداً عند الاستلام بعد فحص ومعاينة السلعة في يدك</span>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-1.5 text-slate-300 font-en">
                    <span class="text-amber-400">⚡ ينتهي العرض خلال:</span>
                    <span id="headerTimer" class="bg-slate-900 border border-white/10 px-2.5 py-0.5 rounded text-[11px] font-black text-white tracking-widest font-mono">03:44:30</span>
                </div>
                <a href="{{ route('shop.track') }}" class="text-brand-400 hover:text-brand-300 font-bold transition flex items-center gap-1.5">
                    <span>تتبع طلبيتك</span>
                    <span>📦</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 🌟 Navigation Header -->
    <header class="glass-header sticky top-[37px] z-40 border-b border-slate-200/80 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 py-3.5 flex justify-between items-center">
            
            <!-- Brand Identity -->
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-brand-600 via-teal-500 to-emerald-400 p-[1px] shadow-lg shadow-brand-500/20">
                    <div class="w-full h-full bg-slate-950 rounded-2xl flex items-center justify-center text-brand-400 font-black text-xl font-en">
                        M
                    </div>
                </div>
                <div>
                    <a href="{{ route('shop.index') }}" class="font-black text-2xl text-slate-950 tracking-tight block leading-none font-en">
                        MED<span class="text-brand-600">EXPRESS</span>
                    </a>
                    <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest block mt-0.5">Enterprise Store Morocco</span>
                </div>
            </div>

            <!-- Header Quick Links -->
            <div class="hidden md:flex items-center gap-8 text-xs font-bold text-slate-600">
                <a href="#catalogSection" class="hover:text-brand-600 transition flex items-center gap-1.5">
                    <span>🛍️</span>
                    <span>جميع المنتجات</span>
                </a>
                <a href="#trustSection" class="hover:text-brand-600 transition flex items-center gap-1.5">
                    <span>🛡️</span>
                    <span>الضمان والتوصيل</span>
                </a>
                <a href="#faqSection" class="hover:text-brand-600 transition flex items-center gap-1.5">
                    <span>❓</span>
                    <span>الأسئلة الشائعة</span>
                </a>
            </div>

            <!-- CTA Action -->
            <div class="flex items-center gap-3">
                <a href="#catalogSection" class="bg-slate-950 hover:bg-brand-600 text-white text-xs font-black px-5 py-2.5 rounded-full transition duration-300 shadow active:scale-95 flex items-center gap-2">
                    <span>تصفح العروض</span>
                    <span>🔥</span>
                </a>
            </div>

        </div>
    </header>

    <main class="space-y-16 py-6">

        <!-- 🚀 Flagship Hero Banner -->
        <section class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="hero-gradient bg-gradient-to-b from-white via-slate-50/80 to-white border border-slate-200/90 rounded-[3rem] p-8 sm:p-14 relative overflow-hidden shadow-sm">
                
                <div class="max-w-3xl space-y-6 text-right relative z-10">
                    
                    <div class="inline-flex items-center gap-2.5 bg-brand-50 border border-brand-200/80 text-brand-700 px-4 py-1.5 rounded-full text-xs font-black shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                        <span>المنتجات الأصلية 100% مع ضمان الفحص والمعاينة قبل الدفع</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-slate-950 tracking-tight leading-[1.18]">
                        الجودة والسرعة في متجرك، <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-l from-brand-600 via-teal-600 to-slate-900">
                            تسوق بثقة وادفع عند الباب.
                        </span>
                    </h1>

                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed max-w-xl font-medium">
                        نوفر لك أفضل المنتجات العملية والأصلية في السوق المغربي. استلم طردك في أي مدينة، افحص جودته ومطابقته بنفسك، ثم ادفع نقداً بكل راحة واطمئنان.
                    </p>

                    <div class="pt-2 flex flex-wrap items-center gap-4">
                        <a href="#catalogSection" class="cta-glow text-white font-black px-8 py-4 rounded-full text-sm transition duration-300 active:scale-95 flex items-center gap-2">
                            <span>اكتشف المنتجات الأكثر طلباً 👇</span>
                        </a>
                        <div class="flex items-center gap-2 bg-white px-5 py-3 rounded-full border border-slate-200 text-xs text-slate-700 font-bold shadow-sm">
                            <span class="text-amber-400">★★★★★</span>
                            <span class="font-en">4.9 / 5 (8,500+ زبون راضٍ بالمغرب)</span>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- 🛡️ Trust Badges -->
        <section id="trustSection" class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                
                <div class="bg-white border border-slate-200/80 p-6 rounded-3xl space-y-2 shadow-sm hover:border-brand-500/40 transition">
                    <div class="w-12 h-12 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center text-2xl font-black shadow-inner">
                        🚚
                    </div>
                    <h3 class="font-black text-slate-900 text-base">توصيل سريع مجاني</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-normal">يصلك طلبك خلال 24 إلى 48 ساعة فقط لجميع مدن المغرب حتى باب منزلك.</p>
                </div>

                <div class="bg-white border border-slate-200/80 p-6 rounded-3xl space-y-2 shadow-sm hover:border-blue-500/40 transition">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl font-black shadow-inner">
                        💵
                    </div>
                    <h3 class="font-black text-slate-900 text-base">الدفع عند الاستلام</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-normal">افتح الطرد وعاين السلعة وتأكد من سلامتها وجودتها قبل أن تدفع أي درهم.</p>
                </div>

                <div class="bg-white border border-slate-200/80 p-6 rounded-3xl space-y-2 shadow-sm hover:border-amber-500/40 transition">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl font-black shadow-inner">
                        🛡️
                    </div>
                    <h3 class="font-black text-slate-900 text-base">ضمان الجودة 100%</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-normal">استبدال مجاني فوري لمدة 7 أيام في حالة وجود أي عيب مصنعي أو كسر.</p>
                </div>

                <div class="bg-white border border-slate-200/80 p-6 rounded-3xl space-y-2 shadow-sm hover:border-purple-500/40 transition">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl font-black shadow-inner">
                        💬
                    </div>
                    <h3 class="font-black text-slate-900 text-base">دعم واتساب 7/7</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-normal">فريق خدمة زبناء محترف ومستعد لمساعدتك والإجابة على استفساراتك فوراً.</p>
                </div>

            </div>
        </section>

        <!-- 🛍️ Product Catalog Section -->
        <section id="catalogSection" class="max-w-7xl mx-auto px-4 sm:px-8 space-y-8">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-5 border-b border-slate-200 pb-6">
                <div>
                    <span class="text-xs font-black text-brand-600 bg-brand-50 px-3 py-1 rounded-full uppercase tracking-wider block mb-1">الكتالوج المباشر</span>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-950 tracking-tight">المنتجات الأكثر طلباً وتوفراً في المخزون 🔥</h2>
                </div>

                <!-- Instant Search Input -->
                <div class="w-full md:w-80">
                    <div class="relative">
                        <input type="text" id="productSearch" onkeyup="filterLiveCatalog()" placeholder="ابحث عن أي منتج..." class="w-full bg-white border border-slate-300 rounded-full px-5 py-3 text-xs text-slate-900 placeholder-slate-400 outline-none focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 shadow-sm transition">
                        <span class="absolute left-4 top-3 text-sm text-slate-400">🔍</span>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div id="catalogGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($products as $product)
                    @php
                        $imagesList = [];
                        
                        // 1. جلب الصور من مصفوفة gallery_images
                        if (!empty($product->gallery_images)) {
                            $decoded = is_array($product->gallery_images) ? $product->gallery_images : json_decode($product->gallery_images, true);
                            if (is_array($decoded)) {
                                foreach ($decoded as $img) {
                                    if ($img) {
                                        $imagesList[] = (!str_starts_with($img, 'http') && !str_starts_with($img, '/storage/')) ? '/storage/' . $img : $img;
                                    }
                                }
                            }
                        }

                        // 2. فحص الصورة الرئيسية image_url
                        if ($product->image_url) {
                            $mainSrc = (!str_starts_with($product->image_url, 'http') && !str_starts_with($product->image_url, '/storage/')) ? '/storage/' . $product->image_url : $product->image_url;
                            if (!in_array($mainSrc, $imagesList)) {
                                array_unshift($imagesList, $mainSrc);
                            }
                        }

                        // صورة احتياطية
                        if (count($imagesList) === 0) {
                            $imagesList[] = 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800';
                        }
                    @endphp

                    <div class="product-card flagship-card bg-white border border-slate-200/90 rounded-[2.5rem] p-5 flex flex-col justify-between shadow-premium hover:shadow-card-hover group relative" data-title="{{ strtolower($product->name) }}" id="card-prod-{{ $product->id }}">
                        
                        <div class="space-y-4">
                            
                            <!-- 📸 Multi-Image Interactive Box (Slider + Thumbnails) -->
                            <div class="space-y-3">
                                
                                <div class="h-72 bg-gradient-to-b from-slate-50 to-slate-100/80 rounded-3xl overflow-hidden relative border border-slate-100 flex items-center justify-center select-none">
                                    
                                    <span class="absolute top-3.5 right-3.5 bg-red-500 text-white text-[10px] font-black px-3 py-1 rounded-full shadow z-20">
                                        تخفيض 35% 🔥
                                    </span>

                                    <span class="absolute top-3.5 left-3.5 bg-slate-900/80 text-white text-[9px] font-bold px-2 py-0.5 rounded-md backdrop-blur z-20">
                                        متوفر بالمخزون ✓
                                    </span>

                                    <!-- Slides Stack -->
                                    <div class="w-full h-full relative" id="carousel-box-{{ $product->id }}">
                                        @foreach($imagesList as $idx => $img)
                                            <div class="carousel-slide-item w-full h-full absolute inset-0 flex items-center justify-center p-4 transition-opacity duration-300 {{ $idx === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none' }}" data-index="{{ $idx }}">
                                                <img src="{{ $img }}" 
                                                     alt="{{ $product->name }} - صورة {{ $idx + 1 }}" 
                                                     class="max-h-full max-w-full object-contain filter drop-shadow-md group-hover:scale-105 transition-transform duration-500"
                                                     loading="lazy"
                                                     onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800';">
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Arrows Navigation (تظهر إذا تعددت الصور) -->
                                    @if(count($imagesList) > 1)
                                        <button type="button" onclick="changeProductSlide({{ $product->id }}, 1, {{ count($imagesList) }})" class="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/95 hover:bg-white text-slate-800 shadow-md flex items-center justify-center text-xs font-black z-20 opacity-0 group-hover:opacity-100 transition hover:scale-110 active:scale-95">
                                            ❮
                                        </button>
                                        <button type="button" onclick="changeProductSlide({{ $product->id }}, -1, {{ count($imagesList) }})" class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/95 hover:bg-white text-slate-800 shadow-md flex items-center justify-center text-xs font-black z-20 opacity-0 group-hover:opacity-100 transition hover:scale-110 active:scale-95">
                                            ❯
                                        </button>

                                        <!-- Dots Indicator -->
                                        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex items-center gap-1.5 z-20 bg-slate-950/40 backdrop-blur-md px-2.5 py-1 rounded-full" id="dots-wrap-{{ $product->id }}">
                                            @foreach($imagesList as $idx => $img)
                                                <button type="button" onclick="goToProductSlide({{ $product->id }}, {{ $idx }}, {{ count($imagesList) }})" class="slide-dot transition-all duration-300 {{ $idx === 0 ? 'w-3 h-1.5 bg-brand-400 rounded-full' : 'w-1.5 h-1.5 bg-white/60 rounded-full' }}" data-dot="{{ $idx }}"></button>
                                            @endforeach
                                        </div>
                                    @endif

                                </div>

                                <!-- Thumbnails Row: تتيح للزبون النقر والتنقل بين الصور مباشرة في الواجهة الرئيسية -->
                                @if(count($imagesList) > 1)
                                    <div class="flex items-center gap-2 overflow-x-auto pb-1 no-scrollbar" id="thumbs-row-{{ $product->id }}">
                                        @foreach($imagesList as $idx => $thumb)
                                            <button type="button" onclick="goToProductSlide({{ $product->id }}, {{ $idx }}, {{ count($imagesList) }})" class="thumb-node w-12 h-12 rounded-xl border-2 {{ $idx === 0 ? 'border-brand-500 ring-2 ring-brand-500/20' : 'border-slate-200 hover:border-slate-400' }} overflow-hidden flex-shrink-0 bg-slate-50 p-0.5 transition" data-thumb="{{ $idx }}">
                                                <img src="{{ $thumb }}" class="w-full h-full object-contain" alt="thumbnail">
                                            </button>
                                        @endforeach
                                    </div>
                                @endif

                            </div>

                            <!-- Typography Details -->
                            <div class="space-y-2">
                                <span class="text-[11px] font-bold text-brand-700 bg-brand-50 px-3 py-0.5 rounded-full inline-block border border-brand-200/50">
                                    {{ $product->category->name ?? 'منتجات مميزة' }}
                                </span>
                                
                                <h3 class="font-black text-lg text-slate-950 group-hover:text-brand-600 transition truncate" title="{{ $product->name }}">
                                    {{ $product->name }}
                                </h3>

                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed font-normal">
                                    {{ $product->description }}
                                </p>
                            </div>
                        </div>

                        <!-- Price & Action -->
                        <div class="border-t border-slate-100 pt-4 mt-5 space-y-3.5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-xs text-slate-400 line-through block font-bold font-en">{{ $product->base_price + 100 }} DH</span>
                                    <span class="text-2xl font-black text-slate-950 font-en">{{ $product->base_price }} <span class="text-sm font-bold text-brand-600 font-sans">DH</span></span>
                                </div>
                                <div class="text-left text-xs font-bold text-amber-400">
                                    <span>★★★★★</span>
                                    <span class="block text-[10px] text-slate-400 font-normal font-en">({{ $product->reviews->count() ?? 5 }} تقييم موثوق)</span>
                                </div>
                            </div>

                            <a href="{{ route('shop.product', $product->slug ?? $product->id) }}" class="w-full bg-slate-950 hover:bg-brand-600 text-white font-black py-4 rounded-2xl text-xs flex items-center justify-center gap-2 transition duration-300 shadow active:scale-95">
                                <span>اطلب الآن • الدفع عند الاستلام 🛍️</span>
                            </a>
                        </div>

                    </div>
                @empty
                    <div class="col-span-3 text-center py-20 bg-white rounded-[2.5rem] border border-slate-200 space-y-2">
                        <span class="text-5xl block mb-2">📦</span>
                        <h3 class="font-black text-slate-900 text-base">لا توجد أي منتجات معروضة حالياً</h3>
                        <p class="text-xs text-slate-400">يمكنك إضافة أول منتج من لوحة التحكم</p>
                    </div>
                @endforelse
            </div>

        </section>

        <!-- ❓ Common FAQ Accordion Section -->
        <section id="faqSection" class="max-w-4xl mx-auto px-4 sm:px-8 space-y-6">
            <div class="text-center space-y-1">
                <span class="text-brand-600 text-xs font-bold uppercase tracking-wider">أسئلة شائعة</span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-950">كل ما تحتاج معرفته قبل إتمام طلبك</h2>
            </div>

            <div class="space-y-3 text-xs">
                <div class="bg-white border border-slate-200/90 p-5 rounded-2xl space-y-1.5 shadow-sm">
                    <h4 class="font-black text-slate-900 text-sm">كيف تتم عملية الشراء والدفع؟</h4>
                    <p class="text-slate-600 leading-relaxed font-normal">العملية بسيطة جداً: تختار المنتج، تملأ معلوماتك في الاستمارة (الاسم، الهاتف، المدينة). يتصل بك فريقنا لتأكيد العنوان وشحن الطلبية فوراً. لا تدفع أي مبلغ مالي حتى يصلك الطرد وتتفحصه بنفسك.</p>
                </div>

                <div class="bg-white border border-slate-200/90 p-5 rounded-2xl space-y-1.5 shadow-sm">
                    <h4 class="font-black text-slate-900 text-sm">كم يستغرق التوصيل؟</h4>
                    <p class="text-slate-600 leading-relaxed font-normal">يصلك الطلب خلال 24 إلى 48 ساعة كحد أقصى لجميع المدن والمناطق المغربية حتى باب منزلك أو مقر عملك.</p>
                </div>

                <div class="bg-white border border-slate-200/90 p-5 rounded-2xl space-y-1.5 shadow-sm">
                    <h4 class="font-black text-slate-900 text-sm">ماذا لو كان هناك أي مشكل في المنتج؟</h4>
                    <p class="text-slate-600 leading-relaxed font-normal">نوفر ضمان استبدال مجاني وفوري لمدة 7 أيام عند وجود أي مشكل، يكفي التواصل مع فريق الدعم عبر الواتساب وسنقوم بخدمتك فوراً.</p>
                </div>
            </div>
        </section>

    </main>

    <!-- 🟢 Floating WhatsApp Support -->
    <div class="fixed bottom-6 left-6 z-50">
        <a href="https://wa.me/212773271042?text={{ rawurlencode('السلام عليكم، بغيت نستفسر على المنتجات المتوفرة في المتجر') }}" target="_blank" class="w-14 h-14 rounded-full bg-[#25D366] hover:bg-[#20ba59] text-white flex items-center justify-center text-3xl shadow-2xl pulse-ring hover:scale-110 transition-all duration-300 relative">
            💬
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center shadow border-2 border-white">1</span>
        </a>
    </div>

    <!-- Live Social Proof Notification Popup -->
    <div id="socialProofPopup" class="fixed bottom-20 md:bottom-6 right-6 z-50 bg-white/95 backdrop-blur border border-slate-200 p-3.5 rounded-2xl shadow-2xl flex items-center gap-3 transition-all duration-500 translate-y-24 opacity-0 max-w-sm">
        <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center text-xl shrink-0 font-black">
            🛍️
        </div>
        <div class="text-xs">
            <p class="font-black text-slate-900"><span id="buyerName">يوسف من الدار البيضاء</span> اشترى للتو</p>
            <p class="text-[11px] text-slate-500 truncate max-w-[200px]" id="buyerProduct">ساعة ذكية فاخرة Ultra Pro</p>
            <span class="text-[9px] text-brand-600 font-bold" id="buyerTime">منذ دقيقة واحدة ⚡</span>
        </div>
    </div>

    <!-- 👑 Signature Developer Footer -->
    <footer class="bg-slate-950 text-white border-t border-slate-800 py-12 px-4 sm:px-8 mt-20">
        <div class="max-w-7xl mx-auto space-y-8 text-center">
            
            <div class="flex items-center justify-center gap-2.5">
                <div class="w-9 h-9 rounded-2xl bg-brand-500 flex items-center justify-center text-slate-950 font-black text-lg font-en">
                    M
                </div>
                <span class="font-black text-2xl tracking-tight text-white font-en">MED<span class="text-brand-400">EXPRESS</span></span>
            </div>

            <p class="text-xs text-slate-400 max-w-md mx-auto leading-relaxed font-normal">
                المنصة المغربية الرائدة للتسوق المباشر مع خدمة الدفع عند الاستلام وضمان الجودة والسرعة في كل طرد.
            </p>

            <div class="border-t border-slate-900 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <div>
                    جميع الحقوق محفوظة © {{ date('Y') }} MED EXPRESS ENTERPRISE
                </div>

                <!-- 🔥 Developer Signature Badge -->
                <div class="inline-flex items-center gap-2.5 bg-slate-900 border border-slate-800 px-5 py-2.5 rounded-full shadow">
                    <span class="text-slate-400 font-normal">Architected & Engineered by</span>
                    <span class="font-black text-brand-400 font-en tracking-wider text-sm">Mohamed Khouyani</span>
                    <span class="text-brand-400">✨</span>
                </div>
            </div>

        </div>
    </footer>

    <!-- ⚙️ JavaScript Engine -->
    <script>
        const activeProductSlides = {};

        // الدالة المسؤولة عن الانتقال إلى صورة معينة وتحديث المصغرات والنقاط
        function goToProductSlide(prodId, targetIndex, total) {
            const box = document.getElementById(`carousel-box-${prodId}`);
            if (!box) return;
            
            const slides = box.querySelectorAll('.carousel-slide-item');
            const dots = document.getElementById(`dots-wrap-${prodId}`)?.querySelectorAll('.slide-dot');
            const thumbs = document.getElementById(`thumbs-row-${prodId}`)?.querySelectorAll('.thumb-node');

            slides.forEach((slide, idx) => {
                if (idx === targetIndex) {
                    slide.classList.remove('opacity-0', 'z-0', 'pointer-events-none');
                    slide.classList.add('opacity-100', 'z-10');
                } else {
                    slide.classList.remove('opacity-100', 'z-10');
                    slide.classList.add('opacity-0', 'z-0', 'pointer-events-none');
                }
            });

            if (dots) {
                dots.forEach((dot, idx) => {
                    if (idx === targetIndex) {
                        dot.className = 'slide-dot transition-all duration-300 w-3 h-1.5 bg-brand-400 rounded-full';
                    } else {
                        dot.className = 'slide-dot transition-all duration-300 w-1.5 h-1.5 bg-white/60 rounded-full';
                    }
                });
            }

            if (thumbs) {
                thumbs.forEach((thumb, idx) => {
                    if (idx === targetIndex) {
                        thumb.className = 'thumb-node w-12 h-12 rounded-xl border-2 border-brand-500 ring-2 ring-brand-500/20 overflow-hidden flex-shrink-0 bg-slate-50 p-0.5 transition';
                    } else {
                        thumb.className = 'thumb-node w-12 h-12 rounded-xl border-2 border-slate-200 hover:border-slate-400 overflow-hidden flex-shrink-0 bg-slate-50 p-0.5 transition';
                    }
                });
            }

            activeProductSlides[prodId] = targetIndex;
        }

        // الدالة المسؤولة عن الأسهم التالية والسابقة
        function changeProductSlide(prodId, direction, total) {
            let currentIndex = activeProductSlides[prodId] || 0;
            let nextIndex = (currentIndex + direction + total) % total;
            goToProductSlide(prodId, nextIndex, total);
        }

        // تصفية الكتالوج المباشرة
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

        // عداد تنازلي للعرض المحدود
        let countdownSeconds = 13470;
        setInterval(() => {
            countdownSeconds--;
            if (countdownSeconds < 0) countdownSeconds = 14400;
            const h = String(Math.floor(countdownSeconds / 3600)).padStart(2, '0');
            const m = String(Math.floor((countdownSeconds % 3600) / 60)).padStart(2, '0');
            const s = String(countdownSeconds % 60).padStart(2, '0');
            const el = document.getElementById('headerTimer');
            if (el) el.innerText = `${h}:${m}:${s}`;
        }, 1000);

        // محاكاة إشعارات المشترين الحية
        const buyerSimulations = [
            { name: 'يوسف من الدار البيضاء', product: 'ساعة ذكية فاخرة Ultra Pro', time: 'منذ دقيقة واحدة' },
            { name: 'أمين من طنجة', product: 'مضخة غسيل السيارات اللاسلكية', time: 'منذ 3 دقائق' },
            { name: 'فاطمة من مراكش', product: 'ساعة ذكية فاخرة Ultra Pro', time: 'منذ 5 دقائق' },
            { name: 'طارق من فاس', product: 'مضخة غسيل السيارات اللاسلكية', time: 'منذ دقيقتين' },
            { name: 'سناء من أكادير', product: 'ساعة ذكية فاخرة Ultra Pro', time: 'منذ 4 دقائق' }
        ];

        function triggerSocialProof() {
            const popup = document.getElementById('socialProofPopup');
            if (!popup) return;
            const item = buyerSimulations[Math.floor(Math.random() * buyerSimulations.length)];
            
            document.getElementById('buyerName').innerText = item.name;
            document.getElementById('buyerProduct').innerText = item.product;
            document.getElementById('buyerTime').innerText = `${item.time} ⚡`;

            popup.classList.remove('translate-y-24', 'opacity-0');
            popup.classList.add('translate-y-0', 'opacity-100');

            setTimeout(() => {
                popup.classList.remove('translate-y-0', 'opacity-100');
                popup.classList.add('translate-y-24', 'opacity-0');
            }, 4500);
        }

        setInterval(triggerSocialProof, 10000);
        setTimeout(triggerSocialProof, 3000);
    </script>
</body>
</html>