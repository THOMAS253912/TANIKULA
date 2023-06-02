<?php

namespace App\Http\Controllers\Api;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseApiController as BaseController;


class UserApiController extends BaseController
{
    public function index()
    {

    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        $data = User::findOrFail($id)->first();
        $result = UserResource::make($data);
        return $this->sendResponse($result, 'Data fetched');
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $datas = User::findOrFail($id);

        $datas->update([
            'password' => bcrypt($request->password),
        ]);

        $datas->update();

        return $this->sendResponse($datas, 'Data Updated');
    }

    public function destroy($id)
    {
        //
    }
}
