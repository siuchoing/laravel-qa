<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    // For login endpoint
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $request->request->add([
            'grant_type' => 'password',
            'client_id' => 2,
            'client_secret' => 'ucH20VlC2OzW2SdAFEilrCLXO83IBPK1Fho8eWId',
            'username' => $request->username,
            'password' => $request->password,
        ]);

        $tokenRequest = Request::create(env('APP_URL') . '/oauth/token', 'post');

        $response = Route::dispatch($tokenRequest);

        return $response;
    }

    // For logout endpoint
    public function destroy(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->noContent();
    }
}
