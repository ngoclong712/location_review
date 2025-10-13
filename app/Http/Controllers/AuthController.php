<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Enums\UserStatusEnum;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
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
            'avatar_path' => 'images/defaults/no-avatar.jpg',
            'bio' => null,
            'role' => UserRoleEnum::USER,
            'status' => UserStatusEnum::UNVERIFIED,
        ]);

        return $this->successResponse($user, 'Đăng ký thành công');
    }

    public function login(Request $request)
    {

    }
}
