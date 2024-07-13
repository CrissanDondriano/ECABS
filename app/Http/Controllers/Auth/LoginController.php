<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\tblRecentActivity;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ], [
            'email.required' => 'The email field is required.',
            'email.email' => 'The email format is invalid.',
            'email.exists' => 'The provided email does not exist.',
            'password.required' => 'The password field is required.',
        ]);

        if (auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))) {
            // Get the user's IP address
            $ipAddress = $request->ip();

            // Get the user's device information (You may need to use a package for this)
            $deviceInfo = $request->header('User-Agent');

            // Get the logging user Id
            $userId = auth()->user()->id;

            $this->loginActivityLogging($ipAddress,$deviceInfo,$userId);

            if (auth()->user()->type == 'admin') {
                return redirect()->route('admin.home');
            } else if (auth()->user()->type == 'staff') {
                return redirect()->route('staff.home');
            } else {
                return redirect()->route('home');
            }
        } else {
            // return redirect()->route('login')
            //     ->with('error','Email-Address And Password Are Wrong.');
            return redirect()->back()->withErrors(['password' => 'Incorrect password.']);
        }

    }

    public function loginActivityLogging($ip,$info,$id)
    {
        $patterns = [
            '/(iPhone|iPad|iPod)/i' => 'iOS Device',
            '/(Android|Mobile)/i' => 'Android Device',
            '/Windows Phone/i' => 'Windows Phone',
            '/Windows NT 10/i' => 'Windows 10',
            '/Macintosh/i' => 'Macintosh',
            '/Linux/i' => 'Linux',
            '/BlackBerry/i' => 'BlackBerry',
            '/Samsung/i' => 'Samsung Device',
            '/Sony/i' => 'Sony Device',
            // Add more patterns for other devices as needed
        ];

        $deviceName = 'Unknown Device'; // Default value if no match is found

        // Iterate through patterns and find the matching device name
        foreach ($patterns as $pattern => $name) {
            if (preg_match($pattern, $info)) {
                $deviceName = $name;
                break;
            }
        }

        $auditLog = new tblRecentActivity();
        $auditLog->device = $deviceName;
        $auditLog->location = "";
        $auditLog->ip = $ip;
        $auditLog->userId = $id;
        $auditLog->save();
    }
}
