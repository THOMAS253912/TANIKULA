<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PushNotification;

class NotificationController extends Controller
{
    public function storeToken(Request $request)
    {
        auth()->user()->update(['fcm_token'=>$request->token]);
        return response()->json(['Token successfully stored.']);
    }

    public function sendWebNotification(Request $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $FcmToken = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();

        $serverKey = 'AAAASSWA7hI:APA91bGkfIJFNGyqIJAiKtLXI79XdZpDuicn7pQrFv-yXdbLmLQETRkRkCY5VnGZBfwRevDkUJdA0ADnJ7Z5r1rnS4flS-ds8yxe_bp4sXouzH8Nfj-PHYCGl8-pVKkE49WqsSuPkKtd';

        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
            ]
        ];
        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        // FCM response
        dd($result);
    }

    public function index()
    {
        return view('costumer.pemberitahuan.index');
    }

    public function fetchAll()
    {
		$emps = PushNotification::join('users', 'push_notifications.user_id', '=', 'users.id')
                    ->select('push_notifications.*', 'users.name as name')
                    ->where('push_notifications.user_id', '=', auth()->user()->id)
                    ->orderBy('push_notifications.created_at', 'desc')
                    ->get();
		$output = '';
                    $output .= '<table id="tableWaitingPayment" class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary align-middle text-center  text-xxs font-weight-bolder opacity-7">
                                Nama</th>
                                <th
                                    class="text-uppercase text-secondary align-middle text-center  text-xxs font-weight-bolder opacity-7 ps-2">
                                    Isi Pemberitahuan</th>
                                <th
                                    class="text-uppercase align-middle text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                    Tanggal Pemberitahuan</th>
                            </tr>
                        </thead>
                        <tbody>';
                        if ($emps->count() > 0) {
                        foreach ($emps as $emp) {
                            $output .= '
                                <tr>
                                    <td class="align-middle text-center ">
                                        <div class="px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">'. $emp->user->name .'</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">'. $emp->title .'</h6>
                                            <p class="text-xs text-secondary mb-0">'. $emp->body .'</p>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center ">
                                        <p class="text-xs font-weight-bold mb-0">'. \App\Helpers\General::datetimeFormat($emp->created_at) .'</p>
                                    </td>
                                </tr>';
			                    }
                            $output .= '</tbody>
                        </table>
                ';
			echo $output;
		} else {
			echo '<div id="app">
                    <section class="section">
                        <div class="container">
                            <div class="page-error">
                                <div class="page-inner">
                                    <div class="page-description">
                                        Tidak ada pesanan!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>';
		}
	}
}
