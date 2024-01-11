<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\InstallationController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StripePaymentController;

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function() {
    Route::get('/', [IndexController::class, 'index'])->name('index');
});

Route::get('/activate', [IndexController::class, 'activate']);
Route::get('/basic_email', [MailController::class, 'basic_email']);



Route::get('/confirm/email/{email_confirmation_code}', [MailController::class, 'emailConfirmationMail']);
Route::get('/confirm/email/{password_reset_code}', [MailController::class, 'emailPasswordResetEmail']);


//Route::get('/install-script-env-editor', [InstallationController::class, 'envFileEditor'])->name('installer.envEditor');
//Route::post('/install-script-env-editor/save', [InstallationController::class, 'envFileEditorSave'])->name('installer.envEditor.save');
//Route::get('/install-script', [InstallationController::class, 'install'])->name('installer.install');
Route::get('/upgrade-script', [InstallationController::class, 'upgrade']);
Route::get('/update-manual', [InstallationController::class, 'updateManual']);

Route::get('/page/{slug}', [PageController::class, 'pageContent']);
Route::get('/privacy-policy', [PageController::class, 'pagePrivacy']);
Route::get('/terms', [PageController::class, 'pageTerms']);

/**********Settings route *************/
// Route::group(['prefix' => 'services'], function(){
//    Route::get('/', [ServiceController::class, 'index']);
//    Route::get('/create', [ServiceController::class, 'create']);
//    Route::post('/save', [ServiceController::class, 'store']);    
// });

Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});


require __DIR__.'/auth.php';
require __DIR__.'/panel.php';
require __DIR__.'/webhooks.php';


