<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Http\Controllers\Api\BaseApiController as BaseController;
use Illuminate\Http\Request;

class AddressApiController extends BaseController
{
    public function indexByid($user_id)
    {
        $datas = Address::where('user_id', $user_id)->orderBy('id', 'DESC')->paginate(6);

        $result = AddressResource::collection($datas);
        return $this->sendResponse($result, 'Data fetched');
    }

    public function store(Request $request)
    {

        if ($request->main_address == 1) {
            $address = Address::where('user_id', $request->user_id)->latest()->get();
            foreach ($address as $item) {
                if ($item->main_address == 1) {
                    $datasFound = Address::findOrFail($item->id);
                    $datasFound->update([
                        "main_address" => 0,
                    ]);
                    $datasFound->update();
                }
            }
        }

        $datas = Address::create([
            'user_id' => $request->user_id,
            "recipients_name" => $request->recipients_name,
            "telp" => $request->telp,
            "address_label" => $request->address_label,
            "provinsi_id" => $request->provinsi_id,
            "kota_id" => $request->kota_id,
            "postal_code" => $request->postal_code,
            "main_address" => $request->main_address,
            "complete_address" => $request->complete_address,
            "note_for_courier" => $request->note_for_courier,
        ]);

        $result = AddressResource::make($datas);
        return $this->sendResponse($result, 'Data fetched');
    }


    public function update(Request $request, $id)
    {
        $datas = Address::findOrFail($id);

        $datas->update([
            "recipients_name" => $request->recipients_name,
            "telp" => $request->telp,
            "address_label" => $request->address_label,
            "provinsi_id" => $request->provinsi_id,
            "kota_id" => $request->kota_id,
            "postal_code" => $request->postal_code,
            "main_address" => $request->main_address,
            "complete_address" => $request->complete_address,
            "note_for_courier" => $request->note_for_courier,
        ]);

        $datas->update();

        return $this->sendResponse($datas, 'Data Updated');
    }

    public function updateMainAddress(Request $request, $id)
    {
        $address = Address::where('user_id', $request->user_id)->latest()->get();
        foreach ($address as $item) {
            if ($item->main_address == 1) {
                $datasFound = Address::findOrFail($item->id);
                $datasFound->update([
                    "main_address" => 0,
                ]);
                $datasFound->update();
            }
        }
        $datas = Address::findOrFail($id);

        $datas->update([
            "main_address" => $request->main_address,
        ]);

        $datas->update();

        return $this->sendResponse($datas, 'Data Updated');
    }


    public function destroy($id)
    {
        $data = Address::findOrFail($id);
        $data->delete();

        return response()->json('Data deleted successfully');
    }
}
