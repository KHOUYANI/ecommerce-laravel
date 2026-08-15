<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Blacklist;
use App\Models\Coupon;
use App\Models\Lead;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // Page d'accueil / Boutique
    public function index()
    {
        $products = Product::with(['variants', 'category'])
            ->where('is_active', true)
            ->latest()
            ->get();

        return view('shop.index', compact('products'));
    }

    // Page de Détail Produit (Landing Page COD)
    public function show($slug)
    {
        // كيبحث بالـ slug أو بـ id أو بـ اسم المنتج لتفادي أي 404
        $product = Product::with(['category', 'variants'])
            ->where('slug', $slug)
            ->orWhere('slug', Str::slug($slug))
            ->orWhere('id', $slug)
            ->orWhere('name', urldecode($slug))
            ->firstOrFail();

        return view('shop.product', compact('product'));
    }

    // API للتحقق من الكوبون بـ Ajax
    public function checkCoupon(Request $request)
    {
        $coupon = Coupon::where('code', strtoupper(trim($request->code)))
            ->where('is_active', true)
            ->first();

        if (!$coupon) {
            return response()->json(['valid' => false, 'message' => 'رمز الكوبون غير صحيح أو منتهي الصلاحية.'], 422);
        }

        return response()->json([
            'valid' => true,
            'type'  => $coupon->type,
            'value' => $coupon->value,
            'code'  => $coupon->code,
        ]);
    }

    // التقاط السلات المتروكة بالخلفية بدون إزعاج الزبون
    public function saveLead(Request $request)
    {
        $phone = preg_replace('/[^0-9]/', '', $request->phone);
        if (strlen($phone) >= 9) {
            Lead::updateOrCreate(
                ['customer_phone' => $phone],
                [
                    'product_id'    => $request->product_id,
                    'customer_name' => $request->name,
                    'city'          => $request->city,
                ]
            );
            return response()->json(['status' => 'saved']);
        }
        return response()->json(['status' => 'ignored']);
    }

    public function storeOrder(Request $request)
    {
        $validated = $request->validate([
            'variant_id'      => 'required|exists:product_variants,id',
            'quantity'        => 'required|integer|min:1',
            'customer_name'   => 'required|string|max:255',
            'customer_phone'  => 'required|string|max:20',
            'city'            => 'required|string|max:100',
            'address'         => 'required|string',
            'coupon_code'     => 'nullable|string',
        ]);

        // 🛑 1. فحص الهاتف في القائمة السوداء والنوامر الوهمية
        $cleanPhone = preg_replace('/[^0-9]/', '', $validated['customer_phone']);
        $isBlacklisted = Blacklist::where('phone', $cleanPhone)->exists();
        
        if ($isBlacklisted || in_array($cleanPhone, ['0600000000', '0700000000', '1234567890']) || strlen($cleanPhone) < 10) {
            return redirect()->back()->with('error', 'عذراً، تعذر إتمام الطلب. المرجو إدخال رقم هاتف صحيح وشغال لتأكيد التوصيل.');
        }

        $variant = ProductVariant::with('product')->findOrFail($validated['variant_id']);

        if ($variant->stock_quantity < $validated['quantity']) {
            return redirect()->back()->with('error', 'عذراً، الكمية المتوفرة في المخزون غير كافية.');
        }

        $unitPrice = $variant->product->base_price + $variant->additional_price;
        $subtotal = $unitPrice * $validated['quantity'];
        $discount = 0;

        if (!empty($validated['coupon_code'])) {
            $coupon = Coupon::where('code', strtoupper(trim($validated['coupon_code'])))->where('is_active', true)->first();
            if ($coupon) {
                $discount = ($coupon->type === 'percent') ? ($subtotal * ($coupon->value / 100)) : $coupon->value;
            }
        }

        $totalAmount = max(0, $subtotal - $discount);

        $order = Order::create([
            'tracking_number' => 'COD-' . strtoupper(Str::random(8)),
            'customer_name'   => $validated['customer_name'],
            'customer_phone'  => $validated['customer_phone'],
            'city'            => $validated['city'],
            'address'         => $validated['address'],
            'total_amount'    => $totalAmount,
            'status'          => 'nouveau',
            'admin_notes'     => $discount > 0 ? "خصم كوبون: {$discount} DH" : null,
        ]);

        OrderItem::create([
            'order_id'           => $order->id,
            'product_variant_id' => $variant->id,
            'quantity'           => $validated['quantity'],
            'unit_price'         => $unitPrice,
        ]);

        $variant->decrement('stock_quantity', $validated['quantity']);

        // تحديث حالة السلة المتروكة إن وجدت بأنها تمت
        Lead::where('customer_phone', $cleanPhone)->update(['is_recovered' => true]);

        // 🔔 إشعار فوري تيليغرام
        $this->sendTelegramNotification($order, $variant, $validated['quantity']);

        return redirect()->route('order.success', $order->tracking_number);
    }

    // Page de Confirmation / Thank You Page
    public function orderSuccess($tracking)
    {
        $order = Order::with('items.variant.product')->where('tracking_number', $tracking)->firstOrFail();
        
        // جلب منتج مقترح للـ Upsell (غير المنتج الذي اشتراه)
        $purchasedProductIds = $order->items->pluck('variant.product_id')->toArray();
        $upsellProduct = Product::with('variants')
            ->whereNotIn('id', $purchasedProductIds)
            ->where('is_active', true)
            ->first();

        return view('shop.success', compact('order', 'upsellProduct'));
    }

    // إضافة منتج الـ Upsell للطلبية مباشرة
    public function addUpsell(Request $request, $tracking)
    {
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
        ]);

        $order = Order::where('tracking_number', $tracking)->firstOrFail();
        $variant = ProductVariant::with('product')->findOrFail($request->variant_id);

        // خصم 40% على منتج الـ Upsell
        $discountedPrice = round(($variant->product->base_price + $variant->additional_price) * 0.6, 2);

        OrderItem::create([
            'order_id'           => $order->id,
            'product_variant_id' => $variant->id,
            'quantity'           => 1,
            'unit_price'         => $discountedPrice,
        ]);

        $order->increment('total_amount', $discountedPrice);

        return redirect()->route('order.success', $order->tracking_number)->with('upsell_added', 'تمت إضافة العرض الحصري إلى طلبيتك بنجاح وتحديث المبلغ الإجمالي!');
    }

    // صفحة التتبع العامة
    public function trackOrderPage()
    {
        return view('shop.track');
    }

    public function findOrder(Request $request)
    {
        $term = trim($request->input('search_term'));
        $cleanPhone = preg_replace('/[^0-9]/', '', $term);

        $order = \App\Models\Order::with('items.variant.product')
            ->where('tracking_number', $term)
            ->orWhere('customer_phone', 'like', "%{$cleanPhone}%")
            ->latest()
            ->first();

        if (!$order) {
            return redirect()->route('shop.track')->with('error', 'لم يتم العثور على أي طلبية مطابقة لهذا الرقم أو الكود. المرجو التأكد من صحة المدخلات.');
        }

        return view('shop.track', compact('order'));
    }

 

    // طلب مباشر وسريع بالواتساب مع تسجيله في النظام
    public function quickWhatsappOrder(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'city'       => 'nullable|string',
        ]);

        $variant = ProductVariant::with('product')->findOrFail($request->variant_id);
        $tracking = 'COD-' . strtoupper(Str::random(8));

        $order = Order::create([
            'tracking_number' => $tracking,
            'customer_name'   => 'زبون واتساب (En attente)',
            'customer_phone'  => '0600000000',
            'city'            => $request->city ?? 'غير محدد',
            'address'         => 'طلب سريع عبر الواتساب',
            'total_amount'    => $variant->product->base_price + $variant->additional_price,
            'status'          => 'nouveau',
            'admin_notes'     => 'تم إنشاؤه عبر زر الواتساب السريع',
        ]);

        OrderItem::create([
            'order_id'           => $order->id,
            'product_variant_id' => $variant->id,
            'quantity'           => 1,
            'unit_price'         => $variant->product->base_price + $variant->additional_price,
        ]);

        $storeWhatsapp = "212773271042"; // نمرتك د الواتساب
        $text = "السلام عليكم، بغيت نطلب هاد المنتج بشكل سريع:\n\n"
              . "🛍️ المنتج: " . $variant->product->name . "\n"
              . "💵 الثمن: " . ($variant->product->base_price + $variant->additional_price) . " DH\n"
              . "📦 كود الطلب: " . $tracking . "\n\n"
              . "ها هما معلوماتي:\n"
              . "- الاسم:\n"
              . "- الهاتف:\n"
              . "- المدينة والعنوان:";

        return redirect("https://wa.me/{$storeWhatsapp}?text=" . urlencode($text));
    }

    // 🔔 إرسال إشعار تيليغرام
    private function sendTelegramNotification($order, $variant, $quantity)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        if (!$botToken || !$chatId) return;

        $msg = "🚀 *طلبية جديدة في MED EXPRESS!* \n\n"
             . "📦 *كود التتبع:* `{$order->tracking_number}`\n"
             . "👤 *الزبون:* {$order->customer_name}\n"
             . "📞 *الهاتف:* `{$order->customer_phone}`\n"
             . "📍 *المدينة:* {$order->city}\n"
             . "🏠 *العنوان:* {$order->address}\n"
             . "🛍️ *المنتج:* {$variant->product->name} (x{$quantity})\n"
             . "💵 *المبلغ الإجمالي:* *{$order->total_amount} DH*\n\n"
             . "⚡ المرجو تأكيد الطلبية عبر لوحة التحكم.";

        @file_get_contents("https://api.telegram.org/bot{$botToken}/sendMessage?chat_id={$chatId}&text=" . urlencode($msg) . "&parse_mode=Markdown");
    }
    
}