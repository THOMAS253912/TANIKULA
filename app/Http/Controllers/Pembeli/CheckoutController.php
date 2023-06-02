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

class CheckoutController extends Controller
{
    public function index(Request $request)
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
        if ($cart_id)
        {
            $cartItem = Cart::with('product')->where('user_id', '=', auth()->user()->id)->where(static function ($query) use ($cart_id) {
                return $query->whereIn('id', $cart_id);
            })->latest()->get();
        }
            elseif ($navbar_cart_id)
        {
            $cartItem = Cart::with('product')->where('user_id', '=', auth()->user()->id)->where(static function ($query) use ($navbar_cart_id) {
                return $query->whereIn('id', $navbar_cart_id);
            })->latest()->get();
        } else {
            // $cartItem = Cart::with('product')->where('user_id', '=', auth()->user()->id)->where(static function ($query) use ($cart_id) {
            //     return $query->whereIn('id', $cart_id);
            // })->latest()->get();
            notify()->warning("Harap pilih produk!", "Peringatan", "topRight");
            return redirect()->back();
        }

        // $cartItem = Cart::with('product')->where('user_id', Auth::id())->latest()->get();

        //Variabel yang valuenya didapat dari request()
        if($request->has('service'))
        {
            $data_origin = 149;
            // $data_destination = $request->destination_costumer;
            $data_destination = 149;
            $data_weight = $request->weight_product;
            $data_courier = $request->courier;
            $data_service = $request->service;

            //logic untuk calculate cost
            $response = Http::retry(10, 200)->asForm()->withHeaders([
                'key' => $key
            ])->post($cost_url, [
                'origin' => $data_origin,
                'destination' => $data_destination,
                'weight' => $data_weight,
                'courier' => $data_courier
            ]);

            $result_cost = $response['rajaongkir']['results'][0]['costs'];
        }
        else{
            $data_courier = "";
            $data_service = "";
            $result_cost = null;
        }

        return view('pages.checkout.index', compact('cartItem', 'address', 'result_cost', 'data_service'));

    }

    //function untuk calculate cost
    // private function postData($key, $url,$data_origin,$data_destination,$data_weight,$data_courier){
    //     //retry() maskudnya function untuk retry hit API jika time out sebanyak parameter pertama dan range interval pada parameter kedua dalam milisecon
    //     //asForm() maksudnya menggunakan application/x-www-form-urlencoded content type biasanya untuk method POST
    //     //withHeaders() maksudnya parameter header (Jika diminta, masing2 API punya header masing-masing dan yang tidak pakai header)
    //     return Http::retry(10, 200)->asForm()->withHeaders([
    //         'key' => $key
    //     ])->post($cost_url, [
    //         'origin' => $data_origin,
    //         'destination' => $data_destination,
    //         'weight' => $data_weight,
    //         'courier' => $data_courier
    //     ]);
    //     //setelah $url itu adalah array yaitu parameter wajib yg dibutuhkan ketika meminta POST request
    // }

    public function check_ongkir(Request $request)
    {
        // //Variabel key dan url API raja ongkir
        $key = 'f5ed16cb52b0f2936e98e7e22a4a02f5'; //Buat akun atau pakai API akun Tahu Coding
        $cost_url = 'https://api.rajaongkir.com/starter/cost';

            if($request->courier)
            {
                $data_origin = 149;
                // $data_destination = $request->destination_costumer;
                $data_destination = 149;
                $data_weight = $request->weight_product;
                $data_courier = $request->courier;

                $response = Http::retry(10, 200)->asForm()->withHeaders([
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

    public function received($orderId)
    {
        $checkOrder = Order::with('address', 'user', 'orderItems')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('addresses', 'orders.address_id', '=', 'addresses.id')
            ->select('orders.*', 'addresses.recipients_name as name_billing')
            ->where('orders.user_id', '=', auth()->user()->id)
            ->where('orders.status', '!=', 'cancelled')
            ->where('orders.status', '!=', 'completed')
            ->where('orders.id', '=', $orderId)
            ->exists();
        if ($checkOrder)
        {
            $order = Order::with('address', 'user', 'orderItems')
                ->where('id', $orderId)
                ->where('user_id', Auth::user()->id)
                ->firstOrFail();

            return view('pages.order.index', compact('order'));
        } else {
            return redirect('/');
        }
    }

    public function placeOrder(Request $request)
    {
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

        $total = 0; // total item checkout
        $cartItem_total = Cart::with('product')->where('user_id', Auth::id())->latest()->get();
        foreach ($cartItem_total as $product_total)
        {
            $total += $product_total->product->price * $product_total->product_qty;
        }

        $orderDate = date('Y-m-d H:i:s');
        $paymentDue = (new \DateTime($orderDate))->modify('+1 day')->format('Y-m-d H:i:s');

        $order->total_price = $total + $request->priceService;
        $order->code = Order::generateCode();
        $order->status = Order::CREATED;
        $order->order_date = $orderDate;
        $order->payment_due = $paymentDue;
        $order->payment_status = Order::UNPAID;
        $order->save();

        $cart_id =  $request->input('cart_id_order', []);
        // $authorizedRoles = [$cart_id];
        // dd($authorizedRoles);
        $cartItem = Cart::with('product')->where('user_id', '=', auth()->user()->id)->where(static function ($query) use ($cart_id) {
            return $query->whereIn('id', $cart_id);
        })->latest()->get();
        foreach ($cartItem as $item) {
            // OrderItem::create([
            //     'order_id' => $order->id,
            //     'product_id' => $item->product_id,
            //     'qty' => $item->product_qty,
            //     'price' => $item->product->price,
            // ]);
            $orderItemCreate = new OrderItem();
            $orderItemCreate->order_id = $order->id;
            $orderItemCreate->product_id = $item->product_id;
            $orderItemCreate->qty = $item->product_qty;
            $orderItemCreate->price = $item->product->price;
            $orderItemCreate->save();

            // $orderItemCheck = OrderItem::where('order_id', $orderItemCreate->id)->get();
            // foreach ($orderItemCheck as $orderItem) {
            //     $prod = Product::where('id', $orderItem->product_id)->first();
            //     $prod->stoke = $prod->stoke - $orderItem->qty;
            //     if ($prod->stock_out == null) {
            //         $prod->stock_out = $orderItem->qty;
            //     } else {
            //         $prod->stock_out = $prod->stock_out + $orderItem->qty;
            //     }
            //     $prod->update();
            // }
        }

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
            $cart_id =  $request->input('cart_id_order', []);
            // $authorizedRoles = [$cart_id];
            // dd($authorizedRoles);
            $cartItemDestroy = Cart::with('product')->where('user_id', '=', auth()->user()->id)->where(static function ($query) use ($cart_id) {
                return $query->whereIn('id', $cart_id);
            })->latest()->get();
            // $cartItem = Cart::with('product')->where('user_id', Auth::id())->latest()->get();
            Cart::destroy($cartItemDestroy);

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

    // handle fetch all eamployees ajax request
    public function fetchAll()
    {
        $emps = Address::with('user')
            ->join('users', 'addresses.user_id', '=', 'users.id')
            ->select('addresses.*', 'users.email as email')
            ->where('user_id', auth()->user()->id)
            ->orderBy('addresses.main_address', 'desc')
            ->get();
        $output = '';
        if ($emps->count() > 0) {
            foreach ($emps as $emp) {
                $output .= '
                <div class="body mt-2 border border-success">';
                if ($emp->main_address == 1) {
                    $output .= '<div class="card-body rounded" style="background-color: hsl(110, 100%, 75%);">';
                } else if ($emp->main_address == 0) {
                    $output .= '<div class="card-body rounded">';
                }
                $output .= '<div class="row align-items-center">
                            <div>';
                if ($emp->main_address == 1) {
                    $output .= '<p class="fw-bold text-black mb-2">' . $emp->recipients_name . '
                                    <span class="fw-normal">(' . $emp->address_label . ') </span>
                                    <svg class="text-success" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-patch-check-fill" viewBox="0 0 16 16">
                                    <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"/>
                                    </svg>
                                </p>';
                } else if ($emp->main_address == 0) {
                    $output .= '<p class="fw-bold text-black mb-2">' . $emp->recipients_name . '
                                    <span class="fw-normal">(' . $emp->address_label . ') </span>
                                </p>';
                }
                $output .= '</div>
                            <div class="col-12 mt-2 mt-md-0">
                            <p class="mb-2 fw-bold text-black">' . $emp->telp . '</p>
                                <p>';
                                    if ($emp->village_id && $emp->district_id && $emp->city_id && $emp->province_id != null) {
                                        $output .= '' . $emp->village->name . ', Kecamatan '. $emp->district->name .', '. $emp->city->name .', Provinsi '. $emp->province->name .'';
                                    }$output .= ', '.$emp->postal_code.'. [TaniKula Note:
                                        '.$emp->complete_address.' '.$emp->note_for_courier.'].</p>
                                    <p>';
                                    if ($emp->village_id && $emp->district_id && $emp->city_id && $emp->province_id != null) {
                                        $output .= ''. $emp->district->name .', ';
                                    }$output .= ''.$emp->postal_code.'.</p>
                            </div>
                        </div>
                        <div class="d-flex flex-row align-items-center justify-content-between justify-content-md-start">
                            <a href="#" id="' . $emp->id . '" class="mt-2 fw-bold editAlamat" type="button" data-bs-toggle="modal" data-bs-target="#EditAlamat" style="color: #16A085" data-bs-dismiss="modal">Edit alamat</a>';
                if ($emp->main_address == 1) {
                    $output .= '<a class="mt-2 ms-md-3 fw-bold text-white px-2 rounded" style="background: #16A085">Alamat utama</a>';
                } else if ($emp->main_address == 0) {
                    $output .= '<a href="#" id="' . $emp->id . '" class="mt-2 ms-md-3 bg-light fw-bold updateMainAddress border px-2 rounded" style="color: #16A085">Jadikan alamat utama</a>';
                }
                $output .= '</div>
                    </div>
                </div>
                ';
            }
            echo $output;
            // <div class="d-flex flex-row justify-content-between">
            //     <p class="fw-bold text-black mb-2 col-8 col-md-8">' . $emp->recipients_name .'
            //         <span class="fw-normal">('.$emp->address_label.') </span>
            //         <svg class="text-success" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-patch-check-fill" viewBox="0 0 16 16">
            //         <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"/>
            //         </svg>
            //     </p>
            //     <a href="#" id="' . $emp->id . '" class="text-danger fw-bold deleteIcon"><i class="bi-trash h4"></i></a>
            // </div>
        } else {
            echo '<h5 class="text-center text-secondary my-5">Tidak ada Alamat!</h5>';
        }
    }

    // handle insert a new employee ajax request
    public function addAlamat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recipients_name' => 'required|max:255',
            'telp' => 'required',
            'address_label' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',
            'postal_code' => 'required|max:5',
            'complete_address' => 'required',
            // 'note_for_courier' => 'required',
        ], [
            'recipients_name.required' => 'Nama penerima diperlukan!',
            'recipients_name.max' => 'Nama penerima maksimal 255 karakter!',
            'telp.required' => 'Nomor telephone diperlukan!',
            'address_label.required' => 'Label alamat diperlukan!',
            'province_id.required' => 'Provinsi diperlukan!',
            'city_id.required' => 'Kota/Kabupaten diperlukan!',
            'district_id.required' => 'Kecamatan diperlukan!',
            'village_id.required' => 'Kelurahan/Desa diperlukan!',
            'postal_code.required' => 'Kode pos diperlukan!',
            'complete_address.required' => 'Alamat lengkap diperlukan!',
            // 'note_for_courier.required' => 'Catatan untuk kurir diperlukan!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            if ($request->main_address ? 1 : 0) {
                $addressOld = Address::where('user_id', auth()->user()->id)->latest()->get();
                foreach ($addressOld as $item) {
                    if ($item->main_address == 1) {
                        $datasFound = Address::findOrFail($item->id);
                        $datasFound->main_address = 0;
                        $datasFound->update();
                    }
                }
            }

            $address = new Address();
            $address->recipients_name = $request->recipients_name;
            $address->address_label = $request->address_label;
            $address->postal_code = $request->postal_code;
            if ($request->province_id && $request->city_id && $request->district_id && $request->village_id) {
                $address->province_id = $request->province_id;
                $address->city_id = $request->city_id;
                $address->district_id = $request->district_id;
                $address->village_id = $request->village_id;
            }
            $address->telp = $request->telp;
            $address->complete_address = $request->complete_address;
            $address->note_for_courier = $request->note_for_courier;
            $address->main_address = $request->main_address ? 1 : 0;
            $address->user_id = auth()->user()->id;
            $address->save();

            return response()->json([
                'status' => 200,
            ]);
        }
    }

    public function editAddress(Request $request)
    {
        $id = $request->id;
        $emp = Address::with('user')
            ->join('users', 'addresses.user_id', '=', 'users.id')
            ->select('addresses.*', 'users.email as email')
            ->where('user_id', auth()->user()->id)
            ->find($id);
        return response()->json($emp);
    }

    // handle update an employee ajax request
    public function updateAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recipients_name' => 'required|max:255',
            'telp' => 'required',
            'address_label' => 'required',
            'postal_code' => 'required|max:5',
            'complete_address' => 'required',
            // 'note_for_courier' => 'required',
        ], [
            'recipients_name.required' => 'Nama penerima diperlukan!',
            'recipients_name.max' => 'Nama penerima maksimal 255 karakter!',
            'telp.required' => 'Nomor telephone diperlukan!',
            'address_label.required' => 'Label alamat diperlukan!',
            'postal_code.required' => 'Kode pos diperlukan!',
            'complete_address.required' => 'Alamat lengkap diperlukan!',
            // 'note_for_courier.required' => 'Catatan untuk kurir diperlukan!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            if ($request->main_address ? 1 : 0) {
                $addressOld = Address::where('user_id', auth()->user()->id)->latest()->get();
                foreach ($addressOld as $item) {
                    if ($item->main_address == 1) {
                        $datasFound = Address::findOrFail($item->id);
                        $datasFound->main_address = 0;
                        $datasFound->update();
                    }
                }
            }

            $address = Address::find($request->emp_id);
            $address->recipients_name = $request->recipients_name;
            $address->address_label = $request->address_label;
            $address->postal_code = $request->postal_code;
            if ($request->province_id && $request->city_id && $request->district_id && $request->village_id) {
                $address->province_id = $request->province_id;
                $address->city_id = $request->city_id;
                $address->district_id = $request->district_id;
                $address->village_id = $request->village_id;
            }
            $address->telp = $request->telp;
            $address->complete_address = $request->complete_address;
            $address->note_for_courier = $request->note_for_courier;
            $address->main_address = $request->main_address ? 1 : 0;
            $address->user_id = auth()->user()->id;
            $address->update();

            return response()->json([
                'status' => 200,
            ]);
        }
    }

    // handle update an employee ajax request
    public function updateMainAddress(Request $request)
    {
        $id = $request->id;
        $addressCheck = Address::where('id', $id)->where('main_address', '0')->first();
        if ($addressCheck) {
            $addressOld = Address::where('user_id', auth()->user()->id)->latest()->get();
            foreach ($addressOld as $item) {
                if ($item->main_address == 1) {
                    $datasFound = Address::findOrFail($item->id);
                    $datasFound->main_address = 0;
                    $datasFound->update();
                }
            }
        }

        $address = Address::findOrFail($id);
        if ($request->main_address == 0) {
            $address->main_address = 1;
        }
        $address->update();

        return response()->json([
            'status' => 200,
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
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
    }
}
