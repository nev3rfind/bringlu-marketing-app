<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdvertiserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;

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
// Home (index) route
Route::get('/', function () {
    return view('index');
})->name('home');

// To display login user navigation buttons for authentication
require __DIR__.'/auth.php';

// Business customer routes 
Route::prefix('')->middleware('auth', 'authorise-business')->group(function() {
    Route::resource('/business', BusinessController::class)->parameters(['business' => 'advert']);
    Route::get('/business/ads/pending', 'App\Http\Controllers\BusinessController@showPending')->name('adverts.pending');
    Route::put('/business/ads/{user}/pending/confirm/{advert}', 'App\Http\Controllers\BusinessController@confirmPending')->name('adverts.pending.confirm');
    Route::put('/business/ads/{user}/pending/reject/{advert}', 'App\Http\Controllers\BusinessController@rejectPending')->name('adverts.pending.reject');
    Route::get('/business/ads/active', 'App\Http\Controllers\BusinessController@showActive')->name('adverts.active');
    Route::get('/business/ads/all', 'App\Http\Controllers\BusinessController@showAll')->name('adverts.all');
    
    // Fixed clients routes
    Route::get('/business/clients/all', 'App\Http\Controllers\ClientController@showAll')->name('clients.all');
    Route::get('/business/clients/{client}/dashboard', 'App\Http\Controllers\ClientController@dashboard')->name('clients.dashboard');
     Route::put('/business/clients/{client}/dashboard/card/{card}', [ClientController::class, 'updateCardValue'])->name('clients.dashboard.update');
     Route::post('/business/clients/{client}/dashboard/reorder', [ClientController::class, 'updateCardPositions'])->name('clients.dashboard.reorder');
    Route::get('/business/clients/{client}/forms', 'App\Http\Controllers\ClientController@forms')->name('clients.forms');
    Route::get('/business/clients/{client}/forms', [ClientController::class, 'forms'])->name('clients.forms');

    // Referral form management routes
    Route::put('/business/referral/{form}/{action}', 'App\Http\Controllers\BusinessController@updateReferralStatus')->name('business.referral.update');
    Route::post('/business/referral/{form}/view', 'App\Http\Controllers\BusinessController@viewReferralForm')->name('business.referral.view');
});

// Advertiser customer routes
Route::prefix('/advertiser')->middleware('auth', 'authorise-adv')->group(function() {
    Route::get('', 'App\Http\Controllers\AdvertiserController@index');
    // Advert details show with rate limiter (max 5 requests per minute)
    Route::get('show/{advert}', 'App\Http\Controllers\AdvertiserController@show')
    ->middleware(['throttle:advertShow'])->name('advert.show');
    // Adverts activity route
    Route::get('/activity', 'App\Http\Controllers\AdvertiserController@activity')->name('advert.activity');
    // Advert advertising request route with rate limiter (max 2 requests per minute)
    Route::post('/{advert}/request', 'App\Http\Controllers\AdvertiserController@request')
    ->middleware(['throttle:advertRequests'])->name('advert.request');
    // Advert details conversion to PDF route
    Route::get('convert/{advert}', 'App\Http\Controllers\AdvertiserController@convertToPdf')->name('advert.topdf');

    Route::post('/referral/store', 'App\Http\Controllers\AdvertiserController@storeReferralForm')->name('advertiser.referral.store');
    Route::post('/referral/{form}/view', 'App\Http\Controllers\AdvertiserController@viewReferralForm')->name('advertiser.referral.view');
});

// Account type redirection route to business OR advertiser controller
Route::get('account-type/{user}', [RegisteredUserController::class,
 'checkUser'])->name('user.account-type');