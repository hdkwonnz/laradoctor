<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request; ////
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
    protected $redirectTo = '/home';

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
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        ////$permissionNames = auth()->user()->getPermissionNames();

        $roleNames = auth()->user()->getRoleNames();
               
        if ($roleNames == '["admin"]') {
            return redirect('admin/index');
        }elseif ($roleNames == '["doctor"]') {
            return redirect('doctor/index');
        }
        
        // $patientId = auth()->user()->patient_id;

        // if ($patientId == null){           
        //     Auth::logout();
        //     return redirect('/login');
            
        // }else{
        //     return redirect('patient/index');
        // }
        
        return $this->authenticated($request, $this->guard()->user()) //original
                 ?: redirect()->intended($this->redirectPath());//original
    }
}
