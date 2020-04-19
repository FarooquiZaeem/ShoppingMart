<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRegisterRequest;
use Illuminate\Http\Request;
use App\User;
use App\Responses\Response;

class AdminController extends Controller
{
    public function register(AdminRegisterRequest $request)
    {
        $user = new User();
        $user->first_name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->is_admin = 1;
        $user->save();
        $response = (new Response())->make(1, 'Registration Completed');
        return response()->json($response, 200);
    }
}
