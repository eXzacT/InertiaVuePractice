<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\NotificationSeenController;
use App\Http\Controllers\RealtorListingImageController;
use App\Http\Controllers\RealtorListingAcceptOfferController;

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

//REMINDER
//we can apply middleware in the constructor or in routes
/* ->only(['create','store','edit','update','destroy'])->middleware('auth');
Route::resource('listing',ListingController::class)
->except(['create','store','edit','update','destroy']); */

//Index Controller
Route::get('/',[IndexController::class, 'index']);
Route::get('/hello',[IndexController::class, 'show'])
    ->middleware('auth');

//User Controller
Route::resource('user-account',UserAccountController::class)
    ->only(['create','store']);

//Auth Controller
Route::get('login',[AuthController::class, 'create'])
    ->name('login');
Route::post('login',[AuthController::class, 'store'])
    ->name('login.store');
Route::delete('logout',[AuthController::class, 'destroy'])
    ->name('logout');

//Listing Controller
Route::resource('listing',ListingController::class)
    ->only(['index','show']);

//ListingOffer Controller
Route::resource('listing.offer',ListingOfferController::class)
    ->middleware('auth')
    ->only(['store']);

//Notification Controller
Route::resource('notification', NotificationController::class)
    ->middleware('auth')
    ->only('index');

//NotificationSeen Controller
Route::put('notification/{notification}/seen',NotificationSeenController::class)
    ->middleware('auth')
    ->name('notification.seen');

//EmailVerification Controller
Route::prefix('email')
    ->middleware('auth')
    ->group(function (){

        //1. Route to website that informs the user they should be verified,
        //this is automatically opened when user tries to do the action which needs the user to be registered first
        //also user is redirected if he manually inputs the url but is already registered
        Route::get('verify',[EmailVerificationController::class, 'index'])
            ->middleware('redirect.if.verified')
            ->name('verification.notice');

        //2. Sending email verification when a user first registers
        Route::get('verify/{id}/{hash}',[EmailVerificationController::class,'verify'])
            ->middleware('signed')
            ->name('verification.verify');

        //3. Resending email verification
        //we don't let the user manually enter this->Handler.php file
        Route::post('verification-notification',[EmailVerificationController::class,'resend'])
            ->middleware('throttle:6,1')
            ->name('verification.send');
});


//Realtor Controller
Route::prefix('realtor')
    ->name('realtor.')
    ->middleware(['auth','verified'])
    ->group(function (){
        Route::put('listing/{listing}/restore',[RealtorListingController::class,'restore'])
            ->withTrashed()
            ->name('listing.restore');
        Route::resource('listing',RealtorListingController::class)
            ->withTrashed();

        Route::resource('listing.image',RealtorListingImageController::class)
            ->only(['create','store','destroy']);

        Route::put('offer/{offer}/accept',RealtorListingAcceptOfferController::class)
            ->name('offer.accept');
    });
