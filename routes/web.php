<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CorporateCustomerController;
use App\Http\Controllers\CorporateDistributorController;
use App\Http\Controllers\CorporateProductController;
use App\Http\Controllers\CorporateVendorController;
use App\Http\Controllers\CorporateWarehouseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistributorInvoiceController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\RequestOrderController;
use App\Http\Controllers\WaybillController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['id', 'en'])) {
        session()->put('locale', $locale);
        session()->save();
    }
    return redirect()->back();
})->name('lang.switch');

// Protected Web Views
Route::middleware(['bff.auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Corporate Master Data
    Route::get('/products', [CorporateProductController::class, 'index'])->name('products.index');
    Route::get('/product-categories', [CorporateProductController::class, 'categoriesIndex'])->name('product-categories.index');
    Route::get('/warehouses', [CorporateWarehouseController::class, 'index'])->name('warehouses.index');
    Route::get('/customers', [CorporateCustomerController::class, 'index'])->name('customers.index');
    Route::get('/vendors', [CorporateVendorController::class, 'index'])->name('vendors.index');
    Route::get('/distributors', [CorporateDistributorController::class, 'index'])->name('distributors.index');

    // Order Management & Request Order Wizard
    Route::get('/request-orders', [RequestOrderController::class, 'index'])->name('request-orders.index');
    Route::get('/request-orders/create', [RequestOrderController::class, 'create'])->name('request-orders.create');
    Route::get('/distributor-orders', [RequestOrderController::class, 'distributorOrdersIndex'])->name('distributor-orders.index');
    Route::get('/waybills', [WaybillController::class, 'index'])->name('waybills.index');
    Route::get('/waybills/{id}', [WaybillController::class, 'show'])->name('waybills.show');
    Route::get('/waybills/{id}/print', [WaybillController::class, 'print'])->name('waybills.print');

    // Inventory
    Route::get('/inventory/stocks', [InventoryController::class, 'stocks'])->name('inventory.stocks');
    Route::get('/inventory/item-ins', [InventoryController::class, 'itemIns'])->name('inventory.item-ins');
    Route::get('/inventory/item-outs', [InventoryController::class, 'itemOuts'])->name('inventory.item-outs');

    // Finance & Invoices
    Route::get('/finance/distributor-invoices', [DistributorInvoiceController::class, 'index'])->name('finance.distributor-invoices');
    Route::get('/finance/corporate-invoices', [DistributorInvoiceController::class, 'corporateInvoices'])->name('finance.corporate-invoices');

    // Internal API Proxies (BFF)
    Route::prefix('api/internal/corporate')->group(function () {
        // Dashboard Stats
        Route::get('/dashboard/summary', [DashboardController::class, 'proxyStats']);

        // Products & Taxonomy
        Route::get('/products', [CorporateProductController::class, 'proxyList']);
        Route::post('/products', [CorporateProductController::class, 'proxyStore']);
        Route::get('/products/{id}', [CorporateProductController::class, 'proxyShow']);
        Route::put('/products/{id}', [CorporateProductController::class, 'proxyUpdate']);
        Route::delete('/products/{id}', [CorporateProductController::class, 'proxyDestroy']);
        Route::get('/product-categories', [CorporateProductController::class, 'proxyCategories']);
        Route::post('/product-categories', [CorporateProductController::class, 'proxyStoreCategory']);
        Route::get('/uoms', [CorporateProductController::class, 'proxyUoms']);

        // Warehouses & Plants
        Route::get('/warehouses', [CorporateWarehouseController::class, 'proxyList']);
        Route::post('/warehouses', [CorporateWarehouseController::class, 'proxyStore']);
        Route::get('/warehouses/{id}', [CorporateWarehouseController::class, 'proxyShow']);
        Route::put('/warehouses/{id}', [CorporateWarehouseController::class, 'proxyUpdate']);
        Route::delete('/warehouses/{id}', [CorporateWarehouseController::class, 'proxyDestroy']);

        // Customers & Vendors
        Route::get('/customers', [CorporateCustomerController::class, 'proxyList']);
        Route::post('/customers', [CorporateCustomerController::class, 'proxyStore']);
        Route::get('/customers/{id}', [CorporateCustomerController::class, 'proxyShow']);
        Route::put('/customers/{id}', [CorporateCustomerController::class, 'proxyUpdate']);
        Route::delete('/customers/{id}', [CorporateCustomerController::class, 'proxyDestroy']);

        Route::get('/vendors', [CorporateVendorController::class, 'proxyList']);
        Route::post('/vendors', [CorporateVendorController::class, 'proxyStore']);
        Route::get('/vendors/{id}', [CorporateVendorController::class, 'proxyShow']);
        Route::put('/vendors/{id}', [CorporateVendorController::class, 'proxyUpdate']);
        Route::delete('/vendors/{id}', [CorporateVendorController::class, 'proxyDestroy']);

        Route::get('/distributors', [CorporateDistributorController::class, 'proxyList']);
        Route::post('/distributors', [CorporateDistributorController::class, 'proxyStore']);

        // Request Orders & Dynamic Pricing
        Route::get('/request-orders', [RequestOrderController::class, 'proxyList']);
        Route::post('/request-orders', [RequestOrderController::class, 'proxyStore']);
        Route::get('/request-orders/{id}', [RequestOrderController::class, 'proxyShow']);
        Route::put('/request-orders/{id}', [RequestOrderController::class, 'proxyUpdate']);
        Route::delete('/request-orders/{id}', [RequestOrderController::class, 'proxyDestroy']);
        Route::post('/request-orders/inquire-routes', [RequestOrderController::class, 'proxyInquireRoutes']);
        Route::post('/request-orders/calculate-pricing', [RequestOrderController::class, 'proxyCalculatePricing']);
        Route::get('/form-dependencies/request-order', [RequestOrderController::class, 'proxyFormDependencies']);
        Route::get('/distributor-orders', [RequestOrderController::class, 'proxyDistributorOrders']);

        // Child Waybills & Tracking
        Route::get('/waybills', [WaybillController::class, 'proxyList']);
        Route::get('/waybills/{id}', [WaybillController::class, 'proxyShow']);
        Route::get('/waybills/{id}/tracking', [WaybillController::class, 'proxyTracking']);
        Route::get('/waybills/{id}/print', [WaybillController::class, 'proxyPrint']);

        // Inventory
        Route::get('/item-ins', [InventoryController::class, 'proxyItemIns']);
        Route::post('/item-ins', [InventoryController::class, 'proxyStoreItemIn']);
        Route::get('/item-outs', [InventoryController::class, 'proxyItemOuts']);
        Route::post('/item-outs', [InventoryController::class, 'proxyStoreItemOut']);

        // Finance & Invoices
        Route::get('/finance/distributor-invoices', [DistributorInvoiceController::class, 'proxyList']);
        Route::post('/finance/distributor-invoices', [DistributorInvoiceController::class, 'proxyStore']);
        Route::get('/finance/distributor-invoices/{id}', [DistributorInvoiceController::class, 'proxyShow']);
        Route::get('/finance/distributor-invoices/form-dependencies', [DistributorInvoiceController::class, 'proxyFormDependencies']);
        Route::get('/invoices', [DistributorInvoiceController::class, 'proxyCorporateInvoices']);

        // Master Central Options
        Route::get('/master/cargo-types', [CorporateProductController::class, 'proxyCargoTypes']);
        Route::get('/master/logistic-vendors', [RequestOrderController::class, 'proxyLogisticVendors']);
        Route::get('/master/cities', [CorporateWarehouseController::class, 'proxyCities']);
    });

    // Frontend internal aliases
    Route::prefix('api/internal')->group(function () {
        Route::get('/dashboard/summary', [DashboardController::class, 'proxyStats']);
        Route::get('/request-orders', [RequestOrderController::class, 'proxyList']);
        Route::get('/products', [CorporateProductController::class, 'proxyList']);
        Route::get('/warehouses', [CorporateWarehouseController::class, 'proxyList']);
        Route::get('/waybills', [WaybillController::class, 'proxyList']);
    });

    Route::prefix('api')->group(function () {
        Route::get('/dashboard/summary', [DashboardController::class, 'proxyStats']);
        Route::get('/request-orders', [RequestOrderController::class, 'proxyList']);
        Route::get('/products', [CorporateProductController::class, 'proxyList']);
        Route::get('/warehouses', [CorporateWarehouseController::class, 'proxyList']);
        Route::get('/waybills', [WaybillController::class, 'proxyList']);
    });
});
