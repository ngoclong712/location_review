<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use ResponseTrait;

    public function update(UpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();

            if (!$user) {
                return $this->errorResponse('Bạn chưa đăng nhập', 401);
            }

            $data = $request->validated();

            if ($request->hasFile('avatar')) {
                if ($user->avatar_path && !str_contains($user->avatar_path, '/images/defaults/')) {
                    $oldPath = public_path($user->avatar_path);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                $file = $request->file('avatar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = '/images/avatars/' . $filename;
                $file->move(public_path('images/avatars'), $filename);

                $data['avatar_path'] = $path;
            }

            $user->update([
                'name' => $data['name'] ?? $user->name,
                'bio' => $data['bio'] ?? $user->bio,
                'avatar_path' => $data['avatar_path'] ?? $user->avatar_path,
            ]);

            DB::commit();
            return $this->successResponse($user, 'Cập nhật thông tin thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }
}
