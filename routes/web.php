<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankAccountController;
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
    Route::get('/request-orders/{id}', [RequestOrderController::class, 'show'])->name('request-orders.show');
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
    Route::get('/finance/bank-accounts', [BankAccountController::class, 'index'])->name('finance.bank-accounts');

    // Internal API Proxies (BFF)
    Route::prefix('api/internal/corporate')->group(function () {
        // Dashboard Stats
        Route::get('/dashboard/summary', [DashboardController::class, 'proxyStats']);

        // Products & Taxonomy
        Route::get('/products', [CorporateProductController::class, 'proxyList']);
        Route::get('/products/check-sku', [CorporateProductController::class, 'proxyCheckSku']);
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
        Route::get('/distributors/{id}', [CorporateDistributorController::class, 'proxyShow']);
        Route::put('/distributors/{id}', [CorporateDistributorController::class, 'proxyUpdate']);
        Route::delete('/distributors/{id}', [CorporateDistributorController::class, 'proxyDestroy']);

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
        Route::get('/finance/distributor-invoices/form-dependencies', [DistributorInvoiceController::class, 'proxyFormDependencies']);
        Route::get('/finance/distributor-invoices/dependencies', [DistributorInvoiceController::class, 'proxyFormDependencies']);
        Route::get('/finance/distributor-invoices/{id}', [DistributorInvoiceController::class, 'proxyShow']);
        Route::put('/finance/distributor-invoices/{id}', [DistributorInvoiceController::class, 'proxyUpdateStatus']);
        Route::match(['post', 'put', 'patch'], '/finance/distributor-invoices/{id}/status', [DistributorInvoiceController::class, 'proxyUpdateStatus']);
        Route::get('/distributor-invoices', [DistributorInvoiceController::class, 'proxyList']);
        Route::post('/distributor-invoices', [DistributorInvoiceController::class, 'proxyStore']);
        Route::get('/distributor-invoices/form-dependencies', [DistributorInvoiceController::class, 'proxyFormDependencies']);
        Route::get('/distributor-invoices/dependencies', [DistributorInvoiceController::class, 'proxyFormDependencies']);
        Route::get('/distributor-invoices/{id}', [DistributorInvoiceController::class, 'proxyShow']);
        Route::put('/distributor-invoices/{id}', [DistributorInvoiceController::class, 'proxyUpdateStatus']);
        Route::match(['post', 'put', 'patch'], '/distributor-invoices/{id}/status', [DistributorInvoiceController::class, 'proxyUpdateStatus']);
        Route::get('/invoices', [DistributorInvoiceController::class, 'proxyCorporateInvoices']);
        Route::get('/invoices/{id}', [DistributorInvoiceController::class, 'proxyCorporateInvoiceShow']);
        Route::post('/invoices/{id}/payment-proof', [DistributorInvoiceController::class, 'proxyUploadPaymentProof']);
        Route::get('/finance/corporate-invoices', [DistributorInvoiceController::class, 'proxyCorporateInvoices']);
        Route::get('/finance/corporate-invoices/{id}', [DistributorInvoiceController::class, 'proxyCorporateInvoiceShow']);
        Route::post('/finance/corporate-invoices/{id}/payment-proof', [DistributorInvoiceController::class, 'proxyUploadPaymentProof']);

        // Bank Accounts & Virtual Accounts
        Route::get('/finance/bank-accounts', [BankAccountController::class, 'proxyList']);
        Route::post('/finance/bank-accounts', [BankAccountController::class, 'proxyStore']);
        Route::get('/finance/bank-accounts/coa-options', [BankAccountController::class, 'proxyCoaOptions']);
        Route::get('/finance/bank-accounts/{id}', [BankAccountController::class, 'proxyShow']);
        Route::put('/finance/bank-accounts/{id}', [BankAccountController::class, 'proxyUpdate']);
        Route::delete('/finance/bank-accounts/{id}', [BankAccountController::class, 'proxyDestroy']);
        Route::post('/finance/bank-accounts/{id}/set-default', [BankAccountController::class, 'proxySetDefault']);

        Route::get('/bank-accounts', [BankAccountController::class, 'proxyList']);
        Route::post('/bank-accounts', [BankAccountController::class, 'proxyStore']);
        Route::get('/bank-accounts/coa-options', [BankAccountController::class, 'proxyCoaOptions']);
        Route::get('/bank-accounts/{id}', [BankAccountController::class, 'proxyShow']);
        Route::put('/bank-accounts/{id}', [BankAccountController::class, 'proxyUpdate']);
        Route::delete('/bank-accounts/{id}', [BankAccountController::class, 'proxyDestroy']);
        Route::post('/bank-accounts/{id}/set-default', [BankAccountController::class, 'proxySetDefault']);

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

    // Comprehensive API Proxies for Blade AJAX requests
    Route::prefix('api')->group(function () {
        // Dashboard Stats
        Route::get('/dashboard/summary', [DashboardController::class, 'proxyStats']);

        // Products & Categories
        Route::get('/products', [CorporateProductController::class, 'proxyList']);
        Route::get('/products/check-sku', [CorporateProductController::class, 'proxyCheckSku']);
        Route::post('/products', [CorporateProductController::class, 'proxyStore']);
        Route::get('/products/{id}', [CorporateProductController::class, 'proxyShow']);
        Route::put('/products/{id}', [CorporateProductController::class, 'proxyUpdate']);
        Route::delete('/products/{id}', [CorporateProductController::class, 'proxyDestroy']);
        Route::get('/product-categories', [CorporateProductController::class, 'proxyCategories']);
        Route::post('/product-categories', [CorporateProductController::class, 'proxyStoreCategory']);
        Route::get('/product-categories/{id}', [CorporateProductController::class, 'proxyShowCategory']);
        Route::put('/product-categories/{id}', [CorporateProductController::class, 'proxyUpdateCategory']);
        Route::delete('/product-categories/{id}', [CorporateProductController::class, 'proxyDestroyCategory']);
        Route::get('/uoms', [CorporateProductController::class, 'proxyUoms']);
        Route::get('/cargo-types', [CorporateProductController::class, 'proxyCargoTypes']);

        // Warehouses
        Route::get('/warehouses', [CorporateWarehouseController::class, 'proxyList']);
        Route::post('/warehouses', [CorporateWarehouseController::class, 'proxyStore']);
        Route::get('/warehouses/{id}', [CorporateWarehouseController::class, 'proxyShow']);
        Route::put('/warehouses/{id}', [CorporateWarehouseController::class, 'proxyUpdate']);
        Route::delete('/warehouses/{id}', [CorporateWarehouseController::class, 'proxyDestroy']);

        // Customers
        Route::get('/customers', [CorporateCustomerController::class, 'proxyList']);
        Route::post('/customers', [CorporateCustomerController::class, 'proxyStore']);
        Route::get('/customers/{id}', [CorporateCustomerController::class, 'proxyShow']);
        Route::put('/customers/{id}', [CorporateCustomerController::class, 'proxyUpdate']);
        Route::delete('/customers/{id}', [CorporateCustomerController::class, 'proxyDestroy']);

        // Vendors
        Route::get('/vendors', [CorporateVendorController::class, 'proxyList']);
        Route::post('/vendors', [CorporateVendorController::class, 'proxyStore']);
        Route::get('/vendors/{id}', [CorporateVendorController::class, 'proxyShow']);
        Route::put('/vendors/{id}', [CorporateVendorController::class, 'proxyUpdate']);
        Route::delete('/vendors/{id}', [CorporateVendorController::class, 'proxyDestroy']);

        // Distributors
        Route::get('/distributors', [CorporateDistributorController::class, 'proxyList']);
        Route::post('/distributors', [CorporateDistributorController::class, 'proxyStore']);
        Route::get('/distributors/{id}', [CorporateDistributorController::class, 'proxyShow']);
        Route::put('/distributors/{id}', [CorporateDistributorController::class, 'proxyUpdate']);
        Route::delete('/distributors/{id}', [CorporateDistributorController::class, 'proxyDestroy']);

        // Orders & Request Orders
        Route::get('/distributor-orders', [RequestOrderController::class, 'proxyDistributorOrders']);
        Route::get('/customer-orders', [RequestOrderController::class, 'proxyDistributorOrders']);
        Route::get('/request-orders', [RequestOrderController::class, 'proxyList']);
        Route::post('/request-orders', [RequestOrderController::class, 'proxyStore']);
        Route::get('/request-orders/{id}', [RequestOrderController::class, 'proxyShow']);
        Route::put('/request-orders/{id}', [RequestOrderController::class, 'proxyUpdate']);
        Route::delete('/request-orders/{id}', [RequestOrderController::class, 'proxyDestroy']);
        Route::post('/request-orders/inquire-routes', [RequestOrderController::class, 'proxyInquireRoutes']);
        Route::post('/request-orders/calculate-pricing', [RequestOrderController::class, 'proxyCalculatePricing']);
        Route::get('/form-dependencies/request-order', [RequestOrderController::class, 'proxyFormDependencies']);

        // Waybills
        Route::get('/waybills', [WaybillController::class, 'proxyList']);
        Route::get('/waybills/{id}', [WaybillController::class, 'proxyShow']);
        Route::get('/waybills/{id}/tracking', [WaybillController::class, 'proxyTracking']);
        Route::get('/waybills/{id}/print', [WaybillController::class, 'proxyPrint']);

        // Inventory
        Route::get('/inventory/stocks', [InventoryController::class, 'proxyStocks']);
        Route::get('/inventory/item-ins', [InventoryController::class, 'proxyItemIns']);
        Route::post('/inventory/item-ins', [InventoryController::class, 'proxyStoreItemIn']);
        Route::get('/inventory/item-outs', [InventoryController::class, 'proxyItemOuts']);
        Route::post('/inventory/item-outs', [InventoryController::class, 'proxyStoreItemOut']);
        Route::get('/stocks', [InventoryController::class, 'proxyStocks']);
        Route::get('/item-ins', [InventoryController::class, 'proxyItemIns']);
        Route::post('/item-ins', [InventoryController::class, 'proxyStoreItemIn']);
        Route::get('/item-outs', [InventoryController::class, 'proxyItemOuts']);
        Route::post('/item-outs', [InventoryController::class, 'proxyStoreItemOut']);

        // Finance
        Route::get('/finance/distributor-invoices', [DistributorInvoiceController::class, 'proxyList']);
        Route::post('/finance/distributor-invoices', [DistributorInvoiceController::class, 'proxyStore']);
        Route::get('/finance/distributor-invoices/form-dependencies', [DistributorInvoiceController::class, 'proxyFormDependencies']);
        Route::get('/finance/distributor-invoices/dependencies', [DistributorInvoiceController::class, 'proxyFormDependencies']);
        Route::get('/finance/distributor-invoices/{id}', [DistributorInvoiceController::class, 'proxyShow']);
        Route::put('/finance/distributor-invoices/{id}', [DistributorInvoiceController::class, 'proxyUpdateStatus']);
        Route::match(['post', 'put', 'patch'], '/finance/distributor-invoices/{id}/status', [DistributorInvoiceController::class, 'proxyUpdateStatus']);
        Route::get('/finance/corporate-invoices', [DistributorInvoiceController::class, 'proxyCorporateInvoices']);
        Route::get('/finance/corporate-invoices/{id}', [DistributorInvoiceController::class, 'proxyCorporateInvoiceShow']);
        Route::post('/finance/corporate-invoices/{id}/payment-proof', [DistributorInvoiceController::class, 'proxyUploadPaymentProof']);
        Route::get('/invoices', [DistributorInvoiceController::class, 'proxyCorporateInvoices']);
        Route::get('/invoices/{id}', [DistributorInvoiceController::class, 'proxyCorporateInvoiceShow']);
        Route::post('/invoices/{id}/payment-proof', [DistributorInvoiceController::class, 'proxyUploadPaymentProof']);

        // Master Central Options
        Route::get('/master/cargo-types', [CorporateProductController::class, 'proxyCargoTypes']);
        Route::get('/master/logistic-vendors', [RequestOrderController::class, 'proxyLogisticVendors']);
        Route::get('/master/cities', [CorporateWarehouseController::class, 'proxyCities']);
        Route::get('/wilayah/kota', [CorporateWarehouseController::class, 'proxyCities']);
    });
});
