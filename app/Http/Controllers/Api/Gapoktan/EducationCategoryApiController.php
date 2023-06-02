<?php

namespace App\Http\Controllers\Api\Gapoktan;

use App\Http\Controllers\Controller;
use App\Http\Resources\Gapoktan\EducationCategoryResource;
use App\Models\EducationCategory;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseApiController as BaseController;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class EducationCategoryApiController extends BaseController
{
    public function index()
    {
        $datas = EducationCategory::latest()->get();
        $result = EducationCategoryResource::collection($datas);
        return $this->sendResponse($result, 'Data fetched');
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $datas = EducationCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->title),
        ]);

        return $this->sendResponse($datas, 'Data Strored');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError("Validation Error", $validator->errors());
        }

        $datas = EducationCategory::findOrFail($id);

        $datas->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        $datas->update();

        return $this->sendResponse($datas, 'Data Updated');
    }

    public function destroy($id)
    {
        $data = EducationCategory::findOrFail($id);
        $data->delete();

        return $this->sendResponse($data, 'Data deleted');
    }
}
