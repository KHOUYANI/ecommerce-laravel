<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>وصل شحن - {{ $order->tracking_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Tajawal', sans-serif; }
        @media print {
            .no-print { display: none; }
            body { background: white; padding: 0; }
        }
    </style>
</head>
<body class="bg-slate-100 p-6 flex flex-col items-center justify-center min-h-screen">

    <div class="no-print mb-4 flex gap-3">
        <button onclick="window.print()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2.5 rounded-xl shadow transition text-sm">
            🖨️ طباعة الوصل (Print Label)
        </button>
        <button onclick="window.close()" class="bg-slate-800 text-white font-bold px-4 py-2.5 rounded-xl text-sm">
            إغلاق
        </button>
    </div>

    <!-- Ticket A6 Pro -->
    <div class="bg-white border-2 border-dashed border-slate-400 p-6 rounded-2xl w-full max-w-md shadow-md text-xs space-y-4">
        <div class="flex justify-between items-center border-b pb-3">
            <div>
                <h1 class="text-base font-black text-slate-900">MED EXPRESS STORE 🇲🇦</h1>
                <p class="text-[10px] text-slate-500 font-bold">بوليصة شحن وتوصيل (COD Voucher)</p>
            </div>
            <div class="text-right">
                <span class="font-mono font-black text-sm text-emerald-600 block">{{ $order->tracking_number }}</span>
                <span class="text-[10px] text-slate-400">{{ $order->created_at->format('Y-m-d H:i') }}</span>
            </div>
        </div>

        <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 space-y-1">
            <div class="font-bold text-slate-900 text-sm">{{ $order->customer_name }}</div>
            <div class="font-mono font-bold text-slate-700" dir="ltr">{{ $order->customer_phone }}</div>
            <div class="font-bold text-emerald-700">📍 المدينة: {{ $order->city }}</div>
            <div class="text-slate-600 text-[11px]">{{ $order->address }}</div>
        </div>

        <div class="border-t pt-2">
            <span class="font-bold text-slate-700 block mb-1">تفاصيل المحتوى:</span>
            @foreach($order->items as $item)
                <div class="flex justify-between font-semibold text-slate-800">
                    <span>• {{ $item->variant->product->name ?? 'Produit' }} (x{{ $item->quantity }})</span>
                    <span>{{ $item->unit_price * $item->quantity }} DH</span>
                </div>
            @endforeach
        </div>

        <div class="bg-slate-900 text-white p-3 rounded-xl flex justify-between items-center">
            <span class="font-bold text-xs">المبلغ الواجب تحصيله (COD):</span>
            <span class="text-lg font-black text-emerald-400">{{ $order->total_amount }} DH</span>
        </div>

        <div class="text-center text-[10px] text-slate-400 border-t pt-2">
            ملاحظة الموزع: يُرجى تسليم الطرد بعد استلام المبلغ نقدًا فقط.
        </div>
    </div>

</body>
</html>