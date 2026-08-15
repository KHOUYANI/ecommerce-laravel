<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ProductController;

// ==========================================
// 🖼️ Storage Image Direct Serving Route
// ==========================================
Route::get('/storage/products/{filename}', function ($filename) {
    $path = 'products/' . $filename;
    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }
    $file = Storage::disk('public')->get($path);
    $type = Storage::disk('public')->mimeType($path);

    return Response::make($file, 200)->header('Content-Type', $type);
});

// ==========================================
// 🛍️ Public Storefront, Checkout & APIs
// ==========================================
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{slug}', [ShopController::class, 'show'])->name('shop.product');
Route::post('/order/checkout', [ShopController::class, 'storeOrder'])->name('order.checkout');
Route::post('/order/whatsapp-quick', [ShopController::class, 'quickWhatsappOrder'])->name('order.whatsappQuick');
Route::post('/coupon/check', [ShopController::class, 'checkCoupon'])->name('coupon.check');
Route::post('/lead/save', [ShopController::class, 'saveLead'])->name('lead.save');
Route::post('/product/{productId}/review', [ShopController::class, 'storeReview'])->name('product.review');
Route::get('/order/success/{tracking}', [ShopController::class, 'orderSuccess'])->name('order.success');
Route::post('/order/{tracking}/upsell', [ShopController::class, 'addUpsell'])->name('order.upsell');
Route::get('/track', [ShopController::class, 'trackOrderPage'])->name('shop.track');
Route::post('/track', [ShopController::class, 'findOrder'])->name('shop.findOrder');

// ==========================================
// 🔐 Admin Authentication Routes
// ==========================================
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ==========================================
// 📦 Protected Admin Dashboard
// ==========================================
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    
    // Orders Operations
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/quick-create', [AdminOrderController::class, 'quickCreateOrder'])->name('orders.quickCreate');
    Route::post('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('/orders/{id}/ajax-status', [AdminOrderController::class, 'ajaxUpdateStatus'])->name('orders.ajaxStatus');
    Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/orders/{id}/print', [AdminOrderController::class, 'printLabel'])->name('orders.print');
    Route::post('/orders/bulk-print', [AdminOrderController::class, 'bulkPrint'])->name('orders.bulkPrint');
    Route::get('/leads', [AdminOrderController::class, 'leadsIndex'])->name('leads.index');
    Route::post('/blacklist/add', [AdminOrderController::class, 'addToBlacklist'])->name('blacklist.add');

    // Products Management
    Route::post('/categories/quick-store', [ProductController::class, 'storeCategory'])->name('categories.quickStore');
    Route::resource('products', ProductController::class);
    Route::post('/products/{id}/toggle', [AdminOrderController::class, 'toggleProduct'])->name('products.toggle');

    // Admin Privileges
    Route::get('/orders/export', [AdminOrderController::class, 'exportCsv'])->name('orders.export');
    Route::get('/settings', [AdminOrderController::class, 'settingsPage'])->name('settings');
    Route::post('/settings', [AdminOrderController::class, 'saveSettings'])->name('settings.save');
    Route::post('/coupons', [AdminOrderController::class, 'storeCoupon'])->name('coupons.store');
});