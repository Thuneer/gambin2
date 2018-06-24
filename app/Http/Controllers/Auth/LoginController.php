<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

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

    use AuthenticatesUsers {
        logout as performLogout;
    }

    public function logout(Request $request)
    {
        $this->performLogout($request);

        return redirect('admin/login');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if ( $user->role_id > 1 ) {// do your margic here
            return redirect('admin');
        }

        return redirect('/');
    }

    public function adminLogin(Request $request)
    {

        // setup rules for validation of user input
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ];

        // run validation, if this does not pass Laravel will redirect back with input and errors
        $this->validate($request, $rules);

        // Check if user with email exists
        $userData = User::where('email', $request->email)->first();

        if ($userData) {

            if (Hash::check($request->password, $userData->password)) {

                if ($userData->hasPermissionTo('access admin panel')) {

                    $remember = $request->input('remember');

                    if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember))
                        return Redirect('admin');
                    else
                        return Redirect::back()->withInput()->withErrors(['Something went wrong']);

                } else {
                    return Redirect::back()->withInput()->withErrors(['No permission']);
                }

            } else {
                return Redirect::back()->withInput()->withErrors(['password' => 'Incorrect password.']);
            }

        } else {
            return Redirect::back()->withInput()->withErrors(['email' => 'A user with this e-mail does not exist.']);
        }

    }
}
