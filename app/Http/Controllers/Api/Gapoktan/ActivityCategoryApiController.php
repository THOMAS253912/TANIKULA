<?php

namespace App\Http\Controllers\Api\Gapoktan;

 
use App\Models\ActivityCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseApiController as BaseController;
use App\Http\Resources\Gapoktan\ActivityCategoryResource;

class ActivityCategoryApiController extends BaseController
{
    public function index()
    {
        $datas = ActivityCategory::latest()->get();
        $result = ActivityCategoryResource::collection($datas);
        return $this->sendResponse($result, 'Data fetched');
    }

    public function create()
    {
      
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
             
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $datas = ActivityCategory::create([
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
        $validator = Validator::make($request->all(),[
            'name' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError("Validation Error", $validator->errors());
        }

        $datas = ActivityCategory::findOrFail($id);

        $datas->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        $datas->update();

        return $this->sendResponse($datas, 'Data Updated');
    }

    public function destroy($id)
    {
        $data = ActivityCategory::findOrFail($id);
        $data->delete();

        return $this->sendResponse($data, 'Data deleted');
    }
}
