<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Rules\Phone;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    // NEW REGiSTER FUNCTIONS \\
    public function step1(Request $request)
    {

      session()->put('step1', $request->type);
      $step1 = session()->get('step1');
      //session()->forget('step1');
      if($request->session()->has('step1'))
      {
        return  redirect()->route('auth.register.step2');
      }
      // return redirect()->back()->with('error', 'Invalid Process');
      return redirect()->route('register')->with('error', 'Invalid Process');
    }

    public function step2(Request $request)
    {
        if(!$request->session()->has('step1'))
        {
            return redirect()->route('register')->with('error', 'Invalid Process');
        }
        //return session()->get('step2type');


        if($request->type)
        {
            $email = $request->value;
            $phone = $request->value;
            $emailexist = User::whereEmail($email)->first();
            $phoneexist = User::wherePhone($phone)->first();
            if($emailexist)
            {
                return redirect()->back()->with('error', 'There is an existing customer with the email');
            }
            if($phoneexist)
            {
                return redirect()->back()->with('error', 'There is an existing customer with the phone');
            }

            session()->put('step2type', $request->type);
            session()->put('step2value', $request->value);
            session()->put('step3otp', rand(343434,895843));

            // SEND OTP \\
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://fagopay-coreapi-development.herokuapp.com/api/v1/verify/bussiness-email-otp',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'mode: live',
                'mode: live',
            ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            return  redirect()->route('auth.register.step3');
        }
        return view('auth.step2');
    }

    public function step3(Request $request)
    {
        if(!$request->session()->has('step2type'))
        {
            return redirect()->route('register')->with('error', 'Invalid Process');
        }
        if($request->f6)
        {
            $code =  $request->f1.$request->f2.$request->f3.$request->f4.$request->f5.$request->f6;
            if(session()->get('step3otp') != $code)
            {
                return redirect()->back()->with('error', 'Invalid OTP Code, please check and try again');
            }
            else
            {
                session()->put('step3otpsuccess', $code);
                return  redirect()->route('auth.register.step4');
            }
        }
        return view('auth.step3');
    }

    public function step4(Request $request)
    {
        if(!$request->session()->has('step3otpsuccess'))
        {
            return redirect()->route('register')->with('error', 'Invalid OTP Process');
        }
        if($request->lastname)
        {
            //return session()->get('step2type');
            if(session()->get('step2type') == 'email')
            {
                $email = session()->get('step2value');
            }
            else
            {
                $email = $request->email;
            }
            if(session()->get('step2type') == 'phone')
            {
                $phone = session()->get('step2value');
            }
            else
            {
                $phone = $request->phone;
            }
            session()->put('firstname', $request->firstname);
            session()->put('lastname', $request->lastname);
            session()->put('email', $email);
            session()->put('phone', $phone);
            $emailexist = User::whereEmail($email)->first();
            $phoneexist = User::wherePhone($phone)->first();
            if($emailexist)
            {
                return redirect()->back()->with('error', 'There is an existing customer with the email');
            }
            if($phoneexist)
            {
                return redirect()->back()->with('error', 'There is an existing customer with the phone');
            }

            return  redirect()->route('auth.register.step5');
        }
        return view('auth.step4');

    }

    public function step5(Request $request)
    {
        if(!$request->session()->has('lastname'))
        {
            return redirect()->route('register')->with('error', 'Invalid OTP Process');
        }
        if($request->password)
        {
            if($request->password != $request->confirmpassword)
            {
                return redirect()->back()->with('error', 'Password does not match');
            }
            //return session()->get('step1');
            if (session()->get('step1')=="2") {
                $register = User::create([
                    'name' => session()->get('firstname').' '.session()->get('firstname'),
                    'email' => session()->get('email'),
                    'phone' => session()->get('phone'),
                    'username' => $this->usernameGenerate(session()->get('email')),
                    'password' => Hash::make($request->password),
                    //'currency_id' => $data['country'],
                    'currency_id' => 5,
                    'meta' => [
                        "business_name" => null
                    ]
                ]);
            }
            else{
                $register = User::create([
                    'name' => session()->get('firstname').' '.session()->get('firstname'),
                    'email' => session()->get('email'),
                    'phone' => session()->get('phone'),
                    'username' => $this->usernameGenerate(session()->get('email')),
                    'password' => Hash::make($request->password),
                     //'currency_id' => $data['country']
                     'currency_id' => 5
                ]);
            }
            //return 34;
            return redirect()->route('login')->with('success', 'Registratioin Successful. Please proceed to login');

           // return redirect()->route('auth.register.step6');
        }
        return view('auth.step5');

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if ($data['type']=="2") {
        return Validator::make($data, [
            'business_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', new Phone],
            'country' => ['required', 'exists:currencies,id'],
            'password' => ['required', Password::default()],
            'agree' => ['accepted']
        ], [
            'agree.accepted' => __('You have to agree with our terms & conditions')
        ]);
    }

    else{
        return Validator::make($data, [
            'namee' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'country' => ['required', 'exists:currencies,id'],
            'password' => ['required', Password::default()],
            'agree' => ['accepted']
        ], [
            'agree.accepted' => __('You have to agree with our terms & conditions')
        ]);
    }

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if ($data['type']=="2") {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'username' => $this->usernameGenerate($data['email']),
            'password' => Hash::make($data['password']),
            'currency_id' => $data['country'],
            'meta' => [
                "business_name" => $data['business_name']
            ]
        ]);
    }
    else{
        return User::create([
            'name' => $data['namee'],
            'email' => $data['email'],
            'username' => $this->usernameGenerate($data['email']),
            'password' => Hash::make($data['password']),
            'currency_id' => $data['country']
        ]);
    }

    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([
                'message' => __('Registration Successful'),
                'redirect' => route('user.set-bank.index')
            ], 201)
            : redirect()->route('user.set-bank.index');

    }

    public function usernameGenerate($email)
    {
        $explodeEmail = explode('@', $email);
        $username = $explodeEmail[0];
        $count_username = User::where('username', $username)->count();
        if ($count_username > 0) {
            $username = $username . $count_username + 1;
        }

        return $username;
    }

    public function showRegistrationForm()
    {
        $currencies = Currency::whereStatus(1)
            ->groupBy('country_name')
            ->pluck('country_name', 'id');
        return view('auth.register', compact('currencies'));
    }
}
