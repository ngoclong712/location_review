<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Enums\UserStatusEnum;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ResponseTrait;
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar_path' => '/images/defaults/no-avatar.jpg',
            'bio' => null,
            'role' => UserRoleEnum::USER,
            'status' => UserStatusEnum::UNVERIFIED,
        ]);

        Auth::login($user);

        return $this->successResponse($user, 'Register successfully');
    }

    public function login(LoginRequest $request)
    {
        $info = $request->validated();

        if(Auth::attempt(['email' => $info['email'], 'password' => $info['password']])){
            $request->session()->regenerate();
            $user = Auth::user();

            return $this->successResponse($user, 'Login successfully');
        }
        else {
            return $this->errorResponse('Wrong email or password');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $this->successResponse([],'Logout successfully');
    }
}
