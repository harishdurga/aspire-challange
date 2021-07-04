<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UsersController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        return User::create($request->validated());
    }

    public function login(UserLoginRequest $request)
    {
        try {
            if (Auth::attempt($request->validated())) {
                $user = User::where(['email' => $request->email])->first();
                return response()->json(['token' => $user->createToken('login-token')->plainTextToken]);
            } else {
                throw new HttpResponseException(response()->json(['message' => 'Incorrect Credentials.'], 401));
            }
        } catch (\Throwable $th) {
            \Log::error($th);
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
