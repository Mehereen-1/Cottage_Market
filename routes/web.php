<?php
use App\Models\Product;
use App\Http\Controllers\SellerApplicationController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DemoAuthController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DiaryController;

Route::get('/', function () {
    return view('homepage');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/shop', function () {
    // Only show approved products
    $products = Product::where('status', 'approved')->get();
    return view('products.index', compact('products'));
});
// Public products page (accessible by everyone)
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');


Route::get('/apply-seller', function () {
    return view('seller.apply');
})->name('apply.seller.form');

Route::post('/apply-seller', [SellerApplicationController::class,'store'])->name('apply.seller');


Route::get('/admin-demo', function () {
    // Check if user is logged in and is admin
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403, 'Access denied. Admin role required.');
    }
    
    $applications = DB::table('seller_applications')->where('status', 'pending')->get();
    $products = Product::where('status', 'pending')->get();

    return view('admin.dashboard', compact('applications','products'));
})->name('admin.demo');

// Admin routes (protected by role)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/admin/approveSeller/{id}', [AdminController::class,'approveSeller'])->name('admin.approveSeller');
    Route::post('/admin/reject-seller/{id}', [AdminController::class, 'rejectSeller'])->name('admin.rejectSeller');
    Route::post('/admin/approveProduct/{id}', [AdminController::class,'approveProduct'])->name('admin.approveProduct');
    Route::post('/admin/rejectProduct/{id}', [AdminController::class, 'rejectProduct'])->name('admin.rejectProduct');
    Route::get('/admin-dashboard', function (){
        $applications = DB::table('seller_applications')->where('status', 'pending')->get();
        $products = Product::where('status', 'pending')->get();
        return view('admin.dashboard', compact('applications','products'));
    })->name('admin.dashboard');
});

// Protected routes that require authentication
Route::middleware('auth')->group(function () {
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    
    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{order}/pay', [PaymentController::class, 'pay'])->name('payment.pay');


    Route::get('/diaries', [DiaryController::class, 'index'])->name('diary.index');
    Route::get('/diaries/create', [DiaryController::class, 'create'])->name('diary.create');
    Route::post('/diaries', [DiaryController::class, 'store'])->name('diary.store');
    Route::get('/diaries/{id}', [DiaryController::class, 'show'])->name('diary.show');
});

// Product CRUD routes for sellers (protected by role)
Route::middleware(['auth', 'role:student'])->group(function () {
    // Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.indexSeller');
    Route::get('/seller/products', [App\Http\Controllers\ProductController::class, 'indexSeller'])->name('products.seller.index');
    Route::get('/products/create', [App\Http\Controllers\ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');
});

// Public product viewing
Route::get('/products/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');


//notificaiton
use App\Http\Controllers\NotificationController;

Route::get('/notifications/fetch', [NotificationController::class, 'fetch'])->name('notifications.fetch');
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markRead');
