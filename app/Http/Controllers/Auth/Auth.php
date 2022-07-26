<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\authRequest;

class Auth extends Controller
{


    # Login VIew  . . .
    public function login()
    {

        return view('dashboard.login');
    }

    ####################################################################################################################

    # Do login process . . .
    public function dologin(authRequest $request)
    {

        # Check Remember Me . . .
        $remmeberMe = $request->rememberMe == 1 ? true : false;

        # Check Login . . .
        $login_check = auth('admin')->attempt($request->only('email', 'password'), $remmeberMe);

        if ($login_check) {
            loggers(1, auth('admin')->user()->id, Request()->ip(), 1);
            $link = 'home';
        } else {

            session()->flash('error_message', trans('admin.errorLogin'));

            $link = 'login';
        }

        return redirect(aurl($link));
    }

    ####################################################################################################################

    public function logout()
    {
        loggers(1, auth('admin')->user()->id, Request()->ip(), 2);
        auth('admin')->logout();
        return redirect(aurl('login'));
    }

    ####################################################################################################################

}
