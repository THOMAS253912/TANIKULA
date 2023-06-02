<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\RoomChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function getAllMessages(Request $request)
    {
        try {

            $auth = Auth::user()->id;
            $users = Chat::join('users AS b', function ($join) {
                $join->on('b.id', '=', 'receiver_id')->orOn('b.id', '=', 'sender_id');
            })->where('b.id', '!=', $auth)->where(function ($q) use ($auth) {
                $q->where('chats.sender_id', $auth)->orWhere('chats.receiver_id', $auth);
            })->groupBy(['b.id'])->get(['b.id AS user_id', 'name', DB::raw('SUM(CASE WHEN chats.is_read IS FALSE AND sender_id != ' . $auth . ' THEN 1 ELSE 0 END) AS read_count')]);

            foreach ($users as $key => $value) {
                $messages = Chat::join('users AS b', function ($join) {
                    $join->on('b.id', '=', 'receiver_id')->orOn('b.id', '=', 'sender_id');
                })->join('room_chats AS d', 'd.chat_id', '=', 'chats.id')
                    ->where('b.id', $value->user_id)
                    ->where(function ($q) use ($auth) {
                        $q->where('chats.sender_id', $auth)->orWhere('chats.receiver_id', $auth);
                    })
                    ->get(['message', 'chats.receiver_id', 'chats.sender_id', 'chats.created_at', 'chats.id as chat_id', 'chats.is_read']);
                $users[$key]->messages = $messages;
            }

            return $users;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function sendMessage(Request $request)
    {
        try {

            DB::beginTransaction();
            $chat =  Chat::create([
                'receiver_id' => $request->receiver_id,
                'sender_id' => Auth::user()->id,
                'product_id' => $request->product_id,
            ]);

            RoomChat::create([
                'receiver_id' => $request->receiver_id,
                'sender_id' => Auth::user()->id,
                'chat_id' => $chat->id,
                'message' => $request->message
            ]);


            DB::commit();
            return $chat;
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
    public function readMessage(Request $request)
    {
        try {

            Chat::whereIn('id', $request->chat_id)->where('receiver_id', Auth::user()->id)->update(['is_read' => true]);

            return true;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
