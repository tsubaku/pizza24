<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

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

    /**
     * The user has been authenticated.
     * (Overridden method)
     *
     * @return mixed
     */
    protected function authenticated()
    {
        $sessionId = Cookie::get('session');
        $userId = auth()->user()->id;
        $cart = Cart::where('user_id', $userId)->first();
        if ($cart->session_id != $sessionId) {

            #Delete cart for non authorized user
            Cart::where('session_id', $sessionId)->forceDelete();

            #Update session_if for Authorize user
            $cart->session_id = $sessionId;
            $cart->save();
        }
    }
}
