<?php

namespace App\Http\Controllers\Auth\admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
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
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */    
    public function __construct()
    {
        $this->middleware("guest:admin",['except'=>['adminlogout']]);
    }
    public function showloginform(){
        return view('auth.admin.login');
    }
    public function login(Request $request){
        $this->validate(
            $request,
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
        );
        if(Auth::guard('admin')->attempt(['email'=>$request->email,'password' => $request->password],false)):
            return redirect()->intended(route('admin'));
        else:
            return redirect()->back()->with('adminloginmsg',"Invalid Values");
        endif;
    }
    public function adminlogout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
