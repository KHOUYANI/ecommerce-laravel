<!DOCTYPE html>
<html lang="ar" dir="rtl" class="dark scroll-smooth" id="adminHtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>السلات المتروكة والعملاء المحتملين | MED EXPRESS ENTERPRISE</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,700&family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            darkMode: 'class',
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
                            750: '#1e293b',
                            800: '#131c2e',
                            850: '#0e1626',
                            900: '#090e1a',
                            950: '#040711',
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
        body { 
            font-family: 'Tajawal', sans-serif; 
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .font-en { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Dark Mesh */
        html.dark body {
            background-color: #040711;
            color: #f1f5f9;
            background-image: 
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.12) 0px, transparent 40%),
                radial-gradient(at 100% 5%, rgba(6, 182, 212, 0.08) 0px, transparent 35%),
                radial-gradient(at 50% 100%, rgba(16, 185, 129, 0.05) 0px, transparent 50%);
            background-attachment: fixed;
        }

        /* Light Mesh */
        html:not(.dark) body {
            background-color: #F8FAFC;
            color: #0F172A;
            background-image: 
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.06) 0px, transparent 40%),
                radial-gradient(at 100% 5%, rgba(6, 182, 212, 0.04) 0px, transparent 35%);
            background-attachment: fixed;
        }

        /* Dark Card Style */
        html.dark .glass-sidebar {
            background: rgba(14, 22, 38, 0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-left: 1px solid rgba(255, 255, 255, 0.06);
        }
        html.dark .glass-card {
            background: linear-gradient(180deg, rgba(19, 28, 46, 0.6) 0%, rgba(14, 22, 38, 0.8) 100%);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.07);
        }
        html.dark .glass-panel {
            background: rgba(14, 22, 38, 0.75);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        /* Light Card Style */
        html:not(.dark) .glass-sidebar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(24px);
            border-left: 1px solid #E2E8F0;
        }
        html:not(.dark) .glass-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03);
        }
        html:not(.dark) .glass-panel {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
        }

        .glass-card {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .glass-card:hover {
            border-color: rgba(16, 185, 129, 0.4);
            transform: translateY(-4px);
        }

        .glow-btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 0 20px -4px rgba(16, 185, 129, 0.5);
            transition: all 0.25s ease;
        }
        .glow-btn:hover {
            box-shadow: 0 0 30px 0px rgba(16, 185, 129, 0.75);
            transform: scale(1.02);
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #10b981;
            border-radius: 4px;
        }
    </style>
</head>
<body class="antialiased selection:bg-brand-500 selection:text-black">

    <div class="min-h-screen flex flex-col lg:flex-row">

        <!-- 🧭 Collapsible Pro Sidebar -->
        <aside class="lg:w-72 glass-sidebar flex-shrink-0 flex flex-col justify-between p-5 border-b lg:border-b-0 z-40">
            <div class="space-y-8">
                
                <!-- Brand Badge -->
                <div class="flex items-center gap-3.5 px-2">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-brand-400 to-teal-500 p-[1px] shadow-lg shadow-brand-500/20">
                        <div class="w-full h-full bg-slate-950 rounded-2xl flex items-center justify-center text-brand-400 font-black text-xl font-en">
                            M
                        </div>
                    </div>
                    <div>
                        <div class="font-black text-xl text-slate-900 dark:text-white font-en tracking-tight leading-none">
                            MED<span class="text-brand-500">EXPRESS</span>
                        </div>
                        <span class="text-[9px] text-brand-600 dark:text-brand-400 font-bold uppercase tracking-widest block mt-1">Enterprise COD HQ</span>
                    </div>
                </div>

                <!-- Navigation List -->
                <nav class="space-y-1.5 text-xs font-bold">
                    <div class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-wider px-3 mb-2 font-en">MAIN OPS</div>
                    
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center justify-between px-3.5 py-3 rounded-2xl text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-900/60 transition">
                        <div class="flex items-center gap-3">
                            <span class="text-base">📦</span>
                            <span>إدارة الطلبيات (Orders)</span>
                        </div>
                    </a>

                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <a href="{{ route('admin.products.list') }}" class="flex items-center justify-between px-3.5 py-3 rounded-2xl text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-900/60 transition">
                            <div class="flex items-center gap-3">
                                <span class="text-base">🛍️</span>
                                <span>المنتجات والمخزون</span>
                            </div>
                        </a>

                        <a href="{{ route('admin.leads.index') }}" class="flex items-center justify-between px-3.5 py-3 rounded-2xl bg-brand-500/10 text-brand-600 dark:text-brand-400 border border-brand-500/20 shadow-sm transition">
                            <div class="flex items-center gap-3">
                                <span class="text-base">🛒</span>
                                <span>السلات المتروكة (Leads)</span>
                            </div>
                            <span class="bg-brand-500 text-slate-950 text-[10px] font-black px-2 py-0.5 rounded-md font-en">{{ $leads->total() }}</span>
                        </a>

                        <a href="{{ route('admin.settings') }}" class="flex items-center justify-between px-3.5 py-3 rounded-2xl text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-900/60 transition">
                            <div class="flex items-center gap-3">
                                <span class="text-base">⚙️</span>
                                <span>التسويق والكوبونات</span>
                            </div>
                        </a>
                    @endif

                    <div class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-wider px-3 pt-4 mb-2 font-en">SHORTCUTS</div>

                    <a href="{{ route('shop.index') }}" target="_blank" class="flex items-center justify-between px-3.5 py-3 rounded-2xl text-slate-600 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-slate-100 dark:hover:bg-slate-900/60 transition">
                        <div class="flex items-center gap-3">
                            <span class="text-base">🌐</span>
                            <span>زيارة المتجر المباشر</span>
                        </div>
                        <span class="text-[10px] text-slate-400 font-en">↗</span>
                    </a>
                </nav>
            </div>

            <!-- User Status & Logout -->
            <div class="pt-6 border-t border-slate-200 dark:border-white/5 space-y-3">
                <div class="flex items-center justify-between px-2">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-slate-200 dark:bg-slate-800 flex items-center justify-center font-bold text-xs text-brand-600 dark:text-brand-400 font-en">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div>
                            <div class="font-bold text-xs text-slate-900 dark:text-white truncate max-w-[120px]">{{ Auth::user()->name ?? 'Mohamed' }}</div>
                            <span class="text-[9px] text-emerald-600 dark:text-emerald-400 font-mono font-bold">{{ (Auth::user()->role ?? 'admin') === 'admin' ? 'Master Admin' : 'Agent Support' }}</span>
                        </div>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" title="تسجيل الخروج" class="w-8 h-8 rounded-xl bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white flex items-center justify-center transition border border-red-500/20 text-xs">
                            🚪
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- 🖥️ Main Workspace Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            
            <!-- Top Command Header Toolbar -->
            <header class="glass-panel sticky top-0 z-30 px-6 py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-200 dark:border-white/5">
                <div>
                    <h2 class="text-lg font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <span>مركز استرجاع السلات المتروكة (Abandoned Carts)</span>
                        <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 font-medium">الزبناء المهتمين الذين قاموا بإدخال أرقام هواتفهم ولم يكملوا الطلب</p>
                </div>

                <div class="flex items-center gap-3">
                    <!-- 🌓 Dark/Light Mode Switcher -->
                    <button type="button" onclick="toggleTheme()" id="themeToggleBtn" class="bg-slate-100 dark:bg-slate-900 hover:bg-slate-200 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-700 px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                        <span id="themeIcon">☀️</span>
                        <span id="themeText">الوضع</span>
                    </button>

                    <!-- Quick Refresh Button -->
                    <button onclick="window.location.reload()" class="bg-slate-100 dark:bg-slate-900 hover:bg-slate-200 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/5 p-2.5 rounded-xl text-xs transition shadow-sm" title="تحديث البيانات">
                        🔄
                    </button>
                </div>
            </header>

            <div class="p-6 sm:p-8 space-y-8 max-w-7xl mx-auto w-full">

                <!-- 📊 Leads KPI Summary Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                    <div class="glass-card p-6 rounded-3xl space-y-2">
                        <div class="flex justify-between items-center text-slate-500 dark:text-slate-400 text-xs font-bold">
                            <span>إجمالي السلات المتروكة</span>
                            <span class="text-base">🛒</span>
                        </div>
                        <div class="text-3xl font-black text-slate-900 dark:text-white font-en">{{ $leads->total() }}</div>
                        <span class="text-[11px] text-slate-400">زبناء محتملين يحتاجون المتابعة</span>
                    </div>

                    <div class="glass-card p-6 rounded-3xl space-y-2">
                        <div class="flex justify-between items-center text-amber-500 text-xs font-bold">
                            <span>نسبة الاسترجاع المتوقعة</span>
                            <span class="text-base">📈</span>
                        </div>
                        <div class="text-3xl font-black text-amber-500 font-en">22.4%</div>
                        <span class="text-[11px] text-amber-600/80 font-bold">معدل تحويل قياسي عبر رسائل الواتساب</span>
                    </div>

                    <div class="glass-card p-6 rounded-3xl space-y-2">
                        <div class="flex justify-between items-center text-emerald-500 text-xs font-bold">
                            <span>مبيعات إضافية محتملة</span>
                            <span class="text-base">💵</span>
                        </div>
                        <div class="text-3xl font-black text-emerald-500 font-en">+{{ $leads->total() * 250 }} <span class="text-xs font-sans font-bold">DH</span></div>
                        <span class="text-[11px] text-emerald-600/80 font-bold">أرباح إضافية مباشرة بلا زيادة ف مصاريف الإعلانات</span>
                    </div>
                </div>

                <!-- 🛒 Leads Table -->
                <div class="glass-card rounded-[2.5rem] overflow-hidden border border-slate-200 dark:border-white/10">
                    <div class="overflow-x-auto">
                        <table class="w-full text-right text-xs">
                            <thead class="bg-slate-50 dark:bg-slate-900/90 text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-white/10 font-bold">
                                <tr>
                                    <th class="p-4">اسم الزبون</th>
                                    <th class="p-4">رقم الهاتف (الواتساب)</th>
                                    <th class="p-4">المدينة</th>
                                    <th class="p-4">المنتج المهتم به</th>
                                    <th class="p-4">توقيت المحاولة</th>
                                    <th class="p-4 text-center">إجراء الاسترجاع السريع</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                                @forelse($leads as $lead)
                                    @php
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $lead->phone);
                                        if (str_starts_with($cleanPhone, '0')) {
                                            $cleanPhone = '212' . substr($cleanPhone, 1);
                                        }
                                        $productTitle = $lead->product->name ?? 'المنتج المميز';
                                        $recoveryMsg = "السلام عليكم أخي " . ($lead->name ?: '') . " 👋\n"
                                                     . "معك خدمة الزبناء لمتجر MED EXPRESS بخصوص اهتمامك بـ (" . $productTitle . ").\n\n"
                                                     . "شفنا بلي حاولتي تطلب وما كملتيش الاستمارة، واش واجهتي شي مشكل؟\n"
                                                     . "🎁 عطيناك تخفيض حصري إضافي 10% + توصيل فوري مجاني يلا بغيتي نأكدوا ليك الطلبية اليوم!\n\n"
                                                     . "واش باغي نوجدو ليك الطرد دابا للشحن؟ وشكراً ✨";
                                    @endphp
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/40 transition">
                                        <td class="p-4 font-black text-slate-900 dark:text-white text-sm">
                                            {{ $lead->name ?: 'زبون مهتم' }}
                                        </td>
                                        <td class="p-4 font-mono font-bold text-slate-600 dark:text-slate-300 text-sm" dir="ltr">
                                            {{ $lead->phone }}
                                        </td>
                                        <td class="p-4 font-bold text-slate-700 dark:text-slate-300">
                                            📍 {{ $lead->city ?: 'غير محددة' }}
                                        </td>
                                        <td class="p-4 font-bold text-brand-600 dark:text-brand-400">
                                            • {{ $productTitle }}
                                        </td>
                                        <td class="p-4 text-slate-400 font-mono text-[11px]">
                                            {{ $lead->created_at->diffForHumans() }}
                                            <span class="block text-[10px] text-slate-500">{{ $lead->created_at->format('Y-m-d H:i') }}</span>
                                        </td>
                                        <td class="p-4 text-center">
                                            <a href="https://wa.me/{{ $cleanPhone }}?text={{ rawurlencode($recoveryMsg) }}" target="_blank" class="inline-flex items-center gap-1.5 bg-[#25D366] hover:bg-[#20ba59] text-slate-950 font-black px-4 py-2 rounded-xl text-xs transition shadow-sm active:scale-95">
                                                <span>💬 استرجاع عبر الواتساب (خصم 10%)</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-12 text-center text-slate-400 dark:text-slate-500 font-bold text-sm">
                                            🎉 رائع! لا توجد أي سلات متروكة غير مسترجعة حالياً.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4 border-t border-slate-200 dark:border-white/5">
                        {{ $leads->links() }}
                    </div>
                </div>

            </div>

            <!-- 👑 Signature Developer VIP Footer -->
            <footer class="border-t border-slate-200 dark:border-white/5 bg-white/80 dark:bg-slate-950/80 py-8 px-6 text-center text-xs text-slate-500 mt-auto">
                <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div>
                        جميع الحقوق محفوظة © 2026 MED EXPRESS PRO ENTERPRISE
                    </div>

                    <!-- 🔥 Mohamed Khouyani Developer Badge -->
                    <div class="inline-flex items-center gap-2.5 bg-slate-100 dark:bg-slate-900 border border-brand-500/30 px-5 py-2 rounded-full shadow-sm">
                        <span class="text-slate-500 dark:text-slate-400 font-normal">Architected & Engineered by</span>
                        <span class="font-black text-brand-600 dark:text-brand-400 font-en tracking-wider text-sm">Mohamed Khouyani</span>
                        <span class="text-brand-500">✨</span>
                    </div>
                </div>
            </footer>

        </div>

    </div>

    <!-- Theme Mode Script -->
    <script>
        function applyTheme(isDark) {
            const html = document.getElementById('adminHtml');
            const icon = document.getElementById('themeIcon');
            const text = document.getElementById('themeText');

            if (isDark) {
                html.classList.add('dark');
                icon.innerText = '☀️';
                text.innerText = 'الوضع';
                localStorage.setItem('admin_theme', 'dark');
            } else {
                html.classList.remove('dark');
                icon.innerText = '🌙';
                text.innerText = 'الوضع';
                localStorage.setItem('admin_theme', 'light');
            }
        }

        function toggleTheme() {
            const isDark = document.getElementById('adminHtml').classList.contains('dark');
            applyTheme(!isDark);
        }

        const savedTheme = localStorage.getItem('admin_theme') || 'dark';
        applyTheme(savedTheme === 'dark');
    </script>

</body>
</html>