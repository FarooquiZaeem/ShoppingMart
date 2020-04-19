<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\AuthenticationException;
use App\Responses\Response;
use Auth;
use App\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::whereEmail($request->email)
            ->first();
        if (!$user) {
            throw new AuthenticationException('No User Found');
        }
        if($this->loginValidate($request->password, $user->password)) {
            $token = $user->createToken('My Token', ['*'])->accessToken;
            $response_arr = [
                'user' => $user,
                'access_token' => $token
            ];
            $response = (new Response)->make(1, 'Login Successful', $response_arr);
            return response()->json($response, 200);
        }
    }

    public function logout()
    {
        $token = Auth::user()->token();
        $token->revoke();
        $response = (new Response)->make(1, 'Logged Out');
        return response()->json($response, 200);
    }

    public function loginValidate($password_string, $hashed_password)
    {
        if (!Hash::check($password_string, $hashed_password)) {
            throw new AuthenticationException('Incorrect Password');
        }
        return true;
    }
}
