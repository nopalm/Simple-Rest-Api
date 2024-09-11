<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(['status' => "Success Register"], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        $refreshToken = JWTAuth::claims(['type' => 'refresh'])->fromUser(auth()->user());

        return response()->json([
            'accessToken' => $token,
            'refreshToken' => $refreshToken
        ]);
    }

    public function refreshToken()
    {
        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken());
            $refreshToken = JWTAuth::claims(['type' => 'refresh'])->fromUser(auth()->user());
            return response()->json([
                'accessToken' => $newToken,
                'refreshToken' => $refreshToken
            ]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token cannot be refreshed, please login again'], 401);
        }
    }

}
