<?php

namespace App\Http\Controllers;

use App\Http\Requests\Badge\StoreRequest;
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
}
