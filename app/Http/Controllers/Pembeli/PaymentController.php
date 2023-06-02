<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\Product;
use App\Models\PushNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function notification(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);

        $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . env('MIDTRANS_SERVER_KEY'));

        if ($notification->signature_key != $validSignatureKey) {
            return response(['message' => 'Invalid signature'], 403);
        }

        $this->initPaymentGateway();
        $statusCode = null;

        $paymentNotification = new \Midtrans\Notification();
        $order = Order::where('code', $paymentNotification->order_id)->firstOrFail();

        if ($order->isPaid()) {
            return response(['message' => 'The order has been paid before'], 422);
        }

        $transaction = $paymentNotification->transaction_status;
        $type = $paymentNotification->payment_type;
        $orderId = $paymentNotification->order_id;
        $fraud = $paymentNotification->fraud_status;

        $vaNumber = null;
        $vendorName = null;
        if (!empty($paymentNotification->va_numbers[0])) {
            $vaNumber = $paymentNotification->va_numbers[0]->va_number;
            $vendorName = $paymentNotification->va_numbers[0]->bank;
        }

        $paymentStatus = null;
        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    $paymentStatus = Payment::CHALLENGE;
                } else {
                    // TODO set payment status in merchant's database to 'Success'
                    $paymentStatus = Payment::SUCCESS;
                }
            }
        } else if ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            $paymentStatus = Payment::SETTLEMENT;
        } else if ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            $paymentStatus = Payment::PENDING;
        } else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            $paymentStatus = PAYMENT::DENY;
        } else if ($transaction == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
            $paymentStatus = PAYMENT::EXPIRE;
        } else if ($transaction == 'cancel') {
            // TODO set payment status in merchant's database to 'Denied'
            $paymentStatus = PAYMENT::CANCEL;
        }

        $paymentParams = [
            'order_id' => $order->id,
            'number' => Payment::generateCode(),
            'amount' => $paymentNotification->gross_amount,
            'method' => 'midtrans',
            'status' => $paymentStatus,
            'token' => $paymentNotification->transaction_id,
            'payloads' => $payload,
            'payment_type' => $paymentNotification->payment_type,
            'va_number' => $vaNumber,
            'vendor_name' => $vendorName,
            'biller_code' => $paymentNotification->biller_code,
            'bill_key' => $paymentNotification->bill_key,
        ];

        $payment = Payment::create($paymentParams);

        if ($paymentStatus && $payment) {
            DB::transaction(
                function () use ($order, $payment) {
                    if (in_array($payment->status, [Payment::SUCCESS, Payment::SETTLEMENT])) {
                        $order->payment_status = Order::PAID;
                        $order->status = Order::CONFIRMED;
                        // $order->payment_due = Carbon::now()->format('Y-m-d H:i:s');
                        $order->save();

                        $orderItemCheck = OrderItem::where('order_id', $order->id)->get();
                        foreach ($orderItemCheck as $orderItem) {
                            $prod = Product::where('id', $orderItem->product_id)->first();
                            $prod->stoke = $prod->stoke - $orderItem->qty;
                            // if ($prod->stock_out == null) {
                            //     $prod->stock_out = $orderItem->qty;
                            // } else {
                            $prod->stock_out = $prod->stock_out + $orderItem->qty;
                            // }
                            $prod->update();
                        }

                        // $cartItem = Cart::with('product')->where('user_id', $order->user_id)->latest()->get();
                        // foreach ($cartItem as $item) {
                        //     $prod = Product::where('id', $item->product_id)->first();
                        //     $prod->stoke = $prod->stoke - $item->product_qty;
                        //     if ($prod->stock_out == null) {
                        //         $prod->stock_out = $item->product_qty;
                        //     } else {
                        //         $prod->stock_out = $prod->stock_out + $item->product_qty;
                        //     }
                        //     $prod->update();
                        // }
                        // Cart::destroy($cartItem);

                        // Push Notification
                        $user_id = $order->user_id;
                        $url = "https://fcm.googleapis.com/fcm/send";
                        $SERVER_API_KEY = 'AAAASSWA7hI:APA91bGkfIJFNGyqIJAiKtLXI79XdZpDuicn7pQrFv-yXdbLmLQETRkRkCY5VnGZBfwRevDkUJdA0ADnJ7Z5r1rnS4flS-ds8yxe_bp4sXouzH8Nfj-PHYCGl8-pVKkE49WqsSuPkKtd';
                        $headers = [
                            'Authorization' => 'key=' . $SERVER_API_KEY,
                            'Content-Type' => 'application/json',
                        ];

                        PushNotification::create([
                            'user_id' => $order->user_id,
                            "title" => "Pembayaran berhasil",
                            "body" => "Berhasil melakukan pembayaran, Pesanan anda sedang diproses!",
                            "img" => "icons8-purchase-order-90.png",
                        ]);

                        Http::withHeaders($headers)->post($url, [
                            // "to" => "cWmdLu_QQqa6CR28k2aDtJ:APA91bHs2-K9fkZ7rOIUOvrq2bEtlxNpTUoZSn7-TpOcNpfmbwFRfhY1NPBCjYv53uCHJLfFPmsmG84pSWXmG2ezDVkv-opbrM-AaQ42j_UKso-qAqGWlMoJv0AhffI2NAaKTv9DIe0v",
                            'to' => '/topics/topic_user_id_' . $user_id,
                            "notification" => [
                                "title" => "Pembayaran berhasil",
                                "body" => "Berhasil melakukan pembayaran, Pesanan anda sedang diproses!",
                                "mutable_content" => true,
                                "sound" => "Tri-tone"
                            ]
                        ]);
                    }
                }
            );
        }

        $message = 'Payment status is : ' . $paymentStatus;

        $response = [
            'code' => 200,
            'message' => $message,
        ];

        return response($response, 200);
    }

    /**
     * Show completed payment status
     *
     * @param Request $request payment data
     *
     * @return void
     */
    public function completed(Request $request)
    {
        $code = $request->query('order_id');
        $order = Order::where('code', $code)->firstOrFail();

        if ($order->payment_status == Order::UNPAID) {
            return redirect('payments/failed?order_id=' . $code);
        }

        Session::flash('success', "Thank you for completing the payment process!");

        return redirect('cart/shipment/place-order/received/' . $order->id);
    }

    /**
     * Show unfinish payment page
     *
     * @param Request $request payment data
     *
     * @return void
     */
    public function unfinish(Request $request)
    {
        $code = $request->query('order_id');
        $order = Order::where('code', $code)->firstOrFail();

        Session::flash('error', "Sorry, we couldn't process your payment.");

        return redirect('cart/shipment/place-order/received/' . $order->id);
    }

    /**
     * Show failed payment page
     *
     * @param Request $request payment data
     *
     * @return void
     */
    public function failed(Request $request)
    {
        $code = $request->query('order_id');
        $order = Order::where('code', $code)->firstOrFail();

        Session::flash('error', "Sorry, we couldn't process your payment.");

        return redirect('cart/shipment/place-order/received/' . $order->id);
    }

    private function initPaymentGateway()
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = env('MIDTRANS_PRODUCTION', false);
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
    }
}
