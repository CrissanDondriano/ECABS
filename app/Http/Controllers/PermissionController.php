<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class PermissionController extends Controller
{
    public function addUser(Request $request)
    {
        // Validate the request data
        $request->validate([
            'fullName' => 'required',
            'address' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'type' => 'required',
            'newPass' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'confirmPass' => 'required',
        ]);

        $newPass = $request->input('newPass');
        $confirmPass = $request->input('confirmPass');

        if($newPass !== $confirmPass){
            return response()->json(['message' => 'The password and confirm password does not match!!'], 404);
        }

        $user = new User();
        $user->name = $request->input('fullName');
        $user->address = $request->input('address');
        $user->email = $request->input('email');
        $user->password = bcrypt($confirmPass);
        $user->type = $request->input('type'); // Assuming '1' for admin and '2' for staff
        $user->contact = "";
        $user->birthdate = "";
        $user->endCooldownDate = "";
        $user->last_online = "";
        $user->save();
        
        // Additional logic (e.g., validation, response) as needed
    }

    public function updateUser(Request $request)
    {
        // Validate the request data
        $request->validate([
            'fullName' => 'required',
            'address' => 'required',
            'email' => ['required', 'string', 'email', 'max:255'],
            'type' => 'required'
            // 'currentPass' => 'required',
            // 'newPass' => [
            //     'required',
            //     Password::min(8)
            //         ->letters()
            //         ->mixedCase()
            //         ->numbers()
            //         ->symbols()
            //         ->uncompromised()
            // ],
            // 'confirmPass' => 'required',
        ]);

        $userId = $request->input('id');
        // $currentPass = $request->input('currentPass');
        // $newPass = $request->input('newPass');
        // $confirmPass = $request->input('confirmPass');

        $userExist = User::find($userId);

        if (!$userExist) {
            return response()->json(['message' => 'User not exist'], 404);
        }

        // if(password_verify($currentPass, $userExist->password)){
        //     if($newPass === $confirmPass){
        //         // Logic to update user information
        //         $userExist->name = $request->input('fullName');
        //         $userExist->address = $request->input('address');
        //         $userExist->email = $request->input('email');
        //         $userExist->type = $request->input('type');

        //         $userExist->save();
        //     }else{
        //         return response()->json(['message' => 'The new and confirm password does not match'], 404);
        //     }
        // }else{
        //     return response()->json(['message' => 'The password is incorrect'], 404);
        // }

        // Logic to update user information
        $userExist->name = $request->input('fullName');
        $userExist->address = $request->input('address');
        $userExist->email = $request->input('email');
        $userExist->type = $request->input('type');

        $userExist->save();
    }

    public function deleteUser($userId)
    {
        $user = User::findorfail($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();
    }

}
