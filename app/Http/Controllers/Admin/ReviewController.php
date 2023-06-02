<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Costumer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function index()
    {
        return view('admin.ulasan.index');
    }

    public function countReview()
    {
        $countOrder = Order::with('address', 'user', 'orderItems', 'review')
                    ->join('users', 'orders.user_id', '=', 'users.id')
                    ->join('addresses', 'orders.address_id', '=', 'addresses.id')
                    ->join('reviews', 'reviews.order_id', '=', 'orders.id')
                    ->select('orders.*', 'addresses.recipients_name as name_billing')
                    ->where('orders.status', '=', 'completed')
                    ->where('orders.review', '=', 'reviewed')
                    ->where('reviews.reply_review', '=', null)
                    ->orderBy('orders.updated_at', 'desc')
                    ->count();

            return response()->json(['count'=> $countOrder]);
    }

    public function fetchBelumDiulas()
    {
        $orders = Order::with('address', 'user', 'orderItems', 'review')
                    ->join('users', 'orders.user_id', '=', 'users.id')
                    ->join('addresses', 'orders.address_id', '=', 'addresses.id')
                    ->join('reviews', 'reviews.order_id', '=', 'orders.id')
                    ->select('orders.*', 'addresses.recipients_name as name_billing')
                    ->where('orders.status', '=', 'completed')
                    ->where('orders.review', '=', 'reviewed')
                    ->where('reviews.reply_review', '=', null)
                    ->orderBy('orders.updated_at', 'desc')
                    ->get();

        foreach ($orders as $order) {
                $reviews = Review::with('user', 'product', 'order')
                        ->join('users', 'reviews.user_id', '=', 'users.id')
                        ->join('products', 'reviews.product_id', '=', 'products.id')
                        ->select('reviews.*', 'users.name as name_reviewer')
                        ->where('reviews.order_id', '=', $order->id)
                        ->get();
        }

        $userInfo = Costumer::with('user')
            ->first();

            $output = '';
            if ($orders->count() > 0) {
                foreach ($orders as $order) {
                $output .= '<div class="border-bottom mb-2 pb-2">
                    <a href="/admin/pesanan/detail-pesanan/'.$order->id.'" class="my-0 text-xs font-weight-bold" style="color: #007bff;">'. $order->code .'</a>';
                    $output .= '<div class="d-flex align-items-center pt-3">';
                        if ($userInfo->image) {
                        $output .= '<img src="../storage/profile/'. $userInfo->image .'" class="rounded-circle shadow-sm" style="border: 1px solid #16A085; width: 55px; height: 55px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="'. $userInfo->user->name .'">';
                        } else {
                        $output .= '<img src="../stisla/assets/img/example-image.jpg" class="rounded-circle shadow-sm" style="border: 1px solid #16A085; width: 55px; height: 55px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="'. $userInfo->user->name .'">';
                        }
                        $output .= '<div>
                            <p class="my-0 mx-3 text-xs font-weight-bold">'. $userInfo->user->name .'</p>';
                            foreach ($order->orderItems as $orderitem) {
                            $output .= '<div class="my-0 mx-3 rating-produkView">
                                <div class="star-icon" style="color: #f0d800; font-size: 10px; font-family: sans-serif; font-weight: 800; text-transform: uppercase;">';
                                    foreach ($orderitem->product->review as $review ) {
                                        if ($review->order_id == $order->id) {
                                            for ($i=1; $i<=$review->stars_rated; $i++) {
                                                $output .= '<i class="lni lni-star-filled checked"></i>';
                                            }
                                            for ($j = $review->stars_rated+1; $j <=5; $j++) {
                                                $output .= '<i class="lni lni-star"></i>';
                                            }
                                        }
                                    }
                                $output .= '</div>
                                <div class="invalid-feedback">
                                </div>
                            </div>';
                            foreach ($orderitem->product->review as $review) {
                                if ($review->order_id == $order->id) {
                                $output .= '<p class="my-1 mx-3 text-xs">
                                    '. \App\Helpers\General::datetimeFormat($review->created_at) .'</p>';
                                    }
                                }
                            }
                        $output .= '</div>
                    </div>
                    <div class="m-3">';
                    foreach ($order->orderItems as $orderitem) {
                        foreach ($orderitem->product->review as $review) {
                            if ($review->order_id == $order->id) {
                                $output .= '<p class="my-0 mx-3 text-justify text-xs font-weight-bold">'. $review->review .'</p>';
                            }
                        }
                    }
                    $output .= '</div>
                    ';
                foreach ($order->orderItems as $orderitem) {
                $output .= '<div class="d-flex mb-1 align-items-center py-2 rounded bg-light px-3">';
                        if ($orderitem->product->photo_product->count() > 0) {
                            foreach ($orderitem->product->photo_product->take(1) as $photos) {
                            $output .= '<img src="../storage/produk/'.$photos->name.'" class="img-fluid rounded"
                                style="width: 7rem; height: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="'. $orderitem->product->name .'">';
                            }
                        } else {
                            $output .= '<img src="../img/no-image.png" class="img-fluid rounded"
                                style="width: 7rem; height: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="'. $orderitem->product->name .'">';
                        }
                        $output .= '<div>
                            <p class="my-0 mx-3 text-xs font-weight-bold text-truncate col-9">
                                '. $orderitem->product->name .'</p>
                        </div>';
                    $output .= '</div>';
                        }
                $output .= '</div>';
            }
		    echo $output;
		} else {
			echo '<div id="app">
                    <section class="section">
                        <div class="container">
                            <div class="page-error">
                                <div class="page-inner">
                                    <div class="page-description">
                                        Tidak ada ulasan!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>';
		}
	}

    public function fetchUlasanSaya()
    {
		$orders = Order::with('address', 'user', 'orderItems', 'review')
                    ->join('users', 'orders.user_id', '=', 'users.id')
                    ->join('addresses', 'orders.address_id', '=', 'addresses.id')
                    ->join('reviews', 'reviews.order_id', '=', 'orders.id')
                    ->select('orders.*', 'addresses.recipients_name as name_billing')
                    ->where('orders.status', '=', 'completed')
                    ->where('orders.review', '=', 'reviewed')
                    ->whereNotNull('reviews.reply_review')
                    ->orderBy('orders.updated_at', 'desc')
                    ->get();

        foreach ($orders as $order) {
                $reviews = Review::with('user', 'product', 'order')
                        ->join('users', 'reviews.user_id', '=', 'users.id')
                        ->join('products', 'reviews.product_id', '=', 'products.id')
                        ->select('reviews.*', 'users.name as name_reviewer')
                        ->where('reviews.order_id', '=', $order->id)
                        ->get();
        }

        $userInfo = Costumer::with('user')
            ->first();

		$output = '';
            if ($orders->count() > 0) {
                foreach ($orders as $order) {
                $output .= '<div class="border-bottom mb-2 pb-2">
                    <a href="/admin/pesanan/detail-pesanan/'.$order->id.'" class="my-0 text-xs font-weight-bold" style="color: #007bff;">'. $order->code .'</a>';
                    $output .= '<div class="d-flex align-items-center pt-3">';
                        if ($userInfo->image) {
                        $output .= '<img src="../storage/profile/'. $userInfo->image .'" class="rounded-circle shadow-sm" style="border: 1px solid #16A085; width: 55px; height: 55px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="'. $userInfo->user->name .'">';
                        } else {
                        $output .= '<img src="../stisla/assets/img/example-image.jpg" class="rounded-circle shadow-sm" style="border: 1px solid #16A085; width: 55px; height: 55px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="'. $userInfo->user->name .'">';
                        }
                        $output .= '<div>
                            <p class="my-0 mx-3 text-xs font-weight-bold">'. $userInfo->user->name .'</p>';
                            foreach ($order->orderItems as $orderitem) {
                            $output .= '<div class="my-0 mx-3 rating-produkView">
                                <div class="star-icon" style="color: #f0d800; font-size: 10px; font-family: sans-serif; font-weight: 800; text-transform: uppercase;">';
                                    foreach ($orderitem->product->review as $review ) {
                                        if ($review->order_id == $order->id) {
                                            for ($i=1; $i<=$review->stars_rated; $i++) {
                                                $output .= '<i class="lni lni-star-filled checked"></i>';
                                            }
                                            for ($j = $review->stars_rated+1; $j <=5; $j++) {
                                                $output .= '<i class="lni lni-star"></i>';
                                            }
                                        }
                                    }
                                $output .= '</div>
                                <div class="invalid-feedback">
                                </div>
                            </div>';
                            foreach ($orderitem->product->review as $review) {
                                if ($review->order_id == $order->id) {
                                $output .= '<p class="my-1 mx-3 text-xs">
                                    '. \App\Helpers\General::datetimeFormat($review->created_at) .'</p>';
                                    }
                                }
                            }
                        $output .= '</div>
                    </div>
                    <div class="m-3">';
                    foreach ($order->orderItems as $orderitem) {
                        foreach ($orderitem->product->review as $review) {
                            if ($review->order_id == $order->id) {
                                $output .= '<p class="my-0 mx-3 text-justify text-xs font-weight-bold">'. $review->review .'</p>';
                                $output .= '
                                    <label style="color: #007bff;" class="mx-3 text-xs"><i class="bi bi-arrow-return-right"></i> Balasan Ulasan</label>
                                    <p class="my-0 mx-3 border rounded p-2 text-justify text-xs font-weight-bold">'. $review->reply_review .'</p>
                                ';
                            }
                        }
                    }
                    $output .= '</div>
                    ';
                foreach ($order->orderItems as $orderitem) {
                $output .= '<div class="d-flex mb-1 align-items-center py-2 rounded bg-light px-3">';
                        if ($orderitem->product->photo_product->count() > 0) {
                            foreach ($orderitem->product->photo_product->take(1) as $photos) {
                            $output .= '<img src="../storage/produk/'.$photos->name.'" class="img-fluid rounded"
                                style="width: 7rem; height: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="'. $orderitem->product->name .'">';
                            }
                        } else {
                            $output .= '<img src="../img/no-image.png" class="img-fluid rounded"
                                style="width: 7rem; height: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="'. $orderitem->product->name .'">';
                        }
                        $output .= '<div>
                            <p class="my-0 mx-3 text-xs font-weight-bold text-truncate col-9">
                                '. $orderitem->product->name .'</p>
                        </div>';
                    $output .= '</div>';
                        }
                $output .= '</div>';
            }
		    echo $output;
		} else {
			echo '<div id="app">
                    <section class="section">
                        <div class="container">
                            <div class="page-error">
                                <div class="page-inner">
                                    <div class="page-description">
                                        Tidak ada ulasan!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>';
		}
	}
}
