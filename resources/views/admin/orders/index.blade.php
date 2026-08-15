<!DOCTYPE html>
<html lang="ar" dir="rtl" class="dark scroll-smooth" id="adminHtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MED EXPRESS ENTERPRISE | مركز القيادة وإدارة العمليات</title>
    
    <!-- Tailwind CSS with Forms & Typography -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Chart.js Engine -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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

        /* Kanban Column Styling */
        .kanban-col {
            min-height: 480px;
            transition: all 0.2s ease;
        }
        .kanban-col.drag-over {
            background: rgba(16, 185, 129, 0.15);
            border: 2px dashed #10b981;
        }
        .kanban-item {
            cursor: grab;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .kanban-item:active {
            cursor: grabbing;
        }
        .kanban-item.dragging {
            opacity: 0.4;
            transform: scale(0.95);
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
                    
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center justify-between px-3.5 py-3 rounded-2xl bg-brand-500/10 text-brand-600 dark:text-brand-400 border border-brand-500/20 shadow-sm transition">
                        <div class="flex items-center gap-3">
                            <span class="text-base">📦</span>
                            <span>إدارة الطلبيات (Orders)</span>
                        </div>
                        <span class="bg-brand-500 text-slate-950 text-[10px] font-black px-2 py-0.5 rounded-md font-en">{{ $stats['new_orders'] ?? 0 }}</span>
                    </a>

                    <!-- Products Links -->
                    <a href="{{ route('admin.products.create') }}" class="flex items-center justify-between px-3.5 py-3 rounded-2xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 hover:bg-emerald-500/20 transition">
                        <div class="flex items-center gap-3">
                            <span class="text-base">➕</span>
                            <span>إضافة منتج جديد</span>
                        </div>
                        <span class="text-[10px] bg-emerald-500 text-slate-950 px-1.5 py-0.5 rounded font-black">NEW</span>
                    </a>

                    <a href="{{ route('admin.products.index') }}" class="flex items-center justify-between px-3.5 py-3 rounded-2xl text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-900/60 transition">
                        <div class="flex items-center gap-3">
                            <span class="text-base">🛍️</span>
                            <span>المنتجات والمخزون</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.leads.index') }}" class="flex items-center justify-between px-3.5 py-3 rounded-2xl text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-900/60 transition">
                        <div class="flex items-center gap-3">
                            <span class="text-base">🛒</span>
                            <span>السلات المتروكة (Leads)</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.settings') }}" class="flex items-center justify-between px-3.5 py-3 rounded-2xl text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-900/60 transition">
                        <div class="flex items-center gap-3">
                            <span class="text-base">⚙️</span>
                            <span>التسويق والكوبونات</span>
                        </div>
                    </a>

                    <div class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-wider px-3 pt-4 mb-2 font-en">TOOLS & EXPORTS</div>

                    <!-- Profit Calculator Trigger -->
                    <button type="button" onclick="document.getElementById('profitModal').classList.remove('hidden')" class="w-full flex items-center gap-3 px-3.5 py-3 rounded-2xl text-blue-600 dark:text-blue-400 bg-blue-500/10 hover:bg-blue-500/20 transition text-right font-black">
                        <span class="text-base">📊</span>
                        <span>حاسبة الأرباح الصافية (COD ROI)</span>
                    </button>

                    <!-- Quick Add Order Modal Button -->
                    <button type="button" onclick="document.getElementById('quickOrderModal').classList.remove('hidden')" class="w-full flex items-center gap-3 px-3.5 py-3 rounded-2xl text-emerald-600 dark:text-emerald-400 bg-emerald-500/10 hover:bg-emerald-500/20 transition text-right font-black">
                        <span class="text-base">➕</span>
                        <span>إضافة طلبية هاتفية سريعة</span>
                    </button>

                    <button type="button" onclick="document.getElementById('exportModal').classList.remove('hidden')" class="w-full flex items-center gap-3 px-3.5 py-3 rounded-2xl text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-900/60 transition text-right">
                        <span class="text-base">📥</span>
                        <span>تصدير شركات الشحن</span>
                    </button>

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
            
            <!-- Top Command Header Toolbar with Dark/Light Switch -->
            <header class="glass-panel sticky top-0 z-30 px-6 py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-200 dark:border-white/5">
                <div>
                    <h2 class="text-lg font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <span>إدارة الطلبيات والعمليات اللوجستية</span>
                        <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 font-medium">تتبع ومعالجة طلبيات الزبناء والتأكيد المباشر عبر الواتساب</p>
                </div>

                <div class="flex items-center gap-3">
                    <!-- 🗂️ View Mode Switcher (Table vs Kanban) -->
                    <div class="bg-slate-200 dark:bg-slate-800 p-1 rounded-xl flex items-center text-xs font-bold">
                        <button type="button" onclick="switchView('table')" id="btnViewTable" class="px-3 py-1.5 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow transition">
                            📋 جدول
                        </button>
                        <button type="button" onclick="switchView('kanban')" id="btnViewKanban" class="px-3 py-1.5 rounded-lg text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition">
                            🗂️ كانبان
                        </button>
                    </div>

                    <!-- ➕ Add Product Top Button -->
                    <a href="{{ route('admin.products.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-black px-3.5 py-2 rounded-xl text-xs flex items-center gap-1.5 transition active:scale-95 shadow">
                        <span>➕ إضافة منتج</span>
                    </a>

                    <!-- 📊 Open Profit Calculator Button -->
                    <button type="button" onclick="document.getElementById('profitModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white font-black px-3.5 py-2 rounded-xl text-xs flex items-center gap-1.5 transition active:scale-95 shadow">
                        <span>📊 الأرباح</span>
                    </button>

                    <!-- ➕ Quick Order Top Button -->
                    <button type="button" onclick="document.getElementById('quickOrderModal').classList.remove('hidden')" class="glow-btn text-slate-950 font-black px-4 py-2 rounded-xl text-xs flex items-center gap-1.5 transition active:scale-95 shadow">
                        <span>➕ طلبية هاتفية</span>
                    </button>

                    <!-- 🌓 Dark/Light Mode Switcher -->
                    <button type="button" onclick="toggleTheme()" id="themeToggleBtn" class="bg-slate-100 dark:bg-slate-900 hover:bg-slate-200 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-700 px-3 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                        <span id="themeIcon">☀️</span>
                        <span id="themeText">الوضع</span>
                    </button>

                    <!-- Live Morocco Server Clock -->
                    <div class="bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 px-3.5 py-1.5 rounded-xl flex items-center gap-2 text-xs font-mono text-slate-700 dark:text-slate-300">
                        <span class="text-brand-600 dark:text-brand-400">🇲🇦:</span>
                        <span id="moroccoClock" class="font-bold text-slate-900 dark:text-white">07:25:00</span>
                    </div>
                </div>
            </header>

            <div class="p-6 sm:p-8 space-y-8 max-w-7xl mx-auto w-full">

                @if(session('success'))
                    <div class="bg-emerald-50 dark:bg-brand-950/90 text-emerald-800 dark:text-brand-300 border border-emerald-200 dark:border-brand-500/30 px-5 py-4 rounded-2xl shadow font-black text-xs flex items-center gap-2.5 backdrop-blur-md">
                        <span>✅</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 dark:bg-red-950/90 text-red-800 dark:text-red-300 border border-red-200 dark:border-red-500/30 px-5 py-4 rounded-2xl shadow font-black text-xs flex items-center gap-2.5 backdrop-blur-md">
                        <span>⚠️</span>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- 📊 Executive KPI Metrics Suite -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    <div class="glass-card p-6 rounded-3xl space-y-3 relative overflow-hidden">
                        <div class="flex justify-between items-center text-slate-500 dark:text-slate-400 text-xs font-bold">
                            <span>إجمالي الطلبيات</span>
                            <span class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-white/5 text-slate-700 dark:text-slate-300 flex items-center justify-center text-sm border border-slate-200 dark:border-white/5">📦</span>
                        </div>
                        <div class="text-3xl font-black text-slate-900 dark:text-white font-en tracking-tight">{{ $stats['total_orders'] ?? 0 }}</div>
                        <div class="flex items-center gap-2 text-[10px] text-slate-500 dark:text-slate-400 font-medium">
                            <span class="text-brand-600 dark:text-brand-400 font-bold font-en">100%</span>
                            <span>الطلبيات المسجلة بالموقع</span>
                        </div>
                    </div>

                    <div class="glass-card p-6 rounded-3xl space-y-3 relative overflow-hidden">
                        <div class="flex justify-between items-center text-amber-600 dark:text-amber-400 text-xs font-bold">
                            <span>طلبيات جديدة (À traiter)</span>
                            <span class="w-8 h-8 rounded-xl bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center text-sm border border-amber-200 dark:border-amber-500/20">⚡</span>
                        </div>
                        <div class="text-3xl font-black text-amber-600 dark:text-amber-400 font-en tracking-tight">{{ $stats['new_orders'] ?? 0 }}</div>
                        <div class="flex items-center gap-2 text-[10px] text-amber-700 dark:text-amber-400/80 font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-ping"></span>
                            <span>تتطلب التأكيد الهاتفي الفوري</span>
                        </div>
                    </div>

                    <div class="glass-card p-6 rounded-3xl space-y-3 relative overflow-hidden">
                        <div class="flex justify-between items-center text-brand-600 dark:text-brand-400 text-xs font-bold">
                            <span>تم التوصيل (Livré)</span>
                            <span class="w-8 h-8 rounded-xl bg-brand-50 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 flex items-center justify-center text-sm border border-brand-200 dark:border-brand-500/20">✓</span>
                        </div>
                        <div class="text-3xl font-black text-brand-600 dark:text-brand-400 font-en tracking-tight">{{ $stats['delivered'] ?? 0 }}</div>
                        <div class="flex items-center gap-2 text-[10px] text-brand-700 dark:text-brand-400/80 font-medium">
                            <span>نسبة التوصيل:</span>
                            <span class="font-black font-en">{{ ($stats['total_orders'] ?? 0) > 0 ? round(($stats['delivered'] / $stats['total_orders']) * 100, 1) : 0 }}%</span>
                        </div>
                    </div>

                    <div class="glass-card p-6 rounded-3xl space-y-3 relative overflow-hidden">
                        <div class="flex justify-between items-center text-cyan-600 dark:text-cyan-400 text-xs font-bold">
                            <span>المداخيل المحصلة</span>
                            <span class="w-8 h-8 rounded-xl bg-cyan-50 dark:bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 flex items-center justify-center text-sm border border-cyan-200 dark:border-cyan-500/20">💵</span>
                        </div>
                        <div class="text-3xl font-black text-slate-900 dark:text-white font-en tracking-tight">
                            {{ number_format($stats['total_revenue'] ?? 0, 2) }} <span class="text-xs font-sans font-bold text-brand-600 dark:text-brand-400">DH</span>
                        </div>
                        <div class="flex items-center gap-2 text-[10px] text-cyan-700 dark:text-cyan-400/80 font-medium">
                            <span>إجمالي السيولة المقبوضة فعلياً</span>
                        </div>
                    </div>
                </div>

                <!-- 🗂️ Interactive Drag & Drop Kanban Pipeline View -->
                <div id="kanbanViewContainer" class="hidden space-y-4">
                    <div class="flex justify-between items-center bg-brand-500/10 border border-brand-500/20 p-4 rounded-2xl text-xs font-bold text-brand-400">
                        <span>⚡ اسحب البطاقة بيدك وضعها في العمود المناسب لتغيير حالتها في الداتابيز فوراً!</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        
                        <!-- Column: Nouveau -->
                        <div class="kanban-col bg-slate-100 dark:bg-slate-900/60 p-4 rounded-3xl border border-amber-500/30 space-y-3" data-status="nouveau" ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="dropOrder(event, 'nouveau')">
                            <div class="flex justify-between items-center pb-2 border-b border-amber-500/20">
                                <span class="font-black text-xs text-amber-500">⚡ جديدة (À traiter)</span>
                                <span class="text-[10px] bg-amber-500/20 text-amber-400 font-black px-2 py-0.5 rounded-full font-en">{{ isset($kanbanOrders) ? $kanbanOrders->where('status', 'nouveau')->count() : 0 }}</span>
                            </div>
                            <div class="space-y-2.5">
                                @if(isset($kanbanOrders))
                                    @foreach($kanbanOrders->where('status', 'nouveau') as $kOrder)
                                        <div class="kanban-item bg-white dark:bg-slate-800 p-3.5 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 space-y-2" draggable="true" ondragstart="dragStart(event, {{ $kOrder->id }})" ondragend="dragEnd(event)">
                                            <div class="flex justify-between items-center text-[10px]">
                                                <span class="font-mono font-bold text-brand-500">{{ $kOrder->tracking_number }}</span>
                                                <span class="font-black text-slate-900 dark:text-white">{{ $kOrder->total_amount }} DH</span>
                                            </div>
                                            <div class="font-bold text-xs text-slate-800 dark:text-slate-200">{{ $kOrder->customer_name }}</div>
                                            <div class="text-[11px] text-slate-500 truncate">📍 {{ $kOrder->city }}</div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Column: Confirme -->
                        <div class="kanban-col bg-slate-100 dark:bg-slate-900/60 p-4 rounded-3xl border border-blue-500/30 space-y-3" data-status="confirme" ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="dropOrder(event, 'confirme')">
                            <div class="flex justify-between items-center pb-2 border-b border-blue-500/20">
                                <span class="font-black text-xs text-blue-500">📞 مؤكدة (Confirmé)</span>
                                <span class="text-[10px] bg-blue-500/20 text-blue-400 font-black px-2 py-0.5 rounded-full font-en">{{ isset($kanbanOrders) ? $kanbanOrders->where('status', 'confirme')->count() : 0 }}</span>
                            </div>
                            <div class="space-y-2.5">
                                @if(isset($kanbanOrders))
                                    @foreach($kanbanOrders->where('status', 'confirme') as $kOrder)
                                        <div class="kanban-item bg-white dark:bg-slate-800 p-3.5 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 space-y-2" draggable="true" ondragstart="dragStart(event, {{ $kOrder->id }})" ondragend="dragEnd(event)">
                                            <div class="flex justify-between items-center text-[10px]">
                                                <span class="font-mono font-bold text-brand-500">{{ $kOrder->tracking_number }}</span>
                                                <span class="font-black text-slate-900 dark:text-white">{{ $kOrder->total_amount }} DH</span>
                                            </div>
                                            <div class="font-bold text-xs text-slate-800 dark:text-slate-200">{{ $kOrder->customer_name }}</div>
                                            <div class="text-[11px] text-slate-500 truncate">📍 {{ $kOrder->city }}</div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Column: En livraison -->
                        <div class="kanban-col bg-slate-100 dark:bg-slate-900/60 p-4 rounded-3xl border border-purple-500/30 space-y-3" data-status="en_livraison" ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="dropOrder(event, 'en_livraison')">
                            <div class="flex justify-between items-center pb-2 border-b border-purple-500/20">
                                <span class="font-black text-xs text-purple-500">🚚 في التوصيل (En livraison)</span>
                                <span class="text-[10px] bg-purple-500/20 text-purple-400 font-black px-2 py-0.5 rounded-full font-en">{{ isset($kanbanOrders) ? $kanbanOrders->where('status', 'en_livraison')->count() : 0 }}</span>
                            </div>
                            <div class="space-y-2.5">
                                @if(isset($kanbanOrders))
                                    @foreach($kanbanOrders->where('status', 'en_livraison') as $kOrder)
                                        <div class="kanban-item bg-white dark:bg-slate-800 p-3.5 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 space-y-2" draggable="true" ondragstart="dragStart(event, {{ $kOrder->id }})" ondragend="dragEnd(event)">
                                            <div class="flex justify-between items-center text-[10px]">
                                                <span class="font-mono font-bold text-brand-500">{{ $kOrder->tracking_number }}</span>
                                                <span class="font-black text-slate-900 dark:text-white">{{ $kOrder->total_amount }} DH</span>
                                            </div>
                                            <div class="font-bold text-xs text-slate-800 dark:text-slate-200">{{ $kOrder->customer_name }}</div>
                                            <div class="text-[11px] text-slate-500 truncate">📍 {{ $kOrder->city }}</div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Column: Livre -->
                        <div class="kanban-col bg-slate-100 dark:bg-slate-900/60 p-4 rounded-3xl border border-emerald-500/30 space-y-3" data-status="livre" ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="dropOrder(event, 'livre')">
                            <div class="flex justify-between items-center pb-2 border-b border-emerald-500/20">
                                <span class="font-black text-xs text-emerald-500">✓ تم الاستلام (Livré)</span>
                                <span class="text-[10px] bg-emerald-500/20 text-emerald-400 font-black px-2 py-0.5 rounded-full font-en">{{ isset($kanbanOrders) ? $kanbanOrders->where('status', 'livre')->count() : 0 }}</span>
                            </div>
                            <div class="space-y-2.5">
                                @if(isset($kanbanOrders))
                                    @foreach($kanbanOrders->where('status', 'livre') as $kOrder)
                                        <div class="kanban-item bg-white dark:bg-slate-800 p-3.5 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 space-y-2" draggable="true" ondragstart="dragStart(event, {{ $kOrder->id }})" ondragend="dragEnd(event)">
                                            <div class="flex justify-between items-center text-[10px]">
                                                <span class="font-mono font-bold text-brand-500">{{ $kOrder->tracking_number }}</span>
                                                <span class="font-black text-slate-900 dark:text-white">{{ $kOrder->total_amount }} DH</span>
                                            </div>
                                            <div class="font-bold text-xs text-slate-800 dark:text-slate-200">{{ $kOrder->customer_name }}</div>
                                            <div class="text-[11px] text-slate-500 truncate">📍 {{ $kOrder->city }}</div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

                <!-- 📋 Standard Table View -->
                <div id="tableViewContainer" class="space-y-8">
                    
                    <!-- 🔍 Filter Controls & Bulk Action Command Bar -->
                    <div class="glass-panel p-5 rounded-[2rem] flex flex-col md:flex-row gap-4 justify-between items-center border border-slate-200 dark:border-white/5">
                        
                        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap gap-3 w-full md:w-auto items-center">
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث بالاسم، الهاتف، كود التتبع..." class="bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-2xl px-4 py-2.5 text-xs text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 outline-none focus:border-brand-500 w-72 transition">
                                <span class="absolute left-3.5 top-3 text-xs text-slate-400">🔍</span>
                            </div>
                            
                            <select name="status" class="bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-2xl px-3.5 py-2.5 text-xs font-bold text-slate-700 dark:text-slate-300 outline-none focus:border-brand-500 transition">
                                <option value="">جميع الحالات</option>
                                <option value="nouveau" {{ request('status') == 'nouveau' ? 'selected' : '' }}>جديدة (Nouveau)</option>
                                <option value="confirme" {{ request('status') == 'confirme' ? 'selected' : '' }}>مؤكدة (Confirmé)</option>
                                <option value="en_livraison" {{ request('status') == 'en_livraison' ? 'selected' : '' }}>في التوصيل (En livraison)</option>
                                <option value="livre" {{ request('status') == 'livre' ? 'selected' : '' }}>تم التوصيل (Livré)</option>
                                <option value="annule" {{ request('status') == 'annule' ? 'selected' : '' }}>ملغاة (Annulé)</option>
                                <option value="retour" {{ request('status') == 'retour' ? 'selected' : '' }}>مرتجع (Retour)</option>
                            </select>

                            <button type="submit" class="bg-slate-900 dark:bg-slate-800 hover:bg-slate-800 dark:hover:bg-slate-700 text-white px-5 py-2.5 rounded-2xl text-xs font-bold transition border border-transparent dark:border-white/10 shadow-sm">
                                تصفية 🔍
                            </button>
                        </form>

                        <!-- Bulk Print Waybill Action -->
                        <form id="bulkPrintForm" action="{{ route('admin.orders.bulkPrint') }}" method="POST" target="_blank">
                            @csrf
                            <input type="hidden" name="order_ids" id="selectedOrderIds">
                            <button type="button" onclick="submitBulkPrint()" class="glow-btn text-slate-950 font-black px-5 py-2.5 rounded-2xl text-xs shadow transition flex items-center gap-2 active:scale-95">
                                <span>🖨️ طباعة البوليصات المحددة</span>
                            </button>
                        </form>

                    </div>

                    <!-- 📦 Main Orders Table -->
                    <div class="glass-card rounded-[2.5rem] overflow-hidden border border-slate-200 dark:border-white/10">
                        <div class="overflow-x-auto">
                            <table class="w-full text-right text-xs">
                                <thead class="bg-slate-50 dark:bg-slate-900/90 text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-white/10 font-bold">
                                    <tr>
                                        <th class="p-4 w-10 text-center">
                                            <input type="checkbox" id="selectAll" class="w-4 h-4 rounded bg-white dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-brand-500 focus:ring-0">
                                        </th>
                                        <th class="p-4">كود التتبع ومسار الشحن</th>
                                        <th class="p-4">مؤشر الأمان (AI Risk)</th>
                                        <th class="p-4">الزبون والتواصل</th>
                                        <th class="p-4">المدينة والعنوان</th>
                                        <th class="p-4">المنتجات المطلوبة</th>
                                        <th class="p-4">المجموع الكلي</th>
                                        <th class="p-4 text-center">تحديث الحالة والإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                                    @forelse($orders as $order)
                                        @php
                                            $cleanPhone = preg_replace('/[^0-9]/', '', $order->customer_phone);
                                            if (str_starts_with($cleanPhone, '0')) {
                                                $cleanPhone = '212' . substr($cleanPhone, 1);
                                            }
                                            $itemsList = $order->items->map(fn($i) => ($i->variant->product->name ?? 'منتج') . ' (x' . $i->quantity . ')')->implode(' + ');
                                            
                                            $whatsappMsg = "السلام عليكم أخي " . $order->customer_name . " 👋\n"
                                                         . "معك خدمة الزبناء لمتجر MED EXPRESS بخصوص طلبيتك:\n\n"
                                                         . "📦 كود الطلب: " . $order->tracking_number . "\n"
                                                         . "🛍️ المنتج: " . $itemsList . "\n"
                                                         . "💵 المبلغ الإجمالي: " . $order->total_amount . " DH (الدفع عند الاستلام)\n"
                                                         . "📍 العنوان: " . $order->city . " - " . $order->address . "\n\n"
                                                         . "عافاك واش كتأكد لينا الطلبية باش نصيفطوها ليك للشحن اليوم؟ وشكراً ✨";

                                            $locMsg = "السلام عليكم أخي " . $order->customer_name . " 🚚\n"
                                                    . "معك مصلحة التوزيع والشحن لمتجر MED EXPRESS بخصوص طلبيتك رقم (" . $order->tracking_number . ").\n\n"
                                                    . "عافاك صيفط لينا الموقع ديالك (Localisation GPS) هنا ف الواتساب باش يوصل ليك الموزع لباب دارك ديريكت بدون تأخير. وشكراً بزاف! 📍";
                                        @endphp
                                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/40 transition">
                                            <td class="p-4 text-center">
                                                <input type="checkbox" class="order-checkbox w-4 h-4 rounded bg-white dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-brand-500 focus:ring-0" value="{{ $order->id }}">
                                            </td>
                                            <td class="p-4">
                                                <div class="font-mono font-black text-brand-600 dark:text-brand-400 text-sm">{{ $order->tracking_number }}</div>
                                                <button type="button" onclick="openTimelineModal('{{ $order->tracking_number }}', '{{ $order->status }}', '{{ $order->created_at->format('Y-m-d H:i') }}', '{{ $order->city }}')" class="text-[10px] text-blue-500 hover:underline font-bold mt-0.5 block">
                                                    🛤️ تتبع المسار الحي
                                                </button>
                                            </td>
                                            <td class="p-4">
                                                <span class="inline-flex items-center gap-1 text-[11px] font-black px-2 py-0.5 rounded-xl border {{ $order->risk_score['badge_bg'] ?? '' }}">
                                                    <span>{{ $order->risk_score['label'] ?? 'عادي' }}</span>
                                                    <span class="font-mono">({{ $order->risk_score['score'] ?? 0 }}%)</span>
                                                </span>
                                            </td>
                                            <td class="p-4">
                                                <div class="font-black text-slate-900 dark:text-white text-sm">{{ $order->customer_name }}</div>
                                                <div class="text-slate-500 dark:text-slate-400 font-mono mb-2" dir="ltr">{{ $order->customer_phone }}</div>
                                                <div class="flex flex-wrap items-center gap-1.5">
                                                    <a href="https://wa.me/{{ $cleanPhone }}?text={{ rawurlencode($whatsappMsg) }}" target="_blank" class="inline-flex items-center gap-1 bg-[#25D366] text-white dark:text-slate-950 hover:bg-[#20ba59] px-2 py-1 rounded-xl text-[11px] font-black transition shadow-sm">
                                                        <span>💬 تأكيد</span>
                                                    </a>
                                                    <a href="https://wa.me/{{ $cleanPhone }}?text={{ rawurlencode($locMsg) }}" target="_blank" class="inline-flex items-center gap-1 bg-blue-600 text-white hover:bg-blue-700 px-2 py-1 rounded-xl text-[11px] font-bold transition shadow-sm" title="طلب موقع التوصيل GPS">
                                                        <span>📍 لوكاسيون</span>
                                                    </a>
                                                    <a href="{{ route('admin.orders.print', $order->id) }}" target="_blank" class="inline-flex items-center gap-1 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 px-2 py-1 rounded-xl text-[11px] font-bold transition border border-slate-200 dark:border-white/10">
                                                        <span>🖨️</span>
                                                    </a>
                                                    <button type="button" onclick="openBlacklistModal('{{ $order->customer_phone }}', '{{ $order->customer_name }}')" class="bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white px-2 py-1 rounded-xl text-[11px] font-bold transition border border-red-500/20" title="حظر هذا الرقم">
                                                        🛑
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="p-4">
                                                <div class="font-bold text-slate-800 dark:text-slate-200">{{ $order->city }}</div>
                                                <div class="text-slate-500 dark:text-slate-400 text-[11px] max-w-xs truncate">{{ $order->address }}</div>
                                            </td>
                                            <td class="p-4">
                                                @foreach($order->items as $item)
                                                    <div class="font-bold text-slate-800 dark:text-slate-300">
                                                        • {{ $item->variant->product->name ?? 'المنتج' }} <span class="text-brand-600 dark:text-brand-400">(x{{ $item->quantity }})</span>
                                                    </div>
                                                @endforeach
                                            </td>
                                            <td class="p-4 font-black text-brand-600 dark:text-brand-400 text-sm font-en">
                                                {{ $order->total_amount }} <span class="text-xs font-bold font-sans text-slate-500 dark:text-slate-400">DH</span>
                                            </td>
                                            
                                            <!-- عمود تحديث الحالة وحذف الطلبية -->
                                            <td class="p-4 text-center">
                                                <div class="inline-flex items-center justify-center gap-2">
                                                    <!-- فورم تحديث الحالة -->
                                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex items-center gap-1.5">
                                                        @csrf
                                                        <select name="status" class="border rounded-xl px-2 py-1.5 text-xs font-bold outline-none 
                                                            {{ $order->status == 'nouveau' ? 'bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border-amber-300 dark:border-amber-500/30' : '' }}
                                                            {{ $order->status == 'confirme' ? 'bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 border-blue-300 dark:border-blue-500/30' : '' }}
                                                            {{ $order->status == 'en_livraison' ? 'bg-purple-50 dark:bg-purple-500/10 text-purple-700 dark:text-purple-400 border-purple-300 dark:border-purple-500/30' : '' }}
                                                            {{ $order->status == 'livre' ? 'bg-emerald-50 dark:bg-brand-500/10 text-emerald-700 dark:text-brand-400 border-emerald-300 dark:border-brand-500/30' : '' }}
                                                            {{ $order->status == 'annule' ? 'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 border-red-300 dark:border-red-500/30' : '' }}
                                                            {{ $order->status == 'retour' ? 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-400 border-slate-300 dark:border-slate-700' : '' }}
                                                        ">
                                                            <option value="nouveau" {{ $order->status == 'nouveau' ? 'selected' : '' }}>جديدة (Nouveau)</option>
                                                            <option value="confirme" {{ $order->status == 'confirme' ? 'selected' : '' }}>مؤكدة (Confirmé)</option>
                                                            <option value="en_livraison" {{ $order->status == 'en_livraison' ? 'selected' : '' }}>في التوصيل (En livraison)</option>
                                                            <option value="livre" {{ $order->status == 'livre' ? 'selected' : '' }}>تم التوصيل (Livré)</option>
                                                            <option value="annule" {{ $order->status == 'annule' ? 'selected' : '' }}>ملغاة (Annulé)</option>
                                                            <option value="retour" {{ $order->status == 'retour' ? 'selected' : '' }}>مرتجع (Retour)</option>
                                                        </select>

                                                        <button type="submit" class="bg-slate-900 dark:bg-slate-800 hover:bg-slate-800 dark:hover:bg-slate-700 text-white px-3 py-1.5 rounded-xl text-xs font-bold transition">
                                                            حفظ 💾
                                                        </button>
                                                    </form>

                                                    <!-- فورم حذف الطلبية -->
                                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('⚠️ واش متأكد باغي تمسح الطلبية رقم ({{ $order->tracking_number }}) نهائياً؟')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white border border-red-500/20 p-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1" title="حذف الطلبية نهائياً">
                                                            <span>🗑️</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="p-12 text-center text-slate-400 dark:text-slate-500 font-bold text-sm">لا توجد أي طلبيات مسجلة حالياً</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="p-4 border-t border-slate-200 dark:border-white/5">
                            {{ $orders->links() }}
                        </div>
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

    <!-- 🛤️ Live Logistic Timeline Modal -->
    <div id="timelineModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-50 flex items-center justify-center hidden p-4">
        <div class="glass-panel rounded-[2.5rem] p-6 sm:p-8 max-w-md w-full text-right space-y-5 shadow-2xl border border-blue-500/30">
            <div class="flex justify-between items-center border-b border-slate-200 dark:border-white/10 pb-3">
                <div>
                    <h3 class="font-black text-slate-900 dark:text-white text-base">🛤️ مسار الشحن والتتبع اللوجستي المباشر</h3>
                    <span id="tl_tracking" class="font-mono text-brand-500 font-black text-xs block mt-0.5">COD-XXXXXXXX</span>
                </div>
                <button type="button" onclick="document.getElementById('timelineModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-700 dark:hover:text-white font-bold text-xl">✕</button>
            </div>

            <!-- Steps Progress -->
            <div class="space-y-4 text-xs font-bold relative pr-6 before:content-[''] before:absolute before:right-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200 dark:before:bg-slate-700">
                <div class="relative flex items-start gap-3">
                    <span class="absolute -right-6 top-0.5 w-4 h-4 rounded-full bg-emerald-500 border-2 border-white dark:border-slate-900 flex items-center justify-center text-[9px] text-white">✓</span>
                    <div>
                        <div class="text-slate-900 dark:text-white">تم تسجيل الطلب من الموقع بنجاح</div>
                        <span id="tl_time" class="text-[10px] text-slate-400 block font-normal">2026-08-15 07:25</span>
                    </div>
                </div>

                <div class="relative flex items-start gap-3">
                    <span id="tl_step2_icon" class="absolute -right-6 top-0.5 w-4 h-4 rounded-full bg-slate-300 dark:bg-slate-700 border-2 border-white dark:border-slate-900 flex items-center justify-center text-[9px] text-white">2</span>
                    <div>
                        <div class="text-slate-900 dark:text-white">تأكيد معلومات العنوان وتجهيز الطرد</div>
                        <span class="text-[10px] text-slate-400 block font-normal">مستودع التوزيع الرئيسي</span>
                    </div>
                </div>

                <div class="relative flex items-start gap-3">
                    <span id="tl_step3_icon" class="absolute -right-6 top-0.5 w-4 h-4 rounded-full bg-slate-300 dark:bg-slate-700 border-2 border-white dark:border-slate-900 flex items-center justify-center text-[9px] text-white">3</span>
                    <div>
                        <div class="text-slate-900 dark:text-white">الطرد في طريق التوصيل مع موزع المدينة</div>
                        <span id="tl_city" class="text-[10px] text-brand-400 block font-normal">الدار البيضاء</span>
                    </div>
                </div>

                <div class="relative flex items-start gap-3">
                    <span id="tl_step4_icon" class="absolute -right-6 top-0.5 w-4 h-4 rounded-full bg-slate-300 dark:bg-slate-700 border-2 border-white dark:border-slate-900 flex items-center justify-center text-[9px] text-white">4</span>
                    <div>
                        <div class="text-slate-900 dark:text-white">تم التسليم وقبض المبلغ نقداً (COD)</div>
                        <span class="text-[10px] text-slate-400 block font-normal">المرحلة النهائية</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 📊 Advanced Profit Calculator Modal -->
    <div id="profitModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-50 flex items-center justify-center hidden p-4">
        <div class="glass-panel rounded-[2.5rem] p-6 sm:p-8 max-w-lg w-full text-right space-y-5 shadow-2xl border border-blue-500/30 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center border-b border-slate-200 dark:border-white/10 pb-3">
                <div>
                    <h3 class="font-black text-slate-900 dark:text-white text-base">📊 حاسبة الأرباح الصافية (COD Profit & Margin Calculator)</h3>
                    <p class="text-[11px] text-slate-400 font-normal">احسب أرباحك الحقيقية بالدرهم المغربي بعد احتساب الإعلانات والروتور</p>
                </div>
                <button type="button" onclick="document.getElementById('profitModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-700 dark:hover:text-white font-bold text-xl">✕</button>
            </div>

            <div class="space-y-3.5 text-xs font-bold">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1">ثمن بيع المنتج (Prix de vente DH):</label>
                        <input type="number" id="calc_selling_price" value="299" oninput="calculateNetProfit()" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl p-2.5 text-xs font-bold text-slate-900 dark:text-white outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1">ثمن شراء السلعة (Prix d'achat DH):</label>
                        <input type="number" id="calc_cost_price" value="80" oninput="calculateNetProfit()" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl p-2.5 text-xs font-bold text-slate-900 dark:text-white outline-none focus:border-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1">تكلفة الإشهار لكل مبيعة (CPA Ads DH):</label>
                        <input type="number" id="calc_ads_cpa" value="45" oninput="calculateNetProfit()" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl p-2.5 text-xs font-bold text-slate-900 dark:text-white outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1">تكلفة التوصيل (Frais Livraison DH):</label>
                        <input type="number" id="calc_shipping_fee" value="35" oninput="calculateNetProfit()" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl p-2.5 text-xs font-bold text-slate-900 dark:text-white outline-none focus:border-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1">نسبة التوصيل المتوقعة (Taux Livraison %):</label>
                        <input type="number" id="calc_delivery_rate" value="80" max="100" min="1" oninput="calculateNetProfit()" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl p-2.5 text-xs font-bold text-slate-900 dark:text-white outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1">تكلفة الروتور (Frais Retour DH):</label>
                        <input type="number" id="calc_return_fee" value="15" oninput="calculateNetProfit()" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl p-2.5 text-xs font-bold text-slate-900 dark:text-white outline-none focus:border-blue-500">
                    </div>
                </div>

                <div class="bg-gradient-to-br from-slate-900 to-slate-950 p-4 rounded-2xl border border-blue-500/30 text-white space-y-2 mt-4 shadow-inner">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-300">الربح الصافي الصافي لكل حبة مسلمة:</span>
                        <span id="res_net_profit" class="text-xl font-black text-emerald-400 font-en">0.00 DH</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-300">هامش الربح الصافي (Marge Nette %):</span>
                        <span id="res_margin" class="font-black text-blue-400 font-en">0%</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-300">أرباح 100 طلبية مؤكدة:</span>
                        <span id="res_bulk_profit" class="font-black text-amber-400 font-en">0.00 DH</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ➕ Quick Manual Phone Order Modal -->
    <div id="quickOrderModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-50 flex items-center justify-center hidden p-4">
        <div class="glass-panel rounded-[2.5rem] p-6 sm:p-8 max-w-lg w-full text-right space-y-4 shadow-2xl border border-slate-200 dark:border-white/10 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center border-b border-slate-200 dark:border-white/10 pb-3">
                <h3 class="font-black text-slate-900 dark:text-white text-base">➕ تسجيل طلبية هاتفية جديدة سريعة</h3>
                <button type="button" onclick="document.getElementById('quickOrderModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-700 dark:hover:text-white font-bold text-xl">✕</button>
            </div>
            
            <form action="{{ route('admin.orders.quickCreate') }}" method="POST" class="space-y-4 text-xs font-bold">
                @csrf
                <div>
                    <label class="block text-slate-700 dark:text-slate-300 mb-1.5">اختر المنتج والنوع المتوفر في المخزون:</label>
                    <select name="variant_id" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl p-3 text-xs font-bold text-slate-900 dark:text-white outline-none focus:border-brand-500">
                        @if(isset($variants))
                            @foreach($variants as $variant)
                                <option value="{{ $variant->id }}">
                                    {{ $variant->product->name }} 
                                    {{ $variant->size ? '- مقاس: ' . $variant->size : '' }}
                                    {{ $variant->color ? '- لون: ' . $variant->color : '' }}
                                    ({{ $variant->product->base_price + $variant->additional_price }} DH) - [متوفر: {{ $variant->stock_quantity }}]
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1.5">الكمية المطلوبة:</label>
                        <input type="number" name="quantity" value="1" min="1" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl p-3 text-xs text-slate-900 dark:text-white outline-none focus:border-brand-500">
                    </div>
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1.5">الحالة المبدئية:</label>
                        <select name="status" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl p-3 text-xs font-bold text-slate-900 dark:text-white outline-none focus:border-brand-500">
                            <option value="confirme">مؤكدة مباشرة (Confirmé)</option>
                            <option value="nouveau">جديدة للتأكيد لاحقاً (Nouveau)</option>
                            <option value="en_livraison">جاهزة للتوصيل (En livraison)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-slate-700 dark:text-slate-300 mb-1.5">اسم ونسب الزبون الكامل:</label>
                    <input type="text" name="customer_name" placeholder="مثال: يونس العلوي" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl p-3 text-xs text-slate-900 dark:text-white outline-none focus:border-brand-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1.5">رقم الهاتف (الواتساب):</label>
                        <input type="tel" name="customer_phone" placeholder="06XXXXXXXX" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl p-3 text-xs text-slate-900 dark:text-white outline-none focus:border-brand-500 text-left" dir="ltr">
                    </div>
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1.5">المدينة:</label>
                        <input type="text" name="city" placeholder="الدار البيضاء، فاس، أزرو..." required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl p-3 text-xs text-slate-900 dark:text-white outline-none focus:border-brand-500">
                    </div>
                </div>

                <div>
                    <label class="block text-slate-700 dark:text-slate-300 mb-1.5">العنوان بالتفصيل:</label>
                    <textarea name="address" rows="2" placeholder="الحي، الإقامة، رقم الباب..." required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl p-3 text-xs text-slate-900 dark:text-white outline-none focus:border-brand-500"></textarea>
                </div>

                <button type="submit" class="w-full glow-btn text-slate-950 font-black py-4 rounded-xl text-xs transition active:scale-95 shadow-md flex items-center justify-center gap-2">
                    <span>حفظ وإنشاء الطلبية فوراً 🚀</span>
                </button>
            </form>
        </div>
    </div>

    <!-- 🛑 Blacklist Quick Modal -->
    <div id="blacklistModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-50 flex items-center justify-center hidden p-4">
        <div class="glass-panel rounded-[2.5rem] p-6 sm:p-8 max-w-md w-full text-right space-y-4 shadow-2xl border border-red-500/30">
            <div class="flex justify-between items-center border-b border-slate-200 dark:border-white/10 pb-3">
                <h3 class="font-black text-red-500 text-base">🛑 حظر رقم الزبون من الطلب</h3>
                <button type="button" onclick="document.getElementById('blacklistModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-700 dark:hover:text-white font-bold text-xl">✕</button>
            </div>
            
            <p class="text-xs text-slate-500 dark:text-slate-400">سيتم منع هذا الرقم نهائياً من تقديم أي طلبيات مستقبلية في الموقع لحماية المتجر من الروتور والنقر الوهمي.</p>

            <form action="{{ route('admin.blacklist.add') }}" method="POST" class="space-y-4 text-xs font-bold">
                @csrf
                <div>
                    <label class="block text-slate-700 dark:text-slate-300 mb-1.5">رقم الهاتف المحظور:</label>
                    <input type="text" id="bl_phone" name="phone" readonly class="w-full bg-slate-100 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl p-3 text-xs font-mono font-bold text-red-500 outline-none text-left" dir="ltr">
                </div>

                <div>
                    <label class="block text-slate-700 dark:text-slate-300 mb-1.5">سبب الحظر (ملاحظة داخلية):</label>
                    <input type="text" name="reason" value="زبون غير جاد / روتور متكرر" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl p-3 text-xs text-slate-900 dark:text-white outline-none focus:border-red-500">
                </div>

                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-3.5 rounded-xl text-xs transition active:scale-95 shadow flex items-center justify-center gap-2">
                    <span>تأكيد الحظر الآن 🛑</span>
                </button>
            </form>
        </div>
    </div>

    <!-- 📥 Multi-Courier Export Modal -->
    <div id="exportModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-50 flex items-center justify-center hidden p-4">
        <div class="glass-panel rounded-[2.5rem] p-6 sm:p-8 max-w-md w-full text-right space-y-4 shadow-2xl border border-slate-200 dark:border-white/10">
            <div class="flex justify-between items-center border-b border-slate-200 dark:border-white/10 pb-3">
                <h3 class="font-black text-slate-900 dark:text-white text-base">تصدير ملف الشحن (Export Couriers)</h3>
                <button type="button" onclick="document.getElementById('exportModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-700 dark:hover:text-white font-bold text-xl">✕</button>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 font-normal">اختر شركة التوصيل لتحميل الملف بالأعمدة المتوافقة مع منصتهم مباشرة:</p>

            <div class="grid grid-cols-2 gap-3 pt-2">
                <a href="{{ route('admin.orders.export', ['company' => 'standard']) }}" class="glass-card hover:border-brand-500 p-4 rounded-2xl text-center transition block">
                    <span class="text-2xl block">📊</span>
                    <span class="font-black text-xs text-slate-900 dark:text-white block mt-1">Excel عادي شامل</span>
                </a>
                <a href="{{ route('admin.orders.export', ['company' => 'cathedis']) }}" class="glass-card hover:border-brand-500 p-4 rounded-2xl text-center transition block">
                    <span class="text-2xl block">🚚</span>
                    <span class="font-black text-xs text-slate-900 dark:text-white block mt-1">Cathedis Express</span>
                </a>
                <a href="{{ route('admin.orders.export', ['company' => 'ameex']) }}" class="glass-card hover:border-brand-500 p-4 rounded-2xl text-center transition block">
                    <span class="text-2xl block">📦</span>
                    <span class="font-black text-xs text-slate-900 dark:text-white block mt-1">Ameex Logistique</span>
                </a>
                <a href="{{ route('admin.orders.export', ['company' => 'ozone']) }}" class="glass-card hover:border-brand-500 p-4 rounded-2xl text-center transition block">
                    <span class="text-2xl block">⚡</span>
                    <span class="font-black text-xs text-slate-900 dark:text-white block mt-1">Ozone Express</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Scripts: Kanban Drag & Drop, Timeline, Profit Calc, Dark/Light Mode -->
    <script>
        // 🗂️ View Switcher (Table vs Kanban)
        function switchView(mode) {
            const tableContainer = document.getElementById('tableViewContainer');
            const kanbanContainer = document.getElementById('kanbanViewContainer');
            const btnTable = document.getElementById('btnViewTable');
            const btnKanban = document.getElementById('btnViewKanban');

            if (mode === 'kanban') {
                tableContainer.classList.add('hidden');
                kanbanContainer.classList.remove('hidden');
                btnKanban.className = "px-3 py-1.5 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow transition";
                btnTable.className = "px-3 py-1.5 rounded-lg text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition";
            } else {
                kanbanContainer.classList.add('hidden');
                tableContainer.classList.remove('hidden');
                btnTable.className = "px-3 py-1.5 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow transition";
                btnKanban.className = "px-3 py-1.5 rounded-lg text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition";
            }
        }

        // 🗂️ Drag & Drop Functions for Kanban
        let draggedOrderId = null;

        function dragStart(e, orderId) {
            draggedOrderId = orderId;
            e.target.classList.add('dragging');
        }

        function dragEnd(e) {
            e.target.classList.remove('dragging');
        }

        function allowDrop(e) {
            e.preventDefault();
            e.currentTarget.classList.add('drag-over');
        }

        function dragLeave(e) {
            e.currentTarget.classList.remove('drag-over');
        }

        function dropOrder(e, newStatus) {
            e.preventDefault();
            e.currentTarget.classList.remove('drag-over');
            if (!draggedOrderId) return;

            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            fetch(`/admin/orders/${draggedOrderId}/ajax-status`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": token
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            })
            .catch(err => alert("حدث خطأ أثناء تحديث الحالة"));
        }

        // 🛤️ Timeline Modal Trigger
        function openTimelineModal(tracking, status, time, city) {
            document.getElementById('tl_tracking').innerText = tracking;
            document.getElementById('tl_time').innerText = time;
            document.getElementById('tl_city').innerText = city;

            const step2 = document.getElementById('tl_step2_icon');
            const step3 = document.getElementById('tl_step3_icon');
            const step4 = document.getElementById('tl_step4_icon');

            // Reset
            [step2, step3, step4].forEach(el => el.className = "absolute -right-6 top-0.5 w-4 h-4 rounded-full bg-slate-300 dark:bg-slate-700 border-2 border-white dark:border-slate-900 flex items-center justify-center text-[9px] text-white");

            if (status === 'confirme' || status === 'en_livraison' || status === 'livre') {
                step2.className = "absolute -right-6 top-0.5 w-4 h-4 rounded-full bg-blue-500 border-2 border-white dark:border-slate-900 flex items-center justify-center text-[9px] text-white";
                step2.innerText = "✓";
            }
            if (status === 'en_livraison' || status === 'livre') {
                step3.className = "absolute -right-6 top-0.5 w-4 h-4 rounded-full bg-purple-500 border-2 border-white dark:border-slate-900 flex items-center justify-center text-[9px] text-white";
                step3.innerText = "✓";
            }
            if (status === 'livre') {
                step4.className = "absolute -right-6 top-0.5 w-4 h-4 rounded-full bg-emerald-500 border-2 border-white dark:border-slate-900 flex items-center justify-center text-[9px] text-white";
                step4.innerText = "✓";
            }

            document.getElementById('timelineModal').classList.remove('hidden');
        }

        function calculateNetProfit() {
            const sellingPrice = parseFloat(document.getElementById('calc_selling_price').value) || 0;
            const costPrice = parseFloat(document.getElementById('calc_cost_price').value) || 0;
            const adsCpa = parseFloat(document.getElementById('calc_ads_cpa').value) || 0;
            const shippingFee = parseFloat(document.getElementById('calc_shipping_fee').value) || 0;
            const deliveryRate = (parseFloat(document.getElementById('calc_delivery_rate').value) || 80) / 100;
            const returnFee = parseFloat(document.getElementById('calc_return_fee').value) || 0;

            const returnRate = 1 - deliveryRate;
            const totalAdsSpentPerDelivery = adsCpa / (deliveryRate || 1);
            const totalReturnCostPerDelivery = (returnRate * returnFee) / (deliveryRate || 1);

            const netProfitPerDelivered = sellingPrice - costPrice - shippingFee - totalAdsSpentPerDelivery - totalReturnCostPerDelivery;
            const margin = sellingPrice > 0 ? ((netProfitPerDelivered / sellingPrice) * 100) : 0;
            const bulkProfit100 = netProfitPerDelivered * 100 * deliveryRate;

            const netProfitEl = document.getElementById('res_net_profit');
            netProfitEl.innerText = `${netProfitPerDelivered.toFixed(2)} DH`;
            if (netProfitPerDelivered >= 0) {
                netProfitEl.className = "text-xl font-black text-emerald-400 font-en";
            } else {
                netProfitEl.className = "text-xl font-black text-red-400 font-en";
            }

            document.getElementById('res_margin').innerText = `${margin.toFixed(1)}%`;
            document.getElementById('res_bulk_profit').innerText = `${bulkProfit100.toFixed(2)} DH`;
        }

        function openBlacklistModal(phone, name) {
            document.getElementById('bl_phone').value = phone;
            document.getElementById('blacklistModal').classList.remove('hidden');
        }

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

        document.getElementById('selectAll')?.addEventListener('change', function(e) {
            document.querySelectorAll('.order-checkbox').forEach(cb => cb.checked = e.target.checked);
        });

        function submitBulkPrint() {
            const selected = Array.from(document.querySelectorAll('.order-checkbox:checked')).map(cb => cb.value);
            if (selected.length === 0) {
                alert('المرجو تحديد طلبية واحدة على الأقل للطباعة الجماعية.');
                return;
            }
            document.getElementById('selectedOrderIds').value = selected.join(',');
            document.getElementById('bulkPrintForm').submit();
        }

        function updateClock() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('fr-FR', { timeZone: 'Africa/Casablanca' });
            const el = document.getElementById('moroccoClock');
            if (el) el.innerText = timeStr;
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>

</body>
</html>