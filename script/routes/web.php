<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes(['verify' => true]);


Route::group(['as' => 'frontend.', 'namespace' => 'App\Http\Controllers\Frontend'], function (){
    Route::get('/', 'HomeController@index')->name('home.index');
    Route::get('/about', 'AboutController@index')->name('about.index');
    Route::get('/nfc','AboutController@nfc')->name('nfc.index');
     Route::get('/teens','AboutController@teens')->name('teens.index');
    Route::get('/business','AboutController@bus')->name('business.index');

    Route::get('/career','AboutController@career')->name('about.career');

    Route::get('/faq','AboutController@faq')->name('about.faq');

    Route::get('/wallet','AboutController@wallet')->name('about.wallet');


    Route::get('/products', 'ProductController@index')->name('products.index');
    Route::get('/store/{store}/product/{product}/', 'ProductController@show')->name('products.show');
    Route::get('/store/{store}', 'ProductController@storeProducts')->name('store-products');

    Route::get('/blog', 'BlogController@index')->name('blog.index');
    Route::get('/blog/{post:slug}', 'BlogController@show')->name('blog.show');
    Route::get('/contact', 'ContactController@index')->name('contact.index');
    Route::post('/contact/send', 'ContactController@send')->name('contact.send');

    Route::resource('cart', 'CartController');

    Route::get('page/{page:slug}', 'PageController@index')->name('page.index');

    Route::get('locale/{locale}', 'LocaleController@setLanguage')->name('set-language');
    Route::post('newsletter-subscribe', '\App\Http\Controllers\CommonController@subscribeToNewsLetter')->name('subscribe-to-news-letter');


    Route::get('single-charge/{single_charge:uuid}', 'SingleChargeController@index')->name('single-charge.index');
    Route::post('single-charge/{single_charge:uuid}', 'SingleChargeController@gateway')->name('single-charge.gateway');
    Route::post('single-charge/{single_charge:uuid}/{gateway}/payment', 'SingleChargeController@payment')->name('single-charge.payment');

    // External Merchant Payment
    // Merchant Payment
    Route::get('merchant/{website}/{uuid}', 'MerchantController@index')->name('merchant.index');
    Route::post('merchant/{website}/{uuid}', 'MerchantController@gateway')->name('merchant.gateway');
    Route::post('merchant/{website}/{uuid}/{gateway}/payment', 'MerchantController@payment')->name('merchant.payment');

    // Invoice Payment
    Route::get('invoice/{invoice:uuid}', 'InvoiceController@index')->name('invoice.index');
    Route::post('invoice/{invoice:uuid}', 'InvoiceController@gateway')->name('invoice.gateway');
    Route::post('invoice/{invoice:uuid}/{gateway}/payment', 'InvoiceController@payment')->name('invoice.payment');

    // Plan Payment
    Route::get('plan/{plan:uuid}', 'PlanController@index')->name('plan.index');
    Route::post('plan/{plan:uuid}/payment', 'PlanController@payment')->name('plan.payment');

    // QR Code Payment
    Route::get('qr/{user:qr}', 'QRPaymentController@index')->name('qr.index');
    Route::post('qr/{user:qr}', 'QRPaymentController@gateway')->name('qr.gateway');
    Route::post('qr/{user:qr}/{gateway}/payment', 'QRPaymentController@payment')->name('qr.payment');

    Route::group(['prefix' => 'payment', 'as' => 'payment.'], function (){
        Route::get('success', [PaymentController::class, 'success'])->name('success');
        Route::get('failed', [PaymentController::class, 'failed'])->name('failed');
        Route::post('test/{website}/{order:uuid}/{gateway}', [PaymentController::class, 'test'])->name('test');
    });
});

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

