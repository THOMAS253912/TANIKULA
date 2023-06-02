<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Resources\WishlistResource;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseApiController as BaseController;
use Illuminate\Support\Facades\Validator;


class WishlistApiController extends BaseController
{
    public function indexByid($user_id)
    {
        $datas = Wishlist::where('user_id', $user_id)->latest()->get();

        $result = WishlistResource::collection($datas);
        return $this->sendResponse($result, 'Data fetched');
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        $datas = Wishlist::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
        ]);

        $result = WishlistResource::make($datas);
        return $this->sendResponse($result, 'Data Strored');
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
        $data = Wishlist::findOrFail($id);
        $data->delete();

        return response()->json('Data deleted successfully');
    }
}
