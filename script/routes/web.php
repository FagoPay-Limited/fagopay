<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes(['verify' => true]);

Route::group(['as' => 'auth.', 'namespace' => 'App\Http\Controllers\Auth'], function (){
    Route::post('/register-step1', 'RegisterController@step1')->name('register.step1');
    Route::any('/register-step2', 'RegisterController@step2')->name('register.step2');
    Route::any('/register-step3', 'RegisterController@step3')->name('register.step3');
    Route::any('/register-step4', 'RegisterController@step4')->name('register.step4');
    Route::any('/register-step5', 'RegisterController@step5')->name('register.step5');
});
 
Route::get('/', function (){
    return redirect()->route('login');
})->name('home.index');

Route::group(['prefix' => 'cron', 'as' => 'cron.'], function (){
    Route::get('run/temporary-files', [\App\Http\Controllers\CronController::class, 'deleteTemporaryFiles'])->name('run.temporary-files');

    Route::get('run/delete-unpaid-external-orders', [\App\Http\Controllers\CronController::class, 'deleteUnpaidExternalOrders'])->name('run.delete-unpaid-external-orders');

    Route::get('run/transfer-refund', [\App\Http\Controllers\CronController::class, 'moneyRefund'])->name('run.money-refund');

    Route::get('run/pre-renewal-notification', [\App\Http\Controllers\CronController::class, 'preRenewalNotification'])->name('run.pre-renewal-notification');

    Route::get('run/auto-renew', [\App\Http\Controllers\CronController::class, 'autoRenew'])->name('run.auto-renew');
});




Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('dashboard', function(){
        abort(404);
    })->name('dashboard.index');
});

