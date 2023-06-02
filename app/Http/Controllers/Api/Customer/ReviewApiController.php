<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseApiController as BaseController;
use App\Models\Review;

class ReviewApiController extends BaseController
{
    // public function index()
    // {
    //     $datas = Review::latest()->get();

    //     return $this->sendResponse($datas, 'Data fetched');
    // }

    public function store(Request $request)
    {

        $datas = Review::create([
            "product_id" => $request->product_id,
            "user_id" =>   $request->user_id,
            "order_id" => $request->order_id,
            "stars_rated" => $request->stars_rated,
            "review" => $request->review,
        ]);

        // $result = Review::make($datas);
        return $this->sendResponse($datas, 'Data fetched');

        // $user_id =  $request->user_id;
        // $order_id =  $request->input('order_id', []);
        // $product_id =  $request->input('product_id', []);
        // $stars_rated =  $request->input('stars_rated', []);
        // $review =  $request->input('review', []);
        // $units = [];
        // foreach ($stars_rated as $index => $unit) {
        //     $units[] = [
        //         "product_id" => $product_id[$index],
        //         "user_id" => $user_id,
        //         "order_id" => $order_id[$index],
        //         "stars_rated" => $stars_rated[$index],
        //         "review" => $review[$index],
        //     ];
        // }

        // Review::insert($units);


        // $orders = Order::where('id', $request->input('rev_order_id'))->first();
        // $orders->review = Order::REVIEWED;
        // $orders->update();

        // return $this->sendResponse($units, 'Data fetched');
    }
}
