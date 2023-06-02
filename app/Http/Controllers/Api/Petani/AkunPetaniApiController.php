<?php

namespace App\Http\Controllers\Api\Petani;

use App\Http\Controllers\Controller;
use App\Http\Resources\FarmerResource;
use App\Models\Farmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\BaseApiController as BaseController;


class AkunPetaniApiController extends BaseController
{
    public function update(Request $request, $id)
    {
        $datas = Farmer::findOrFail($id);

        $datas->update([
            'city' => $request->city,
            'address' => $request->address,
            'telp' => $request->telp,
        ]);

        $datas->update();

        return $this->sendResponse($datas, 'Data Updated');
    }

    public function updatePhoto(Request $request)
    {
        $data = Farmer::findOrFail($request->id);

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
