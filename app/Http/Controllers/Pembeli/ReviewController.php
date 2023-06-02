<?php

namespace App\Http\Controllers\Pembeli;

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
        return view('costumer.ulasan.index');
    }

    public function fetchBelumDiulas()
    {
        $orders = Order::with('address', 'user', 'orderItems', 'review')
                    ->join('users', 'orders.user_id', '=', 'users.id')
                    ->join('addresses', 'orders.address_id', '=', 'addresses.id')
                    ->select('orders.*', 'addresses.recipients_name as name_billing')
                    ->where('orders.user_id', '=', auth()->user()->id)
                    ->where('orders.status', '=', 'completed')
                    ->where('orders.review', '=', null)
                    ->orderBy('orders.updated_at', 'desc')
                    ->get();

        foreach ($orders as $order) {
                $reviews = Review::with('user', 'product', 'order')
                        ->join('users', 'reviews.user_id', '=', 'users.id')
                        ->join('products', 'reviews.product_id', '=', 'products.id')
                        ->select('reviews.*', 'users.name as name_reviewer')
                        ->where('reviews.user_id', '=', auth()->user()->id)
                        ->where('reviews.order_id', '=', $order->id)
                        ->get();
        }

        $userInfo = Costumer::with('user')
            ->where('user_id', '=', auth()->user()->id)
            ->first();

		$output = '';
            if ($orders->count() > 0) {
                foreach ($orders as $order) {
                $output .= '<div class="border-bottom mb-2 pb-2">
                    <a href="/pembeli/daftar-transaksi/detail-order/'.$order->id.'" class="my-0 text-secondary text-xs font-weight-bold">'. $order->code .'</a>';
                    $output .= '<div class="d-flex align-items-center pt-3">';
                        if ($userInfo->image) {
                        $output .= '<img src="../storage/profile/'. $userInfo->image .'" class="rounded-circle shadow-sm" style="border: 1px solid #16A085; width: 55px; height: 55px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="'. $userInfo->user->name .'">';
                        } else {
                        $output .= '<img src="../stisla/assets/img/example-image.jpg" class="rounded-circle shadow-sm" style="border: 1px solid #16A085; width: 55px; height: 55px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="'. $userInfo->user->name .'">';
                        }
                        $output .= '<div>
                            <p class="my-0 mx-3 text-secondary text-xs font-weight-bold">'. $userInfo->user->name .'</p>';
                            foreach ($order->orderItems as $orderitem) {
                            $output .= '<div class="my-0 mx-3 rating-produkView">
                                <div class="star-icon" style="font-size: 10px; font-family: sans-serif; font-weight: 800; text-transform: uppercase;">';
                                $output .= '<i class="lni lni-star-filled checked"></i>';
                                $output .= '<i class="lni lni-star-filled checked"></i>';
                                $output .= '<i class="lni lni-star-filled checked"></i>';
                                $output .= '<i class="lni lni-star-filled checked"></i>';
                                $output .= '<i class="lni lni-star-filled checked"></i>';
                                $output .= '</div>
                                <div class="invalid-feedback">
                                </div>
                            </div>';
                            $output .= '<p class="my-1 mx-3 text-secondary text-xs">
                                '. \App\Helpers\General::datetimeFormat($order->order_date) .'</p>';
                            }
                        $output .= '</div>
                    </div>
                    <div class="m-3">';
                    $output .= '<p class="my-0 mx-3 text-danger text-xs font-weight-bold">Belum ada Ulasan</p>';
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
                            <p class="my-0 mx-3 text-secondary text-xs font-weight-bold text-truncate col-9">
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
                    ->select('orders.*', 'addresses.recipients_name as name_billing')
                    ->where('orders.user_id', '=', auth()->user()->id)
                    ->where('orders.status', '=', 'completed')
                    ->where('orders.review', '=', 'reviewed')
                    ->orderBy('orders.updated_at', 'desc')
                    ->get();

        foreach ($orders as $order) {
                $reviews = Review::with('user', 'product', 'order')
                        ->join('users', 'reviews.user_id', '=', 'users.id')
                        ->join('products', 'reviews.product_id', '=', 'products.id')
                        ->select('reviews.*', 'users.name as name_reviewer')
                        ->where('reviews.user_id', '=', auth()->user()->id)
                        ->where('reviews.order_id', '=', $order->id)
                        ->get();
        }

        $userInfo = Costumer::with('user')
            ->where('user_id', '=', auth()->user()->id)
            ->first();

		$output = '';
            if ($orders->count() > 0) {
                foreach ($orders as $order) {
                $output .= '<div class="border-bottom mb-2 pb-2">
                    <a href="/pembeli/daftar-transaksi/detail-order/'.$order->id.'" class="my-0 text-secondary text-xs font-weight-bold">'. $order->code .'</a>';
                    $output .= '<div class="d-flex align-items-center pt-3">';
                        if ($userInfo->image) {
                        $output .= '<img src="../storage/profile/'. $userInfo->image .'" class="rounded-circle shadow-sm" style="border: 1px solid #16A085; width: 55px; height: 55px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="'. $userInfo->user->name .'">';
                        } else {
                        $output .= '<img src="../stisla/assets/img/example-image.jpg" class="rounded-circle shadow-sm" style="border: 1px solid #16A085; width: 55px; height: 55px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="'. $userInfo->user->name .'">';
                        }
                        $output .= '<div>
                            <p class="my-0 mx-3 text-secondary text-xs font-weight-bold">'. $userInfo->user->name .'</p>';
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
                                $output .= '<p class="my-1 mx-3 text-secondary text-xs">
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
                                $output .= '<p class="my-0 mx-md-3 text-secondary text-justify text-xs font-weight-bold">'. $review->review .'</p>';
                                if ($review->reply_review) {
                                    $output .= '
                                        <div class="my-2 mx-md-3 border bg-primary text-white rounded p-2 text-justify text-xs"><p class="text-xs m-0 font-weight-bold pb-1">Respon Penjual :</p>'. $review->reply_review .'</div>
                                    ';
                                }
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
                            <p class="my-0 mx-3 text-secondary text-xs font-weight-bold text-truncate col-9">
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

    // handle insert a new employee ajax request
	public function addReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'stars_rated' => 'required',
            'review' => 'required',
        ], [
            'stars_rated.required' => 'Rating produk diperlukan!',
            'review.required' => 'Catatan review produk diperlukan!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $product_id =  $request->input('product_id', []);
            $order_id =  $request->input('order_id', []);
            $stars_rated =  $request->input('stars_rated', []);
            $review =  $request->input('review', []);
            $hide =  $request->input('hide') ? 1 : 0;
            $units = [];
            foreach ($stars_rated as $index => $unit) {
                $units[] = [
                    "product_id" => $product_id[$index],
                    "user_id" => auth()->user()->id,
                    "order_id" => $order_id[$index],
                    "stars_rated" => $stars_rated[$index],
                    "review" => $review[$index],
                    "hide" => $hide,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ];
            }

            Review::insert($units);

            $orders = Order::where('id', $request->input('rev_order_id'))->first();
            $orders->review = Order::REVIEWED;
            $orders->update();

            return response()->json([
                'status' => 200,
            ]);
        }
	}

    // handle update an employee ajax request
	public function updateUlasanSaya(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reviewed_stars_rated' => 'required',
            'reviewed_review' => 'required',
        ], [
            'reviewed_stars_rated.required' => 'Rating produk diperlukan!',
            'reviewed_review.required' => 'Catatan review produk diperlukan!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            if ($request->input('hide') == 0) {
                $id =  $request->input('reviewed_id', []);
                $product_id =  $request->input('reviewed_product_id', []);
                $stars_rated =  $request->input('reviewed_stars_rated', []);
                $hide =  $request->input('hide') ? 1 : 0;
                $review =  $request->input('reviewed_review', []);
                foreach ($id as $index => $unit) {
                    $data = array(
                        "product_id" => $product_id[$index],
                        "user_id" => auth()->user()->id,
                        "stars_rated" => $stars_rated[$index],
                        "review" => $review[$index],
                        "hide" => $hide,
                        "created_at" => Carbon::now(),
                        "updated_at" => Carbon::now(),
                    );

                    Review::where('id', $id[$index])
                    ->update($data);
                }
            } elseif ($request->input('hide') == 1) {
                $id =  $request->input('reviewed_id', []);
                $product_id =  $request->input('reviewed_product_id', []);
                $stars_rated =  $request->input('reviewed_stars_rated', []);
                $unhide =  $request->input('hide') ? 0 : 1;
                $review =  $request->input('reviewed_review', []);
                foreach ($id as $index => $unit) {
                    $data = array(
                        "product_id" => $product_id[$index],
                        "user_id" => auth()->user()->id,
                        "stars_rated" => $stars_rated[$index],
                        "review" => $review[$index],
                        "hide" => $unhide,
                        "created_at" => Carbon::now(),
                        "updated_at" => Carbon::now(),
                    );

                    Review::where('id', $id[$index])
                    ->update($data);
                }
            }



            return response()->json([
                'status' => 200,
            ]);
        }
	}
}
