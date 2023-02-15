<?php

namespace Database\Seeders;

use App\Models\Gateway;
use Illuminate\Database\Seeder;

class GatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gateways = [
            ['id' => '1','name' => 'paypal','logo' => '/uploads/payment-gateway/paypal.png','charge' => '2','namespace' => 'App\\Lib\\Paypal','is_auto' => '1','image_accept' => '0','test_mode' => '1','status' => '1','phone_required' => '0','data' => '{"client_id":"","client_secret":""}', 'currency_id' => 1, 'created_at' => now(),'updated_at' => now()],

            ['id' => '2','name' => 'stripe','logo' => '/uploads/payment-gateway/stripe.png','charge' => '2','namespace' => 'App\\Lib\\Stripe','is_auto' => '1','image_accept' => '0','test_mode' => '1','status' => '1','phone_required' => '0','data' => '{"publishable_key":"","secret_key":""}', 'currency_id' => 1, 'created_at' => now(),'updated_at' => now()],

            ['id' => '3','name' => 'mollie','logo' => '/uploads/payment-gateway/mollie.png','charge' => '2','namespace' => 'App\\Lib\\Mollie','is_auto' => '1','image_accept' => '0','test_mode' => '1','status' => '1','phone_required' => '0','data' => '{"api_key":""}', 'currency_id' => 1, 'created_at' => now(),'updated_at' => now()],

            ['id' => '4','name' => 'paystack','logo' => '/uploads/payment-gateway/paystack.png','charge' => '2','namespace' => 'App\\Lib\\Paystack','is_auto' => '1','image_accept' => '0','test_mode' => '1','status' => '1','phone_required' => '0','data' => '{"public_key":"","secret_key":""}', 'currency_id' => 5, 'created_at' => now(),'updated_at' => now()],

            ['id' => '5','name' => 'razorpay','logo' => '/uploads/payment-gateway/rajorpay.png','charge' => '2','namespace' => 'App\\Lib\\Razorpay','is_auto' => '1','image_accept' => '0','test_mode' => '1','status' => '1','phone_required' => '0','data' => '{"key_id":"","key_secret":""}', 'currency_id' => 4, 'created_at' => now(),'updated_at' => now()],

            ['id' => '6','name' => 'instamojo','logo' => '/uploads/payment-gateway/instamojo.png','charge' => '2','namespace' => 'App\\Lib\\Instamojo','is_auto' => '1','image_accept' => '0','test_mode' => '1','status' => '1','phone_required' => '1','data' => '{"x_api_key":"","x_auth_token":""}', 'currency_id' => 4, 'created_at' => now(),'updated_at' => now()],

            ['id' => '7','name' => 'toyyibpay','logo' => '/uploads/payment-gateway/toyybipay.png','charge' => '2','namespace' => 'App\\Lib\\Toyyibpay','is_auto' => '1','image_accept' => '0','test_mode' => '1','status' => '1','phone_required' => '1','data' => '{"user_secret_key":"","cateogry_code":""}','currency_id' => 6,'created_at' => now(),'updated_at' => now()],

            ['id' => '8','name' => 'flutterwave','logo' => '/uploads/payment-gateway/flutterwave.png','charge' => '2','namespace' => 'App\\Lib\\Flutterwave','is_auto' => '1','image_accept' => '0','test_mode' => '1','status' => '1','phone_required' => '1','data' => '{"public_key":"","secret_key":"","encryption_key":"FLWSECK_TEST498417c2cc01","payment_options":"card"}', 'currency_id' => 5, 'created_at' => now(),'updated_at' => now()],

            ['id' => '9','name' => 'payu','logo' => '/uploads/payment-gateway/payu.png','charge' => '2','namespace' => 'App\\Lib\\Payu','is_auto' => '1','image_accept' => '0','test_mode' => '1','status' => '1','phone_required' => '1','data' => '{"merchant_key":"","merchant_salt":"","auth_header":""}','currency_id'=>4,'created_at' => now(),'updated_at' => now()],

            ['id' => '10','name' => 'thawani','logo' => '/uploads/payment-gateway/uhawan.png','charge' => '1','namespace' => 'App\\Lib\\Thawani','is_auto' => '1','image_accept' => '0','test_mode' => '1','status' => '1','phone_required' => '1','data' => '{"secret_key":"","publishable_key":""}','currency_id'=> 7,'created_at' => now(),'updated_at' => now()],

            ['id' => '11','name' => 'mercadopago','logo' => '/uploads/payment-gateway/mercado-pago.png','charge' => '2','namespace' => 'App\\Lib\\Mercado','is_auto' => '1','image_accept' => '0','test_mode' => '1','status' => '1','phone_required' => '0','data' => '{"secret_key":"","public_key":""}', 'currency_id' => 1, 'created_at' => now(),'updated_at' => now()],

            ['id' => '12','name' => 'manual','logo' => '/uploads/payment-gateway/manual.png','charge' => '1','namespace' => 'App\\Lib\\CustomGateway','is_auto' => '0','image_accept' => '1','test_mode' => '1','status' => '1','phone_required' => '0','data' => '','currency_id'=> 1,'created_at' => now(),'updated_at' => now()],
            
            ['id' => '13','name' => 'From Wallet','logo' => '/uploads/payment-gateway/mycredit.png','charge' => '0','namespace' => 'App\\Lib\\Credit','is_auto' => '1','image_accept' => '0','test_mode' => '0','status' => '1','phone_required' => '0','data' => '','currency_id'=> 1, 'created_at' => now(),'updated_at' => now()]
        ];
        Gateway::insert($gateways);
        \Artisan::call('cache:clear');
    }
}
