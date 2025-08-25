<?php

namespace App\Http\Controllers\API;

use Auth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if($token = Auth::guard('api')->attempt($credentials)){
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in_sec' => JWTAuth::factory()->getTTL() * 60,
                'status' => 'success',
                'message' => 'Login Successful',
            ]);
        }
        return response()->json([
            'status' => 'failed',
            'message' => 'Invalid Credential',
        ]);
    }
    public function logout(){
        try {
            JWTAuth::invalidate(JWTAuth::getToken()); // invalidate the current token
            return response()->json(['message' => 'Successfully logged out']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to logout, token missing or invalid'], 401);
        }
    }
    public function refresh(){
        return response()->json([
            'access_token' => JWTAuth::refresh(JWTAuth::getToken()),
            'token_type' => 'bearer',
            'expires_in_sec' => JWTAuth::factory()->getTTL() * 60,
            'status' => 'success',
            'message' => 'Refresh Successful',
        ]);
    }
    public function user(){
        return ['user' => Auth::guard('api')->user()];
    }
}
