<?php

namespace App\Http\Controllers\User;

use Throwable;
use App\Models\User;
use App\Models\Transfer;
use App\Models\Transaction;
use App\Models\Network;
use App\Models\Bill;
use App\Models\Billtransactions;
use Illuminate\Http\Request;
use App\Mail\MoneyTransferMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total_transfer = Transfer::whereUserId(auth()->id())->sum('amount') + Transfer::whereUserId(auth()->id())->sum('charge');
        $pending_transfer = Transfer::whereUserId(auth()->id())->whereStatus(1)->sum('amount');
        $return_transfer = Transfer::whereUserId(auth()->id())->whereStatus(0)->sum('amount');
        $beneficiarys = Transfer::whereUserId(auth()->id())->where('is_beneficiary', 1)->get();
        $transfers = Transfer::whereUserId(auth()->id())->latest()
                    ->when(request('search'), function($q) {
                        $q->where('trx', 'like', '%' . request('search') . '%');
                        $q->orWhere('amount', 'like', '%' . request('search') . '%');
                        $q->orWhere('email', 'like', '%' . request('search') . '%');
                    })
                    ->orWhere('email', auth()->user()->email)
                    ->with('currency', 'user')->paginate();

        return view('user.transfers.index', compact('transfers', 'total_transfer', 'pending_transfer', 'return_transfer', 'beneficiarys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.transfers.create');
    }

    public function store(Request $request)
    {
        
        
        $trx = time().rand(1,100);
        
        $request->validate([
            'password' => 'required',
            'email' => 'required|email',
            'amount' => 'required|integer',
            'is_beneficiary' => 'nullable|boolean',
        ]);

        if (Hash::check($request->password, auth()->user()->password)) {
            if (auth()->user()->email != $request->email) {
            if (auth()->user()->wallet > $request->amount) {

                $total_charge = get_charge('transfer_charge', $request->amount) + get_charge('transaction_charge', $request->amount);
                
            
                
                \DB::beginTransaction();
                try {
                    
                    if ($request->is_beneficiary){
    $transfer= Transfer::whereIs_beneficiary($request->is_beneficiary)->first();
                if ($request->is_beneficiary !=$transfer->is_beneficiary){
                    Transfer::create([
                        'user_id' => auth()->id(),
                        'email' => $request->email,
                        'amount' => $request->amount - $total_charge,
                        'is_beneficiary' => $request->is_beneficiary,
                        'charge' => $total_charge,
                        'trx' => $trx,
                        'rate' => user_currency()->rate,
                        'currency_id' => auth()->user()->currency_id,
                    ]);
                    
                    }
                    else{
                   
                   Transfer::create([
                        'user_id' => auth()->id(),
                        'email' => $request->email,
                        'amount' => $request->amount - $total_charge,
                        'charge' => $total_charge,
                        'trx' => $trx,
                        'rate' => user_currency()->rate,
                        'currency_id' => auth()->user()->currency_id,
                    ]);
                    
                    
                }
                    }
                    else{
                        Transfer::create([
                        'user_id' => auth()->id(),
                        'email' => $request->email,
                        'amount' => $request->amount - $total_charge,
                        'charge' => $total_charge,
                        'trx' => $trx,
                        'rate' => user_currency()->rate,
                        'currency_id' => auth()->user()->currency_id,
                    ]);
                    }
                

                    Transaction::create([
                        'trx' => $trx,
                        'type' => 'Debit',
                        'name' => auth()->user()->name,
                        'email' => $request->email,
                        'charge' => $total_charge,
                        'feature' => 'Transfer',
                        'user_id' => auth()->id(),
                        'amount' => '-'.$request->amount - $total_charge,
                        'reason' => 'Transfer money',
                        'currency_id' => auth()->user()->currency_id,
                    ]);
                    
                   

                    $user = User::find(auth()->id());
                    $user->wallet = $user->wallet - $request->amount;
                    $user->save();

                    $options = [
                        'name' => $user->name,
                        'amount' => $request->amount,
                        'currency' => user_currency()->symbol,
                        'url' => route('user.transfers.index'),
                    ];
                
                
                    if (config('system.queue.mail')) {
                        Mail::to(auth()->user()->email)->queue(new MoneyTransferMail($options));
                    } else {
                        Mail::to($request->email)->send(new MoneyTransferMail($options));
                    }

                    \DB::commit();
                    
                    return response()->json([
                        'message' => $request->is_beneficiary ? __("Transfer successful. Beneficiary created  successfully") : __("Transfer successful."),
                        'redirect' => route('user.transfers.index'),
                    ]);
                
                  
                } catch (Throwable $th) {
                    \DB::rollback();
                    return response()->json([
                        'message' => __('Something was wrong, Please contact with author.')
                    ]);
                }
            } 
            
             else {
                return response()->json([
                    'message' => __("Insufficient balance.")
                ], 404);
            }
            
        }else {
                return response()->json([
                    'message' => __("Transfer to yourself is not allowed.")
                ], 404);
            }
            
            }else {
            return response()->json([
                'message' => __("Your password is wrong.")
            ], 404);
        }
    }

    public function show(Request $request, Transfer $transfer)
    {
        \DB::beginTransaction();
        try {
            if ($request->type == 'accept') {
                $transfer->update([
                    'status' => 2
                ]);
                $user = User::with('currency')->findOrFail(auth()->id());
                $sender = User::with('currency')->findOrFail($transfer->user_id);
                $amount = str_replace(',','',number_format(convert_money($transfer->amount, $sender->currency) * $user->currency->rate, 2));
                $user->update([
                    'wallet' => $user->wallet + $amount
                ]);

                Transaction::create([
                    'type' => 'credit',
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'user_id' => auth()->id(),
                    'amount' => $amount,
                    'reason' => 'Transfer money received',
                    'currency_id' => auth()->user()->currency_id,
                ]);

                \DB::commit();

                return response()->json([
                    'message' => __('Transfer money accepted successfully.'),
                    'redirect' => route('user.transfers.index'),
                ]);
            } elseif ($request->type == 'cancle') {

                $transfer->update([
                    'status' => 0
                ]);
                $user = User::findOrFail($transfer->user_id);
                $user->update([
                    'wallet' => $user->wallet + ($transfer->amount + $transfer->charge)
                ]);

                Transaction::create([
                    'type' => 'credit',
                    'name' =>  $user->name,
                    'email' =>  $user->email,
                    'user_id' => $transfer->user_id,
                    'amount' => $transfer->amount + $transfer->charge,
                    'reason' => 'Transfer money back',
                    'currency_id' => $user->currency_id,
                ]);

                \DB::commit();

                return response()->json([
                    'message' => __('Transfer money has been canceled.'),
                    'redirect' => route('user.transfers.index'),
                ]);
            }

        } catch (Throwable $th) {
            \DB::rollback();
            return response()->json([
                'message' => __('Something was wrong, Please contact with author.'),
                'redirect' => route('user.transfers.index'),
            ], 404);
        }
    }


    public function destroy(Transfer $transfer)
    {
        abort_if($transfer->user_id != auth()->id(), 404);
        $transfer->is_beneficiary = 0;
        $transfer->save();
        return response()->json([
            'message' => __('Beneficiary deleted successfully.'),
            'redirect' => route('user.transfers.index'),
        ]);
    }

    public function getTransfers()
    {
        $data['total'] = Transfer::whereUserId(auth()->id())->count();
        $data['completed'] = Transfer::whereUserId(auth()->id())->whereStatus(2)->count();
        $data['pending'] = Transfer::whereUserId(auth()->id())->whereStatus(1)->count();
        $data['refund'] = Transfer::whereUserId(auth()->id())->whereStatus(3)->count();
        $data['cancled'] = Transfer::whereUserId(auth()->id())->whereStatus(0)->count();
        return response()->json($data);
    }
    
    
        public function airtime(){
            $data['title']='Airtime';
            $data['network'] = Network::whereAirtime(1)->get();
            $data['discount'] = Network::whereAirtime(1)->first();
            $user = auth()->id();
            $data['bills'] = Bill::whereUserId($user->id)->whereType(1)->get();
            $data['trans'] = Billtransactions::whereuser_id($user->id)->wheretype(1)->orderBy('created_at', 'DESC')->get();
            return view('user.bills.airtime', $data);
        }
        
        
        
}
