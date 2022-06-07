<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\DishController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CategorieController;

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
Route::get('/sale', [SalesController::class, 'getSales'])->name('sale');

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
        });
        Route::middleware('checkRole:kassamedewerker,serveerster,admin')->group(function(){
            Route::resource('/dishes', DishController::class);
        });
        Route::middleware('checkRole:admin,kassamedewerker')->group(function(){
            Route::resource('/discounts', SalesController::class)->except(['show']);
        });
    });
});



