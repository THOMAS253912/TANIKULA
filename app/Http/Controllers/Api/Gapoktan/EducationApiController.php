<?php

namespace App\Http\Controllers\Api\Gapoktan;

use App\Http\Resources\Gapoktan\EducationResource;
use App\Models\Education;
use App\Http\Controllers\Api\BaseApiController as BaseController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EducationApiController extends BaseController
{
    public function index()
    {
        $datas = Education::orderBy('id', 'DESC')
            ->where('category_education_id', '!=', null)
            ->paginate(8);

        $result = EducationResource::collection($datas);
        return $this->sendResponse($result, 'Data fetched');
    }

    public function search($title)
    {
        $datas = Education::where('title', 'LIKE', '%' . $title . '%')
            ->where('category_education_id', '!=', null)
            ->paginate(8);
        if (count($datas)) {
            // return Response()->json($datas);
            $result = EducationResource::collection($datas);
            return $this->sendResponse($result, 'Data fetched');
        } else {
            return $this->sendResponse([], 'Data fetched');
            // return response()->json(['Result' => 'No Data not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'category_education_id' => 'required',
            'title' => 'required',
            // 'file' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
            'desc' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError("Validation Error", $validator->errors());
        }

        $file = $request->file('file');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('edukasi', $fileName);

        $datas = Education::create([
            'user_id' => $request->user_id,
            'category_education_id' => $request->category_education_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'date' => Carbon::now()->format('Y-m-d'),
            'file' => $fileName,
            'desc' => $request->desc,
        ]);

        $result = EducationResource::make($datas);
        // return $this->sendResponse($result, 'Data Strored');
        return $result;
    }


    public function show($id)
    {
        $data = Education::find($id);
        if (is_null($data)) {
            return response()->json('Data not found', 404);
        }
        return response()->json([new EducationResource($data)]);
    }


    public function update(Request $request, $id)
    {
        $data = Education::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'category_education_id' => 'required',
            'title' => 'required',
            // 'file' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
            'desc' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $data->update([
            'user_id' => $request->user_id,
            'category_education_id' => $request->category_education_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'file' => $data->file,
            'desc' => $request->desc,
        ]);

        $data->update();

        return response()->json(['Data updated successfully.', new EducationResource($data)]);
    }

    public function updateWFile(Request $request)
    {
        $data = Education::findOrFail($request->id);
        $validator = Validator::make($request->all(), [
            'category_education_id' => 'required',
            'title' => 'required',
            // 'file' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
            'desc' => 'required'
        ]);


        $file = $request->file('file');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('edukasi', $fileName);
        if ($data->file) {
            Storage::delete('/edukasi/' . $data->file);
        }


        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $data->update([
            'user_id' => $request->user_id,
            'category_education_id' => $request->category_education_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'file' => $fileName,
            'desc' => $request->desc,
        ]);

        $data->update();

        return response()->json(['Data updated successfully.', new EducationResource($data)]);
    }


    public function destroy($id)
    {
        $data = Education::findOrFail($id);
        $data->delete();
        if (Storage::delete('edukasi/' . $data->file)) {
            Education::destroy($id);
        } else {
            $data->delete();
        }

        return response()->json('Data deleted successfully');
    }
}
