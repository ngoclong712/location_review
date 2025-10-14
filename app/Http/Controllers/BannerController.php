<?php

namespace App\Http\Controllers;

use App\Http\Requests\Config\StoreBannerRequest;
use App\Http\Requests\Config\UpdateBannerRequest;
use Illuminate\Http\Request;
use App\Models\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    use ResponseTrait;
    protected $configKey = 'banner';

    public function homepage()
    {
        $banner = Config::where('key', $this->configKey)
            ->where('is_public', 1)
            ->get(['id', 'value']);
        return $this->successResponse($banner);
    }

    public function index()
    {
        $banners = Config::where('key', $this->configKey)->get(['id', 'value', 'is_public']);
        return $this->successResponse($banners);
    }

    public function store(StoreBannerRequest $request)
    {
        DB::beginTransaction();
        try {
            $file = $request->file('banner');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = '/images/banners/' . $filename;

            // Lưu file vào public/images/banners
            $file->move(public_path('images/banners'), $filename);

            $banner = Config::create([
                'key' => $this->configKey,
                'value' => $path, // không có "/" ở đầu
                'is_public' => 0
            ]);

            DB::commit();
            return $this->successResponse($banner);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to add new banner: ' . $e->getMessage());
        }
    }


    public function update(Request $request, Config $banner)
    {
        DB::beginTransaction();
        try {
            $banner->is_public = $request->has('is_public')
                ? (bool) $request->is_public
                : !$banner->is_public;

            $banner->save();

            DB::commit();
            return $this->successResponse($banner, 'Banner updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to update banner');
        }
    }

    public function destroy(Config $banner)
    {
        $banner->delete();
        return $this->successResponse($banner);
    }
}
