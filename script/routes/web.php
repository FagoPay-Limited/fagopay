<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

//Auth::routes(['verify' => true]);

Route::get('/login', function (){
    return redirect()->away("https://fargopayuser.herokuapp.com");
})->name('login');

Route::get('/register', function (){
    return redirect()->away("https://fargopayuser.herokuapp.com/register");
})->name('register');

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

Route::group([
    'namespace' => 'App\Lib'
], function (){
    Route::get('/payment/paypal', 'Paypal@status');
    Route::post('/stripe/payment', 'Stripe@status')->name('stripe.payment');
    Route::get('/stripe', 'Stripe@view')->name('stripe.view');
    Route::get('/payment/mollie', 'Mollie@status');
    Route::post('/payment/paystack', 'Paystack@status')->name('paystack.status');
    Route::get('/paystack', 'Paystack@view')->name('paystack.view');
    Route::get('/mercadopago/pay', 'Mercado@status')->name('mercadopago.status');
    Route::get('/razorpay/payment', 'Razorpay@view')->name('razorpay.view');
    Route::post('/razorpay/status', 'Razorpay@status');
    Route::get('/payment/flutterwave', 'Flutterwave@status');
    Route::get('/payment/thawani', 'Thawani@status');
    Route::get('/payment/instamojo', 'Instamojo@status');
    Route::get('/payment/toyyibpay', 'Toyyibpay@status');
    Route::get('/manual/payment', 'CustomGateway@status')->name('manual.payment');
    Route::get('payu/payment', 'Payu@view')->name('payu.view');
    Route::post('/payu/status', 'Payu@status')->name('payu.status');
});


