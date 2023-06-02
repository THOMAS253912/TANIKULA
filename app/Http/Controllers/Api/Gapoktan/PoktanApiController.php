<?php

namespace App\Http\Controllers\Api\Gapoktan;

use App\Models\Poktan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\BaseApiController as BaseController;
use App\Http\Resources\PoktanResource;
use Illuminate\Support\Facades\DB;

class PoktanApiController extends BaseController
{
    public function index()
    {
        $datas = Poktan::latest()->get();
        $result = PoktanResource::collection($datas);
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

        $gapoktan_id = $request->gapoktan_id;
        $is_active = $request->is_active ? 1 : 0;
        $datas = Poktan::create([
            'user_id' => $user->id,
            'gapoktan_id' => $gapoktan_id,
            'is_active' => $is_active,
        ]);

        $result = PoktanResource::make($datas);
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

        $data = Poktan::with('user', 'gapoktan')->find($request->id); 
        if ($request->is_active == 0) {
            $data->is_active = $request->is_active ? 1 : 0;
        } elseif ($request->is_active == 1) {
            $data->is_active = $request->is_active ? 0 : 1;
        }
        $data->save();

        $result = PoktanResource::make($data);
        return $this->sendResponse($result, 'Data Updated');
	}

    public function destroy($id)
    {

        $data =DB::table('users')
                ->leftJoin('poktans','users.id', '=','poktans.user_id')
                ->where('users.id', $id); 
                
        DB::table('poktans')->where('user_id', $id)->delete();                           
        $data->delete();
        
        return response()->json('Data deleted successfully');
	}

}
