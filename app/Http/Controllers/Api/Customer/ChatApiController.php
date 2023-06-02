<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseApiController as BaseController;
use App\Http\Resources\ChatResource;
use App\Models\Chat;

class ChatApiController extends BaseController
{
    public function index()
    {
        $datas = Chat::latest()->get();
        $result = ChatResource::collection($datas);
        return $this->sendResponse($result, 'Data fetched');
    }

    public function store(Request $request)
    {
        $datas = Chat::create([
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'is_hide' => 0,
            'is_read' => 0,
            'text' => $request->text,     
         ]);
        $result = ChatResource::make($datas);
        return $this->sendResponse($result, 'Data Strored');
        // return $this->sendResponse($datas, 'Data Strored');

    }

    public function updateHide(Request $request, $id)
    {
        $datas = Chat::findOrFail($id);

        $datas->update([
            'is_hide' => $request->text,
        ]);

        $datas->update();

        return $this->sendResponse($datas, 'Data Updated');
    }

    public function updateRead(Request $request, $id)
    {
        $datas = Chat::findOrFail($id);

        $datas->update([
            'is_read' => $request->text,
        ]);

        $datas->update();

        return $this->sendResponse($datas, 'Data Updated');
    }
}
