<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CmsController extends Controller
{
    function index()
    {
        $cms = Cms::all();
        return view('admin.cms.index', compact('cms'));
    }
    function get()
    {
        return  Cms::all()->pluck('content', 'alias');
    }

    function update(Request $request)
    {
        try {
            $data = [];
            foreach ($request->except('_token') as $key => $value) {
                array_push($data, [
                    'alias' => $key,
                    'content' => $value
                ]);

                Cms::where('alias', $key)->update(['content' => $value]);
            }

            return $data;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }
    function updateImage(Request $request)
    {
        try {
            $data = [];
            foreach ($request->allFiles() as $key => $value) {

                $file = $request->file($key);

                array_push($data, [
                    'alias' => $key,
                    'content' => $file->getClientOriginalName()
                ]);

                $path = Storage::disk('cms')->putFileAs(str_replace('app_', '', $key), $file, $file->getClientOriginalName());
                Cms::where('alias', $key)->update(['content' => $file->getClientOriginalName()]);
            }


            return $data;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }
    function updateImageMultiple(Request $request)
    {
        try {
            $data = [];
            $cms = Cms::where('alias', 'app_slider')->first();
            $cms = json_decode($cms->content);
            foreach ($request->app_slider as $key => $value) {

                $filename = $value->getClientOriginalName();

                if (isset($cms[$key])) {
                    if ($cms[$key] != $filename) {
                        $cms[$key] = $filename;
                    }
                } else {
                    array_push($cms, $filename);
                }

                $path = Storage::disk('cms')->putFileAs('slider', $value, $filename);
            }

            Cms::where('alias', 'app_slider')->update(['content' => json_encode($cms)]);


            return $cms;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }
}
