@extends('layouts.user.app')

@section('content') 
@push('style')
     
    <style type="text/css">
    * {
  box-sizing: border-box;
}
 
.title {
  max-width: 400px;
  margin: auto;
  text-align: center;
  font-family: "Poppins", sans-serif;
}
.title h3 {
  font-weight: bold;
}
.title p {
  font-size: 12px;
  color: #118a44;
}
.title p.msg {
  color: initial;
  text-align: initial;
  font-weight: bold;
}

.otp-input-fields {
  margin: auto;
  background-color: white;
  box-shadow: 0px 0px 8px 0px #02025044;
  max-width: 400px;
  width: auto;
  display: flex;
  justify-content: center;
  gap: 10px;
  padding: 40px;
}
.otp-input-fields input {
  height: 40px;
  width: 40px;
  background-color: transparent;
  border-radius: 4px;
  border: 1px solid #2f8f1f;
  text-align: center;
  outline: none;
  font-size: 16px;
  /* Firefox */
}
.otp-input-fields input::-webkit-outer-spin-button, .otp-input-fields input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
.otp-input-fields input[type=number] {
  -moz-appearance: textfield;
}
.otp-input-fields input:focus {
  border-width: 2px;
  border-color: #287a1a;
  font-size: 20px;
}

.result {
  max-width: 400px;
  margin: auto;
  padding: 24px;
  text-align: center;
}
.result p {
  font-size: 24px;
  font-family: "Antonio", sans-serif;
  opacity: 1;
  transition: color 0.5s ease;
}
.result p._ok {
  color: green;
}
.result p._notok {
  color: red;
  border-radius: 3px;
}
    </style>
@endpush
@push('script')
<script>
 var otp_inputs = document.querySelectorAll(".otp__digit")
var mykey = "0123456789".split("")
otp_inputs.forEach((_)=>{
  _.addEventListener("keyup", handle_next_input)
})
function handle_next_input(event){
  let current = event.target
  let index = parseInt(current.classList[1].split("__")[2])
  current.value = event.key
  
  if(event.keyCode == 8 && index > 1){
    current.previousElementSibling.focus()
  }
  if(index < 6 && mykey.indexOf(""+event.key+"") != -1){
    var next = current.nextElementSibling;
    next.focus()
  }
  var _finalKey = ""
  for(let {value} of otp_inputs){
      _finalKey += value
  }
  if(_finalKey.length == 6){
    document.querySelector("#_otp").classList.replace("_notok", "_ok")
    document.querySelector("#_otp").innerText = _finalKey
  }else{
    document.querySelector("#_otp").classList.replace("_ok", "_notok")
    document.querySelector("#_otp").innerText = _finalKey
  }
}
</script>
@endpush   

<head>
  <title></title>
  <!--[if !mso]><!-- -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!--<![endif]-->
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <style type="text/css">
    #outlook a {
      padding: 0;
    }
    .ReadMsgBody {
      width: 100%;
    }
    .ExternalClass {
      width: 100%;
    }
    .ExternalClass * {
      line-height: 100%;
    }
    body {
      margin: 0;
      padding: 0;
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
    }
    table,
    td {
      border-collapse: collapse;
      mso-table-lspace: 0pt;
      mso-table-rspace: 0pt;
    }
    img {
      border: 0;
      height: auto;
      line-height: 100%;
      outline: none;
      text-decoration: none;
      -ms-interpolation-mode: bicubic;
    }
    p {
      display: block;
      margin: 13px 0;
    }
  </style>
  <!--[if !mso]><!-->
  <style type="text/css">
    @media only screen and (max-width: 480px) {
      @-ms-viewport {
        width: 320px;
      }
      @viewport {
        width: 320px;
      }
    }
  </style> 
  <link
    href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700"
    rel="stylesheet"
    type="text/css"
  />
  <style type="text/css">
    @import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);
  </style>
  <!--<![endif]-->
  <style type="text/css">
    @media only screen and (min-width: 480px) {
      .mj-column-per-100,
      * [aria-labelledby="mj-column-per-100"] {
        width: 100% !important;
      }
    }
  </style>
</head>
<body >
  <div >
    <!--[if mso | IE]>
      <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="640" align="center" style="width:640px;">
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->
    <style type="text/css">
      html,
      body,
      * {
        -webkit-text-size-adjust: none;
        text-size-adjust: none;
      }
      a {
        color: #1eb0f4;
        text-decoration: none;
      }
      a:hover {
        text-decoration: underline;
      }
    </style>
    
    <div
      style="
        max-width: 640px;
        margin: 0 auto;
        box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.1);
        border-radius: 4px;
        overflow: hidden;
      "
    >
      <div
        style="
          margin: 0px auto;
          max-width: 640px;
          background: #7289da
            url(https://cdn.discordapp.com/email_assets/f0a4cc6d7aaa7bdf2a3c15a193c6d224.png)
            top center / cover no-repeat;
        "
      >
      
        <!--[if mso | IE]>
      <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:640px;">
        <v:fill origin="0.5, 0" position="0.5,0" type="tile" src="https://cdn.discordapp.com/email_assets/f0a4cc6d7aaa7bdf2a3c15a193c6d224.png" />
        <v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0">
      <![endif]-->
        <table
          role="presentation"
          cellpadding="0"
          cellspacing="0"
          style="
            font-size: 0px;
            width: 100%;
            background: #7289da
              url(https://cdn.discordapp.com/email_assets/f0a4cc6d7aaa7bdf2a3c15a193c6d224.png)
              top center / cover no-repeat;
          "
          align="center"
          border="0"
          background="https://cdn.discordapp.com/email_assets/f0a4cc6d7aaa7bdf2a3c15a193c6d224.png"
        >
          <tbody>
            <tr>
              <td
                style="
                  text-align: center;
                  vertical-align: top;
                  direction: ltr;
                  font-size: 0px;
                  padding: 57px;
                "
              >
                <!--[if mso | IE]>
      <table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:undefined;width:640px;">
      <![endif]-->
                <div
                  style="
                    cursor: auto;
                    color: white;
                    font-family: Whitney, Helvetica Neue, Helvetica, Arial,
                      Lucida Grande, sans-serif;
                    font-size: 26px;
                    font-weight: 600;
                    line-height: 36px;
                    text-align: center;
                  "
                >
                 Verify BVN
                </div>
                <!--[if mso | IE]>
      </td></tr></table>
      <![endif]-->
              </td>
            </tr>
          </tbody>
        </table>
        <!--[if mso | IE]>
        </v:textbox>
      </v:rect>
      <![endif]-->
      </div>
      <!--[if mso | IE]>
      </td></tr></table>
      <![endif]-->
      <!--[if mso | IE]>
      <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="640" align="center" style="width:640px;">
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->
      <div style="margin: 0px auto; max-width: 640px; background: #ffffff">
        <table
          role="presentation"
          cellpadding="0"
          cellspacing="0"
          style="font-size: 0px; width: 100%; background: #ffffff"
          align="center"
          border="0"
        >
          <tbody>
            <tr>
              <td
                style="
                  text-align: center;
                  vertical-align: top;
                  direction: ltr;
                  font-size: 0px;
                  padding: 40px 70px;
                "
              >
                <!--[if mso | IE]>
      <table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;width:640px;">
      <![endif]-->
                <div
                  aria-labelledby="mj-column-per-100"
                  class="mj-column-per-100 outlook-group-fix"
                  style="
                    vertical-align: top;
                    display: inline-block;
                    direction: ltr;
                    font-size: 13px;
                    text-align: left;
                    width: 100%;
                  "
                >
                  <table
                    role="presentation"
                    cellpadding="0"
                    cellspacing="0"
                    width="100%"
                    border="0"
                  >
                    <tbody>
                      
                      <tr>
                        <td
                          style="
                            word-break: break-word;
                            font-size: 0px;
                            padding: 10px 25px;
                          "
                          align="center"
                        >
                          <table
                            role="presentation"
                            cellpadding="0"
                            cellspacing="0"
                            style="border-collapse: separate"
                            align="center"
                            border="0"
                          >
                            
                          </table>
                        </td>
                      </tr>

                      <tr>
                          <td
                            style="
                              word-break: break-word;
                              font-size: 0px;
                              padding: 10px 25px;
                            "
                            align="center"
                          >
                            <table
                              role="presentation"
                              cellpadding="0"
                              cellspacing="0"
                              style="border-collapse: separate"
                              align="center"
                              border="0"
                            >
                              <tbody>
                                @if(!session()->get('bvn'))
                                <form action="{{ route('user.request.bvn') }}" method="post" class="">
                                @csrf
                                  <center>
                                  <div class="title">
                                    <h3>ENTER BVN</h3>
                                    <p class="info">Please enter your bvn number below to verify your BVN</p>
                                    <p class="msg">An sms will be send to your registered BVN number</p>
                                  </div>
                                 </center>
                                 <div class="form-group">
                                   <input type="number" class="form-control">
                                 </div> 
                                 
                                 <div class="form-group">
                                  <button class="btn btn-primary" type="submit">Proceed</button>
                                </div> 
                                
                                </form>
                                @else
                                <form action="javascript: void(0)" class="otp-form" name="otp-form">
                                  <center>
                                  <div class="title">
                                    <h3>OTP VERIFICATION</h3>
                                    <p class="info">An otp has been sent to your</p>
                                    <p class="msg">Please enter OTP to verify</p>
                                  </div>
                                 </center>
                                  <div class="otp-input-fields">
                                    <input type="number" class="otp__digit otp__field__1">
                                    <input type="number" class="otp__digit otp__field__2">
                                    <input type="number" class="otp__digit otp__field__3">
                                    <input type="number" class="otp__digit otp__field__4">
                                    <input type="number" class="otp__digit otp__field__5">
                                    <input type="number" class="otp__digit otp__field__6">
                                  </div>
                                  
                                  <div class="result"><p id="_otp" class="_notok">855412</p></div>
                                </form>
                                @endif
                              </tbody>

                               
                            </table>
                          </td>
                        </tr>
                    </tbody>
                  </table>
                </div>
                <!--[if mso | IE]>
      </td></tr></table>
      <![endif]-->
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!--[if mso | IE]>
      </td></tr></table>
      <![endif]-->
      <!--[if mso | IE]>
      <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="640" align="center" style="width:640px;">
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->
    </div>
    <div style="margin: 0px auto; max-width: 640px; background: transparent">
      <table
        role="presentation"
        cellpadding="0"
        cellspacing="0"
        style="font-size: 0px; width: 100%; background: transparent"
        align="center"
        border="0"
      >
        <tbody>
          <tr>
            <td
              style="
                text-align: center;
                vertical-align: top;
                direction: ltr;
                font-size: 0px;
                padding: 0px;
              "
            >
              <!--[if mso | IE]>
      <table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;width:640px;">
      <![endif]-->
              <div
                aria-labelledby="mj-column-per-100"
                class="mj-column-per-100 outlook-group-fix"
                style="
                  vertical-align: top;
                  display: inline-block;
                  direction: ltr;
                  font-size: 13px;
                  text-align: left;
                  width: 100%;
                "
              >
                <table
                  role="presentation"
                  cellpadding="0"
                  cellspacing="0"
                  width="100%"
                  border="0"
                >
                  <tbody>
                    <tr>
                      <td style="word-break: break-word; font-size: 0px">
                        <div style="font-size: 1px; line-height: 12px">
                          &nbsp;
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!--[if mso | IE]>
      </td></tr></table>
      <![endif]-->
            </td>
          </tr>
        </tbody>
      </table>
    </div>
     
  </div>
</body>
 
  @endsection
  