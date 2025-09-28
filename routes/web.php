<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ProductController;
// use App\Http\Controllers\AdminController;
// use App\Http\Controllers\SellerApplicationController;
// use App\Models\Product;

// Route::get('/', function(){ return view('homepage'); });


// Route::get('/demo-home', function () {
//     return view('demo.home');
// });

// Route::get('/demo-products', function () {
//     // Hardcoded products
//     $products = collect([
//         (object)[
//             'id'=>1,
//             'title'=>'Handmade Necklace',
//             'description'=>'Beautiful cottage-style necklace.',
//             'price'=>25,
//             'status'=>'approved',
//             'image'=>'https://via.placeholder.com/150'
//         ],
//         (object)[
//             'id'=>2,
//             'title'=>'Vintage Ring',
//             'description'=>'Classic design.',
//             'price'=>40,
//             'status'=>'pending',
//             'image'=>'https://via.placeholder.com/150'
//         ],
//         (object)[
//             'id'=>3,
//             'title'=>'Artisanal Bracelet',
//             'description'=>'Made by local artisans.',
//             'price'=>30,
//             'status'=>'approved',
//             'image'=>'https://via.placeholder.com/150'
//         ],
//     ]);
//     return view('demo.products', ['products' => $products]);
// });

// Route::get('/demo-admin', function () {
//     // Hardcoded pending sellers and products
//     $pendingSellers = collect([
//         (object)['id'=>1, 'name'=>'Ali', 'email'=>'ali@test.com'],
//         (object)['id'=>2, 'name'=>'Sara', 'email'=>'sara@test.com'],
//     ]);

//     $pendingProducts = collect([
//         (object)['id'=>2,'title'=>'Vintage Ring','user'=>'Ali','status'=>'pending'],
//     ]);

//     return view('demo.admin', compact('pendingSellers','pendingProducts'));
// });


// Route::middleware(['auth'])->group(function(){
//     // buyer actions (guest/student)
//     Route::post('/apply-seller', [SellerApplicationController::class,'store'])->name('apply.seller');

//     // product resource — only for sellers (students)
//     Route::middleware('role:student')->group(function(){
//         Route::resource('products', ProductController::class)->except(['show','index']);
//     });

//     // both guest & student can view products
//     Route::get('products', [ProductController::class,'index'])->name('products.index');
//     Route::get('products/{product}', [ProductController::class,'show'])->name('products.show');
// });

// // admin dashboard
// Route::middleware(['auth','role:admin'])->group(function(){
//     Route::get('/admin', [AdminController::class,'index'])->name('admin.index');
//     Route::post('/admin/approve-seller/{id}', [AdminController::class,'approveSeller'])->name('admin.approveSeller');
//     Route::post('/admin/approve-product/{id}', [AdminController::class,'approveProduct'])->name('admin.approveProduct');
// });

Route::get('/', function () {
    return view('homepage');
});
use App\Models\Product;
use App\Http\Controllers\SellerApplicationController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AdminController;


Route::get('/shop', function () {
    // Only show approved products
    $products = Product::where('status', 'approved')->get();
    return view('products.index', compact('products'));
});

Route::get('/apply-seller', function () {
    return view('seller.apply');
})->name('apply.seller');

Route::post('/apply-seller', [SellerApplicationController::class,'store'])->name('apply.seller');


Route::get('/admin-demo', function () {
    $applications = DB::table('seller_applications')->where('status', 'pending')->get();
    $products = Product::where('status', 'pending')->get();

    return view('admin.dashboard', compact('applications','products'));
});

Route::post('/admin/approveSeller/{id}', [AdminController::class,'approveSeller'])->name('admin.approveSeller');
Route::post('/admin/reject-seller/{id}', [AdminController::class, 'rejectSeller'])->name('admin.rejectSeller');
Route::post('/admin/approveProduct/{id}', [AdminController::class,'approveProduct'])->name('admin.approveProduct');
Route::post('/admin/rejectProduct/{id}', [AdminController::class, 'rejectProduct'])->name('admin.rejectProduct');