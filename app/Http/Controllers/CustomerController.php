<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRegisterRequest;
use Illuminate\Http\Request;
use App\User;
use App\Responses\Response;

class CustomerController extends Controller
{
    public function register(CustomerRegisterRequest $request)
    {
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->contact_no = $request->contact_no;
        $user->password = bcrypt($request->password);
        $user->is_admin = 0;
        $user->save();
        $response = (new Response())->make(1, 'Registration Completed');
        return response()->json($response, 200);
    }
}
