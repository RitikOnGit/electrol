<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StaffManageController;
use App\Http\Controllers\StockManagementController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SiteManagerController;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\LoginController;


Route::get('login',[LoginController::class, 'index'])->name('login');
Route::post('login',[LoginController::class, 'login']);
Route::post('logout',[LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/test-middleware', function () {
    return 'Middleware test successful';
})->middleware('guardcheck');

// Route::get('/test-middleware', function () {
//     return 'Middleware test successful';
// })->middleware(CheckRole::class);


Route::middleware(['guardcheck'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/manage-stock',[StockManagementController::class, 'stockManage'])->name('stock-management');
    Route::get('/manage-Product',[StockManagementController::class, 'ProductManage'])->name('Product-management');
    Route::post('/add-product',[StockManagementController::class, 'productSave'])->name('product.save');
    Route::get('/product_list/{id}', [StockManagementController::class, 'productShow'])->name('product_list.show');

    Route::get('/manage-staff',[StaffManageController::class, 'staffManage'])->name('staff-management');
    Route::post('/add-staff',[StaffManageController::class, 'save'])->name('add-staff.save');

    Route::get('/manage-invoice',[InvoiceController::class, 'invoiceManage'])->name('invoice-management');
    Route::get('/add-invoice',[InvoiceController::class, 'invoiceadd'])->name('invoice-add');
    Route::post('/save-invoice',[InvoiceController::class, 'invoiceSave'])->name('invoice-save');
    Route::get('/invoice-pdf/{invId}',[InvoiceController::class, 'printInvoice'])->name('invoice-pdf');
    Route::get('/invoice_list/{id}', [StockManagementController::class, 'show'])->name('invoice_list.show');

    Route::get('/manage-tender',[TenderController::class, 'tenderManage'])->name('tender-management');
    Route::post('/add-tender',[TenderController::class, 'saveTenderp'])->name('add-tender');

    Route::get('/approval',[ApprovalController::class, 'approval'])->name('approval');
    Route::get('/reports',[ReportsController::class, 'reports'])->name('reports');

    Route::get('/manage-cash',[StockManagementController::class, 'cashManage'])->name('cash-management');
    Route::get('/cash_manage_data/{id}', [StockManagementController::class, 'cashEdata'])->name('cash_manage_data.show');
    Route::post('/add-manage-cash',[StockManagementController::class, 'addCashManage'])->name('cash-manageme-add.save');

    Route::get('/stock_list/{id}', [StockManagementController::class, 'show'])->name('stock_list.show');
    Route::post('/stocksave', [StockManagementController::class, 'save'])->name('stock.save');


    Route::get('/manage-site',[SiteManagerController::class, 'siteManage'])->name('site-management');
    Route::post('/add-site',[SiteManagerController::class, 'save'])->name('add-site.save');

    Route::get('/manage-client',[ClientController::class, 'clientManage'])->name('client-management');
    Route::get('/client-edit/{C_id}',[ClientController::class, 'show_edit'])->name('client-edit');
    Route::post('/add-client',[ClientController::class, 'save'])->name('client-add');

    Route::get('/Purchase-order',[StockManagementController::class, 'Purchaseorder'])->name('Purchase-order');
    Route::post('/add-purchase-order',[StockManagementController::class, 'addPurchaseorder'])->name('add-purchase-order');
    Route::get('/purchase-pdf/{purchaseId}',[StockManagementController::class, 'printPurorder'])->name('purchase-pdf');
});




Route::get('/pdf', [App\Http\Controllers\PDFController::class, 'generatePDF']);
