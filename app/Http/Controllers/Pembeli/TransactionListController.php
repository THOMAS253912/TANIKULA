<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\Costumer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class TransactionListController extends Controller
{
    public function index()
    {
        return view('costumer.transaction_list.index');
    }

    public function fetchAll()
    {
        $emps = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('addresses', 'orders.address_id', '=', 'addresses.id')
            ->select('orders.*', 'addresses.recipients_name as name_billing')
            ->where('orders.user_id', '=', auth()->user()->id)
            ->orderBy('orders.created_at', 'desc')
            ->get();
        $output = '';
        $output .= '<table id="listTableSemua" class="table align-items-center mb-0">
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
                                                <h6 class="mb-0 text-sm">' . $emp->code . '</h6>
                                                <p class="text-xs text-secondary mb-0">' . \App\Helpers\General::datetimeFormat($emp->order_date) . '</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">Rp. ' . number_format($emp->total_price, 0) . '</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">' . $emp->name_billing . '</h6>
                                            <p class="text-xs text-secondary mb-0">' . $emp->user->email . '</p>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold text-capitalize">' . $emp->status . '</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold text-capitalize">' . $emp->payment_status . '</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="/pembeli/daftar-transaksi/detail-order/' . $emp->id . '" class="text-secondary font-weight-bold text-xs">
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

    public function fetchDikemas()
    {
        $emps = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('addresses', 'orders.address_id', '=', 'addresses.id')
            ->select('orders.*', 'addresses.recipients_name as name_billing')
            ->where('orders.user_id', '=', auth()->user()->id)
            ->where('orders.status', '=', 'confirmed')
            ->orderBy('orders.created_at', 'desc')
            ->get();
        $output = '';
        $output .= '<table id="listTableDikemas" class="table align-items-center mb-0">
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
                                                <h6 class="mb-0 text-sm">' . $emp->code . '</h6>
                                                <p class="text-xs text-secondary mb-0">' . \App\Helpers\General::datetimeFormat($emp->order_date) . '</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">Rp. ' . number_format($emp->total_price, 0) . '</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">' . $emp->name_billing . '</h6>
                                            <p class="text-xs text-secondary mb-0">' . $emp->user->email . '</p>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold text-capitalize">' . $emp->status . '</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold text-capitalize">' . $emp->payment_status . '</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="/pembeli/daftar-transaksi/detail-order/' . $emp->id . '" class="text-secondary font-weight-bold text-xs">
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

    public function fetchDikirim()
    {
        $emps = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('addresses', 'orders.address_id', '=', 'addresses.id')
            ->select('orders.*', 'addresses.recipients_name as name_billing')
            ->where('orders.user_id', '=', auth()->user()->id)
            ->where('orders.status', '=', 'delivered')
            ->orderBy('orders.created_at', 'desc')
            ->get();
        $output = '';
        $output .= '<table id="listTableDikirim" class="table align-items-center mb-0">
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
                                                <h6 class="mb-0 text-sm">' . $emp->code . '</h6>
                                                <p class="text-xs text-secondary mb-0">' . \App\Helpers\General::datetimeFormat($emp->order_date) . '</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">Rp. ' . number_format($emp->total_price, 0) . '</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">' . $emp->name_billing . '</h6>
                                            <p class="text-xs text-secondary mb-0">' . $emp->user->email . '</p>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold text-capitalize">' . $emp->status . '</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold text-capitalize">' . $emp->payment_status . '</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="/pembeli/daftar-transaksi/detail-order/' . $emp->id . '" class="text-secondary font-weight-bold text-xs">
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

    public function fetchSelesai()
    {
        $emps = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('addresses', 'orders.address_id', '=', 'addresses.id')
            ->select('orders.*', 'addresses.recipients_name as name_billing')
            ->where('orders.user_id', '=', auth()->user()->id)
            ->where('orders.status', '=', 'completed')
            ->orderBy('orders.created_at', 'desc')
            ->get();
        $output = '';
        $output .= '<table id="listTableSelesai" class="table align-items-center mb-0">
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
                                                <h6 class="mb-0 text-sm">' . $emp->code . '</h6>
                                                <p class="text-xs text-secondary mb-0">' . \App\Helpers\General::datetimeFormat($emp->order_date) . '</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">Rp. ' . number_format($emp->total_price, 0) . '</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">' . $emp->name_billing . '</h6>
                                            <p class="text-xs text-secondary mb-0">' . $emp->user->email . '</p>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold text-capitalize">' . $emp->status . '</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold text-capitalize">' . $emp->payment_status . '</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="/pembeli/daftar-transaksi/detail-order/' . $emp->id . '" class="text-secondary font-weight-bold text-xs">
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

    public function fetchDibatalkan()
    {
        $emps = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('addresses', 'orders.address_id', '=', 'addresses.id')
            ->select('orders.*', 'addresses.recipients_name as name_billing')
            ->where('orders.user_id', '=', auth()->user()->id)
            ->where('orders.status', '=', 'cancelled')
            ->orderBy('orders.created_at', 'desc')
            ->get();
        $output = '';
        $output .= '<table id="listTableDibatalkan" class="table align-items-center mb-0">
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
                                                <h6 class="mb-0 text-sm">' . $emp->code . '</h6>
                                                <p class="text-xs text-secondary mb-0">' . \App\Helpers\General::datetimeFormat($emp->order_date) . '</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">Rp. ' . number_format($emp->total_price, 0) . '</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">' . $emp->name_billing . '</h6>
                                            <p class="text-xs text-secondary mb-0">' . $emp->user->email . '</p>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold text-capitalize">' . $emp->status . '</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold text-capitalize">' . $emp->payment_status . '</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="/pembeli/daftar-transaksi/detail-order/' . $emp->id . '" class="text-secondary font-weight-bold text-xs">
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

    public function viewTransactionList($id)
    {
        $checkOrder = Order::with('address', 'user', 'orderItems')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('addresses', 'orders.address_id', '=', 'addresses.id')
            ->select('orders.*', 'addresses.recipients_name as name_billing')
            ->where('orders.user_id', '=', auth()->user()->id)
            ->where('orders.id', '=', $id)
            ->exists();
        if ($checkOrder) {
            $order = Order::with('address', 'user', 'orderItems')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->join('addresses', 'orders.address_id', '=', 'addresses.id')
                ->select('orders.*', 'addresses.recipients_name as name_billing')
                ->where('orders.user_id', '=', auth()->user()->id)
                // ->where('orders.id', '=', $id)
                ->find($id);

            $reviews = Review::with('user', 'product')
                ->join('users', 'reviews.user_id', '=', 'users.id')
                ->join('products', 'reviews.product_id', '=', 'products.id')
                ->select('reviews.*', 'users.name as name_reviewer')
                ->where('reviews.user_id', '=', auth()->user()->id)
                ->where('reviews.order_id', '=', $id)
                ->get();

            $userInfo = Costumer::with('user')
                ->where('user_id', '=', auth()->user()->id)
                ->first();

            return view('costumer.transaction_list.detail', compact('order', 'reviews', 'userInfo'));
        } else {
            return redirect('/pembeli/daftar-transaksi');
        }
    }

    // handle update an employee ajax request
	public function orderCompleted(Request $request)
    {
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
            $orders->status = Order::COMPLETED;
			$orders->update();

            return response()->json([
                    'status' => 200,
                ]);
        }
	}
}
