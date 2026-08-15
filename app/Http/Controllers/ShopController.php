<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Blacklist;
use App\Models\Coupon;
use App\Models\Lead;
use App\Models\Review;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::with(['variants', 'category', 'reviews'])
            ->where('is_active', true)
            ->latest()
            ->get();

        return view('shop.index', compact('products'));
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'variants', 'reviews' => function($q) {
            $q->latest();
        }])
        ->where('slug', $slug)
        ->orWhere('slug', Str::slug($slug))
        ->orWhere('id', $slug)
        ->orWhere('name', urldecode($slug))
        ->firstOrFail();

        return view('shop.product', compact('product'));
    }

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

    public function saveLead(Request $request)
    {
        $phone = preg_replace('/[^0-9]/', '', $request->phone);
        if (strlen($phone) >= 9) {
            Lead::updateOrCreate(
                ['customer_phone' => $phone],
                [
                    'product_id'    => $request->product_id,
                    'customer_name' => $request->name ?? 'زبون مهتم',
                    'city'          => $request->city ?? 'غير محدد',
                ]
            );
            return response()->json(['status' => 'saved']);
        }
        return response()->json(['status' => 'ignored']);
    }

    public function storeOrder(Request $request)
    {
        $validated = $request->validate([
            'product_id'      => 'nullable',
            'variant_id'      => 'nullable',
            'quantity'        => 'nullable|integer|min:1',
            'bundle_option'   => 'nullable|integer|min:1',
            'customer_name'   => 'required|string|max:255',
            'customer_phone'  => 'required|string|max:30',
            'city'            => 'required|string|max:100',
            'address'         => 'required|string',
            'coupon_code'     => 'nullable|string',
            'payment_method'  => 'required|in:cod,card',
        ]);

        $cleanPhone = preg_replace('/[^0-9]/', '', $validated['customer_phone']);
        $isBlacklisted = Blacklist::where('phone', $cleanPhone)->exists();
        
        if ($isBlacklisted || in_array($cleanPhone, ['0600000000', '0700000000', '1234567890']) || strlen($cleanPhone) < 9) {
            return redirect()->back()->with('error', 'عذراً، تعذر إتمام الطلب. المرجو إدخال رقم هاتف صحيح وشغال لتأكيد التوصيل.')->withInput();
        }

        $qty = (int) ($request->bundle_option ?? $request->quantity ?? 1);
        $product = null;
        $variant = null;

        if ($request->filled('variant_id')) {
            $variant = ProductVariant::with('product')->find($request->variant_id);
            if ($variant) {
                $product = $variant->product;
            }
        }

        if (!$product && $request->filled('product_id')) {
            $product = Product::with('variants')->find($request->product_id);
        }

        if (!$product) {
            $product = Product::with('variants')->first();
        }

        if (!$product) {
            return redirect()->back()->with('error', 'المرجو اختيار المنتج لتأكيد الطلب.')->withInput();
        }

        if (!$variant) {
            $variant = $product->variants()->first();
            if (!$variant) {
                $variant = ProductVariant::create([
                    'product_id'       => $product->id,
                    'size'             => 'Standard',
                    'color'            => 'Default',
                    'additional_price' => 0,
                    'stock_quantity'   => 100,
                ]);
            }
        }

        $unitPrice = (float) $product->base_price;
        if ($variant && isset($variant->additional_price)) {
            $unitPrice += (float) $variant->additional_price;
        }

        $subtotal = $unitPrice * $qty;

        if ($qty == 2) {
            $subtotal = $subtotal * 0.85;
        } elseif ($qty >= 3) {
            $subtotal = $subtotal * 0.75;
        }

        $shipping = 0;
        if ($qty < 2) {
            $cityClean = mb_strtolower(trim($validated['city']));
            if (in_array($cityClean, ['casablanca', 'rabat', 'azrou', 'الدار البيضاء', 'الرباط', 'أزرو', 'ازرو'])) {
                $shipping = 0;
            } elseif (in_array($cityClean, ['fès', 'fes', 'meknès', 'meknes', 'فاس', 'مكناس'])) {
                $shipping = 15;
            } elseif (in_array($cityClean, ['marrakech', 'tanger', 'tangier', 'مراكش', 'طنجة'])) {
                $shipping = 20;
            } elseif (in_array($cityClean, ['laâyoune', 'layoune', 'العيون'])) {
                $shipping = 35;
            } else {
                $shipping = 25;
            }
        }

        $discount = 0;
        if (!empty($validated['coupon_code'])) {
            $coupon = Coupon::where('code', strtoupper(trim($validated['coupon_code'])))->where('is_active', true)->first();
            if ($coupon) {
                $discount = ($coupon->type === 'percent') ? ($subtotal * ($coupon->value / 100)) : (float) $coupon->value;
            }
        }

        $totalAmount = max(0, $subtotal + $shipping - $discount);
        $trackingNumber = 'COD-' . strtoupper(Str::random(8));

        $order = Order::create([
            'tracking_number' => $trackingNumber,
            'customer_name'   => $validated['customer_name'],
            'customer_phone'  => $validated['customer_phone'],
            'city'            => $validated['city'],
            'address'         => $validated['address'],
            'total_amount'    => $totalAmount,
            'status'          => 'nouveau',
            'payment_method'  => $validated['payment_method'],
            'payment_status'  => 'unpaid',
            'admin_notes'     => $discount > 0 ? "خصم كوبون: {$discount} DH" : null,
        ]);

        OrderItem::create([
            'order_id'           => $order->id,
            'product_variant_id' => $variant->id,
            'quantity'           => $qty,
            'unit_price'         => $unitPrice,
        ]);

        if ($variant->stock_quantity >= $qty) {
            $variant->decrement('stock_quantity', $qty);
        }

        Lead::where('customer_phone', $cleanPhone)->update(['is_recovered' => true]);

        // 💳 معالجة الدفع عبر YouCan Pay
        if ($validated['payment_method'] === 'card') {
            $privateKey = trim(env('YOUCAN_PRIVATE_KEY', ''));

            if (empty($privateKey)) {
                $order->items()->delete();
                $order->delete();
                return redirect()->back()->with('error', '⚠️ المفتاح YOUCAN_PRIVATE_KEY غير موجود في إعدادات Railway!')->withInput();
            }

            try {
                $endpoint = 'https://pay.youcan.shop/api/tokenize';

                $payload = [
                    'pri_key'     => $privateKey,
                    'amount'      => (int) round($totalAmount * 100),
                    'currency'    => 'MAD',
                    'order_id'    => $order->tracking_number,
                    'success_url' => route('youcan.callback', ['tracking' => $order->tracking_number]) . '?status=success',
                    'error_url'   => route('youcan.callback', ['tracking' => $order->tracking_number]) . '?status=failed',
                    'customer_ip' => $request->ip() ?? '127.0.0.1',
                    'customer'    => [
                        'name'         => $validated['customer_name'],
                        'address'      => $validated['address'],
                        'zip_code'     => '53000',
                        'city'         => $validated['city'],
                        'state'        => $validated['city'],
                        'country_code' => 'MA',
                        'phone'        => $validated['customer_phone'],
                        'email'        => 'customer_' . $order->id . '@medexpress.ma',
                    ],
                ];

                $response = Http::asJson()->acceptJson()->post($endpoint, $payload);
                $resData = $response->json();

                if ($response->successful() && isset($resData['token']['id'])) {
                    $token = $resData['token']['id'];
                    $isSandbox = str_contains($privateKey, 'sandbox') || env('YOUCAN_SANDBOX', true);
                    
                    $payUrl = $isSandbox 
                        ? "https://pay.youcan.shop/sandbox/payment-gateways/tokenize/{$token}"
                        : "https://pay.youcan.shop/payment-gateways/tokenize/{$token}";

                    return redirect()->away($payUrl);
                } else {
                    $order->items()->delete();
                    $order->delete();
                    $msg = $resData['message'] ?? $response->body();
                    return redirect()->back()->with('error', '❌ استجابة YouCan Pay: ' . $msg)->withInput();
                }
            } catch (\Exception $e) {
                $order->items()->delete();
                $order->delete();
                return redirect()->back()->with('error', '❌ خطأ تقني: ' . $e->getMessage())->withInput();
            }
        }

        $this->sendTelegramNotification($order, $product, $qty);
        return redirect()->route('order.success', $order->tracking_number);
    }

    public function youcanCallback(Request $request, $tracking)
    {
        $order = Order::with(['items.variant.product'])->where('tracking_number', $tracking)->firstOrFail();
        $status = $request->query('status');

        if ($status === 'failed' || $status !== 'success') {
            foreach ($order->items as $item) {
                $item->variant->increment('stock_quantity', $item->quantity);
            }
            $productSlug = $order->items->first()->variant->product->slug ?? '';
            $order->items()->delete();
            $order->delete();

            return redirect()->route('shop.product', $productSlug)->with('error', '❌ تم إلغاء أو رفض عملية الدفع بالبطاقة. تأكد من رصيدك أو اختر الدفع عند الاستلام.');
        }

        $order->update([
            'payment_status' => 'paid',
            'status'         => 'confirme',
            'admin_notes'    => ($order->admin_notes ? $order->admin_notes . ' | ' : '') . '✅ تم استلام الأداء بنجاح عبر YouCan Pay'
        ]);

        $firstItem = $order->items->first();
        $this->sendTelegramNotification($order, $firstItem->variant->product ?? null, $firstItem->quantity ?? 1);

        return redirect()->route('order.success', $order->tracking_number);
    }

    public function orderSuccess($tracking)
    {
        $order = Order::with(['items.variant.product'])->where('tracking_number', $tracking)->firstOrFail();
        
        $purchasedProductIds = $order->items->pluck('variant.product_id')->filter()->toArray();
        $upsellProduct = Product::with('variants')
            ->whereNotIn('id', $purchasedProductIds)
            ->where('is_active', true)
            ->first();

        return view('shop.success', compact('order', 'upsellProduct'));
    }

    public function addUpsell(Request $request, $tracking)
    {
        $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'variant_id' => 'nullable',
        ]);

        $order = Order::where('tracking_number', $tracking)->firstOrFail();
        $product = null;
        $variant = null;

        if ($request->filled('variant_id')) {
            $variant = ProductVariant::with('product')->find($request->variant_id);
            if ($variant) $product = $variant->product;
        }

        if (!$product && $request->filled('product_id')) {
            $product = Product::with('variants')->findOrFail($request->product_id);
            $variant = $product->variants()->first();
        }

        if (!$variant && $product) {
            $variant = ProductVariant::create([
                'product_id'       => $product->id,
                'size'             => 'Standard',
                'color'            => 'Default',
                'additional_price' => 0,
                'stock_quantity'   => 100,
            ]);
        }

        $upsellPrice = round($product->base_price * 0.8, 2);

        OrderItem::create([
            'order_id'           => $order->id,
            'product_variant_id' => $variant->id,
            'quantity'           => 1,
            'unit_price'         => $upsellPrice,
        ]);

        $order->increment('total_amount', $upsellPrice);

        return redirect()->route('order.success', $order->tracking_number)->with('upsell_added', 'تمت إضافة العرض الحصري إلى طلبيتك بنجاح وتحديث المبلغ الإجمالي!');
    }

    public function trackOrderPage()
    {
        return view('shop.track');
    }

    public function findOrder(Request $request)
    {
        $term = trim($request->input('search_term') ?? $request->input('search'));
        $cleanPhone = preg_replace('/[^0-9]/', '', $term);

        $order = Order::with(['items.variant.product'])
            ->where('tracking_number', $term)
            ->orWhere('customer_phone', 'like', "%{$cleanPhone}%")
            ->latest()
            ->first();

        if (!$order) {
            return redirect()->route('shop.track')->with('error', 'لم يتم العثور على أي طلبية مطابقة لهذا الرقم أو الكود. المرجو التأكد من صحة المدخلات.');
        }

        return view('shop.track', compact('order'));
    }

    public function quickWhatsappOrder(Request $request)
    {
        $product = null;
        $variant = null;

        if ($request->filled('variant_id')) {
            $variant = ProductVariant::with('product')->find($request->variant_id);
            if ($variant) $product = $variant->product;
        }

        if (!$product && $request->filled('product_id')) {
            $product = Product::with('variants')->find($request->product_id);
            if ($product) $variant = $product->variants()->first();
        }

        if (!$product) {
            $product = Product::with('variants')->first();
            if ($product) $variant = $product->variants()->first();
        }

        if ($product && !$variant) {
            $variant = ProductVariant::create([
                'product_id'       => $product->id,
                'size'             => 'Standard',
                'color'            => 'Default',
                'additional_price' => 0,
                'stock_quantity'   => 100,
            ]);
        }

        $prodName = $product ? $product->name : 'منتج من المتجر';
        $prodPrice = $product ? $product->base_price : '0';
        $tracking = 'COD-' . strtoupper(Str::random(8));

        $order = Order::create([
            'tracking_number' => $tracking,
            'customer_name'   => 'زبون واتساب (En attente)',
            'customer_phone'  => '0600000000',
            'city'            => $request->city ?? 'غير محدد',
            'address'         => 'طلب سريع عبر الواتساب',
            'total_amount'    => (float) $prodPrice,
            'status'          => 'nouveau',
            'payment_method'  => 'cod',
            'payment_status'  => 'unpaid',
            'admin_notes'     => 'تم إنشاؤه عبر زر الواتساب السريع',
        ]);

        if ($variant) {
            OrderItem::create([
                'order_id'           => $order->id,
                'product_variant_id' => $variant->id,
                'quantity'           => 1,
                'unit_price'         => (float) $prodPrice,
            ]);
        }

        $storeWhatsapp = "212773271042";
        $text = "السلام عليكم، بغيت نطلب هاد المنتج بشكل سريع:\n\n"
              . "🛍️ المنتج: " . $prodName . "\n"
              . "💵 الثمن: " . $prodPrice . " DH\n"
              . "📦 كود الطلب: " . $tracking . "\n\n"
              . "معلومات التوصيل ديالي:\n"
              . "- الاسم:\n"
              . "- المدينة والعنوان:";

        return redirect("https://wa.me/{$storeWhatsapp}?text=" . urlencode($text));
    }

    public function storeReview(Request $request, $productId)
    {
        $request->validate([
            'reviewer_name' => 'required|string|max:255',
            'reviewer_city' => 'nullable|string|max:255',
            'rating'        => 'required|integer|min:1|max:5',
            'comment'       => 'required|string',
        ]);

        Review::create([
            'product_id'    => $productId,
            'reviewer_name' => $request->reviewer_name,
            'reviewer_city' => $request->reviewer_city ?? 'المغرب',
            'rating'        => $request->rating,
            'comment'       => $request->comment,
            'is_approved'   => 1,
        ]);

        return redirect()->back()->with('review_success', 'شكراً لك! تم نشر تقييمك بنجاح.');
    }

    private function sendTelegramNotification($order, $product, $quantity)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        if (!$botToken || !$chatId) return;

        $productName = is_object($product) ? $product->name : 'منتج';
        $payMethod = $order->payment_method === 'card' ? '💳 بطاقة بنكية (YouCan Pay)' : '💵 الدفع عند الاستلام (COD)';

        $msg = "🚀 *طلبية جديدة في MED EXPRESS!* \n\n"
             . "📦 *كود التتبع:* `{$order->tracking_number}`\n"
             . "👤 *الزبون:* {$order->customer_name}\n"
             . "📞 *الهاتف:* `{$order->customer_phone}`\n"
             . "📍 *المدينة:* {$order->city}\n"
             . "🏠 *العنوان:* {$order->address}\n"
             . "🛍️ *المنتج:* {$productName} (x{$quantity})\n"
             . "💳 *طريقة الدفع:* {$payMethod}\n"
             . "💵 *المبلغ الإجمالي:* *{$order->total_amount} DH*\n\n"
             . "⚡ المرجو تأكيد الطلبية عبر لوحة التحكم.";

        @file_get_contents("https://api.telegram.org/bot{$botToken}/sendMessage?chat_id={$chatId}&text=" . urlencode($msg) . "&parse_mode=Markdown");
    }
}