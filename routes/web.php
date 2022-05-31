<?php

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\HomeController;
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

Auth::routes(['register' => false]);


Route::group(['prefix' => 'cms'], function() {
    Route::get('/signout', function() {
        Session::flush();
        Auth::logout();
        return Redirect("/login");
    });
    Route::group(['middleware' => ['auth']], function() {
        Route::get('/home', function () {
            return View::make('cms.home');
            });
    });


    Route::middleware(['isAdmin'])->group(function(){
        Route::resource('/categories', CategorieController::class)->except(['show']);
        Route::resource('/dishes', DishController::Class)->except(['show']);
        Route::resource('/users', UserController::class)->except(['show']);
    });

    Route::middleware(['isCashier'])->group(function(){

    });

});



