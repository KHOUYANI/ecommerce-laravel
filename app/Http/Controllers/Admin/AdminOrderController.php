<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariant;
use App\Models\Lead;
use App\Models\Blacklist;
use App\Models\Coupon;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items.variant.product')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('tracking_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(10)->withQueryString();

        // 🛡️ حساب مؤشر الأمان والمخاطر لكل طلبية
        foreach ($orders as $order) {
            $order->risk_score = $this->calculateRiskScore($order);
        }

        // جلب جميع الطلبيات للوحة الكانبان التفاعلية
        $kanbanOrders = Order::with('items.variant.product')->latest()->get();

        $stats = [
            'total_orders'  => Order::count(),
            'new_orders'    => Order::where('status', 'nouveau')->count(),
            'delivered'     => Order::where('status', 'livre')->count(),
            'total_revenue' => Order::where('status', 'livre')->sum('total_amount'),
        ];

        // 📈 مبيعات آخر 7 أيام
        $salesLabels = [];
        $salesData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dayName = $date->locale('ar')->dayName;
            $salesLabels[] = $dayName;
            $salesData[] = Order::whereDate('created_at', $date->toDateString())
                ->where('status', '!=', 'annule')
                ->sum('total_amount');
        }

        // 🍩 توزيع الحالات
        $statusCounts = [
            Order::where('status', 'nouveau')->count(),
            Order::where('status', 'confirme')->count(),
            Order::where('status', 'en_livraison')->count(),
            Order::where('status', 'livre')->count(),
            Order::where('status', 'annule')->count(),
        ];

        $variants = ProductVariant::with('product')->where('stock_quantity', '>', 0)->get();

        return view('admin.orders.index', compact('orders', 'kanbanOrders', 'stats', 'salesLabels', 'salesData', 'statusCounts', 'variants'));
    }

    private function calculateRiskScore($order)
    {
        $score = 100;
        $cleanPhone = preg_replace('/[^0-9]/', '', $order->customer_phone);

        if (Blacklist::where('phone', $cleanPhone)->exists()) {
            return ['score' => 10, 'level' => 'danger', 'label' => 'محظور بقائمة سوداء 🚨', 'badge_bg' => 'bg-red-500/20 text-red-400 border-red-500/30'];
        }

        if (strlen($cleanPhone) != 10 || !in_array(substr($cleanPhone, 0, 2), ['06', '07', '05'])) {
            $score -= 35;
        }

        if (preg_match('/(.)\1{5,}/', $cleanPhone)) {
            $score -= 40;
        }

        if (strlen(trim($order->address)) < 8) {
            $score -= 25;
        }

        if (str_word_count($order->customer_name) < 2 && strlen($order->customer_name) < 6) {
            $score -= 15;
        }

        if ($score >= 80) {
            return ['score' => $score, 'level' => 'safe', 'label' => 'موثوقة وآمنة 🟢', 'badge_bg' => 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30'];
        } elseif ($score >= 50) {
            return ['score' => $score, 'level' => 'warning', 'label' => 'تتطلب تأكيد 🟡', 'badge_bg' => 'bg-amber-500/20 text-amber-400 border-amber-500/30'];
        } else {
            return ['score' => $score, 'level' => 'danger', 'label' => 'احتمال وهمية 🔴', 'badge_bg' => 'bg-red-500/20 text-red-400 border-red-500/30'];
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status'      => 'required|in:nouveau,confirme,en_livraison,livre,annule,retour',
            'admin_notes' => 'nullable|string',
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'status'      => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->back()->with('success', 'تم تحديث حالة الطلبية بنجاح!');
    }

    // 🗑️ دالة حذف الطلبية
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->items()->delete();
        $order->delete();

        return redirect()->back()->with('success', 'تم حذف الطلبية بنجاح نهائياً!');
    }

    // تحديث الحالة بالسحب والإفلات AJAX للكانبان
    public function ajaxUpdateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:nouveau,confirme,en_livraison,livre,annule,retour',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return response()->json(['success' => true, 'message' => 'تم نقل الطلبية وتحديث حالتها بنجاح']);
    }

    public function quickCreateOrder(Request $request)
    {
        $validated = $request->validate([
            'variant_id'     => 'required|exists:product_variants,id',
            'quantity'       => 'required|integer|min:1',
            'customer_name'  => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'city'           => 'required|string|max:100',
            'address'        => 'required|string',
            'status'         => 'required|in:nouveau,confirme,en_livraison',
        ]);

        $variant = ProductVariant::with('product')->findOrFail($validated['variant_id']);

        if ($variant->stock_quantity < $validated['quantity']) {
            return redirect()->back()->with('error', 'الكمية المطلوبة غير متوفرة في المخزون!');
        }

        $unitPrice = $variant->product->base_price + $variant->additional_price;
        $totalAmount = $unitPrice * $validated['quantity'];

        $order = Order::create([
            'tracking_number' => 'COD-' . strtoupper(Str::random(8)),
            'customer_name'   => $validated['customer_name'],
            'customer_phone'  => $validated['customer_phone'],
            'city'            => $validated['city'],
            'address'         => $validated['address'],
            'total_amount'    => $totalAmount,
            'status'          => $validated['status'],
            'admin_notes'     => 'تم إنشاؤه يدوياً من طرف الأدمن (طلبية هاتفية)',
        ]);

        \App\Models\OrderItem::create([
            'order_id'           => $order->id,
            'product_variant_id' => $variant->id,
            'quantity'           => $validated['quantity'],
            'unit_price'         => $unitPrice,
        ]);

        $variant->decrement('stock_quantity', $validated['quantity']);

        return redirect()->back()->with('success', 'تم تسجيل الطلبية الهاتفية وتحديث المخزون بنجاح!');
    }

    public function exportCsv(Request $request)
    {
        $company = $request->query('company', 'standard');
        $orders = Order::with('items.variant.product')->latest()->get();

        $filename = "orders_" . $company . "_" . date('Y-m-d_H-i') . ".csv";

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($orders, $company) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            if ($company === 'cathedis') {
                fputcsv($file, ['Reference', 'Destinataire', 'Telephone', 'Ville', 'Adresse', 'Montant CRBT', 'Marchandise', 'Commentaire']);
                foreach ($orders as $order) {
                    $itemsStr = $order->items->map(fn($i) => ($i->variant->product->name ?? 'Produit') . ' (x' . $i->quantity . ')')->implode(', ');
                    fputcsv($file, [$order->tracking_number, $order->customer_name, $order->customer_phone, $order->city, $order->address, $order->total_amount, $itemsStr, $order->admin_notes ?? '']);
                }
            } elseif ($company === 'ameex') {
                fputcsv($file, ['Code Suivi', 'Nom Client', 'Tel Client', 'Gouvernorat/Ville', 'Adresse Complete', 'COD (DH)', 'Designation Colis']);
                foreach ($orders as $order) {
                    $itemsStr = $order->items->map(fn($i) => ($i->variant->product->name ?? 'Produit') . ' (x' . $i->quantity . ')')->implode(', ');
                    fputcsv($file, [$order->tracking_number, $order->customer_name, $order->customer_phone, $order->city, $order->address, $order->total_amount, $itemsStr]);
                }
            } elseif ($company === 'ozone') {
                fputcsv($file, ['Ref', 'Client', 'Mobile', 'Destination', 'Adresse', 'Total A Encaisser', 'Contenu']);
                foreach ($orders as $order) {
                    $itemsStr = $order->items->map(fn($i) => ($i->variant->product->name ?? 'Produit') . ' (x' . $i->quantity . ')')->implode(', ');
                    fputcsv($file, [$order->tracking_number, $order->customer_name, $order->customer_phone, $order->city, $order->address, $order->total_amount, $itemsStr]);
                }
            } else {
                fputcsv($file, ['كود التتبع', 'اسم الزبون', 'الهاتف', 'المدينة', 'العنوان', 'المبلغ الإجمالي (DH)', 'الحالة', 'المنتجات المطلوبة', 'تاريخ الطلب']);
                foreach ($orders as $order) {
                    $itemsStr = $order->items->map(fn($i) => ($i->variant->product->name ?? 'Produit') . ' (x' . $i->quantity . ')')->implode(' | ');
                    fputcsv($file, [
                        $order->tracking_number,
                        $order->customer_name,
                        $order->customer_phone,
                        $order->city,
                        $order->address,
                        $order->total_amount,
                        $order->status,
                        $itemsStr,
                        $order->created_at->format('Y-m-d H:i')
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function printLabel($id)
    {
        $order = Order::with('items.variant.product')->findOrFail($id);
        return view('admin.orders.print', compact('order'));
    }

    public function bulkPrint(Request $request)
    {
        $orderIds = explode(',', $request->order_ids);
        $orders = Order::with('items.variant.product')->whereIn('id', $orderIds)->latest()->get();
        return view('admin.orders.bulk_print', compact('orders'));
    }

    public function leadsIndex()
    {
        $leads = Lead::with('product')->where('is_recovered', false)->latest()->paginate(15);
        return view('admin.leads.index', compact('leads'));
    }

    public function addToBlacklist(Request $request)
    {
        $cleanPhone = preg_replace('/[^0-9]/', '', $request->phone);
        Blacklist::updateOrCreate(
            ['phone' => $cleanPhone],
            ['reason' => $request->reason ?? 'تم حظره بسبب عدم الجدية / روتور متكرر']
        );

        return redirect()->back()->with('success', 'تمت إضافة الرقم إلى القائمة السوداء بنجاح ومنعه من الطلب!');
    }

    public function settingsPage()
    {
        $fbPixel = Setting::get('fb_pixel_id', '');
        $tiktokPixel = Setting::get('tiktok_pixel_id', '');
        $coupons = Coupon::latest()->get();

        return view('admin.settings.index', compact('fbPixel', 'tiktokPixel', 'coupons'));
    }

    public function saveSettings(Request $request)
    {
        Setting::set('fb_pixel_id', $request->fb_pixel_id);
        Setting::set('tiktok_pixel_id', $request->tiktok_pixel_id);

        return redirect()->back()->with('success', 'تم حفظ إعدادات التتبع والبيكسل بنجاح!');
    }

    public function storeCoupon(Request $request)
    {
        $request->validate([
            'code'  => 'required|string|unique:coupons,code',
            'type'  => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:1',
        ]);

        Coupon::create([
            'code'      => strtoupper(trim($request->code)),
            'type'      => $request->type,
            'value'     => $request->value,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'تم إنشاء كود الخصم الجديد بنجاح!');
    }

    public function productsList()
    {
        $products = Product::with(['category', 'variants'])->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'base_price'     => 'required|numeric|min:0',
            'description'    => 'nullable|string',
            'image'          => 'nullable|image|max:2048',
            'variants'       => 'required|array|min:1',
            'variants.*.sku' => 'required|string|distinct',
            'variants.*.stock_quantity' => 'required|integer|min:0',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name) . '-' . Str::random(5),
            'description' => $request->description,
            'base_price'  => $request->base_price,
            'image_url'   => $imagePath,
            'is_active'   => true,
        ]);

        foreach ($request->variants as $varData) {
            ProductVariant::create([
                'product_id'       => $product->id,
                'sku'              => $varData['sku'],
                'size'             => $varData['size'] ?? null,
                'color'            => $varData['color'] ?? null,
                'additional_price' => $varData['additional_price'] ?? 0,
                'stock_quantity'   => $varData['stock_quantity'] ?? 0,
            ]);
        }

        return redirect()->route('admin.products.list')->with('success', 'تمت إضافة المنتج والمخزون بنجاح!');
    }

    public function toggleProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['is_active' => !$product->is_active]);
        return redirect()->back()->with('success', 'تم تغيير حالة توفر المنتج بنجاح!');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ]);

        $category = \App\Models\Category::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . rand(100, 999),
        ]);

        return response()->json([
            'success' => true,
            'category' => $category
        ]);
    }
}