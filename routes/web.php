<?php
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LoanTransactionController;
use App\Http\Controllers\PlantController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\AboutController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin and Staff can access Plants
    Route::middleware('role:admin,staff')->group(function () {
        Route::get('/plants', [PlantController::class, 'index'])->name('plants.index');
    });

    // Customers: all authenticated users can access the page.
    // RBAC for CRUD actions is enforced inside CustomerController (abort 403).
    Route::get('customers/export-pdf', [CustomerController::class, 'exportPdf'])->name('customers.exportPdf');
    Route::resource('customers', CustomerController::class);

    // Only Admin can access these routes
    Route::middleware('role:admin')->group(function () {
        Route::resource('loans', LoanController::class);
        Route::get('loantransactions/export-pdf', [LoanTransactionController::class, 'generatePDF'])->name('loantransactions.exportPdf');
        Route::resource('loantransactions', LoanTransactionController::class);
        Route::get('/product', [ProductsController::class, 'index'])->name('product.index');
        Route::get('/Order', [OrdersController::class, 'index'])->name('Order.index');
        Route::get('/payment', [PaymentsController::class, 'index'])->name('payment.index');
        Route::get('/history-nav', [HistoryController::class, 'index'])->name('history-nav.index');
        Route::get('/about', [AboutController::class, 'index'])->name('about.index');
    });
}); 

require __DIR__.'/auth.php';
