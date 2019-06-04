<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/display';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    //redirect after login
    protected function authenticated($request, $user){
        switch ($user->role_id) {
            case 1:
                break;
            case 2:
                return redirect('users'); //redirect to admin panel
                break;
            case 3:
                break;
            case 4:
                $request->session()->put('warehouse_id', $user->warehouse_id);
                return redirect('shipments');
                break;
            case 5:
                break;
            case 6:
                break;
            case 7:
                break;
            case 8:
                break;
            case 9:
                break;
        }
        return redirect('login'); //redirect to standard user homepage
    }

    //column that used for login
    public function username()
    {
        return 'username';
    }
}
