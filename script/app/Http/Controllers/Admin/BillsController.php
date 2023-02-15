<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AirtimeConversion;
use App\Models\AirtimeConvNumber;
use App\Models\GeneralSetting;
use App\Models\Network;
use App\Models\Internetbundle;
use App\Models\Cabletvbundle;
use App\Models\Bill;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class BillsController extends Controller
{



    public function vpinsettings(Request $request){
        $pageTitle = "VPin Settings";
        if(isset($request->vendor))
        {
            $general = GeneralSetting::first();
            $general->vpin_vendor = $request->vendor;
            $general->vpin_discount = $request->vpin_discount;
            $general->save();
                    return redirect()->back()->with('success', __('Updated Successfullt'));

            $notify[] = ['success','VPin vendor Updated Successfuly'];
            return back()->withNotify($notify);
        }
        return view('admin.bills.vpin_settings',compact('pageTitle'));
    }

    public function airtimeswap(){
        $category = Network::whereAirtime(1)->get();
        $pageTitle = "Airtime Swap Settings";
        return view('admin.bills.swap_settings',compact('pageTitle','category'));
    }

    public function airtimeswapedit($id){
        $network = Network::whereSymbol($id)->first();
        $numbers = AirtimeConvNumber::whereNetwork($id)->get();
        $pageTitle = "Airtime Swap Settings";
        return view('admin.bills.swap_settings_edit',compact('pageTitle','network','numbers'));
    }
    public function airtimeswapupdate(Request $request, $id){
        $network = Network::whereSymbol($id)->first();
        $network->conversion_note = $request->note;
        $network->airtime_convert = $request->airtime_convert ? 1 : 0;

        $numbers = AirtimeConvNumber::whereNetwork($id)->delete();
        $input_form = [];
        if ($request->has('field_name')) {
            for ($a = 0; $a < count($request->field_name); $a++) {
                $number = new AirtimeConvNumber();
                $number->phone = $request->field_name[$a];
                $number->network = $id;
                $number->save();
            }
        }
        $network->save();
                return redirect()->back()->with('success', __('Updated Successfullt'));

        $notify[] = ['success','Airtime Swap Settings Updated Successfuly'];
        return back()->withNotify($notify);
    }


    public function network(){
        $category = Network::whereAirtime(1)->get();
        $pageTitle = "Manage Networks";
        return view('admin.bills.network',compact('pageTitle','category'));
    }


    public function networkupdate(Request $request, $id){
        $network = Network::whereId($id)->whereAirtime(1)->first();
        $network->airtime_vend_ussd = $request->airtime_vend_ussd;
        $network->internet_vend_ussd = $request->internet_vend_ussd;
        $network->vending_server_id = $request->vending_server_id;
        $network->vending_api_key = $request->vending_api_key;
        $network->status = $request->status ? 1 : 0;
        $network->host_sim = $request->host_sim ? 2 : 1;
        $network->airtime_sim_host = $request->airtime_sim_host ? 1 : 0;
        $network->internet_sim_host = $request->internet_sim_host ? 1 : 0;
        $network->save();
        return redirect()->back()->with('success', __('Updated Successfullt'));

        $notify[] = ['c','Airtime Settings Updated Successfuly'];
        return back()->withNotify($notify);
    }


    public function internet(){
        $category = Network::whereInternet(1)->get();
        $pageTitle = "Manage Internet";
        return view('admin.bills.internet',compact('pageTitle','category'));
    }


    public function internetdata($id){
        $category = Internetbundle::whereNetworkcode($id)->paginate(10);
        $pageTitle = "Manage Internet Data";
        return view('admin.bills.internet-data',compact('pageTitle','category'));
    }

    public function internetupdate(Request $request, $id){
        $network = Internetbundle::whereId($id)->first();
        $network->name = $request->name;
        $network->cost = $request->cost;
        $network->status = $request->status ? 1 : 0;
        $network->save();
                return redirect()->back()->with('success', __('Updated Successfullt'));

        $notify[] = ['success','Internet Bundle Updated Successfuly'];
        return back()->withNotify($notify);
    }

    public function cabletv(){
        $category = Network::whereTv(1)->get();
        $pageTitle = "Manage Cable TV";
        return view('admin.bills.cabletv',compact('pageTitle','category'));
    }

    public function cabletvdata($id){
        $category = Cabletvbundle::whereNetworkcode($id)->paginate(10);
        $pageTitle = "Manage Cable TV Plans";
        return view('admin.bills.cabletv-data',compact('pageTitle','category'));
    }

    public function cabletvupdate(Request $request, $id){
        $network = Cabletvbundle::whereId($id)->first();
        $network->name = $request->name;
        $network->cost = $request->cost;
        $network->status = $request->status ? 1 : 0;
        $network->save();
                return redirect()->back()->with('success', __('Updated Successfullt'));

        $notify[] = ['success','Cable TV Bundle Updated Successfuly'];
        return back()->withNotify($notify);
    }

    public function airtime()
    {
        $pageTitle = 'Airtime Recharge';
        $bills = Bill::whereType(1)->get();
        return view('admin.bills.airtime', compact('pageTitle', 'bills'));
    }

        public function internetsubsciption()
    {
        $pageTitle = 'Internet Subscription';
        $bills = Bill::whereType(2)->get();
        return view('admin.bills.internetsubscription', compact('pageTitle', 'bills'));
    }


        public function cabletvsubscription()
    {
        $pageTitle = 'Cable TV Subscription';
        $bills = Bill::whereType(3)->get();
        return view('admin.bills.cabletvsubscription', compact('pageTitle', 'bills'));
    }


        public function utility()
    {
        $pageTitle = 'Utility Bills Payment';
        $bills = Bill::whereType(4)->get();
        return view('admin.bills.utility', compact('pageTitle', 'bills'));
    }



    public function waecreg()
    {
        $pageTitle = 'WAEC Regostration Token';
        $bills = Bill::whereType(5)->get();
        return view('admin.bills.waecreg', compact('pageTitle', 'bills'));
    }

    public function waecres()
    {
        $pageTitle = 'WAEC Result Checker';
        $bills = Bill::whereType(6)->get();
        return view('admin.bills.waecres', compact('pageTitle', 'bills'));
    }
    public function sportbetting()
    {
        $pageTitle = 'Sport Betting Report';
        $bills = Bill::whereType(7)->get();
        return view('admin.bills.sportbetting', compact('pageTitle', 'bills'));
    }
    public function pendingconversion()
    {
        $pageTitle = 'Pending Airtime Conversion';
        $bills = AirtimeConversion::whereStatus('pending')->whereType('manual')->paginate(10);
        return view('admin.bills.airtime-conversion', compact('pageTitle', 'bills'));
    }

    public function approvedconversion()
    {
        $pageTitle = 'Approved Airtime Conversion';
        $bills = AirtimeConversion::whereStatus('success')->whereType('manual')->paginate(10);
        return view('admin.bills.airtime-conversion', compact('pageTitle', 'bills'));
    }

    public function declinedconversion()
    {
        $pageTitle = 'Declined Airtime Conversion';
        $bills = AirtimeConversion::whereStatus('declined')->whereType('manual')->paginate(10);
        return view('admin.bills.airtime-conversion', compact('pageTitle', 'bills'));
    }
    public function incompleteconversion()
    {
        $pageTitle = 'Incomplete Airtime Conversion';
        $bills = AirtimeConversion::whereStatus('incomplete')->whereType('manual')->paginate(10);
        return view('admin.bills.airtime-conversion', compact('pageTitle', 'bills'));
    }

    public function approveconversion($id)
    {
        $pageTitle = 'Pending Airtime Conversion';
        $conversion = AirtimeConversion::whereStatus('pending')->whereType('manual')->whereTrx($id)->first();
        if(!$conversion)
        {
                    return redirect()->back()->with('error', __('Invalid Transaction'));

            $notify[] = ['danger','Invalid Transaction'];
            return back()->withNotify($notify);
        }
        $conversion->status = 'success';
        $conversion->save();

        $user = User::whereId($conversion->user_id)->first();
        $user->wallet += $conversion->receive;
        $user->save();
    
        $transactions = new Transaction();
        $transactions->user_id = $user->id;
        $transactions->amount = $conversion->receive; 
        $transactions->charge = 0;
        $transactions->type = 'credit'; 
        $transactions->reason = 'Payment For Manual Airtime Conversion';
        $transactions->trx = $id;
        $transactions->save();
        return redirect()->back()->with('success', __('Approved Successfully'));

        $notify[] = ['success','Airtime Conversion Approved Successfuly'];
        return back()->withNotify($notify);
    }


    public function declineconversion($id)
    {
        $pageTitle = 'Pending Airtime Conversion';
        $conversion = AirtimeConversion::whereStatus('pending')->whereType('manual')->whereTrx($id)->first();
        if(!$conversion)
        {
            $notify[] = ['danger','Invalid Transaction'];
            return back()->withNotify($notify);
        }
        $conversion->status = 'canceled';
        $conversion->save();
 
        return redirect()->back()->with('success', __('Declined Successfully'));

        $notify[] = ['success','Airtime Conversion Declined Successfuly'];
        return back()->withNotify($notify);
    }



    
}
