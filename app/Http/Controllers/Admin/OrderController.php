<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\Costumer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function countOrder()
    {
        $countOrder = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('addresses', 'orders.address_id', '=', 'addresses.id')
            ->select('orders.*', 'addresses.recipients_name as name_billing')
            ->where('orders.payment_status', '=', 'paid')
            ->where('orders.status', '=', 'confirmed')
            ->orderBy('orders.created_at', 'desc')
            ->count();

        return response()->json(['count'=> $countOrder]);
    }

    public function index()
    {
        return view('admin.pesanan.index');
    }

    public function fetchAll()
    {
		$emps = Order::join('users', 'orders.user_id', '=', 'users.id')
                ->join('addresses', 'orders.address_id', '=', 'addresses.id')
                ->select('orders.*', 'addresses.recipients_name as name_billing')
                ->orderBy('orders.created_at', 'desc')
                ->get();
		$output = '';
           if ($emps->count() > 0) {
			$output .= '<table id="listTableSemua" class="table table-striped table-sm text-center align-middle">
            <thead class="text-darken">
                <th class="align-middle text-center text-sm">No.</th>
                <th class="align-middle text-center text-sm">
                    ID Pesanan
                </th>
                <th class="align-middle text-center text-sm">
                    Total Bayar
                </th>
                <th class="align-middle text-center text-sm">
                    Nama Pemesan
                </th>
                <th class="align-middle text-center text-sm">
                    Status Pesanan
                </th>
                <th class="align-middle text-center text-sm">
                    Status Pembayaran
                </th>
                <th class="align-middle text-center text-sm">
                </th>
            </thead>
            <tbody>';
            $nomor=1;
			foreach ($emps as $emp) {
                // if ($emp->gapoktan->user->name == auth()->user()->name) {
                $output .= '<tr>';
                $output .= '<td class="align-middle text-center">' . $nomor++ . '</td>';
                $output .= '<td class="align-middle text-center">
                    <div class="d-flex flex-column justify-content-center">
                        <p class="m-0 text-sm font-weight-bold">'. $emp->code .'</p>
                        <p class="text-xs m-0">
                            '. \App\Helpers\General::datetimeFormat($emp->order_date) .'</p>
                        </div>
                    </td>
                    <td class="align-middle text-center">
                        <p class="text-xs font-weight-bold m-0">Rp.
                            '. number_format($emp->total_price, 0) .'</p>
                        </td>
                    <td class="align-middle text-center text-sm">
                        <div class="d-flex flex-column justify-content-center">
                            <p class="m-0 text-sm">'. $emp->name_billing .'</p>
                            <p class="text-xs m-0">'. $emp->user->email .'</p>
                        </div>
                    </td>
                    <td class="align-middle text-center">
                        <span
                            class="text-xs font-weight-bold text-capitalize">'. $emp->status .'</span>
                        </td>
                    <td class="align-middle text-center">
                        <span
                            class="text-xs font-weight-bold text-capitalize">'. $emp->payment_status .'</span>
                    </td>
                    <td class="align-middle text-center">
                        <a href="/admin/pesanan/detail-pesanan/'.$emp->id.'" style="color: #007bff;" class="font-weight-bold text-xs">
                            Detail Pesanan
                        </a>
                    </td>
                </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h5 class="text-center text-secondary my-5">Belum ada pesanan!</h5>';
		}
	}

    public function fetchDikemas()
    {
		$emps = Order::join('users', 'orders.user_id', '=', 'users.id')
                    ->join('addresses', 'orders.address_id', '=', 'addresses.id')
                    ->select('orders.*', 'addresses.recipients_name as name_billing')
                    ->where('orders.payment_status', '=', 'paid')
                    ->where('orders.status', '=', 'confirmed')
                    ->orderBy('orders.created_at', 'desc')
                    ->get();
		$output = '';
           if ($emps->count() > 0) {
			$output .= '<table id="tableDikemas" class="table table-striped table-sm text-center align-middle">
            <thead class="text-darken">
                <th class="align-middle text-center text-sm">No.</th>
                <th class="align-middle text-center text-sm">
                    ID Pesanan
                </th>
                <th class="align-middle text-center text-sm">
                    Total Bayar
                </th>
                <th class="align-middle text-center text-sm">
                    Nama Pemesan
                </th>
                <th class="align-middle text-center text-sm">
                    Status Pesanan
                </th>
                <th class="align-middle text-center text-sm">
                    Status Pembayaran
                </th>
                <th class="align-middle text-center text-sm">
                </th>
            </thead>
            <tbody>';
            $nomor=1;
			foreach ($emps as $emp) {
                // if ($emp->gapoktan->user->name == auth()->user()->name) {
                $output .= '<tr>';
                $output .= '<td class="align-middle text-center">' . $nomor++ . '</td>';
                $output .= '<td class="align-middle text-center">
                    <div class="d-flex flex-column justify-content-center">
                        <p class="m-0 text-sm font-weight-bold">'. $emp->code .'</p>
                        <p class="text-xs m-0">
                            '. \App\Helpers\General::datetimeFormat($emp->order_date) .'</p>
                        </div>
                    </td>
                    <td class="align-middle text-center">
                        <p class="text-xs font-weight-bold m-0">Rp.
                            '. number_format($emp->total_price, 0) .'</p>
                        </td>
                    <td class="align-middle text-center text-sm">
                        <div class="d-flex flex-column justify-content-center">
                            <p class="m-0 text-sm">'. $emp->name_billing .'</p>
                            <p class="text-xs m-0">'. $emp->user->email .'</p>
                        </div>
                    </td>
                    <td class="align-middle text-center">
                        <span
                            class="text-xs font-weight-bold text-capitalize">'. $emp->status .'</span>
                        </td>
                    <td class="align-middle text-center">
                        <span
                            class="text-xs font-weight-bold text-capitalize">'. $emp->payment_status .'</span>
                    </td>
                    <td class="align-middle text-center">
                        <a href="/admin/pesanan/detail-pesanan/'.$emp->id.'" style="color: #007bff;" class="font-weight-bold text-xs">
                            Detail Pesanan
                        </a>
                    </td>
                </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h5 class="text-center text-secondary my-5">Belum ada pesanan!</h5>';
		}
	}

    public function fetchDikirim()
    {
		$emps = Order::join('users', 'orders.user_id', '=', 'users.id')
                    ->join('addresses', 'orders.address_id', '=', 'addresses.id')
                    ->select('orders.*', 'addresses.recipients_name as name_billing')
                    ->where('orders.payment_status', '=', 'paid')
                    ->where('orders.status', '=', 'delivered')
                    ->orderBy('orders.created_at', 'desc')
                    ->get();
		$output = '';
           if ($emps->count() > 0) {
			$output .= '<table id="tableDikirim" class="table table-striped table-sm text-center align-middle">
            <thead class="text-darken">
                <th class="align-middle text-center text-sm">No.</th>
                <th class="align-middle text-center text-sm">
                    ID Pesanan
                </th>
                <th class="align-middle text-center text-sm">
                    Total Bayar
                </th>
                <th class="align-middle text-center text-sm">
                    Nama Pemesan
                </th>
                <th class="align-middle text-center text-sm">
                    Status Pesanan
                </th>
                <th class="align-middle text-center text-sm">
                    Status Pembayaran
                </th>
                <th class="align-middle text-center text-sm">
                </th>
            </thead>
            <tbody>';
            $nomor=1;
			foreach ($emps as $emp) {
                // if ($emp->gapoktan->user->name == auth()->user()->name) {
                $output .= '<tr>';
                $output .= '<td class="align-middle text-center">' . $nomor++ . '</td>';
                $output .= '<td class="align-middle text-center">
                    <div class="d-flex flex-column justify-content-center">
                        <p class="m-0 text-sm font-weight-bold">'. $emp->code .'</p>
                        <p class="text-xs m-0">
                            '. \App\Helpers\General::datetimeFormat($emp->order_date) .'</p>
                        </div>
                    </td>
                    <td class="align-middle text-center">
                        <p class="text-xs font-weight-bold m-0">Rp.
                            '. number_format($emp->total_price, 0) .'</p>
                        </td>
                    <td class="align-middle text-center text-sm">
                        <div class="d-flex flex-column justify-content-center">
                            <p class="m-0 text-sm">'. $emp->name_billing .'</p>
                            <p class="text-xs m-0">'. $emp->user->email .'</p>
                        </div>
                    </td>
                    <td class="align-middle text-center">
                        <span
                            class="text-xs font-weight-bold text-capitalize">'. $emp->status .'</span>
                        </td>
                    <td class="align-middle text-center">
                        <span
                            class="text-xs font-weight-bold text-capitalize">'. $emp->payment_status .'</span>
                    </td>
                    <td class="align-middle text-center">
                        <a href="/admin/pesanan/detail-pesanan/'.$emp->id.'" style="color: #007bff;" class="font-weight-bold text-xs">
                            Detail Pesanan
                        </a>
                    </td>
                </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h5 class="text-center text-secondary my-5">Belum ada pesanan!</h5>';
		}
	}

    public function fetchSelesai()
    {
		$emps = Order::join('users', 'orders.user_id', '=', 'users.id')
                    ->join('addresses', 'orders.address_id', '=', 'addresses.id')
                    ->select('orders.*', 'addresses.recipients_name as name_billing')
                    ->where('orders.payment_status', '=', 'paid')
                    ->where('orders.status', '=', 'completed')
                    ->orderBy('orders.created_at', 'desc')
                    ->get();
		$output = '';
           if ($emps->count() > 0) {
			$output .= '<table id="tableSelesai" class="table table-striped table-sm text-center align-middle">
            <thead>
                <th class="align-middle text-center text-sm">No.</th>
                <th class="align-middle text-center text-sm">
                    ID Pesanan
                </th>
                <th class="align-middle text-center text-sm">
                    Total Bayar
                </th>
                <th class="align-middle text-center text-sm">
                    Nama Pemesan
                </th>
                <th class="align-middle text-center text-sm">
                    Status Pesanan
                </th>
                <th class="align-middle text-center text-sm">
                    Status Pembayaran
                </th>
                <th class="align-middle text-center text-sm">
                </th>
            </thead>
            <tbody>';
            $nomor=1;
			foreach ($emps as $emp) {
                // if ($emp->gapoktan->user->name == auth()->user()->name) {
                $output .= '<tr>';
                $output .= '<td class="align-middle text-center">' . $nomor++ . '</td>';
                $output .= '<td class="align-middle text-center">
                    <div class="d-flex flex-column justify-content-center">
                        <p class="m-0 text-sm font-weight-bold">'. $emp->code .'</p>
                        <p class="text-xs m-0">
                            '. \App\Helpers\General::datetimeFormat($emp->order_date) .'</p>
                        </div>
                    </td>
                    <td class="align-middle text-center">
                        <p class="text-xs font-weight-bold m-0">Rp.
                            '. number_format($emp->total_price, 0) .'</p>
                        </td>
                    <td class="align-middle text-center text-sm">
                        <div class="d-flex flex-column justify-content-center">
                            <p class="m-0 text-sm">'. $emp->name_billing .'</p>
                            <p class="text-xs m-0">'. $emp->user->email .'</p>
                        </div>
                    </td>
                    <td class="align-middle text-center">
                        <span
                            class="text-xs font-weight-bold text-capitalize">'. $emp->status .'</span>
                        </td>
                    <td class="align-middle text-center">
                        <span
                            class="text-xs font-weight-bold text-capitalize">'. $emp->payment_status .'</span>
                    </td>
                    <td class="align-middle text-center">
                        <a href="/admin/pesanan/detail-pesanan/'.$emp->id.'" style="color: #007bff;" class="font-weight-bold text-xs">
                            Detail Pesanan
                        </a>
                    </td>
                </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h5 class="text-center text-secondary my-5">Belum ada pesanan!</h5>';
		}
	}

    public function fetchDibatalkan()
    {
		$emps = Order::join('users', 'orders.user_id', '=', 'users.id')
                    ->join('addresses', 'orders.address_id', '=', 'addresses.id')
                    ->select('orders.*', 'addresses.recipients_name as name_billing')
                    ->where('orders.status', '=', 'cancelled')
                    ->orderBy('orders.created_at', 'desc')
                    ->get();
		$output = '';
           if ($emps->count() > 0) {
			$output .= '<table id="listTableDibatalkan" class="table table-striped table-sm text-center align-middle">
            <thead>
                <th class="align-middle text-center text-sm">No.</th>
                <th class="align-middle text-center text-sm">
                    ID Pesanan
                </th>
                <th class="align-middle text-center text-sm">
                    Total Bayar
                </th>
                <th class="align-middle text-center text-sm">
                    Nama Pemesan
                </th>
                <th class="align-middle text-center text-sm">
                    Status Pesanan
                </th>
                <th class="align-middle text-center text-sm">
                    Status Pembayaran
                </th>
                <th class="align-middle text-center text-sm">
                </th>
            </thead>
            <tbody>';
            $nomor=1;
			foreach ($emps as $emp) {
                // if ($emp->gapoktan->user->name == auth()->user()->name) {
                $output .= '<tr>';
                $output .= '<td class="align-middle text-center">' . $nomor++ . '</td>';
                $output .= '<td class="align-middle text-center">
                    <div class="d-flex flex-column justify-content-center">
                        <p class="m-0 text-sm font-weight-bold">'. $emp->code .'</p>
                        <p class="text-xs m-0">
                            '. \App\Helpers\General::datetimeFormat($emp->order_date) .'</p>
                        </div>
                    </td>
                    <td class="align-middle text-center">
                        <p class="text-xs font-weight-bold m-0">Rp.
                            '. number_format($emp->total_price, 0) .'</p>
                        </td>
                    <td class="align-middle text-center text-sm">
                        <div class="d-flex flex-column justify-content-center">
                            <p class="m-0 text-sm">'. $emp->name_billing .'</p>
                            <p class="text-xs m-0">'. $emp->user->email .'</p>
                        </div>
                    </td>
                    <td class="align-middle text-center">
                        <span
                            class="text-xs font-weight-bold text-capitalize">'. $emp->status .'</span>
                        </td>
                    <td class="align-middle text-center">
                        <span
                            class="text-xs font-weight-bold text-capitalize">'. $emp->payment_status .'</span>
                    </td>
                    <td class="align-middle text-center">
                        <a href="/admin/pesanan/detail-pesanan/'.$emp->id.'" style="color: #007bff;" class="font-weight-bold text-xs">
                            Detail Pesanan
                        </a>
                    </td>
                </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h5 class="text-center text-secondary my-5">Belum ada pesanan!</h5>';
		}
	}

    public function viewOrder($id)
    {
        $order = Order::join('users', 'orders.user_id', '=', 'users.id')
                ->join('addresses', 'orders.address_id', '=', 'addresses.id')
                ->select('orders.*', 'addresses.recipients_name as name_billing')
                ->orderBy('orders.created_at', 'desc')
                ->find($id);

        $reviews = Review::with('user', 'product')
                ->join('users', 'reviews.user_id', '=', 'users.id')
                ->join('products', 'reviews.product_id', '=', 'products.id')
                ->select('reviews.*', 'users.name as name_reviewer')
                ->where('reviews.order_id', '=', $id)
                ->get();

        $userInfo = Costumer::with('user')
                ->first();

        return view('admin.pesanan.detail', compact('order', 'reviews', 'userInfo'));
    }

    // handle update an employee ajax request
	public function updateOrder(Request $request) {
        $validator = Validator::make($request->all(), [
            // Required
        ], [
            // Validator
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else
        {
            $orders = Order::find($request->emp_id);
            $orders->status = Order::DELIVERED;
			$orders->update();

            return response()->json([
                    'status' => 200,
                ]);
        }
	}

    // handle insert a new employee ajax request
	public function replyReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //
        ], [
            //
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $review_id =  $request->input('review_id', []);
            $reply_review =  $request->input('reply_review', []);
            foreach ($review_id as $index => $unit) {
                $data = array(
                    "reply_review" => $reply_review[$index],
                );

                Review::where('id', $review_id[$index])
                ->update($data);
            }

            return response()->json([
                'status' => 200,
            ]);
        }
	}
}
