<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Costumer;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseApiController as BaseController;
use Illuminate\Support\Facades\Storage;

class CustomerApiController extends BaseController
{
    public function index()
    {
        $datas = Costumer::latest()->get();
        $result = CustomerResource::collection($datas);
        return $this->sendResponse($result, 'Data fetched');
    }

    public function update(Request $request, $id)
    {
        $datas = Costumer::findOrFail($id);

        $datas->update([
            'gender' => $request->gender,
            'birth' => $request->birth, 
            'telp' => $request->telp,
        ]);

        $datas->update();

        return $this->sendResponse($datas, 'Data Updated');
    }

    public function show($id)
    {
        $data =   Costumer::where('user_id', $id)->first();
        $result = CustomerResource::make($data);
        return $this->sendResponse($result, 'Data fetched');

    }

    
    public function updatePhoto(Request $request){
        $data = Costumer::findOrFail($request->id);

        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('profile', $imageName);
        if ($data->image) {
            Storage::delete('/profile/' . $data->image);
        }

        $data->update([
            'image' => $imageName,
        ]);

        $data->update();
        return $this->sendResponse($data, 'Data Updated');
    }
}
