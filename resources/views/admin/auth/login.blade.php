<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | لوحة التحكم MED EXPRESS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;600;800;900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Tajawal', sans-serif; }</style>
</head>
<body class="bg-slate-900 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white max-w-md w-full p-8 rounded-3xl shadow-2xl border border-slate-700">
        <div class="text-center mb-8">
            <div class="w-12 h-12 rounded-2xl bg-emerald-600 flex items-center justify-center text-white text-2xl font-black mx-auto mb-3 shadow-lg shadow-emerald-600/40">
                M
            </div>
            <h1 class="text-xl font-black text-slate-900">تسجيل الدخول للأدمن</h1>
            <p class="text-xs text-slate-400 font-bold mt-1">MED EXPRESS CONTROL PANEL</p>
        </div>

        @if($errors->any())
            <div class="mb-4 bg-red-50 text-red-600 border border-red-200 text-xs font-bold p-3 rounded-xl">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4 text-xs font-bold">
            @csrf

            <div>
                <label class="block text-slate-700 mb-1">البريد الإلكتروني:</label>
                <input type="email" name="email" value="{{ old('email', 'admin@codstore.ma') }}" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 outline-none text-left" dir="ltr">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">كلمة المرور:</label>
                <input type="password" name="password" placeholder="••••••••" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 outline-none text-left" dir="ltr">
            </div>

            <button type="submit" class="w-full bg-slate-900 hover:bg-emerald-600 text-white font-black py-3.5 rounded-xl shadow-lg transition duration-200 text-sm mt-2">
                دخول إلى لوحة التحكم 🔐
            </button>
        </form>

        <div class="mt-6 text-center text-[11px] text-slate-400">
            كلمة السر الافتراضية: <span class="font-mono text-emerald-600 font-bold">password</span>
        </div>
    </div>

</body>
</html>