@extends('layouts.user.master')

@section('title', __('Bulk Airtime'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('user.home.index') }}"><i class="fas fa-home"></i></a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Bulk Airtime') }}</li>
@endsection 
@section('content')
<div id="content" class="main-content">
  <div class="layout-px-spacing">
    <div class="row layout-top-spacing">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">

	  <div class="alert alert-icon alert-primary" role="alert">
    <em class="icon ni ni-tranx"></em> You are entitled to <b>{{$discount}} % Cashback</b> on this transaction.<br>

  <small class="text-danger"> For multiple phone numbers, please separate numbers with a coma symbol ',' without adding space in between</small>
</div>

<div class="card card-bordered">
    <div class="card-inner">
         
        <div class="tab-content mt-0">
            <div class="tab-panes" id="networkcount">
                <div class="invest-ov gy-2">
                    <div class="row">
                        <div class="invest-ov-info col-3">
							<center>
                            <div class="amount text-danger"><b id="airtelnet">0</b></div>
                            <div class="amount text-danger">Airtel</div>
							</center>
                        </div> 
                        <div class="invest-ov-info col-3">
						    <center>
                            <div class="amount text-secondary"><b id="etisalatnet">0</b></div>
                            <div class="amount text-secondary">Etisalat</div>
							</center>
                        </div> 
                        <div class="invest-ov-info col-3">
							<center>
                            <div class="amount text-success"><b id="globacomnet">0</b></div>
                            <div class="amount text-success">Glo</div>
							</center>
                        </div> 
                        <div class="invest-ov-info col-3">
					    	<center>
                            <div class="amount text-warning"><b id="mtnnet">0</b></div>
                            <div class="amount text-warning">MTN</div>
							</center>
                        </div> 
						
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


        <div class="card">
          <div class="card-body">
            <div class="buy-sell-widget">
              <div class="tab-content tab-content-default">
                <div class="tab-pane fade show active" id="buy" role="tabpanel">
                  <form
                    class="contact-form"
                    class="currency_validate"
                    action=""
                    method="post"
                    enctype="multipart/form-data"
                  >
                    @csrf

                    <div class="row">
                      
                      <div class="form-group col-12">
                        <label >Enter Phone Number</label>
                        <div class="input-group mb-3">
                          <input
                            class="form-control"
                            name="phone"
                            type="tel"
							onkeyup="getnetworks(event)"
                            placeholder="080123456789"
                          />
                        </div>
                      </div>
                    </div>

					  
					<div class="row" id="mtndiv" style="display:none">
					
                      <div class="form-group col-12">
						<hr>
                        <label class="text-warning">Enter An amount</label>
                        <div class="input-group mb-3">
                          <input
                            class="form-control"
                            name="mtnamount"
                            onkeyup="getmtncashback(event)"
                            type="number"
                            placeholder="MTN AMOUNT"
                          />
                        </div>

						<div class="alert alert-warning">
                              <div class="alert-text">
                                  <h6 class="text-primary">Total Amount: ₦‎<a id="mtntotal">0</a></h6>
                                  <h6 class="text-success">Total Cashback: ₦‎<a id="mtncashback">0</a></h6>
                                  <h6 class="text-info">Total Payable: ₦‎<a id="mtnpayable">0</a></h6>
                              </div>
                         </div>

                      </div>
 
					</div>
					<div class="row" id="airteldiv" style="display:none">
                       <div class="form-group col-12">
						<hr>
                        <label class="text-danger">Enter Airtel amount</label>
                        <div class="input-group mb-3">
                          <input
                            class="form-control"
                            name="airtelamount"                            
                            onkeyup="getairtelcashback(event)"
                            type="number"
                            placeholder="AIRTEL AMOUNT"
                          />
                        </div>

						<div class="alert alert-danger">
                              <div class="alert-text">
                                  <h6 class="text-primary">Total Amount: ₦‎<a id="airteltotal">0</a></h6>
                                  <h6 class="text-success">Total Cashback: ₦‎<a id="airtelcashback">0</a></h6>
                                  <h6 class="text-info">Total Payable: ₦‎<a id="airtelpayable">0</a></h6>
                              </div>
                            </div>
                      </div> 
					</div>
					<div class="row" id="glodiv" style="display:none">
                       <div class="form-group col-12">
						<hr>
                        <label class="text-success">Enter GLO amount</label>
                        <div class="input-group mb-3">
                          <input
                            class="form-control"
                            name="globalcomamount"
                            onkeyup="getglobacomcashback(event)"
                            type="number"
                            placeholder="GLOBACOM AMOUNT"
                          />
                        </div>

						<div class="alert alert-success">
                              <div class="alert-text">
                                  <h6 class="text-primary">Total Amount: ₦‎<a id="glototal">0</a></h6>
                                  <h6 class="text-success">Total Cashback: ₦‎<a id="glocashback">0</a></h6>
                                  <h6 class="text-info">Total Payable: ₦‎<a id="glopayable">0</a></h6>
                              </div>
                            </div>
                      </div>
 
					</div>

					<div class="row" id="etisalatdiv" style="display:none">
                      <div class="form-group col-12">
						<hr>
                        <label class="text-secondary">Enter Etisalat amount</label>
                        <div class="input-group mb-3">
                          <input
                            class="form-control"
                            name="etisalatamount"
                            onkeyup="getetisalatcashback(event)"
                            type="number"
                            placeholder="ETISALAT AMOUNT"
                          />
                        </div>

						<div class="alert alert-primary">
                              <div class="alert-text">
                                  <h6 class="text-primary">Total Amount: ₦‎<a id="etisalattotal">0</a></h6>
                                  <h6 class="text-success">Total Cashback: ₦‎<a id="etisalatcashback">0</a></h6>
                                  <h6 class="text-info">Total Payable: ₦‎<a id="etisalatpayable">0</a></h6>
                              </div>
                        </div>
                      </div>
 
					</div>
					
					<hr>
					<div class="row">
                     <div class="col-sm-12 col-xxl-12">
                        <button
                          type="submit"
                          class="btn btn-primary text-white"
                        >
                          Recharge Now
                        </button>
					</div>

                    </div>
                  </form>
                </div>
              </div>

			  
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> 
  <hr>


				<div class="row layout-top-spacing">

				
                <!-- row opened -->
				<div class="col-xl-12">


<!-- nk-block -->
<div class="nk-block nk-block-lg">
                                         
										 <div class="card card-bordered card-preview">
											 <div class="card-inner">
												 <table class="datatable-init-export nowrap table" data-export-title="Export">
													 <thead>
														 
														<th>ID</th>
														<th>Phone</th>
														<th>Network</th>
														<th>Amount</th>
														<th>Status</th>
														<th>Date</th>
													 </thead>
													 <tbody>
													 @foreach($logs as $data)
													<tr>
														<td>#{{$data->trx}}</td>
														<td class="text-success">{{$data->beneficiary}}</td>
														<td>{{strtoupper($data->network)}}<br>
														</td>

														<td>₦‎{{number_format($data->amount,2)}}</td>

                                                       @if($data->status == 0)
														<td><span class="badge bg-warning badge-pill">Pending</span></td>
														@elseif($data->status == 1)
														<td><span class="badge bg-success badge-pill">Completed</span></td>
														@else
														<td><span class="badge bg-danger badge-pill">Declined</span></td>
														@endif
														<td>{{date(' d M, Y ', strtotime($data->created_at))}} {{date('h:i A', strtotime($data->created_at))}}</td>
													</tr>
											  @endforeach

 
			 </tbody>
		   </table>
		 </div>
 
										 </div><!-- .card-preview -->
									 </div> <!-- nk-block -->
 
  
 
   </div>
  

				</div>
 
 

@push('script')

<script>
	$(document).ready(function() {
	$("#GlobalSearchInput").keyup(function() {
		var div = $('#showSearchDiv');
		if ($("#GlobalSearchInput").val().length > 0) {
		div.show();
		} else {
		div.hide();
		}
	});
	});

	/*
	const [mtnnetwork, GETMTN] = useState(0);
	const [airtelnetwork, GETAIRTEL] = useState(0);
	const [globacomnetwork, GETGLOBACOM] = useState(0);
	const [etisalatnetwork, GETETISALAT] = useState(0);
	const [mtncashback, MTNCAHSBACK] = useState(0);
	const [mtntotal, MTNTOTAL] = useState(0);
	const [airtelcashback, AIRTELCAHSBACK] = useState(0);
	const [airteltotal, AIRTELTOTAL] = useState(0);
	const [globacomcashback, GLOBACOMCAHSBACK] = useState(0);
	const [globacomtotal, GLOBACOMTOTAL] = useState(0);
	const [etisalatcashback, ETISALATCASHBACK] = useState(0);
	const [etisalattotal, ETISALATTOTAL] = useState(0);
     */
    
	  var mtnnetwork;
      var airtelnetwork;
      var globacomnetwork;
      var etisalatnetwork;
	  const DISCOUNT = "{{$discount}}";

	const getnetworks = (event) => {
    try {
	  const phone = event.target.value;
      const strArray = phone.split(",");
      console.log(strArray);
       let mtn = 0;
       let globacom = 0;
       let etisalat = 0;
       let airtel = 0;
       let network = null;
      
       for(let i = 0; i < strArray.length; i++)
      {
        const prefix = strArray[i].substr(0,4);
        const count = strArray[i].length;
          // MTM SWITCH
          if(prefix  === '0803')
          {
              network = 'mtn';
              
                 if(count === 11)
              {
                mtn = mtn + 1;
              }
            
              
          }
          if(prefix  === '0806')
          {
              network = 'mtn';
               if(count === 11)
              {
                mtn = mtn + 1;
              }
          }
          if(prefix  === '0814')
          {
              network = 'mtn';
               if(count === 11)
              {
                mtn = mtn + 1;
              }
          }
          if(prefix  === '0810')
          {
              network = 'mtn';
               if(count === 11)
              {
                mtn = mtn + 1;
              }
          }
          if(prefix  === '0813')
          {
              network = 'mtn';
               if(count === 11)
              {
                mtn = mtn + 1;
              }
          }
          if(prefix  === '0816')
          {
              network = 'mtn';
               if(count === 11)
              {
                mtn = mtn + 1;
              }
          }
          if(prefix  === '0703')
          {
              network = 'mtn';
               if(count === 11)
              {
                mtn = mtn + 1;
              }
          }
          if(prefix  === '0706')
          {
              network = 'mtn';
               if(count === 11)
              {
                mtn = mtn + 1;
              }
          }
          if(prefix  === '0903')
          {
              network = 'mtn';
               if(count === 11)
              {
                mtn = mtn + 1;
              }
          }
          if(prefix  === '0906')
          {
              network = 'mtn';
               if(count === 11)
              {
                mtn = mtn + 1;
              }
          }
         
          // ETISALAT SWITCH
          if(prefix  === '0809')
          {
              network = 'etisalat';
               if(count === 11)
              {
                etisalat = etisalat + 1;
              }
          }
          if(prefix  === '0817')
          {
              network = 'etisalat';
               if(count === 11)
              {
                etisalat = etisalat + 1;
              }
          }
          if(prefix  === '0818')
          {
              network = 'etisalat';
               if(count === 11)
              {
                etisalat = etisalat + 1;
              }
          }
          if(prefix  === '0908')
          {
              network = 'etisalat';
               if(count === 11)
              {
                etisalat = etisalat + 1;
              }
          }
          if(prefix  === '0909')
          {
              network = 'etisalat';
               if(count === 11)
              {
                etisalat = etisalat + 1;
              }
          }
          
          // GLOBACOM SWITCH
          if(prefix  === '0805')
          {
              network = 'glo';
               if(count === 11)
              {
                globacom = globacom + 1;
              }
          }
          if(prefix  === '0807')
          {
              network = 'glo';
               if(count === 11)
              {
                globacom = globacom + 1;
              }
          }
          if(prefix  === '08011')
          {
              network = 'glo';
               if(count === 11)
              {
                globacom = globacom + 1;
              }
          }
          if(prefix  === '0815')
          {
              network = 'glo';
               if(count === 11)
              {
                globacom = globacom + 1;
              }
          }
          if(prefix  === '07015')
          {
              network = 'glo';
               if(count === 11)
              {
                globacom = globacom + 1;
              }
          }
          if(prefix  === '0905')
          {
              network = 'glo';
               if(count === 11)
              {
                globacom = globacom + 1;
              }
          }
          // AIRTEL SWITCH
          if(prefix  === '0802')
          {
              network = 'airtel';
               if(count === 11)
              {
                airtel = airtel + 1;
              }
          }
          if(prefix  === '0808')
          {
              network = 'airtel';
               if(count === 11)
              {
                airtel = airtel + 1;
              }
          }
          if(prefix  === '0812')
          {
              network = 'airtel';
               if(count === 11)
              {
                airtel = airtel + 1;
              }
          }
          if(prefix  === '0708')
          {
              network = 'airtel';
               if(count === 11)
              {
                airtel = airtel + 1;
              }
          }
          if(prefix  === '0701')
          {
              network = 'airtel';
               if(count === 11)
              {
                airtel = airtel + 1;
              }
          }
          if(prefix  === '0902')
          {
              network = 'airtel';
               if(count === 11)
              {
                airtel = airtel + 1;
              }
          }
          if(prefix  === '0901')
          {
              network = 'airtel';
               if(count === 11)
              {
                airtel = airtel + 1;
              }
          }
          if(prefix  === '0907')
          {
              network = 'airtel';
               if(count === 11)
              {
                airtel = airtel + 1;
              }
          }
          else
          {
              network = "unknown";
          }
          // END FOREACH
      }
      // console.log(mtn);
      document.getElementById("mtnnet").innerHTML = mtn;
      document.getElementById("airtelnet").innerHTML = airtel;
      document.getElementById("globacomnet").innerHTML = globacom;
      document.getElementById("etisalatnet").innerHTML = etisalat;

       mtnnetwork = mtn;
       airtelnetwork = airtel;
       globacomnetwork = globacom;
       etisalatnetwork = etisalat;
	  // getmtncashback(mtnnetwork);

	    var mtnshow = $('#mtndiv');
		if (mtnnetwork > 0)
		{
			mtnshow.show();
		} else {
			mtnshow.hide();
		}

		var airtelshow = $('#airteldiv');
		if (airtelnetwork > 0)
		{
			airtelshow.show();
		} else {
			airtelshow.hide();
		}

		var gloshow = $('#glodiv');
		if (globacomnetwork > 0)
		{
			gloshow.show();
		} else {
			gloshow.hide();
		}

		var etisalatshow = $('#etisalatdiv');
		if (etisalatnetwork > 0)
		{
			etisalatshow.show();
		} else {
			etisalatshow.hide();
		}

     } catch (error) {
      console.error(error);
    }
  }; 
  const getmtncashback = (e) => {
    try {
     const amount = e.target.value*mtnnetwork;
     const discount = DISCOUNT/100*amount;
	 document.getElementById("mtntotal").innerHTML = amount;
	 document.getElementById("mtncashback").innerHTML = discount;
	 document.getElementById("mtnpayable").innerHTML = amount-discount;
     } catch (error) {
      console.error(error);
    }
  };  

  const getairtelcashback = (e) => {
    try {
     const amount = e.target.value*airtelnetwork;
     const discount = DISCOUNT/100*amount;
	 document.getElementById("airteltotal").innerHTML = amount;
	 document.getElementById("airtelcashback").innerHTML = discount;
	 document.getElementById("airtelpayable").innerHTML = amount-discount;
     } catch (error) {
      console.error(error);
    }
  };  

  const getglobacomcashback = (e) => {
    try {
     const amount = e.target.value*globacomnetwork;
     const discount = DISCOUNT/100*amount;
	 document.getElementById("glototal").innerHTML = amount;
	 document.getElementById("glocashback").innerHTML = discount;
	 document.getElementById("glopayable").innerHTML = amount-discount;
     } catch (error) {
      console.error(error);
    }
  };  

  const getetisalatcashback = (e) => {
    try {
     const amount = e.target.value*etisalatnetwork;
     const discount = DISCOUNT/100*amount;
	 document.getElementById("etisalattotal").innerHTML = amount;
	 document.getElementById("etisalatcashback").innerHTML = discount;
	 document.getElementById("etisalatpayable").innerHTML = amount-discount; 
     } catch (error) {
      console.error(error);
    }
  };  
</script>
@endpush
@endsection 