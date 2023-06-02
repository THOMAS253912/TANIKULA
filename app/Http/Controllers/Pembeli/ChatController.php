<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Costumer;
use App\Models\Chat;
use App\Models\RoomChat;
use Illuminate\Support\Facades\Validator;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function tokenFcm(Request $req)
    {
        $input = $req->all();
        $fcm_token = $input['fcm_token'];
        $user_id = $input['user_id'];

        $user = User::findOrFail($user_id);

        $user->fcm_token = $fcm_token;
        $user->save();
        return response()->json([
            'success' => true,
            'message' => 'User token updated successfully.'
        ]);
    }

    public function index()
    {
        $chats = Chat::all();
        $roomChats = RoomChat::all();

        return view('costumer.chat.index', [
            'chats' => $chats,
            'roomChats' => $roomChats,
        ]);
    }

    public function createChat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required',
        ], [
            'message.required' => 'Pesan harus diisi!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $input = $request->all();
            $receiver_id = $input['receiver_id'];
            $chat_id = $input['chat_id'];
            $message = $input['message'];

            $roomChat = new RoomChat();
            $roomChat->sender_id = auth()->user()->id;
            $roomChat->receiver_id = $receiver_id;
            $roomChat->chat_id = $chat_id;
            $roomChat->message = $message;

            $this->broadcastMessage(auth()->user()->name, $message);

            $roomChat->save();

            return response()->json([
                'status' => 200,
            ]);
        }
    }

    public function produkChat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required',
        ], [
            'message.required' => 'Pesan harus diisi!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $input = $request->all();
            $receiver_id = $input['receiver_id'];
            $product_id = $input['product_id'];
            $message = $input['message'];

            $checkChats = Chat::where('receiver_id', $receiver_id)->exists();
            if ($checkChats) {
                $loopChats = Chat::where('receiver_id', $receiver_id)->latest()->get();
                foreach ($loopChats as $key) {
                    $roomChat = new RoomChat();
                    $roomChat->sender_id = auth()->user()->id;
                    $roomChat->receiver_id = $receiver_id;
                    $roomChat->chat_id = $key->id;
                    $roomChat->message = $message;
                }

                $this->broadcastMessage(auth()->user()->name, $message);

                $roomChat->save();
            } else {
                $chat = new Chat([
                    'sender_id' => auth()->user()->id,
                    'receiver_id' => $receiver_id,
                    'product_id' => $product_id,
                ]);

                $chat->save();

                $roomChat = new RoomChat([
                    'sender_id' => auth()->user()->id,
                    'receiver_id' => $receiver_id,
                    'chat_id' => $chat->id,
                    'message' => $message
                ]);

                $this->broadcastMessage(auth()->user()->name, $message);

                $roomChat->save();
            }

            return response()->json([
                'status' => 200,
            ]);
        }
    }

    private function broadcastMessage($senderName, $message)
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder('New message from : ' . $senderName);
        $notificationBuilder->setBody($message)
            ->setSound('default')
            ->setClickAction('http://localhost::8000/gapoktan/chat');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData([
            'sender_name' => $senderName,
            'message' => $message,
        ]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        // You must change it to get your tokens
        $tokens = User::all()->pluck('fcm_token')->toArray();
        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
        return $downstreamResponse->numberSuccess();
    }
}
