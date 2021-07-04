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
        if (Auth::attempt($request->validated())) {
            $user = User::where(['email' => $request->email])->first();
            $admin_token = $user->id == 1 ? ['*'] : [];
            $token = $user->createToken('login-token', $admin_token);
            return response()->json(['token' => $token->plainTextToken]);
        } else {
            throw new HttpResponseException(response()->json(['message' => 'Incorrect Credentials.'], 401));
        }
    }
}
