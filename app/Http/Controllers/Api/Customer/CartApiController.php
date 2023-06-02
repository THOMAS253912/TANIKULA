<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use Illuminate\Support\Facades\Validator;
use App\Models\Cart;
use App\Http\Controllers\Api\BaseApiController as BaseController;
use Illuminate\Http\Request;

class CartApiController extends BaseController
{
    public function indexByid($user_id)
    {
        $datas = Cart::where('user_id', $user_id)->latest()->get();

        $result = CartResource::collection($datas);
        return $this->sendResponse($result, 'Data fetched');
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
         $validator = Validator::make($request->all(),[
            // 'category_activity_id' => 'required',
             
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $datas = Cart::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'product_qty' => $request->product_qty,
            'session_id' => $request->session_id,

         ]);
 
        $result = CartResource::make($datas);
        return $this->sendResponse($result, 'Data fetched');
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
        //
    }

    public function destroy($id)
    {
        $data = Cart::findOrFail($id);
        $data->delete();

        return response()->json('Data deleted successfully');
    }

    public function updateQty(Request $request, $id)
    {
        $datas = Cart::findOrFail($id);

        $datas->update([
            'product_qty' => $request->product_qty,
        ]);

        $datas->update();

        return $this->sendResponse($datas, 'Data Updated');
    }
}
