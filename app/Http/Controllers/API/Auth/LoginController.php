<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //

    public function login(Request $request) : Response
    {
        $credentials = $request->only('username','password');

        if(Auth::guard('api')->attempt($credentials)){
            return response(Auth::guard('api')->user(),200);
        }
        abort(401);
    }

    public function logout(){
        Auth::guard('api')->logout();
        return response(null,200);
    }
}
