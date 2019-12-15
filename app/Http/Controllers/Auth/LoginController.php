<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Route;
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

    //////////////////
    //Client ID: 1
    //Client secret: jsbYfXl0Bwri0DQtMAxPoluS32rpiRh62yrLbDF8
    //Password grant client created successfully.
    //Client ID: 2
    //Client secret: ucH20VlC2OzW2SdAFEilrCLXO83IBPK1Fho8eWId
    ////////////////////////////////////////////////////////////
//    public function getToken(Request $request)
//    {
//        $request->request->add([
//            'grant_type' => 'password',
//            'client_id' => 2,
//            'client_secret' => 'ucH20VlC2OzW2SdAFEilrCLXO83IBPK1Fho8eWId',
//            'username' => $request->username,
//            'password' => $request->password,
//        ]);
//
//        // make sure APP_URL = http://localhost:8000 in .env
//        $requestToken = Request::create(env('APP_URL') . '/oauth/token', 'post');
//        $response = Route::dispatch($requestToken);
//
//        return $response;
//    }
}
