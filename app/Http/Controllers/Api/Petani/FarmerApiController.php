<?php

namespace App\Http\Controllers\Api\Petani;

use App\Http\Controllers\Controller;
use App\Http\Resources\FarmerResource;
use App\Models\Farmer;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseApiController as BaseController;
use App\Models\Poktan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FarmerApiController extends BaseController
{
    public function index()
    {
        $datas = Farmer::latest()->get();
        $result = FarmerResource::collection($datas);
        return $this->sendResponse($result, 'Data fetched');
    }

     public function store(Request $request) 
    {
	 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole('poktan');

        $poktan_id = $request->poktan_id;
        $is_active = $request->is_active ? 1 : 0;
        $datas = Farmer::create([
            'user_id' => $user->id,
            'poktan_id' => $poktan_id,
            'is_active' => $is_active,
        ]);

        $result = FarmerResource::make($datas);
        return $this->sendResponse($result, 'Data Stored');
	}

    public function update(Request $request) 
    {
        $user = User::find($request->user_id);
        if($request->password) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
        } else {
            $user->name = $request->name;
            $user->email = $request->email;
        }
        $user->save();

        $data = Farmer::with('user', 'poktan')->find($request->id); 
        if ($request->is_active == 0) {
            $data->is_active = $request->is_active ? 1 : 0;
        } elseif ($request->is_active == 1) {
            $data->is_active = $request->is_active ? 0 : 1;
        }
        $data->save();

        $result = Farmer::make($data);
        return $this->sendResponse($result, 'Data Updated');
	}

    public function destroy($id)
    {

        $data =DB::table('users')
                ->leftJoin('farmers','users.id', '=','farmers.user_id')
                ->where('users.id', $id); 
                
        DB::table('farmers')->where('user_id', $id)->delete();                           
        $data->delete();
        
        return response()->json('Data deleted successfully');
	}
}
