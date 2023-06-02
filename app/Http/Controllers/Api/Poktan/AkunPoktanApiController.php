<?php

namespace App\Http\Controllers\Api\Poktan;

use App\Http\Controllers\Controller;
use App\Http\Resources\PoktanResource;
use App\Models\Poktan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AkunPoktanApiController extends Controller
{
     public function index()
    {
        $datas = Poktan::latest()->get();
        $result = PoktanResource::collection($datas);
        return $this->sendResponse($result, 'Data fetched');
    }

    public function update(Request $request, $id)
    {
        $datas = Poktan::findOrFail($id);

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
        $data = Poktan::findOrFail($request->id);

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
