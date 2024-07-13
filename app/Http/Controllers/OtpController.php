<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\tblUserOtp;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;

class OtpController extends Controller
{   
    public function showConfirmationForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'contact' => 'required|numeric|min:11|regex:/^09\d{9}$/',
            'bday' => [
                'required',
                'date',
                'before_or_equal:' . Carbon::now()->subYears(18)->format('Y-m-d'),
            ], // Must be 18 years old or older
            'address' => 'required|string|max:255',
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                'confirmed', // Ensure 'password_confirmation' field is present and matches 'password'
            ],
        ], [
            'bday.before_or_equal' => 'You must be 18 years old or older to register.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $name = $request->input('name');
        $contact = $request->input('contact');
        $bday = $request->input('bday');
        $address = $request->input('address');
        $email = $request->input('email');
        $password = $request->input('password');
        $password_confirmation = $request->input('password_confirmation');

        // Now you have access to all the form inputs
        $newOtp = new tblUserOtp();
        $newOtp->userId = $contact;
        $newOtp->otp = rand(1000,9999);
        $newOtp->expired_at = Carbon::now()->addMinutes(5);
        $newOtp->save();

        $otp = tblUserOtp::where('userId', $contact)->first();
        $otpCode = $otp->otp;

        //nexmo
        // $originalNumber = $contact;
        // $originalNumber = ltrim($originalNumber, '0');

        // $newNumber = "63".$originalNumber;

        // $basic  = new Basic("0b084dc3", "8IiqVm2JHUOUBwLx");
        // $client = new Client($basic);
        // $client->sms()->send(
        //     new SMS($newNumber, "ECABS", '[ECABS] Your OTP Confirmation Code:'. $otpCode)
        // );

        // Pass form inputs to the view
        return view('auth.authConfirmation', compact(
            'name', 'contact', 'bday', 'address', 'email', 'password', 'password_confirmation', 'otpCode'
        ));
    }

    public function finalConfirmation(Request $request){
        $contact = $request->input('contact');
        $otp = $request->input('otp');

        $findOtp = tblUserOtp::where('userId', $contact)->first();
        if(!$findOtp){
            return response()->json(['message' => 'OTP confirmation is missing!!'], 404);
        }
        $numberOtp = $findOtp->otp;

        if($otp !== $numberOtp){
            return response()->json(['message' => 'OTP does not match!!'], 404);
        }
    }
}
