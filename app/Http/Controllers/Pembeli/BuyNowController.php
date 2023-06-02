<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\PushNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;

class BuyNowController extends Controller
{
    public function buyNow(Request $request)
    {
        //Variabel key dan url API raja ongkir
        $key = 'f5ed16cb52b0f2936e98e7e22a4a02f5'; //Buat akun atau pakai API akun Tahu Coding
        $cost_url = 'https://api.rajaongkir.com/starter/cost';


        $address = Address::with('user')
            ->join('users', 'addresses.user_id', '=', 'users.id')
            ->select('addresses.*', 'users.email as email')
            ->where('user_id', auth()->user()->id)
            ->where('addresses.main_address', 1)
            ->orderBy('addresses.updated_at', 'desc')
            ->take(1)
            ->get();
        // $old_cartItem = Cart::with('product')->where('user_id', Auth::id())->latest()->get();
        // foreach ($old_cartItem as $item) {
        //     if (!Product::where('id', $item->product_id)->where('stoke', '>=', $item->product_qty)->exists()) {
        //         $removeItem = Cart::where('user_id', Auth::id())->where('product_id', $item->product_id)->first();
        //         $removeItem->delete();
        //     }
        // }

        $cart_id =  $request->input('cart_id', []);
        $navbar_cart_id =  $request->input('navbar_cart_id', []);
        // $authorizedRoles = [$cart_id];
        // dd($authorizedRoles);
        if ($cart_id) {
            $cartItem = Cart::with('product')->where('user_id', '=', auth()->user()->id)->where(static function ($query) use ($cart_id) {
                return $query->whereIn('id', $cart_id);
            })->latest()->get();
        } elseif ($navbar_cart_id) {
            $cartItem = Cart::with('product')->where('user_id', '=', auth()->user()->id)->where(static function ($query) use ($navbar_cart_id) {
                return $query->whereIn('id', $navbar_cart_id);
            })->latest()->get();
        } else {
            $cartItem = Cart::with('product')->where('user_id', '=', auth()->user()->id)->where(static function ($query) use ($cart_id) {
                return $query->whereIn('id', $cart_id);
            })->latest()->get();
        }


        // $cartItem = Cart::with('product')->where('user_id', Auth::id())->latest()->get();

        //Variabel yang valuenya didapat dari request()
        if ($request->has('service')) {
            $data_origin = 172;
            $data_destination = $request->destination_costumer;
            // $data_destination = 172;
            $data_weight = $request->weight_product;
            $data_courier = $request->courier;
            $data_service = $request->service;

            //logic untuk calculate cost
            $response = Http::withoutVerifying()->retry(10, 200)->asForm()->withHeaders([
                'key' => $key
            ])->post($cost_url, [
                'origin' => $data_origin,
                'destination' => $data_destination,
                'weight' => $data_weight,
                'courier' => $data_courier
            ]);

            $result_cost = $response['rajaongkir']['results'][0]['costs'];
        } else {
            $data_courier = "";
            $data_service = "";
            $result_cost = null;
        }

        return view('pages.checkout.buy_now_exp', compact('cartItem', 'address', 'result_cost', 'data_service'));
    }

    public function buyNowPost(Request $request)
    {
        $product_id = $request->prod_id;
        $product_qty = $request->quantity;

        $prod_check = Product::where('id', $product_id)->first();

        if ($prod_check) {
            if ($product_qty > $prod_check->stoke) {
                notify()->warning("Kuantiti tidak boleh melebihi stok", "Peringatan", "topRight");
                return redirect()->back();
            } else {
                //Variabel key dan url API raja ongkir
                $key = 'f5ed16cb52b0f2936e98e7e22a4a02f5'; //Buat akun atau pakai API akun Tahu Coding
                $cost_url = 'https://api.rajaongkir.com/starter/cost';

                $address = Address::with('user')
                    ->join('users', 'addresses.user_id', '=', 'users.id')
                    ->select('addresses.*', 'users.email as email')
                    ->where('user_id', auth()->user()->id)
                    ->where('addresses.main_address', 1)
                    ->orderBy('addresses.updated_at', 'desc')
                    ->take(1)
                    ->get();
                // $old_cartItem = Cart::with('product')->where('user_id', Auth::id())->latest()->get();
                // foreach ($old_cartItem as $item) {
                //     if (!Product::where('id', $item->product_id)->where('stoke', '>=', $item->product_qty)->exists()) {
                //         $removeItem = Cart::where('user_id', Auth::id())->where('product_id', $item->product_id)->first();
                //         $removeItem->delete();
                //     }
                // }

                $cartItem = Product::with('user.gapoktan')->where('id', $product_id)->first();
                $cartItem->id = $product_id;
                $cartItem->user_id = $cartItem->user->name;
                $cartItem->photo_product = $cartItem->photo_product->take(1);
                $cartItem->stoke = $product_qty;
                $cartItem->price = $cartItem->price;
                $cartItem->name = $cartItem->name;
                $cartItem->slug = $cartItem->slug;
                $cartItem->origin_address = $cartItem->user->gapoktan[0]->city_id;
                //Variabel yang valuenya didapat dari request()
                if ($request->has('service')) {
                    $data_origin = $request->origin;
                    $data_destination = $request->destination_costumer;
                    $data_weight = $request->weight_product;
                    $data_courier = $request->courier;
                    $data_service = $request->service;

                    //logic untuk calculate cost
                    $response = Http::withoutVerifying()->retry(10, 200)->asForm()->withHeaders([
                        'key' => $key
                    ])->post($cost_url, [
                        'origin' => $data_origin,
                        'destination' => $data_destination,
                        'weight' => $data_weight,
                        'courier' => $data_courier
                    ]);

                    $result_cost = $response['rajaongkir']['results'][0]['costs'];
                } else {
                    $data_courier = "";
                    $data_service = "";
                    $result_cost = null;
                }

                return view('pages.checkout.buy_now', compact('cartItem', 'address', 'result_cost', 'data_service'));
            }
        }
    }

    public function check_ongkir(Request $request)
    {
        // //Variabel key dan url API raja ongkir
        $key = 'f5ed16cb52b0f2936e98e7e22a4a02f5'; //Buat akun atau pakai API akun Tahu Coding
        $cost_url = 'https://api.rajaongkir.com/starter/cost';

        if ($request->courier) {
            $data_origin = $request->origin;
            $data_destination = $request->destination_costumer;
            $data_weight = $request->weight_product;
            $data_courier = $request->courier;

            $response = Http::withoutVerifying()->retry(10, 200)->asForm()->withHeaders([
                'key' => $key
            ])->post($cost_url, [
                'origin' => $data_origin,
                'destination' => $data_destination,
                'weight' => $data_weight,
                'courier' => $data_courier
            ]);

            $result_cost = $response['rajaongkir']['results'][0]['costs'];
        } else {
            $result_cost = null;
        }

        return response()->json($result_cost);
    }

    public function placeOrder(Request $request)
    {
        $product_id = $request->id_product;
        $product_qty = $request->product_qty;

        $order = new Order();
        $order->user_id = auth()->user()->id; //

        $address = Address::with('user')
            ->join('users', 'addresses.user_id', '=', 'users.id')
            ->select('addresses.*', 'users.email as email')
            ->where('user_id', auth()->user()->id)
            ->where('addresses.main_address', 1)
            ->orderBy('addresses.updated_at', 'desc')
            ->take(1)
            ->get();

        foreach ($address as $address) {
            $order->address_id = $address->id; // alamat checkout
        }

        $cartItem_total = Product::where('id', $product_id)->first();
        $total = $cartItem_total->price * $product_qty;

        $orderDate = date('Y-m-d H:i:s');
        $paymentDue = (new \DateTime($orderDate))->modify('+1 day')->format('Y-m-d H:i:s');

        $order->total_price = $total + $request->priceService;
        $order->code = Order::generateCode();
        $order->status = Order::CREATED;
        $order->order_date = $orderDate;
        $order->payment_due = $paymentDue;
        $order->payment_status = Order::UNPAID;
        $order->save();

        $cartItem = Product::where('id', $product_id)->first();
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $cartItem->id,
            'qty' => $product_qty,
            'price' => $cartItem->price,
        ]);

        $this->initPaymentGateway();

        $customerDetails = [
            'first_name' => $address->recipients_name,
            'email' => $address->user->email,
            'phone' => $address->telp,
        ];

        $params = [
            'enable_payments' => \App\Models\Payment::PAYMENT_CHANNELS,
            'transaction_details' => [
                'order_id' => $order->code,
                'gross_amount' => $order->total_price,
            ],
            'customer_details' => $customerDetails,
            'expiry' => [
                'start_time' => date('Y-m-d H:i:s T'),
                'unit' => \App\Models\Payment::EXPIRY_UNIT,
                'duration' => \App\Models\Payment::EXPIRY_DURATION,
            ],
        ];

        $snap = \Midtrans\Snap::createTransaction($params);

        if ($snap->token) {
            $order->payment_token = $snap->token;
            $order->payment_url = $snap->redirect_url;
            $order->save();
        }

        if ($order) {
            // $cartItem = Cart::with('product')->where('user_id', Auth::id())->latest()->get();
            // Cart::destroy($cartItem);

            // Push Notification
            $user_id = auth()->user()->id;
            $url = "https://fcm.googleapis.com/fcm/send";
            $SERVER_API_KEY = 'AAAASSWA7hI:APA91bGkfIJFNGyqIJAiKtLXI79XdZpDuicn7pQrFv-yXdbLmLQETRkRkCY5VnGZBfwRevDkUJdA0ADnJ7Z5r1rnS4flS-ds8yxe_bp4sXouzH8Nfj-PHYCGl8-pVKkE49WqsSuPkKtd';
            $headers = [
                'Authorization' => 'key=' . $SERVER_API_KEY,
                'Content-Type' => 'application/json',
            ];

            PushNotification::create([
                'user_id' => auth()->user()->id,
                "title" => "Pemesanan berhasil dibuat",
                "body" => "Pesanan Anda telah dibuat, Silahkan melanjutkan pembayaran!",
                "img" => "icons8-create-order-96.png",
            ]);

            Http::withHeaders($headers)->post($url, [
                // "to" => "cWmdLu_QQqa6CR28k2aDtJ:APA91bHs2-K9fkZ7rOIUOvrq2bEtlxNpTUoZSn7-TpOcNpfmbwFRfhY1NPBCjYv53uCHJLfFPmsmG84pSWXmG2ezDVkv-opbrM-AaQ42j_UKso-qAqGWlMoJv0AhffI2NAaKTv9DIe0v",
                'to' => '/topics/topic_user_id_' . $user_id,
                "notification" => [
                    "title" => "Pemesanan berhasil dibuat",
                    "body" => "Pesanan Anda telah dibuat, Silahkan melanjutkan pembayaran!",
                    "mutable_content" => true,
                    "sound" => "Tri-tone"
                ]
            ]);

            $this->_sendEmailOrderReceived($order);

            Session::flash('success', 'Thank you. Your order has been received!');
            return response()->json([
                'status' => 200,
                'id' => $order->id
            ]);
            // return redirect('cart/shipment/place-order/received/' . $order->id);
        }

        // return redirect('cart/shipment');
        return response()->json([
            'status' => 401,
        ]);
    }

    /**
     * Send email order detail to current user
     *
     * @param Order $order order object
     *
     * @return void
     */
    private function _sendEmailOrderReceived($order)
    {
        \App\Jobs\SendMailOrderReceived::dispatch($order, Auth::user());
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
