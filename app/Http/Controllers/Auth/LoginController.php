<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Returns the column name used for login
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Handles redirection after login based on user role
     *
     * @param \Request $request
     * @param object $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function authenticated($request, $user)
    {
        switch ($user->role_id) {
            case 1:
                return redirect('reports'); //redirect to admin panel
                break;
            case 2:
                return redirect('retaildashboard');
            case 3:
                break;
            case 4:
                return \Redirect::route('shipments.index');
            case 5:
                return \Redirect::route('dashboard.warehouse');
            case 6:
                break;
            case 7:
                break;
            case 8:
                return redirect('users'); //redirect to admin panel
            case 9:
                break;
        }
        return redirect('login'); //redirect to standard user homepage
    }
}
