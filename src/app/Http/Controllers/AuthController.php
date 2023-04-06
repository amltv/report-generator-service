<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validateUser = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if ($validateUser->fails()) {
            return response()->json([
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'Email & Password does not exist.',
            ], 401);
        }

        return response()->json([
            'token' => Auth::getUser()->createToken('api')->plainTextToken
        ]);
    }
}
