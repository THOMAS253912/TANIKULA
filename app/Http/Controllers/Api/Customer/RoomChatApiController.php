<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomChatResource;
use App\Models\RoomChat;
use App\Http\Controllers\Api\BaseApiController as BaseController;
use Illuminate\Http\Request;

class RoomChatApiController extends BaseController
{
    public function index()
    {
        $datas = RoomChat::latest()->get();
        $result = RoomChatResource::collection($datas);
        return $this->sendResponse($result, 'Data fetched');
    }

    public function store(Request $request)
    {
        $datas = RoomChat::create([
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'chat_id' => $request->chat_id,
         ]);
 
        return $this->sendResponse($datas, 'Data Strored');
    }

    public function updateHide(Request $request, $id)
    {
        $datas = RoomChat::findOrFail($id);

        $datas->update([
            'is_hide' => $request->is_hide,
        ]);

        $datas->update();

        return $this->sendResponse($datas, 'Data Updated');
    }
}
