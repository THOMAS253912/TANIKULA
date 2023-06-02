<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kutia\Larafirebase\Facades\Larafirebase;
use App\Http\Controllers\Api\BaseApiController as BaseController;
use App\Http\Resources\ProductResource;
use App\Models\Gapoktan;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;

class ProductCustomerApiController extends BaseController
{
    public function index()
    {
        // $datas = Product::where("is_active", 1)->latest()->get();
        $datas = Product::orderBy('id', 'DESC')->paginate(6)->where("is_active", 1);

        $result = ProductResource::collection($datas);
        return $this->sendResponse($result, 'Data fetched');
    }

    public function detail($slug)
    {
        $datas = Product::where("slug", "=", $slug)->first();

        $result = ProductResource::make($datas);
        return $this->sendResponse($result, 'Data fetched');
        if ($datas) {
            # code...xsxs
        } else {
            $result = [];
            return $this->sendResponse($result, 'Data fetched');
        }
    }

    public function search($name)
    {
        $datas = Product::orderBy('id', 'DESC')
            ->where('name', 'LIKE', '%' . $name . '%')
            ->where('is_active', '=', 1)
            ->paginate(8);

        $result = ProductResource::collection($datas);
        return $this->sendResponse($result, 'Data fetched');
    }

    public function category($id)
    {
        $datas = Product::orderBy('id', 'DESC')
            ->where('category_product_id', '=', $id)
            ->where('is_active', '=', 1)
            ->paginate(8);

        $result = ProductResource::collection($datas);
        return $this->sendResponse($result, 'Data fetched');
    }

    public function tokoById($id)
    {
        $datas = Gapoktan::where('user_id', '=', $id)->first();
        return $this->sendResponse($datas, 'Data fetched');
    }

    public function viewCategory(Request $request, $slug)
    {
        if (ProductCategory::where('slug', $slug)->exists()) {
            $category_product = ProductCategory::where('slug', $slug)->first();
            if ($request->filter_price == 'max_price') {
                $product = Product::with('photo_product')
                    ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                    ->join('users', 'products.user_id', '=', 'users.id')
                    ->select('products.*', 'product_categories.name as category_name')
                    ->where('category_product_id', $category_product->id)
                    ->where('product_categories.is_active', '=', 1)
                    ->where('products.is_active', '=', 1)
                    ->orderBy('products.price', 'desc')
                    ->get();
            } else if ($request->filter_price == 'min_price') {
                $product = Product::with('photo_product')
                    ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                    ->join('users', 'products.user_id', '=', 'users.id')
                    ->select('products.*', 'product_categories.name as category_name')
                    ->where('category_product_id', $category_product->id)
                    ->where('product_categories.is_active', '=', 1)
                    ->where('products.is_active', '=', 1)
                    ->orderBy('products.price', 'asc')
                    ->get();
            } else {
                $product = Product::with('photo_product')
                    ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                    ->join('users', 'products.user_id', '=', 'users.id')
                    ->select('products.*', 'product_categories.name as category_name')
                    ->where('category_product_id', $category_product->id)
                    ->where('product_categories.is_active', '=', 1)
                    ->where('products.is_active', '=', 1)
                    ->orderBy('products.updated_at', 'desc')
                    ->get();
            }

            // return view('pages.category.index', compact('category_product', 'product'));
            return $this->sendResponse($product, 'Data fetched');
        } else {
            return redirect('/')->with('status', 'Kategori Produk tidak ditemukan');
        }
    }

    public function sendnofit()
    {
        try {
            $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();

            //Notification::send(null,new SendPushNotification($request->title,$request->message,$fcmTokens));

            /* or */

            //auth()->user()->notify(new SendPushNotification($title,$message,$fcmTokens));

            /* or */

            Larafirebase::withTitle("tes 1")
                ->withBody("tes 1 body")
                ->sendMessage($fcmTokens);
        } catch (\Exception $e) {
        }
    }
}
