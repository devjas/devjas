<?php

namespace App\Http\Controllers\Auth;

use Validator;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AdminAuthController extends Controller
{
    use AuthenticatesUsers;
    
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin-login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'logoutAdmin']);
    }

    public function postLogin(Request $request) {
        
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(Auth::guard('admin')->attempt([
            'email'=>$request->email,
            'password'=>$request->password,
            'is_active'=>1])) {
            
            $request->session()->regenerate();
            
            return redirect()->intended(route('admin-dashboard'));
        }

        return back()->withErrors($credentials);
    }

    public function getLogin() {
        return view('concert-admin.auth.admin-login');
    }

    public function logoutAdmin(Request $request) {
        
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
