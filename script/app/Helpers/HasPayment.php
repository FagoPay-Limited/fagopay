<?php

namespace App\Helpers;

use App\Models\Gateway;
use App\Rules\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Session;

trait HasPayment
{
    private function validateRequest(Request $request, Gateway $gateway): void
    {
        $request->validate([
            'name' => [Rule::requiredIf(fn() => !\Auth::check()), 'string'],
            'email' => [Rule::requiredIf(fn() => !\Auth::check()), 'email'],
            'phone' => [
                Rule::requiredIf(fn() => $gateway->phone_required),
                new Phone
            ],
            'comment' => ['nullable', 'string', 'max:255'],
            'screenshot' => ['nullable', 'image', 'max:2048'] // 2MB
        ]);
    }
    
    function GetNetwork($number)
{
    $prefix = substr($number,0,4);
    //BEGIN SWITCH
    // MTM SWITCH
    if($prefix == '0803')
    {
        $network = 'mtn';
    }
    elseif($prefix == '0806')
    {
        $network = 'mtn';
    }
    elseif($prefix == '0814')
    {
        $network = 'mtn';
    }
    elseif($prefix == '0810')
    {
        $network = 'mtn';
    }
    elseif($prefix == '0813')
    {
        $network = 'mtn';
    }
    elseif($prefix == '0816')
    {
        $network = 'mtn';
    }
    elseif($prefix == '0703')
    {
        $network = 'mtn';
    }
    elseif($prefix == '0706')
    {
        $network = 'mtn';
    }
    elseif($prefix == '0903')
    {
        $network = 'mtn';
    }
    elseif($prefix == '0906')
    {
        $network = 'mtn';
    }

    // ETISALAT SWITCH
    elseif($prefix == '0809')
    {
        $network = 'etisalat';
    }
    elseif($prefix == '0817')
    {
        $network = 'etisalat';
    }
    elseif($prefix == '0818')
    {
        $network = 'etisalat';
    }
    elseif($prefix == '0908')
    {
        $network = 'etisalat';
    }
    elseif($prefix == '0909')
    {
        $network = 'etisalat';
    }
    
    // GLOBACOM SWITCH
    elseif($prefix == '0805')
    {
        $network = 'glo';
    }
    elseif($prefix == '0807')
    {
        $network = 'glo';
    }
    elseif($prefix == '08011')
    {
        $network = 'glo';
    }
    elseif($prefix == '0815')
    {
        $network = 'glo';
    }
    elseif($prefix == '07015')
    {
        $network = 'glo';
    }
    elseif($prefix == '0905')
    {
        $network = 'glo';
    }
    // AIRTEL SWITCH
    elseif($prefix == '0802')
    {
        $network = 'airtel';
    }
    elseif($prefix == '0808')
    {
        $network = 'airtel';
    }
    elseif($prefix == '0812')
    {
        $network = 'airtel';
    }
    elseif($prefix == '0708')
    {
        $network = 'airtel';
    }
    elseif($prefix == '0701')
    {
        $network = 'airtel';
    }
    elseif($prefix == '0902')
    {
        $network = 'airtel';
    }
    elseif($prefix == '0901')
    {
        $network = 'airtel';
    }
    elseif($prefix == '0907')
    {
        $network = 'airtel';
    }
    else
    {
        $network = "unknown";
    }
    return $network;
}



    private function proceedToPayment(Request $request, Gateway $gateway, array $paymentData)
    {
        // Upload files if exists
        if ($gateway->is_auto == 0) {
            $paymentData['comment'] = $request->input('comment');
            if ($request->hasFile('screenshot')) {

                $path = 'uploads/' . strtolower(config('app.name')) . '/payments' . date('/y/m/');
                $name = uniqid() . date('dmy') . time() . "." . $request->file('screenshot')->getClientOriginalExtension();

                Storage::disk(config('filesystems.default'))->put($path . $name, file_get_contents(Request()->file('screenshot')));

                $image = Storage::disk(config('filesystems.default'))->url($path . $name);

                $paymentData['screenshot'] = $image;
            }
        }

        $gatewayInfo = json_decode($gateway->data, true);
        if (!empty($gatewayInfo)){
            foreach ($gatewayInfo as $key => $value) {
                $paymentData[$key] = $value;
            }
        }

        return $gateway->namespace::make_payment($paymentData);
    }

    private function clearSessions()
    {
        Session::forget('payment_info');
        Session::forget('singlePaymentData');
        Session::forget('payment_info');
        Session::forget('singlePaymentData');
        Session::forget('donationPaymentData');
        Session::forget('invoicePaymentData');
        Session::forget('planPaymentData');
        Session::forget('merchantPaymentData');
        Session::forget('qrPaymentData');
        Session::forget('charge_wallet');
        Session::forget('amount');
    }
}
