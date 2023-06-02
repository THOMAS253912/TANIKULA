<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseController;
use App\Http\Resources\PhotoProductResource;
use App\Models\PhotoProduct;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoProductApiControlller extends BaseController
{
    public function index()
    {
        $datas = PhotoProduct::get();

        $result = PhotoProductResource::collection($datas);
        return $this->sendResponse($result, 'Data fetched');
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'product_id' => 'required',
            'name' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        } 

        $file = $request->file('name');
        sleep(2);
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('produk', $fileName);

        $datas = PhotoProduct::create([
            'product_id' => $request->product_id, 
            'name' => $fileName, 
        ]);

        $result = PhotoProductResource::make($datas);
        return $this->sendResponse($result, 'Data Stored');
    }

    public function deleteWhereProductId(Request $request)
    {
        $data = PhotoProduct::where('product_id', $request->product_id)->get();
        foreach ($data as $key => $value) {
            Storage::delete('/produk/' . $value->name);
        }
        PhotoProduct::where('product_id', $request->product_id)->delete();
        
        return response()->json('Data deleted successfully');
    }
}
