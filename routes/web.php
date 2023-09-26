<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\RealtorListingImageController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


//Index Controller
Route::get('/',[IndexController::class, 'index']);
Route::get('/hello',[IndexController::class, 'show'])
    ->middleware('auth');

//Listing Controller
Route::resource('listing',ListingController::class)
    ->only(['index','show']);

//ListingOffer Controller
Route::resource('listing.offer',ListingOfferController::class)
    ->middleware('auth')
    ->only(['store']);

//we can apply middleware in the constructor or in routes
/* ->only(['create','store','edit','update','destroy'])->middleware('auth');
Route::resource('listing',ListingController::class)
->except(['create','store','edit','update','destroy']); */

//AuthController
Route::get('login',[AuthController::class, 'create'])
->name('login');
Route::post('login',[AuthController::class, 'store'])
->name('login.store');
Route::delete('logout',[AuthController::class, 'destroy'])
->name('logout');

//User Controller
Route::resource('user-account',UserAccountController::class)
->only(['create','store']);

//Realtor Controller
Route::prefix('realtor')
    ->name('realtor.')
    ->middleware('auth')
    ->group(function (){
        Route::name('listing.restore')
            ->put('listing/{listing}/restore',[RealtorListingController::class,'restore'])
            ->withTrashed();
        Route::resource('listing',RealtorListingController::class)
            ->except(['show'])
            ->withTrashed();

        Route::resource('listing.image',RealtorListingImageController::class)
            ->only(['create','store','destroy']);
    });