<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes(['verify' => true]);

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



Route::group(['as' => 'admin.', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth', 'admin']], function () {
    // Website
    Route::post('customers/send-email/{user}', 'CustomerController@sendEmail')->name('customers.send-email');
    Route::resource('customers', 'CustomerController')->except('create', 'store');
    Route::get('get-customers', 'CustomerController@getCustomers')->name('get-customers');
    Route::get('customer/login/{user}', 'CustomerController@Login')->name('customer.login');
    Route::resource('staff', 'StaffController');
    Route::get('promotional-email', 'PromotionalEmailController@index')->name('promotional-email.index');
    Route::post('promotion-email-send', 'PromotionalEmailController@sendEmail')->name('promotional-email.send-email');
    Route::group(['prefix' => 'reports', 'as' => 'reports.'], function (){
        Route::get('banks', 'ReportController@banks')->name('banks.index');
    });
    Route::get('transactions', 'TransactionController@index')->name('transactions.index');
    Route::get('transactions/{transaction}', 'TransactionController@show')->name('transactions.show');
    Route::get('get-transaction', 'TransactionController@getTransaction')->name('get-transaction');
    Route::group(['prefix' => 'payments', 'as' => 'payments.'], function (){
        Route::get('single-charge', 'SingleChargeController@index')->name('single-charge.index');
        Route::get('single-charge/{singleCharge}', 'SingleChargeController@show')->name('single-charge.show');
        Route::get('donations', 'DonationController@index')->name('donations.index');
        Route::get('donations/{donation}', 'DonationController@show')->name('donations.show');
        Route::get('get-donations', 'DonationController@getDonations')->name('get-donations');
        Route::get('get-single-charge', 'SingleChargeController@getSingleCharge')->name('single-charge');
    });

     Route::group(['prefix' => 'bills', 'as' => 'bills.'], function (){

        // BILLS PAYMENT SETTINGS
          Route::get('airtime/swap/settings','BillsController@airtimeswap')->name('airtime.swap.settings');
          Route::get('airtime/swap/settings/{id}','BillsController@airtimeswapedit')->name('airtime.swap.edit');
          Route::post('airtime/swap/settings/{id}','BillsController@airtimeswapupdate');
          Route::get('network/settings','BillsController@network')->name('network.settings');
          Route::post('network/settings/{id}','BillsController@networkupdate')->name('network.update');
          Route::get('internet/settings','BillsController@internet')->name('internet.settings');
          Route::get('internet/settings/{id}','BillsController@internetdata')->name('internet.edit');
          Route::post('internet/settings/{id}','BillsController@internetupdate')->name('internet.update');
          Route::get('cabletv/settings','BillsController@cabletv')->name('cabletv.settings');
          Route::get('cabletv/settings/{id}','BillsController@cabletvdata')->name('cabletv.edit');
          Route::post('cabletv/settings/{id}','BillsController@cabletvupdate')->name('cabletv.update');
          Route::any('vpin/settings','BillsController@vpinsettings')->name('vpin.settings');
          Route::get('bills/airtime', 'BillsController@airtime')->name('report.airtime');
          Route::get('bills/internet', 'BillsController@internetsubsciption')->name('report.internet');
          Route::get('bills/cabletv', 'BillsController@cabletvsubscription')->name('report.cabletv');
          Route::get('bills/utility', 'BillsController@utility')->name('report.utility');
          Route::get('bills/waecreg', 'BillsController@waecreg')->name('report.waecreg');
          Route::get('bills/waecres', 'BillsController@waecres')->name('report.waecres');
          Route::get('bills/sport-betting', 'BillsController@sportbetting')->name('report.sportbetting');
          Route::get('airtime/conversion/pending', 'BillsController@pendingconversion')->name('pending.conversion');
          Route::get('airtime/conversion/approved', 'BillsController@approvedconversion')->name('approved.conversion');
          Route::get('airtime/conversion/declined', 'BillsController@declinedconversion')->name('declined.conversion');
          Route::get('airtime/conversion/incomplete', 'BillsController@incompleteconversion')->name('incomplete.conversion');
          Route::get('airtime/conversion/approve/{id}', 'BillsController@approveconversion')->name('approve.conversion');
          Route::get('airtime/conversion/decline/{id}', 'BillsController@declineconversion')->name('decline.conversion');


        Route::get('airtimetocash/pending', 'SingleChargeController@pendingconversion')->name('airtimetocash.pending');
        Route::get('airtimetocash/approved', 'SingleChargeController@approvedconversion')->name('airtimetocash.approved');
    });

    Route::group(['prefix' => 'bills', 'as' => 'bills.'], function (){
        Route::get('bills-swap-pending', 'TransactionController@swappending')->name('bills.swap.pending');
        Route::get('bills-swap-approved', 'TransactionController@swapapproved')->name('bills.swap.approved');
        Route::get('bills-swap-declined', 'TransactionController@swapdeclined')->name('bills.swap.declined');
    });

    Route::get('invoices', 'InvoiceController@index')->name('invoices.index');
    Route::get('invoices/{invoice}', 'InvoiceController@show')->name('invoices.show');
    Route::get('get-invoices', 'InvoiceController@getInvoices')->name('get-invoices');
    Route::get('merchants', 'MerchantController@index')->name('merchants.index');
    Route::get('merchants/{merchant}/log', 'MerchantController@log')->name('merchants.log');
    Route::get('payment-plans', 'PaymentPlanController@index')->name('payment-plans.index');
    Route::get('payment-plans/{id}', 'PaymentPlanController@show')->name('payment-plans.show');
    Route::get('charges', 'ChargeController@index')->name('charges.index');
    Route::resource('banks', 'BankController');

    Route::post('payouts/delete-all', 'PayoutController@deleteAll')->name('payouts.delete');
    Route::get('payouts/approved', 'PayoutController@approved')->name('payouts.approved');
    Route::get('payouts/reject', 'PayoutController@reject')->name('payouts.reject');
    Route::resource('payouts', 'PayoutController')->only('index', 'show');
    Route::get('get-payouts', 'PayoutController@getPayouts')->name('get-payouts');

    // System
    Route::get('dashboard', 'AdminController@dashboard')->name('dashboard.index');
    Route::get('settings', 'AdminController@settings')->name('settings');
    Route::post('currencies/sync', 'CurrencyController@sync')->name('currencies.sync');
    Route::put('currencies/default/{currency}', 'CurrencyController@makeDefault')->name('currencies.make.default');
    Route::resource('currencies', 'CurrencyController');
    Route::resource('banks', 'BankController')->only('index', 'update', 'store', 'destroy');
//    Route::resource('taxes', 'TaxController');
    Route::post('update-general', 'AdminController@updateGeneral')->name('update-general');
    Route::post('update-password', 'AdminController@updatePassword')->name('update-password');
    Route::get('clear-cache', 'AdminController@clearCache')->name('clear-cache');

    Route::post('blog/delete-all',  'BlogController@deleteAll')->name('blog.delete-all');
    Route::resource('blog', 'BlogController');
    Route::resource('reviews', 'ReviewController');
    Route::resource('users', 'UserController');

    Route::get('pages/choose/{lang}', 'PageController@choose')->name('page.choose');
    Route::post('page/delete-all',  'PageController@deleteAll')->name('page.delete-all');
    Route::resource('page', 'PageController');
    Route::resource('payment-gateways', 'PaymentGatewayController')->except('show');
    Route::post('/orders/mass-destroy','OrderController@massDestroy')->name('orders.mass-destroy');
    Route::get('orders/invoice/{order}/print', 'OrderController@print')->name('orders.print.invoice');
    Route::get('orders/pdf', 'OrderController@orderPdf')->name('orders.pdf');
    Route::post('orders/payment-status/{id}', 'OrderController@paymentStatusUpdate')->name('orders.payment-status');
    Route::resource('orders', 'OrderController');
    Route::get('get-orders', 'OrderController@getOrders')->name('get-orders');

    Route::post('users/login/{user}', 'UserController@login')->name('users.login');
    Route::delete('subscribers/{email}/unsubscribe', 'SubscriberController@unsubscribe')->name('subscribers.unsubscribe');
    Route::resource('subscribers', 'SubscriberController')->only('index', 'destroy');
    Route::post('supports/get-ticket', 'SupportController@getSupport')->name('supports.get-ticket');
    Route::post('supports/update-status', 'SupportController@updateStatus')->name('supports.update-status');
    Route::post('supports/reply/{support}', 'SupportController@reply')->name('supports.reply');
    Route::resource('supports', 'SupportController');

    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::group(['prefix' => 'website', 'as' => 'website.', 'namespace' => 'Website'], function () {
            Route::group(['prefix' => 'heading', 'as' => 'heading.'], function () {
                Route::controller('HeadingController')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::put('update-welcome', 'updateWelcome')->name('update-welcome');
                    Route::put('update-feature', 'updateFeature')->name('update-feature');
                    Route::put('update-about', 'updateAbout')->name('update-about');
                    Route::put('update-payment', 'updatePayment')->name('update-payment');
                    Route::put('update-integration', 'updateIntegration')->name('update-integration');
                    Route::put('update-capture', 'updateCapture')->name('update-capture');
                    Route::put('update-security', 'updateSecurity')->name('update-security');
                    Route::put('update-review', 'updateReview')->name('update-review');
                    Route::put('update-faq', 'updateFaq')->name('update-faq');
                    Route::put('update-latest-news', 'updateLatestNews')->name('update-latest-news');
                    Route::put('update-contact', 'updateContact')->name('update-contact');
                });
            });
            Route::get('logo', 'LogoController@index')->name('logo.index');
            Route::put('logo', 'LogoController@update')->name('logo.update');
            Route::get('footer', 'FooterController@index')->name('footer.index');
            Route::post('footer/store', 'FooterController@store')->name('footer.store');

            Route::get('about','AboutController@index')->name('about.index');


            Route::put('about','AboutController@update')->name('about.update');

            Route::resource('faq', 'FAQController')->except('show');
        });
        Route::get('charges', 'IncomeChargeController@index')->name('charges.index');
        Route::put('charges/update', 'IncomeChargeController@update')->name('charges.update');
    });


    Route::post('/kyc-method/mass-destroy','KycMethodController@massDestroy')->name('kyc-method.mass-destroy');
    Route::resource('kyc-method','KycMethodController')->except('destroy');

    Route::post('kyc-requests/destroy/mass',  'KycRequestController@destroyMass')->name('kyc-requests.destroy.mass');
    Route::post('users/kyc-verified/{user}', 'KycRequestController@kycVerified')->name('kyc-requests.kyc-verified');
    Route::resource('kyc-requests', 'KycRequestController')->except('edit', 'update');

    //Support Route
    Route::post('supportInfo', 'SupportController@getSupportData')->name('support.info');
    Route::post('supportstatus', 'SupportController@supportStatus')->name('support.status');
    Route::resource('support', 'SupportController');

    Route::resource('money-requests', 'RequestMoneyController')->only('index', 'show');
    Route::resource('products', 'ProductController')->only('index');
    Route::resource('stores', 'StoreController')->except('show');
    Route::resource('deposits', 'DepositeController')->only('index', 'show', 'destroy');

    Route::get('get-deposits', 'DepositeController@getDeposits')->name('get-deposits');
    Route::get('deposit/approve/{id}', 'DepositeController@approve')->name('deposits.approve');
    Route::get('deposit/reject/{id}', 'DepositeController@reject')->name('deposits.reject');

    Route::get('get-request-money', 'RequestMoneyController@getRequestMoney')->name('get-request-money');
    Route::get('get-products', 'ProductController@getProducts')->name('get-products');
    Route::get('get-stores', 'StoreController@getStores')->name('get-stores');

    Route::resource('roles', 'RoleController')->except('show');
    Route::post('assign-role/search', 'AssignRoleController@search')->name('assign-role.search');
    Route::resource('assign-role', 'AssignRoleController')->only('index', 'store');
    Route::get('shippings', 'ShippingController@index')->name('shippings.index');
    Route::get('categories', 'ProductCategoryController@index')->name('categories.index');
    Route::get('transfers', 'TransferController@index')->name('transfers.index');
    Route::get('bills', 'BillsController@getAirtime')->name('bills.airtime');



    Route::get('get-transfers', 'TransferController@getTransfers')->name('get-transfers');

    Route::resource('seo', 'SeoController')->only('index', 'edit', 'update');
    Route::resource('env', 'EnvController');
    Route::resource('media', 'MediaController');
    Route::get('medias/list', 'MediaController@list')->name('media.list');
    Route::post('medias/delete', 'MediaController@destroy')->name('medias.delete');
    Route::get('/dashboard/static', 'DashboardController@staticData');
    Route::get('/dashboard/performance/{period}', 'DashboardController@performance');
    Route::get('/dashboard/deposit/performance/{period}', 'DashboardController@depositPerformance');
    Route::get('/dashboard/order_statics/{month}', 'DashboardController@order_statics');
    Route::get('/dashboard/visitors/{days}', 'DashboardController@google_analytics');
    Route::get('languages/delete/{id}', 'LanguageController@destroy')->name('languages.delete');
    Route::post('languages/setActiveLanguage', 'LanguageController@setActiveLanguage')->name('languages.active');
    Route::post('languages/add_key', 'LanguageController@add_key')->name('language.add_key');
    Route::resource('language', 'LanguageController');
    Route::resource('menu', 'MenuController');
    Route::post('/menus/destroy', 'MenuController@destroy')->name('menus.destroy');
    Route::post('menues/node', 'MenuController@MenuNodeStore')->name('menus.MenuNodeStore');
    Route::get('/site-settings', 'SitesettingsController@index')->name('site-settings');
    Route::post('/site-settings-update/{type}', 'SitesettingsController@update')->name('site-settings.update');
    Route::resource('cron', 'CronController');

});

