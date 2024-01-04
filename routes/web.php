<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\BuyPageController;
use App\Http\Controllers\RentPageController;
use App\Http\Controllers\SearchPageController;
use App\Http\Controllers\SingleListPropertyController;
use App\Http\Controllers\UserAccountPageController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\OurTeamPageController;
use App\Http\Controllers\OurServicesPageController;
use Illuminate\Support\Facades\Auth;



Route::group(['middleware' => ['LoginUserCheck']], function() {
    // Users account Page
    Auth::routes();
    Route::get('/account', [UserAccountPageController::class, 'index'])->name('account');

    Route::get('/email-verify', [UserAccountPageController::class, 'emailVerifyLoad']);
    Route::post('/email-verify', [UserAccountPageController::class, 'emailVerify'])->name('auth.emailVerify');

    Route::post('/contact-seller', [UserAccountPageController::class, 'contactSeller'])->name('auth.contactSeller');

    Route::get('/user-property-listed', [UserAccountPageController::class, 'UserPropertyTotalListed'])->name('UserPropertyTotalListed');
    


    // Home page
    Route::get('/', [HomePageController::class, 'index']);
    
    
    // edit property
    Route::get('/get-user-property-info', [UserAccountPageController::class, 'GetUserPropertyInfo'])->name('GetUserPropertyInfo');

    Route::get('/logout-user', [CustomAuthController::class, 'logoutUser'])->name('auth.logoutUser');

    
    
    // new property
    Route::post('add-new-property', [UserAccountPageController::class, 'addNewProperty'])->name('account.addNewProperty');
    Route::post('update-property', [UserAccountPageController::class, 'updateProperty'])->name('account.updateProperty');
    Route::post('sold-property', [UserAccountPageController::class, 'soldProperty'])->name('account.soldProperty');
    Route::post('delete-user-property', [UserAccountPageController::class, 'delUserProperty'])->name('account.delUserProperty');
    
    // change passwrod
    Route::post('change-user-password', [UserAccountPageController::class, 'chngUserPass'])->name('account.chngUserPass');

    // change information
    Route::post('change-user-info', [UserAccountPageController::class, 'chngUserInfo'])->name('account.chngUserInfo');
    
    // change profile pic
    Route::post('/change-profile-pic', [UserAccountPageController::class, 'changeProfilePic'])->name('account.changeProfilePic');

   
});



Route::get('/search', [SearchPageController::class, 'index'])->name('search');
Route::get('/autocomplete', [HomePageController::class, 'autocomplete'])->name('autocomplete');
Route::get('/apartment-autocomplete', [HomePageController::class, 'apartmentAutocomplete'])->name('apartment.autocomplete');

// Buy Page
Route::get('/buy', [BuyPageController::class, 'index'])->name('buy');
Route::get('/buy/{buy_single_slug}', [BuyPageController::class, 'buySingleProperty']);

// rent page
Route::get('/rent', [RentPageController::class, 'index'])->name('rent');
Route::get('/rent/{rent_single_slug}', [RentPageController::class, 'rentSingleProperty']);

// Pages
Route::get('/our-team', [OurTeamPageController::class, 'index']);
Route::get('/our-services', [OurServicesPageController::class, 'index']);


// Single list property Page
Route::get('/single-list-property', [SingleListPropertyController::class, 'index']);

Route::get('/forgot-password', [CustomAuthController::class, 'forgotPasswordLoad']);
Route::post('/forgot-password', [CustomAuthController::class, 'forgotPasswordValidation'])->name('auth.forgotPasswordValidation');
Route::post('/forgot-password-mail', [CustomAuthController::class, 'forgotPasswordMail'])->name('auth.forgotPasswordMail');

Route::get('/reset-password', [CustomAuthController::class, 'resetPasswordLoad']);
Route::post('/reset-password', [CustomAuthController::class, 'resetPassword'])->name('auth.resetPassword');

Route::post('/register-user', [CustomAuthController::class, 'registerUser'])->name('auth.registerUser');
Route::post('/login-user', [CustomAuthController::class, 'loginUser'])->name('auth.loginUser');
