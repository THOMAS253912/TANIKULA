<?php

namespace App\Http\Controllers\Api\Gapoktan;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\Gapoktan\ActivityResource;
use Illuminate\Support\Str;
use App\Models\Activity;
use Carbon\Carbon;
use App\Http\Controllers\Api\BaseApiController as BaseController;
use Illuminate\Http\Request;

class ActivityApiController extends BaseController
{
    public function index()
    {
        $datas = Activity::orderBy('id', 'DESC')
            ->where('category_activity_id', '!=', null)
            ->paginate(7);

        $result = ActivityResource::collection($datas);
        return $this->sendResponse($result, 'Data fetched');
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_activity_id' => 'required',
            'title' => 'required',
            'desc' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $datas = Activity::create([
            'user_id' => $request->user_id,
            'category_activity_id' => $request->category_activity_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'date' => $request->date,
            'desc' => $request->desc,
        ]);

        $result = ActivityResource::make($datas);
        return $this->sendResponse($result, 'Data Stored');
    }


    public function show($id)
    {
        $data = Activity::find($id);
        if (is_null($data)) {
            return response()->json('Data not found', 404);
        }
        return response()->json([new ActivityResource($data)]);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_activity_id' => 'required',
            'title' => 'required',
            'desc' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $datas = Activity::findOrFail($id);

        $datas->update([
            'category_activity_id' => $request->category_activity_id,
            'title' => $request->title,
            'date' => $request->date,
            'slug' => Str::slug($request->title),
            'desc' => $request->desc,
        ]);

        $datas->update();

        $result = ActivityResource::make($datas);
        return $this->sendResponse($result, 'Data Updated');
    }

    public function destroy($id)
    {
        $data = Activity::findOrFail($id);
        $data->delete();

        return response()->json('Data deleted successfully');
    }

    public function search($title)
    {
        $datas = Activity::where('title', 'LIKE', '%' . $title . '%')
            ->where('category_activity_id', '!=', null)
            ->paginate(8);
        if (count($datas)) {
            // return Response()->json($datas);
            $result = ActivityResource::collection($datas);
            return $this->sendResponse($result, 'Data fetched');
        } else {
            return $this->sendResponse([], 'Data fetched');
            // return response()->json(['Result' => 'No Data not found'], 404);
        }
    }
}
