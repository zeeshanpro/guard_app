<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:55',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors()]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $accessToken = $user->createToken('authToken')->accessToken;
       
        return response([ 'user' => $user, 'access_token' => $accessToken]);
    }

    public function login(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors()],400);
        }

        if (!auth()->attempt($data)) {
            return response(['message' => 'Login credentials are invaild'],400);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        
        return response(['access_token' => $accessToken]);

    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return redirect()->route('login');
        //return response()->json(['message' => 'Successfully logged out']);
    }
}
