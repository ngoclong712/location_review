<?php

namespace App\Http\Controllers;

use App\Http\Requests\Badge\StoreRequest;
use App\Http\Requests\Badge\UpdateRequest;
use App\Models\Badge;
use Illuminate\Support\Facades\DB;

class BadgeController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $badges = Badge::query()
        ->orderBy('id', 'desc')
        ->get();

        return $this->successResponse($badges);
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $file = $request->file('badge');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = '/images/badges/' . $filename;

            $file ->move(public_path('images/badges'), $filename);

            $data = $request->validated();
            $badges = Badge::create([
               'name' => $data['name'],
                'description' => $data['description'],
                'icon_path' => $path,
            ]);
            DB::commit();

            return $this->successResponse($badges);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update(UpdateRequest $request, Badge $badge)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            if($request->hasFile('badge')) {
                if($badge->icon_path) {
                    $oldPath = public_path($badge->icon_path);
                    if(file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                $file = $request->file('badge');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = '/images/badges/' . $filename;
                $file ->move(public_path('images/badges'), $filename);

                $data['icon_path'] = $path;
            }
            $badge->update([
                'name' => $data['name'] ?? $badge->name,
                'description' => $data['description'] ?? $badge->description,
                'icon_path' => $data['icon_path'] ?? $badge->icon_path,
            ]);

            DB::commit();
            return $this->successResponse($badge);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }

    public function destroy(Badge $badge)
    {
        if($badge->icon_path) {
            $oldPath = public_path($badge->icon_path);
            if(file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
        
        $badge->delete();
        return $this->successResponse($badge);
    }
}
