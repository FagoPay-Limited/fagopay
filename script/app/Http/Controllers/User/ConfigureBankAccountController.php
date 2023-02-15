<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Payout;
use App\Models\Transaction;
use App\Models\UserBank;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ConfigureBankAccountController extends Controller
{
    public function index()
    {
        abort_if(\Auth::user()->banks()->exists(), 404);
        $banks = Bank::whereCurrencyId(\Auth::user()->currency_id)->pluck('name', 'code', 'id');
        return view('user.configure-banks.set-bank.index', compact('banks'));
    }
        
     public function checkEmaill(Request $request)
        {  
                $curl = curl_init();
                $email = $request->input('email');
                $code = $request->input('bank');
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.paystack.co/bank/resolve?account_number='.$email.'&bank_code='.$code.'',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer sk_test_8a0b1f199362d7acc9c390bff72c4e81f74e2ac3'
                ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                $reply = json_decode($response, true);
                if(!isset($reply))
                {
                   return response()->json([
                'success' => 'ffalse',
                'message' => 'API ERROR'
            ]);
                }

                if($reply['status'] != 'true')
                {
                    return response()->json([
                'success' => 'falsee',
                'message' => $reply['message']
            ]);
                }
              
                if($reply['status'] == 'true')
                {
                 $name = $reply['data']['account_name'];
                 $words = explode(" ", $name);

                 $firstname = @$words[0];
                 $lastname = @$words[1];
                 
                return response()->json([
                'success' => 'truee',
                'message' => $name
            ]);

                }
            }    
        
    public function store(Request $request)
    {
        abort_if(\Auth::user()->banks()->exists(), 404);
        $request->validate([
            'bank' => ['required'],
            'account_type' => ['required', Rule::in(['individual', 'company'])],
            'account_number' => ['required', 'numeric'],
            'account_name' => ['required', 'string'],
        ]);
        
        $banks = Bank::whereCode($request->input('bank'))->first();
        UserBank::create([
            'user_id' => \Auth::id(),
            'bank_id' => $banks->id,
            'data' => [
                'account_number' => $request->input('account_number'),
                'account_name' => $request->input('account_name'),
                'account_type' => $request->input('account_type'),
            ]
        ]);
        
        $transactions = Transaction::whereUserId(auth()->id())->where('amount', '>', 0)->latest()->paginate();
        $payouts = Payout::whereUserId(auth()->id())->whereStatus('completed')->sum('amount');
        return view('user.home.index', compact('transactions', 'payouts'));
       
    }
}
