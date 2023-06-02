<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Http\Controllers\Api\BaseApiController as BaseController;
use Illuminate\Http\Request;

class ReviewPublicApiController extends BaseController
{
    public function index()
    {
        $datas = Review::with('user', 'product')
            ->join('users', 'reviews.user_id', '=', 'users.id')
            ->join('products', 'reviews.product_id', '=', 'products.id')
            ->select('reviews.*', 'users.name as name_reviewer')->latest()->get();

        return $this->sendResponse($datas, 'Data fetched');
    }


    public function starRated($id)
    {
        $reviews = Review::where('product_id', $id)->get();
        $ratingSum = Review::where('product_id', $id)->sum('stars_rated');
        if ($reviews->count() > 0) {
            $ratingValue = $ratingSum / $reviews->count();
        } else {
            $ratingValue = 0;
        }
        // $rateNum = number_format($ratingValue);
        $response = [
            'length'    => $reviews->count(),
            'rate' => $ratingValue,
        ];

        return $response;
    }
}
