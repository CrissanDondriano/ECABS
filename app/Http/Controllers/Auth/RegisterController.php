<?php

namespace App\Http\Controllers\Auth;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\tblUserOtp;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $otp = $data['otp'];
        $contact = $data['contact'];

        $exist = tblUserOtp::where('userId', $contact)->where('otp', $otp)->first();
        
        if(!$exist){
            throw ValidationException::withMessages([
                'otp' => ['The provided OTP is invalid.'],
            ]);
        }

        // Check if the OTP has expired
        if ($exist->expired_at && Carbon::now()->gt($exist->expired_at)) {
            throw ValidationException::withMessages([
                'otp' => ['The provided OTP has expired Please redo the Register.'],
            ]);
        }

        return Validator::make($data, [
            'otp' => 'required|exists:tbl_user_otps,otp',
            // 'name' => ['required', 'string', 'max:255', 'unique:users'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'contact' => ['required', 'min:11', 'regex:/^09\d{9}$/', 'numeric'],
            // 'bday' => [
            //     'required',
            //     'date',
            //     'before_or_equal:' . Carbon::now()->subYears(18)->format('Y-m-d'),
            // ],
            // 'address' => ['required', 'string', 'max:255'],
            // 'password' => [
            //     'required',
            //     Password::min(8)
            //         ->letters()
            //         ->mixedCase()
            //         ->numbers()
            //         ->symbols()
            //         ->uncompromised(),
            // ],
        ], [
            'otp.required' => 'The OTP field is required.',
            'otp.exists' => 'The provided OTP is invalid.',
            // 'bday.before_or_equal' => 'Your age is not qualified for registration.',
            // Add other custom error messages as needed
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $otp = $data['otp'];
        $contact = $data['contact'];

        $exist = tblUserOtp::where('userId', $contact)->where('otp', $otp)->first();
        
        if(!$exist){
            throw ValidationException::withMessages([
                'otp' => ['The provided OTP is invalid.'],
            ]);
        }

        $exist->delete();

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'contact' => $data['contact'],
            'birthdate' => $data['bday'],
            'address' => $data['address'],
            'password' => Hash::make($data['password']),
            'endCooldownDate' => '',
            'last_online' => ''
        ]);
    }
}
