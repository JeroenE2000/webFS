<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\CartController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\AllergiesController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\OrderSalesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact',function(){
    return view('guest.contact');
});
Route::get('/news',function(){
    return view('guest.news');
});

Route::get('/categories', [GuestController::class, 'index'])->name('categories');
Route::get('/download-menu-as-pdf',[GuestController::class, 'pdfConverter'])->name('downloadMenu');
Route::get('/{category_id}/get-courses', [GuestController::class, 'getDishes'])->name('get-dishes');
Route::get('/shopping_cart', [GuestController::class, 'shoppingCart'])->name('shopping_cart');
Route::post('/order', [GuestController::class, 'order'])->name('postOrder');
Route::get('/sale', [SalesController::class, 'getSales'])->name('sale');
Route::get('/order/{order_id}/qr-code', [GuestController::class, 'QrCodeMaker'])->name('getQrCode');


Route::middleware('checkRole:user')->group(function(){
    Route::get('/order', [OrderController::class , 'index'])->name('order');
    Route::post('/store_table_number', [OrderController::class ,'storeTableNumber'])->name('postTableNumber');
    Route::get('/order/shopping_cart', [OrderController::class, 'shoppingCart'])->name('getShoppingCart');
    Route::get('/order/categories', [OrderController::class, 'getCategories'])->name('tableCategories');
    Route::get('/order/{category_id}/get-courses',[OrderController::class, 'getDishes'])->name('getTableCourses');
    Route::post('/order/store', [OrderController::class, 'saveOrder'])->name('orderCreate');
    Route::get('/check_out_page', [OrderController::class, 'checkOutPage'])->name('checkOutPage');
    Route::post('/check_out', [OrderController::class, 'checkOutAndLogOut'])->name('checkOut');
});


Auth::routes();

Route::get('/signout', function() {
    Session::flush();
    Auth::logout();
    return Redirect("/login");
});

Route::middleware('checkRole:admin,kassamedewerker,serveerster')->group(function(){
    Route::group(['prefix' => 'cms'], function() {
        Route::get('/signout', function() {
            Session::flush();
            Auth::logout();
            return Redirect("/login");
        });
        Route::get('/dishes/search', [DishController::class, 'search'])->name('dishes.search');
        Route::get('/home', function () {
            return View::make('cms.home');
        });

        Route::middleware('checkRole:admin')->group(function(){
            Route::resource('/categories', CategorieController::class)->except(['show']);
            Route::resource('/users', UserController::class)->except(['show']);
            Route::resource('/allergies', AllergiesController::class)->except(['show']);
            Route::resource('/tables', TableController::class)->except(['show']);
            Route::get('/orders-betweenDates', [OrderSalesController::class , 'toOrdersBetweenDate'])->name('orders.betweenDates');
            Route::post('/orders-betweenDates', [OrderSalesController::class , 'ordersBetweenDate'])->name('orders.betweenDates.post');
        });
        Route::middleware('checkRole:kassamedewerker,serveerster,admin')->group(function(){
            Route::resource('/dishes', DishController::class);
        });
        Route::middleware('checkRole:admin,kassamedewerker')->group(function(){
            Route::resource('/discounts', SalesController::class)->except(['show']);
            Route::get('/cart', [CartController::class, 'cartList'])->name('cart.index');
            Route::post('/cart', [CartController::class, 'addToCart'])->name('cart.store');
            Route::post('/cart-update', [CartController::class, 'update'])->name('cart.update');
            Route::post('/remove', [CartController::class, 'removeCart'])->name('cart.remove');
            Route::post('/clear', [CartController::class, 'clearAllCart'])->name('cart.clearAllCart');
            Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
            Route::resource('/orders', OrderSalesController::class)->except(['create ', 'store' , 'destroy' , 'edit' , 'update']);
        });
    });
});



