<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الدفع الآمن بالبطاقة البنكية | MED EXPRESS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@500;700;900&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <script src="https://youcanpay.com/js/ycpay.js"></script>
    <style>
        body { font-family: 'Tajawal', sans-serif; }
        .font-en { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border border-slate-200 p-6 sm:p-8 space-y-6">
        
        <div class="text-center space-y-2">
            <span class="font-black text-slate-900 text-xl tracking-wide">MED <span class="text-emerald-600">EXPRESS</span></span>
            <h1 class="text-lg font-black text-slate-800">الدفع الآمن بالبطاقة البنكية 🔒</h1>
            <p class="text-xs text-slate-500">المرجو إدخال معلومات البطاقة لإتمام طلبك</p>
        </div>

        <div class="bg-slate-50 border border-slate-200 p-4 rounded-2xl flex justify-between items-center text-xs font-bold">
            <span class="text-slate-600">المبلغ المطلوب للدفع:</span>
            <span class="text-emerald-600 text-base font-black font-en">{{ number_format($order->total_amount, 2) }} DH</span>
        </div>

        <!-- نافذة إدخال بيانات البطاقة الخاصة بـ YouCan Pay -->
        <div id="payment-container" class="min-h-[220px]"></div>

        <div id="pay-error-box" class="hidden bg-red-50 text-red-600 border border-red-200 text-xs font-bold p-3 rounded-xl text-center"></div>

        <button type="button" id="pay-btn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-blue-600/30 transition text-sm flex items-center justify-center gap-2">
            <span>تأكيد وأداء المبلغ الآن 💳</span>
        </button>

        <p class="text-[10px] text-center text-slate-400">جميع المعاملات مشفرة ومؤمنة 100% عبر YouCan Pay</p>
    </div>

    <script>
        const pubKey = "{{ env('YOUCAN_PUBLIC_KEY') }}";
        const isSandboxMode = {{ str_contains(env('YOUCAN_PRIVATE_KEY', ''), 'sandbox') ? 'true' : 'false' }};
        const token = "{{ $token }}";
        const successUrl = "{{ route('youcan.callback', ['tracking' => $order->tracking_number]) }}?status=success";

        const ycPay = new YCPay(pubKey, {
            formContainer: '#payment-container',
            locale: 'ar',
            isSandbox: isSandboxMode
        });

        ycPay.renderCreditCardForm();

        document.getElementById('pay-btn').addEventListener('click', function () {
            const btn = this;
            const errBox = document.getElementById('pay-error-box');
            errBox.classList.add('hidden');
            
            btn.disabled = true;
            btn.innerText = "جاري معالجة الأداء...";

            ycPay.pay(token)
                .then((res) => {
                    window.location.href = successUrl;
                })
                .catch((err) => {
                    btn.disabled = false;
                    btn.innerText = "تأكيد وأداء المبلغ الآن 💳";
                    errBox.classList.remove('hidden');
                    errBox.innerText = err.message || "❌ فشلت عملية الأداء. تأكد من صحة بيانات البطاقة ورصيدك.";
                });
        });
    </script>
</body>
</html>