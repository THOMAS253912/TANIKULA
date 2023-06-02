<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class WaitingPaymentController extends Controller
{
    public function index()
    {
        return view('costumer.waiting_payment.index');
    }

    public function fetchAll()
    {
		$emps = Order::join('users', 'orders.user_id', '=', 'users.id')
                    ->join('addresses', 'orders.address_id', '=', 'addresses.id')
                    ->select('orders.*', 'addresses.recipients_name as name_billing')
                    ->where('orders.user_id', '=', auth()->user()->id)
                    ->where('orders.payment_status', '=', 'unpaid')
                    ->where('orders.status', '=', 'created')
                    ->orderBy('orders.created_at', 'desc')
                    ->get();
		$output = '';
                    $output .= '<table id="tableWaitingPayment" class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    ID Pesanan</th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Total Bayar</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Nama Pemesan</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Status Pesanan</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Status Pembayaran</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>';
                        if ($emps->count() > 0) {
                        foreach ($emps as $emp) {
                            $output .= '
                                <tr>
                                    <td>
                                        <div class="px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">'. $emp->code .'</h6>
                                                <p class="text-xs text-secondary mb-0">'. \App\Helpers\General::datetimeFormat($emp->order_date) .'</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">Rp. '. number_format($emp->total_price, 0) .'</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">'. $emp->name_billing .'</h6>
                                            <p class="text-xs text-secondary mb-0">'. $emp->user->email .'</p>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold text-capitalize">'. $emp->status .'</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold text-capitalize">'. $emp->payment_status .'</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="/pembeli/menunggu-pembayaran/detail-order/'.$emp->id.'" class="text-secondary font-weight-bold text-xs">
                                            Detail Pesanan
                                        </a>
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

    public function viewWaitingPayment($id)
    {
        $checkOrder = Order::with('address', 'user', 'orderItems')
                        ->join('users', 'orders.user_id', '=', 'users.id')
                        ->join('addresses', 'orders.address_id', '=', 'addresses.id')
                        ->select('orders.*', 'addresses.recipients_name as name_billing')
                        ->where('orders.user_id', '=', auth()->user()->id)
                        ->where('orders.payment_status', '=', 'unpaid')
                        ->where('orders.status', '=', 'created')
                        ->where('orders.id', '=', $id)
                        ->exists();
        if ($checkOrder) {
            $order = Order::with('address', 'user', 'orderItems')
                        ->join('users', 'orders.user_id', '=', 'users.id')
                        ->join('addresses', 'orders.address_id', '=', 'addresses.id')
                        ->select('orders.*', 'addresses.recipients_name as name_billing')
                        ->where('orders.user_id', '=', auth()->user()->id)
                        ->where('orders.payment_status', '=', 'unpaid')
                        ->where('orders.status', '=', 'created')
                        // ->where('orders.id', '=', $id)
                        ->find($id);
            return view('costumer.waiting_payment.detail', compact('order'));
        } else {
            return redirect('/pembeli/menunggu-pembayaran');
        }
    }

    // handle update an employee ajax request
	public function updateWaitingPayment(Request $request) {
        $validator = Validator::make($request->all(), [
            'cancellation_note' => 'required',
        ], [
            'cancellation_note.required' => 'Silahkan pilih alasan pembatalan pesanan!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {

            $orders = Order::find($request->emp_id);
            $orders->status = Order::CANCELLED;
            $orders->cancelled_by = auth()->user()->id;
            $orders->cancelled_at = Carbon::now()->format('Y-m-d H:i:s');
            $orders->cancellation_note = $request->input('cancellation_note');
            // if ($orders->orderItems->count() > 0) {
            //     foreach ($orders->orderItems as $item) {
			// 		$products = Product::where('id', $item->product_id)->first();
            //         $countProduct = $products->stoke + $item->qty;
            //         $stockOutProduct = $products->stock_out - $item->qty;
            //         $products->stoke = $countProduct;
            //         $products->stock_out = $stockOutProduct;
            //         $products->update();
			// 	}
            // }
            $orders->update();

            return response()->json([
                    'status' => 200,
                ]);
        }
	}

    public function deleteOrders(Request $request, $id)
    {
        $deleteOrder = Order::where('id', $id);
        $deleteOrder->delete();

        return response()->json([
            'status' => 200,
        ]);
    }
}
