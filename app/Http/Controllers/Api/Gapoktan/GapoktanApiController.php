<?php

namespace App\Http\Controllers\Api\Gapoktan;

use App\Models\Gapoktan;
use App\Http\Controllers\Api\BaseApiController as BaseController;
use App\Http\Resources\GapoktanResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GapoktanApiController extends BaseController
{
    public function index()
    {
        $datas = Gapoktan::latest()->get();
        $result = GapoktanResource::collection($datas);
        return $this->sendResponse($result, 'Data fetched');
    }

    public function update(Request $request, $id)
    {
        $datas = Gapoktan::findOrFail($id);

        $datas->update([
            'chairman' => $request->chairman,
            'city' => $request->city,
            'address' => $request->address,
            'telp' => $request->telp,
        ]);

        $datas->update();

        return $this->sendResponse($datas, 'Data Updated');
    }
    
    public function updatePhoto(Request $request){
        $data = Gapoktan::findOrFail($request->id);

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
