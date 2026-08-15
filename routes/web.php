<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminAuthController;

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
Route::prefix('admin')->middleware('auth')->group(function () {
    
    // Shared between Admin & Confirmation Team
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::post('/orders/quick-create', [AdminOrderController::class, 'quickCreateOrder'])->name('admin.orders.quickCreate');
    Route::post('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::post('/orders/{id}/ajax-status', [AdminOrderController::class, 'ajaxUpdateStatus'])->name('admin.orders.ajaxStatus');
    Route::get('/orders/{id}/print', [AdminOrderController::class, 'printLabel'])->name('admin.orders.print');
    Route::post('/orders/bulk-print', [AdminOrderController::class, 'bulkPrint'])->name('admin.orders.bulkPrint');
    Route::get('/leads', [AdminOrderController::class, 'leadsIndex'])->name('admin.leads.index');
    Route::post('/blacklist/add', [AdminOrderController::class, 'addToBlacklist'])->name('admin.blacklist.add');

    // Admin-Only Privileges (Settings, Products, Exports)
    Route::middleware('role:admin')->group(function () {
        Route::get('/orders/export', [AdminOrderController::class, 'exportCsv'])->name('admin.orders.export');
        Route::get('/products', [AdminOrderController::class, 'productsList'])->name('admin.products.list');
        Route::get('/products/create', [AdminOrderController::class, 'createProduct'])->name('admin.products.create');
        Route::post('/products/store', [AdminOrderController::class, 'storeProduct'])->name('admin.products.store');
        Route::post('/products/{id}/toggle', [AdminOrderController::class, 'toggleProduct'])->name('admin.products.toggle');
        
        // Marketing, Pixels & Coupons
        Route::get('/settings', [AdminOrderController::class, 'settingsPage'])->name('admin.settings');
        Route::post('/settings', [AdminOrderController::class, 'saveSettings'])->name('admin.settings.save');
        Route::post('/coupons', [AdminOrderController::class, 'storeCoupon'])->name('admin.coupons.store');
    });
});