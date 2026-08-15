<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>طباعة الشحن الجماعية - MED EXPRESS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Tajawal', sans-serif; }
        @media print {
            .no-print { display: none; }
            body { background: white; padding: 0; }
            .page-break { page-break-after: always; }
        }
    </style>
</head>
<body class="bg-slate-100 p-6 flex flex-col items-center">

    <div class="no-print mb-6 flex gap-3">
        <button onclick="window.print()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-3 rounded-xl shadow-lg transition text-sm flex items-center gap-2">
            <span>🖨️ طباعة جميع البوليصات المحددة ({{ count($orders) }})</span>
        </button>
        <button onclick="window.close()" class="bg-slate-800 text-white font-bold px-4 py-3 rounded-xl text-sm">
            إغلاق
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl w-full">
        @foreach($orders as $order)
            <div class="bg-white border-2 border-dashed border-slate-400 p-5 rounded-2xl shadow-sm text-xs space-y-3">
                <div class="flex justify-between items-center border-b pb-2">
                    <div>
                        <h1 class="text-sm font-black text-slate-900">MED EXPRESS STORE 🇲🇦</h1>
                        <p class="text-[9px] text-slate-400 font-bold">بوليصة توصيل COD</p>
                    </div>
                    <div class="text-right">
                        <span class="font-mono font-black text-xs text-emerald-600 block">{{ $order->tracking_number }}</span>
                        <span class="text-[9px] text-slate-400">{{ $order->created_at->format('Y-m-d H:i') }}</span>
                    </div>
                </div>

                <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-200 space-y-0.5">
                    <div class="font-bold text-slate-900">{{ $order->customer_name }}</div>
                    <div class="font-mono text-slate-700 text-[11px]" dir="ltr">{{ $order->customer_phone }}</div>
                    <div class="font-bold text-emerald-700">📍 {{ $order->city }}</div>
                    <div class="text-slate-600 text-[10px]">{{ $order->address }}</div>
                </div>

                <div class="border-t pt-1.5">
                    @foreach($order->items as $item)
                        <div class="flex justify-between text-[11px] font-semibold text-slate-700">
                            <span>• {{ $item->variant->product->name ?? 'Produit' }} (x{{ $item->quantity }})</span>
                            <span>{{ $item->unit_price * $item->quantity }} DH</span>
                        </div>
                    @endforeach
                </div>

                <div class="bg-slate-900 text-white p-2 rounded-xl flex justify-between items-center">
                    <span class="font-bold text-[11px]">المبلغ للتحصيل:</span>
                    <span class="text-base font-black text-emerald-400">{{ $order->total_amount }} DH</span>
                </div>
            </div>
        @endforeach
    </div>

</body>
</html>