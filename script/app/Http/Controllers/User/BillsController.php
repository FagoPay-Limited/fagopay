<?php

namespace App\Http\Controllers\User;

use Throwable;
use App\Models\User;
use App\Models\Transfer;
use App\Models\Transaction;
use App\Models\Network;
use App\Models\Bill;
use App\Models\Billtransactions;
use App\Models\Billsbulk;
use App\Models\AirtimeConversion;
use App\Models\AirtimeConvNumber;
use App\Models\Cabletvbundle;
use App\Models\Internetbundle;
use Illuminate\Http\Request;
use App\Mail\MoneyTransferMail;
use App\Models\VPin;
use App\Models\Power;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;
class BillsController extends Controller
{
    
    
    
    
    public function VPin(){
            $data['title']='Airtime';
            $data['network'] = Network::whereAirtime(1)->get();
            $data['discount'] = env('BULKDISCOUNT');
            $user = Auth::user();
            
            $data['logs'] = VPin::where('user_id', $user->id)->orderBy('id','DESC')->get();
            return view('user.bills.vpin', $data);
        }
        
        
  public function VPinPost(Request $request)
  {
    
    $this->validate($request, [
          'unit' => 'required|numeric',
          'amount' => 'required|numeric|min:50',
          'network' => 'sometimes',

      ]);
      
      $input = $request->all();
      $user = Auth::user();

      $sum = $request->unit * $request->amount;
      $discount = $sum/100*env('VPINDISCOUNT');
      $total = $sum - $discount;
      // return $sum;
      if ($user->wallet < $total)
      {
        
        return redirect()->back()->with('error', 'Insufficient wallet Balance');   

      }
 
       $code = rand(1111111111,999999);
      
        $mode = env('MODE');
    
      // VTPASS VENDOR ENDS
      
        $network = Network::whereCode($request->network)->first();

        if(!$network)
        {
        return redirect()->back()->with('error', 'Invalid Network');   

        }
        $url = 'https://www.nellobytesystems.com/APIEPINV1.asp?UserID='.env('CKUSERID').'&APIKey='.env('CKAPIKEY').'&MobileNetwork='.$request->network.'&Value='.$request->amount.'&Quantity='.$request->unit.'&RequestID='.$code.'&CallBackURL=callback_url';
  
        $curl = curl_init();
  
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
          ),
        ));
  
        $response = curl_exec($curl);
  
        curl_close($curl);
        $reply = json_decode($response,true);         
  
          if(!isset($reply['TXN_EPIN'])) 
          {          
                return redirect()->back()->with('error', 'API_RESPONSE: '.@$reply['status']);   
          }
          
          if($reply['TXN_EPIN']) 
          {
            $user->balance -= $total;
            $user->save();
            $code = getTrx();
            $transactions = new Transaction();
            $transactions->user_id = $user->id;
            $transactions->amount = $total; 
            $transactions->charge = 0;
            $transactions->trx_type = '-'; 
            $transactions->details = 'Payment For VPIN Printing';
            $transactions->trx = $code;
            $transactions->save();
  
            $vpin = new VPin();
            $vpin->user_id = $user->id;
            $vpin->trx = $code; 
            $vpin->amount = $request->amount; 
            $vpin->unit = $request->unit; 
            $vpin->total = $total; 
            $vpin->network = $network->name; 
            $vpin->provider = 'VTPass'; 
            $vpin->display_name = $general->sitename; 
            $vpin->mode = env('MODE');
            $vpin->vpin = json_encode($reply['TXN_EPIN']); 
            $vpin->message = 'Action Successful'; 
            $vpin->save();
            
            return redirect()->back()->with('success', 'Pin generated successfully');   
  
          }   
          else
          {
                         return redirect()->back()->with('error', 'Sorry we cant process this transaction at the moment');   

          }

               return redirect()->back()->with('error', 'Sorry we cant process this transaction at the moment');   
   
          
    }
        
    
    
    public function SwapAirtime(){
            $data['title']='Airtime';
            $data['network'] = Network::whereAirtime(1)->whereAirtimeConvert(1)->get();
            $data['discount'] = env('BULKDISCOUNT');
            $user = Auth::user();
            $data['logs'] = AirtimeConversion::where('user_id', $user->id)->where('status','!=', 'incomplete')->orderBy('id','DESC')->get();
            return view('user.bills.swapairtime', $data);
        }
        
    
public function SwapAirtimePost(Request $request)
{
  
       $this->validate($request, [
        'phone' => 'required|numeric',
        'network' => 'required',
        'amount' => 'required|numeric|min:50',

    ]);
     
    $input = $request->all();
    $user = Auth::user();
    $network = Network::whereSymbol($request->network)->whereAirtimeConvert(1)->first();
    $fee = $network->conversion/100* $request->amount;
    if(!$network)
    {
        return redirect()->back()->with('error', 'Invalid Network');   
    }

    $phone = AirtimeConvNumber::whereNetwork($request->network)->inRandomOrder()->limit(1)->first();
   if(!$phone)
   {
    return redirect()->back()->with('error', 'Sorry we cant process this airtime conversion at the moment');   
   }

       $code = rand(1111111111,999999);
       $log = new AirtimeConversion();
       $log->sender = $request->phone;
       $log->beneficiary = $phone->phone;
       $log->user_id = $user->id;
       $log->network = $request->network;
       $log->amount = $request->amount;
       $log->receive = $request->amount-$fee;
       $log->charge = $fee;
       $log->status = 'incomplete';
       $log->type = 'manual';
       $log->trx = $code;
       $log->save();
       session()->put('swaptrx', $code);
       
       return response()->json([
                        'message' => ("Airtime Swap Transaction Created, Proceed To Payment."),
                        'redirect' => route('user.bills.swapairtime.preview'),
                    ]);
                    
   }
   
    public function SwapAirtimePreview(Request $request){
          
    $input = $request->all();
    $user = Auth::user();
    $trx = session()->get('swaptrx');

    $data['log'] = AirtimeConversion::where('trx', $trx)->where('status','incomplete')->orderBy('id', 'DESC')->first();
    if (!$data['log']) {

    return redirect()->route('user.bills.swapairtime')->with('error', 'Invalid Transaction');
    }
    $data['network'] = Network::whereSymbol($data['log']->network)->first();
    
    
    return view('user.bills.swapairtimepreview', $data);

    }
    
    
    public function airtimeswapcomplete(Request $request){
          
    $input = $request->all();    
    $user = Auth::user();
    $trx = session()->get('swaptrx');

    $log = AirtimeConversion::where('trx', $trx)->where('status','incomplete')->orderBy('id', 'DESC')->first();
    if (!$log) {
        
        return response()->json([
                        'message' => ("Invalid Transaction"),
                        'redirect' => route('user.bills.swapairtime'),
                    ],404);
                    

    }

    $log->status = 'pending';
    $log->save();
    
    return response()->json([
                        'message' => ("Transaction logged successfuly. Please hold on while your transaction is verified by our server."),
                        'redirect' => route('user.bills.swapairtime'),
                    ]);

    }


    public function BulkAirtime(){
            $data['title']='Airtime';
            $data['network'] = Network::whereAirtime(1)->get();
            $data['discount'] = env('BULKDISCOUNT');
            $user = Auth::user();
            $data['logs'] = Billsbulk::whereUserId($user->id)->get();
            return view('user.bills.bulkairtime', $data);
        }
        
        public function BulkAirtimePost(Request $request)
    {
       
        
        $validator = Validator::make($request->all(),[
            'phone' => 'required',
            'mtnamount' => 'nullable|numeric|min:50',
            'airtelamount' => 'nullable|numeric|min:50',
            'globalcomamount' => 'nullable|numeric|min:50',
            'etisalatamount' => 'nullable|numeric|min:50',
        ]);
        if ($validator->fails()) 
          {
              if($request->phone < 1)
              {
                  return redirect()->back()->with('error', 'Please enter phone number');   
              }
              return redirect()->back()->with('error', 'Input validation error, Please check and try again');   

          }
        
        $input = $request->all();
        $user = Auth::user();
        /*
        if (!Hash::check($request->pin, $user->trxpin)) 
        {
            
          $notify[] = ['error', 'Invalid Pin'];
          return back()->withNotify($notify);
        }
        */
        $phone = array($request->phone);
        $str_arr = explode (",", $request->phone); 
        $DISCOUNT = env('BULKDISCOUNT');

        foreach($str_arr as $phone)
        {
      try 
      {
        // START AIRTIME LOG
        //CHECK IF LENGTH = 11 DIGITS
        if(strlen($phone))
        {
            
          // $getnet =  GetNetwork($phone);
     $prefix = substr($phone,0,4);
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
    $getnet =  $network;
          $network = Network::whereSymbol($getnet)->first();
          $log = new Billsbulk();
          $log->beneficiary = $phone;
          $log->network = $getnet;
          if($getnet == 'mtn')
          {
            $amount = $request->mtnamount;
             if($amount < 100)
              {
                  return redirect()->back()->with('error', 'Please amount must not be less than 100NGN');   
              }
            $cashback = $DISCOUNT/100*$amount;
            $log->amount = $amount;
            $log->cashback = $cashback;
            $log->payable = $amount-$cashback;
          }
          if($getnet == 'airtel')
          {
            $amount = $request->airtelamount;
             if($amount < 100)
              {
                  return redirect()->back()->with('error', 'Please amount must not be less than 100NGN');   
              }
            $cashback = $DISCOUNT/100*$amount;
            $log->amount = $amount;
            $log->cashback = $cashback;
            $log->payable = $amount-$cashback;
          }
          if($getnet == 'glo')
          {
            $amount = $request->globalcomamount;
             if($amount < 100)
              {
                  return redirect()->back()->with('error', 'Please amount must not be less than 100NGN');   
              }
            $cashback = $DISCOUNT/100*$amount;
            $log->amount = $amount;
            $log->cashback = $cashback;
            $log->payable = $amount-$cashback;
          }
          if($getnet == 'etisalat')
          {
            $amount = $request->etisalatamount;
             if($amount < 100)
              {
                  return redirect()->back()->with('error', 'Please amount must not be less than 100NGN');   
              }
            $cashback = $DISCOUNT/100*$amount;
            $log->amount = $amount;
            $log->cashback = $cashback;
            $log->payable = $amount-$cashback;
          }
          $log->status = 0;
          $log->user_id = $user->id;
          $log->save();
        }
        
      }
        // END AIRTIME LOG
          catch (\Exception $exp) {}

      }
    return redirect()->back()->with('success', 'Bulk airtime recharge has been logged successfuly');   

    }
        
  
    
        
    public function airtime(){
            $data['title']='Airtime';
            $data['network'] = Network::whereAirtime(1)->get();
            $data['discount'] = Network::whereAirtime(1)->first();
            $user = Auth::user();
            $data['benefit'] = Bill::whereUserId($user->id)->whereModule(1)->get();
            $data['bills'] = Bill::whereUserId($user->id)->whereType(1)->latest()->get();
            return view('user.bills.airtime', $data);
        }
        
      public function airtimebuy(Request $request)
    {
         $this->validate($request, [
            'network' => 'required',
            'amount' => 'required|numeric|min:50',

        ]);
        
        if($request->type == "red")
                {
             $this->validate($request, [
            'choosebeneficiary' => 'required',

        ]);
          $phone = $request->choosebeneficiary;
                }
         else{
             $this->validate($request, [
            'phone' => 'required',

        ]);         
          $phone = $request->phone;          
                }
                    
                    
                    
        $user = Auth::user();
        $network = Network::whereSymbol($request->network)->first();

        if(!$network)
        {
            
         return back()->with('error', 'Invalid Network');
        }

        if ($user->wallet < $request->amount)
        {
            
             return response()->json([
                        'message' => ("Insufficient wallet balance."),
                    ],404); 

        }


        $mode = env('MODE');
        $username = env('VTPASSUSERNAME');
        $password = env('VTPASSPASSWORD');
        $str = $username.':'.$password;
        $auth = base64_encode($str);
        date_default_timezone_set("Africa/Lagos");
        $datecode = date('Y').date('m').date('d').date('H').date('i').date('s');
        $codex = substr(str_shuffle('FAGOPAY') , 0 , 3 );
        $trx = $datecode.$codex;
        
        if($mode == 0)
        {
        $url = 'https://sandbox.vtpass.com/api/pay';
        }
        else
        {
        $url = 'https://vtpass.com/api/pay';
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>'{
        "amount": "'.$request->amount.'",
        "phone": "'.$phone.'",
        "serviceID": "'.$request->network.'",
        "request_id": "'.$trx.'"
        }',
      CURLOPT_HTTPHEADER => array(
    'Authorization: Basic '.$auth,
    'Content-Type: application/json',
      ),
    ));

    $resp = curl_exec($curl);
    $reply = json_decode($resp, true);
    curl_close($curl);
    //return $reply;
    if(!isset($reply['code'] )) 
    {
      return response()->json([
                        'message' => ("Sorry we cant process this payment at the moment."),
                    ],404); 

    }
    
    
    
    if(isset($reply['content']['errors'] )) 
    {
                           return redirect()->back()->with('error', 'API '.@$reply['content']['errors'].@$reply['response_description']);   
 
    }
   

    if($reply['code'] != "000") 
    {
                     return response()->json([
                        'message' => ("Sorry we cant process this payment at the moment."),
                    ],404); 
                      

    }
    
    
     if(!isset($reply['content']['transactions']['transactionId']))
    {
                      return response()->json([
                        'message' => ("Sorry we cant process this payment at the moment."),
                    ],404); 

    }

     if($reply['code'] == 000)
     {
        	$user->wallet -= $request->dis;
            $user->save();

            $transaction = new Bill();
            $transaction->user_id = $user->id;
            $transaction->amount = $request->amount;
            $transaction->trx = $trx;
            if(isset($request->beneficiary))
                {
            $benefisaved = Bill::whereUserId($user->id)->whereIs_beneficiary($phone)->first();
            if(!$benefisaved)
            {
             $transaction->is_beneficiary = $phone; 
             $transaction->is_beneficiary_name = $request->beneficiary; 
             $transaction->module = "1"; 
                    
                }
                }
            $transaction->phone = $phone;
            $transaction->network = $request->network;
            $transaction->newbalance = $user->wallet;
            $transaction->type = 1;
            $transaction->gateway = 'API';
            $transaction->status = 1;
            $transaction->save();
            
            
            
                
            return response()->json([
                        'message' => ("Airtime Recharge Was Successful."),
                        'redirect' => route('user.airtime'),
                    ]);     

     }

     }
     
     
     
     
       public function internet()
    {
        $pageTitle = 'Internet Data Recharge';
        $user = Auth::user();
        $discount = Network::whereAirtime(1)->first();
            $benefit = Bill::whereUserId($user->id)->whereModule(1)->get();
        $network = Network::whereInternet(1)->get();
        $bills = Bill::whereUserId($user->id)->whereType(2)->latest()->get();
        $bill = Internetbundle::whereStatus(1)->get();
            return view('user.bills.internet', compact(
            'pageTitle',
            'network',
            'bills',
            'bill',
            'discount',
            'benefit',
            'user'
        ));
 
    }


      public function loadinternet(Request $request)
    {
       $request->validate([
            'network' => 'required|string|',
            'plan' => 'required',

        ]);
        if($request->type == "red")
                {
             $this->validate($request, [
            'choosebeneficiary' => 'required',

        ]);
          $phone = $request->choosebeneficiary;
                }
         else{
             $this->validate($request, [
            'phone' => 'required',

        ]);         
          $phone = $request->phone;          
                }

        $network  = Network::whereAirtime(1)->whereSymbol($request->network)->first();
        $internet  = Internetbundle::wherePlan($request->plan)->first();
        $mode = env('MODE');
        $username = env('VTPASSUSERNAME');
        $password = env('VTPASSPASSWORD');
        $str = $username.':'.$password;
        $auth = base64_encode($str);

        $user = Auth::user();
        if ($internet->cost > $user->wallet)
        {
                            return response()->json([
                        'message' => ("Insufficient wallet balance."),
                    ],404);   

        }


        if($mode == 0)
        {
        $url = 'https://sandbox.vtpass.com/api/pay';
        }
        else
        {
        $url = 'https://vtpass.com/api/pay';
        }
        date_default_timezone_set("Africa/Lagos");

        $datecode = date('Y').date('m').date('d').date('H').date('i').date('s');
        $codex = substr(str_shuffle('FAGOPAY') , 0 , 3 );
        $trx = $datecode.$codex;
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>'{
        "amount": "'.$internet->cost.'",
        "phone": "'.$phone.'",
        "billersCode": "'.$phone.'",
        "serviceID": "'.$internet->code.'",
        "variation_code": "'.$internet->plan.'",
        "request_id": "'.$trx.'"
        }',
      CURLOPT_HTTPHEADER => array(
    'Authorization: Basic '.$auth,
    'Content-Type: application/json',
      ),
    ));

    $resp = curl_exec($curl);
    $reply = json_decode($resp, true);
    curl_close($curl);
    //return  $resp;

    if(!isset($reply['code'] )) 
    {
                       return response()->json([
                        'message' => ("We cant process this payment at the moment"),
                    ],404);

    }
    
    
    
    if(isset($reply['content']['errors'] )) 
    {
                           return redirect()->back()->with('error', 'API '.@$reply['content']['errors'].@$reply['response_description']);   
 
    }
   

    if($reply['code'] != "000") 
    {
                       return response()->json([
                        'message' => ("We cant process this payment at the moment"),
                    ],404);

    }
    
    
     if(!isset($reply['content']['transactions']['transactionId']))
    {
        
        return response()->json([
                        'message' => ("We cant process this payment at the moment"),
                    ],404);
                            

    }

    if($reply['code']== 000) {

    $user->wallet -= $request->dis;
    $user->save();

            $transaction = new Bill();
            $transaction->user_id = $user->id;
            $transaction->amount = $internet->cost;
            $transaction->trx = $trx;
            
            if(isset($request->beneficiary))
                {
            $benefisaved = Bill::whereUserId($user->id)->whereIs_beneficiary($phone)->first();
            if(!$benefisaved)
            {
             $transaction->is_beneficiary = $phone; 
             $transaction->is_beneficiary_name = $request->beneficiary; 
             $transaction->module = "1"; 
                    
                }
                }
                
                
            $transaction->phone = $phone;
            $transaction->network = $request->network;
            $transaction->accountname = $internet->name;
            $transaction->newbalance = $user->balance;
            $transaction->type = 2;
            $transaction->status = 1;
            $transaction->save();
            
             return response()->json([
                        'message' => ("Internet Subscription Was Successful."),
                        'redirect' => route('user.internet'),
                    ]);
                    
            


    }


    }
    
           public function checkEmail(Request $request)
    {
         $input = $request->only(['email']);
         $discount = Network::whereAirtime(1)->where('discountcode',$input)->first();


        // json is null
        if (!$discount) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Code'
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Code Found',
                'discount' => $discount->discount
            ]);
        }
    }
        public function checkEmailtv(Request $request)
    {
         $input = $request->only(['email']);
         $discount = Network::whereTv(1)->where('discountcode',$input)->first();


        // json is null
        if (!$discount) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Code'
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Code Found',
                'discount' => $discount->discount
            ]);
        }
    }
    
      

    
         public function cabletv()
    {
        $pageTitle = 'Cable TV Subscription';
        $user = Auth::user();
         $discount = Network::whereTv(1)->first();
        $network = Network::whereTv(1)->get();
        $benefit = Bill::whereUserId($user->id)->whereModule(2)->get();
        $bills = Bill::whereUserId($user->id)->whereType(3)->get();

        $bill = Cabletvbundle::whereStatus(1)->get();

        return view('user.bills.cabletv', compact(

            'pageTitle',
            'network',
            'discount',
            'bills',
            'benefit',
            'bill',
            'user'
        ));
    }


    public function validatedecoder(Request $request)
     {
       $request->validate([
            'decoder' => 'required|string|',
            'plan' => 'required',

        ]);
        
        if($request->type == "2")
                {
             $this->validate($request, [
            'iuc' => 'required',

        ]);
          $iuc = $request->iuc;
                }
         else{
             $this->validate($request, [
            'beneficiary' => 'required',

        ]);         
          $iuc = $request->beneficiary;   
                }

        $decoder  = Cabletvbundle::wherePlan($request->plan)->first();
        $mode = env('MODE');
        $username = env('VTPASSUSERNAME');
        $password = env('VTPASSPASSWORD');
        $str = $username.':'.$password;
        $auth = base64_encode($str);

        $user = Auth::user();
        $total = $decoder->cost + env('CABLECHARGE');
         if ($total > $user->wallet) {
                      return response()->json([
                        'message' => ("Insufficient wallet balance."),
                    ],404);
        }

        if($mode == 0)
        {
        $url = 'https://sandbox.vtpass.com/api/merchant-verify';
        }
        else
        {
        $url = 'https://vtpass.com/api/merchant-verify';
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>'{
         "billersCode": "'.$iuc.'",
        "serviceID": "'.$decoder->code.'"
        }',
      CURLOPT_HTTPHEADER => array(
    'Authorization: Basic '.$auth,
    'Content-Type: application/json',
      ),
    ));

    $resp = curl_exec($curl);
    $reply = json_decode($resp, true);
    curl_close($curl);
    //return  $resp;

    if(!isset($reply['code'] )) 
    {
                                    return redirect()->back()->with('error', 'Sorry, We cant process this payment at the moment');    

    }
    
    
    
    if(isset($reply['content']['errors'] )) 
    {
                              return redirect()->back()->with('error', 'API '.@$reply['content']['errors'].@$reply['response_description']);   

    }
   
 

    if($reply['code'] != 000) {
                                       return redirect()->back()->with('error', 'Sorry, We cant process this payment at the moment');    

    }

    if(!isset($reply['content']['Customer_Name'])) {
    
     return response()->json([
                        'message' => ("Invalid IUC Number"),
                    ],404);
    }
    
    if(isset($reply['content']['Customer_Name'])) {
    Session::put('customer', $reply['content']['Customer_Name']);
    Session::put('number', $iuc);
    Session::put('planname', $decoder->name);
    Session::put('plancode', $request->plan);
    Session::put('decoder', $decoder->network);
    Session::put('cost', $decoder->cost);
    Session::put('amount', $request->dis);
    
     return response()->json([
                        'message' => ("Customer Name Detected."),
                        'redirect' => route('user.decodervalidated'),
                    ]);
    }


    }
    
    
     public function decodervalidated(){

        $customer = Session::get('customer');
        $planname = Session::get('planname');
        $number = Session::get('number');
        $plancode = Session::get('plancode');
        $decoder = Session::get('decoder');
        $cost = Session::get('cost');
        $amount = Session::get('amount');

        $pageTitle = "Cable TV Validation";
                return view('user.bills.cabletvvalidated', compact('pageTitle','customer','planname','number','plancode','decoder','amount','cost'));
    }


     public function decoderpay(Request $request)
    {
       $request->validate([
            'number' => 'required',
            'customer' => 'required',

        ]);


        $decoder  = Cabletvbundle::wherePlan($request->plan)->first();


        $user = Auth::user();
         $total = $decoder->cost + env('CABLECHARGE');
         if ($total > $user->wallet) {
                                                  return redirect()->back()->with('error', 'Insufficient wallet balance');    

        }
       $mode = env('MODE');
        $username = env('VTPASSUSERNAME');
        $password = env('VTPASSPASSWORD');
        $str = $username.':'.$password;
        $auth = base64_encode($str);


        if($mode == 0)
        {
        $url = 'https://sandbox.vtpass.com/api/pay';
        }
        else
        {
        $url = 'https://vtpass.com/api/pay';
        }
                date_default_timezone_set("Africa/Lagos");
        $phone = "080";
        if($user->phone != null)
        {
            $phone = $user->phone;
        }
        $datecode = date('Y').date('m').date('d').date('H').date('i').date('s');
        $codex = substr(str_shuffle('FAGOPAY') , 0 , 3 );
        $code = $datecode.$codex; 
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>'{
         "billersCode": "'.$request->number.'",
         "variation_code": "'.$request->plan.'",
         "phone": "'.$phone.'",
        "serviceID": "'.$decoder->code.'",
        "request_id": "'.$code.'"
        }',
      CURLOPT_HTTPHEADER => array(
    'Authorization: Basic '.$auth,
    'Content-Type: application/json',
      ),
    ));

    $resp = curl_exec($curl);
    $reply = json_decode($resp, true);
    curl_close($curl);
    //return  $resp;

    if($reply['code'] != 000) {
                                           return redirect()->back()->with('error', 'Sorry, We cant process this payment at the moment');    

    }

    if($reply['code']== 000) {


      $user->wallet -= $total;
      $user->save();


            $transaction = new Bill();
            $transaction->user_id = $user->id;
            $transaction->amount = $decoder->cost;
            $transaction->trx = $code;
            $transaction->phone = $request->number;
            $transaction->network = $decoder->network;
            $transaction->plan = $decoder->name;
            $transaction->accountname = $request->customer;
            $transaction->newbalance = $user->wallet;
            $transaction->type = 3;
            $transaction->status = 1;
            $transaction->save();

    $notify[] = ['success', 'Payment Was Successfully'];
    return redirect()->route('user.cabletv')->with('success', 'Payment Successful');;
    }


    }





     public function utility()
    {
        $pageTitle = 'Utility Bills Payment';
        $user = Auth::user();
        $bills = Bill::whereUserId($user->id)->whereType(4)->latest()->get();
        $network = Power::whereStatus(1)->get();
        return view('user.bills.utility', compact(
            'pageTitle',
            'network',
            'bills',
            'network',
            'user'
        ));
    }




    public function validatebill(Request $request)
    {
       $request->validate([
            'number' => 'required',
            'company' => 'required|string|',
            'type' => 'required',
            'amount' => 'required|integer|min:500',

        ]);


        $meter  = Power::whereBillercode($request->company)->first();
        $mode = env('MODE');
        $username = env('VTPASSUSERNAME');
        $password = env('VTPASSPASSWORD');
        $str = $username.':'.$password;
        $auth = base64_encode($str);
        $user = Auth::user();
        $total = $request->amount + env('POWERCHARGE');


         if ($total > $user->wallet) {
                                               return redirect()->back()->with('error', 'Insufficient wallet balance');    

        }

        if($mode == 0)
        {
        $url = 'https://sandbox.vtpass.com/api/merchant-verify';
        }
        else
        {
        $url = 'https://vtpass.com/api/merchant-verify';
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>'{
         "billersCode": "'.$request->number.'",
        "serviceID": "'.$meter->billercode.'",
        "type": "'.$request->type.'"
        }',
      CURLOPT_HTTPHEADER => array(
    'Authorization: Basic '.$auth,
    'Content-Type: application/json',
      ),
    ));

    $resp = curl_exec($curl);
    $reply = json_decode($resp, true);
    curl_close($curl);
    //return  $resp;
 if(!isset($reply['code'] )) 
    {
                                        return redirect()->back()->with('error', 'Sorry, We cant process this payment at the moment');    

    }
    
    
    
    if(isset($reply['content']['errors'] )) 
    {
                                  return redirect()->back()->with('error', 'API '.@$reply['content']['errors'].@$reply['response_description']);   

    }
   

    if($reply['code'] != "000") 
    {
                                           return redirect()->back()->with('error', 'Sorry, We cant process this payment at the moment');    

    }
    
     

    if($reply['code']== 000) {

    if(!isset($reply['content']['Customer_Name']))
     {
                                            return redirect()->back()->with('error', 'Sorry, We cant process this payment at the moment');    

    }

    Session::put('customer', $reply['content']['Customer_Name']);
    Session::put('address', $reply['content']['Address']);
    Session::put('number', $request->number);
    Session::put('type', $request->type);
    Session::put('plancode', $meter->billercode);
    Session::put('meter', $meter->name);
    Session::put('cost', $request->amount);
    return redirect()->route('user.billvalidated');
    }


    }


     public function billvalidated(){

        $customer = Session::get('customer');
        $number = Session::get('number');
        $address = Session::get('address');
        $plancode = Session::get('plancode');
        $meter = Session::get('meter');
        $cost = Session::get('cost');
        $type = Session::get('type');

        $pageTitle = "Utility Bill Validation";
       return view('user.bills.utilityvalidated', compact('pageTitle','customer','number','plancode','meter','cost','type','address'));
    }




    public function billpay(Request $request)
    {
       $request->validate([
            'number' => 'required',
            'customer' => 'required',

        ]);

         $meter  = Power::whereBillercode($request->company)->first();
        $mode = env('MODE');
        $username = env('VTPASSUSERNAME');
        $password = env('VTPASSPASSWORD');
        $str = $username.':'.$password;
        $auth = base64_encode($str);
        $user = Auth::user();
        $total = $request->amount + env('POWERCHARGE');


        $meter  = Power::whereBillercode($request->plan)->first();
         if ($total > $user->wallet) {
                                                        return redirect()->back()->with('error', 'Insufficient wallet balance');    

        }

        if($mode == 0)
        {
        $url = 'https://sandbox.vtpass.com/api/pay';
        }
        else
        {
        $url = 'https://vtpass.com/api/pay';
        }
                        date_default_timezone_set("Africa/Lagos");

$datecode = date('Y').date('m').date('d').date('H').date('i').date('s');
        $codex = substr(str_shuffle('01234567890') , 0 , 5 );
        $code = $datecode.$codex; 
         $phone = "080";
        if($user->phone != null)
        {
            $phone = $user->phone;
        }
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>'{
         "billersCode": "'.$request->number.'",
         "variation_code": "'.$request->type.'",
         "phone": "'.$phone.'",
        "serviceID": "'.$meter->billercode.'",
        "amount": "'.$request->amount.'",
        "request_id": "'.$code.'"
        }',
      CURLOPT_HTTPHEADER => array(
    'Authorization: Basic '.$auth,
    'Content-Type: application/json',
      ),
    ));

    $resp = curl_exec($curl);
    $reply = json_decode($resp, true);
    curl_close($curl);
    //return $resp;

    if(!isset($reply['code'] )) 
    {
                                                return redirect()->back()->with('error', 'Sorry, We cant process this payment at the moment');    

    }
    
    
    
    if(isset($reply['content']['errors'] )) 
    {
                                     return redirect()->back()->with('error', 'API '.@$reply['content']['errors'].@$reply['response_description']);   

    }
   

    if($reply['code'] != "000") 
    {
                                                   return redirect()->back()->with('error', 'Sorry, We cant process this payment at the moment');    

    }
    
    
     if(!isset($reply['content']['transactions']['transactionId']))
    {
                                                       return redirect()->back()->with('error', 'Sorry, We cant process this payment at the moment');    
 
    }
     
    if($reply['code']== 000) {


      $user->wallet -= $total;
      $user->save();


            $transaction = new Bill();
            $transaction->user_id = $user->id;
            $transaction->amount = $request->amount;
            $transaction->trx = $code;
            $transaction->phone = $request->number;
            $transaction->network = $meter->name;
            $transaction->accountnumber = $reply['content']['transactions']['unique_element'];
            $transaction->accountname = $reply['customerName'];
            $transaction->newbalance = $user->balance;
            $transaction->type = 4;
            $transaction->status = 1;
            $transaction->save();

            

            if(isset($reply['mainToken']))
            {
            $transaction->accountnumber = $reply['mainToken'].'<br> Units: '.$reply['mainTokenUnits'];
            }
            else
            {
            $transaction->accountnumber = "Null";
            }
           
            $transaction->accountname = 'Meter: '.$reply['content']['transactions']['product_name'].'<br>Meter Number: '.$reply['content']['transactions']['unique_element'];
            $transaction->newbalance = $user->balance;
             $transaction->save();
    
     
     $notify[] = ['success', 'Payment Was Successfully'];
    return redirect()->route('user.utility')->with('success', 'Payment Was Successfully');
  }
}


public function utilitytoken($id)
{

  
   $mode = env('MODE');
   $username = env('VTPASSUSERNAME');
   $password = env('VTPASSPASSWORD');
   $str = $username.':'.$password;
   $auth = base64_encode($str);
   $user = auth()->user(); 
    $bill = Bill::whereTrx($id)->whereUserId($user->id)->first();
   if(empty($bill))
   {
       $notify[] = ['error', 'Sorry, Order Not Found'];
       return back()->withNotify($notify);
   }
   
   if($mode == 0)
   {
   $url = 'https://sandbox.vtpass.com/api/requery';
   }
   else
   {
   $url = 'https://vtpass.com/api/requery';
   }
   $curl = curl_init();
   curl_setopt_array($curl, array(
   CURLOPT_URL => $url,
   CURLOPT_RETURNTRANSFER => true,
   CURLOPT_ENCODING => "",
   CURLOPT_MAXREDIRS => 10,
   CURLOPT_TIMEOUT => 0,
   CURLOPT_FOLLOWLOCATION => true,
   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
   CURLOPT_CUSTOMREQUEST => "POST",
   CURLOPT_POSTFIELDS =>'{
    "request_id": "'.$id.'"
   }',
 CURLOPT_HTTPHEADER => array(
'Authorization: Basic '.$auth,
'Content-Type: application/json',
 ),
));

$resp = curl_exec($curl);
$reply = json_decode($resp, true);
curl_close($curl);
if(!isset($reply['code'])) {
                                                           return redirect()->back()->with('error', 'Sorry, We cant process this payment at the moment');    

}

//return $reply;
if(isset($reply['content']['errors'] )) 
   {
                                                         return redirect()->back()->with('error', 'Sorry, We cant process this payment at the moment');    

   }
   

if($reply['code'] != "000") {
                                                       return redirect()->back()->with('error', 'Sorry, We cant process this payment at the moment');    

}


   
    if(!isset($reply['content']['transactions']['product_name']))
   {
                                                            return redirect()->back()->with('error', 'Transaction not found');    

   }
   //return $resp;
   $token = @$reply['purchased_code'];
   $customer = @$reply['customerName'];
   $address = @$reply['customerAddress'];
   $unit = @$reply['mainTokenUnits'];
   $status = @$reply['content']['transactions']['status'];
   $meter = @$reply['content']['transactions']['unique_element'];
   $disco = @$reply['content']['transactions']['product_name'];
   $amount = @$reply['content']['transactions']['unit_price'];
   
   $bill->api = json_encode($reply);
   $bill->save();
   

   $pageTitle = "Utility Token";
   return view('user.bills.utilitytoken', compact('pageTitle','address','token','status','meter','unit','disco','amount','customer'));
}





     
     
}