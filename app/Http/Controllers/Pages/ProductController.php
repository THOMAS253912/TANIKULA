<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\PhotoProduct;
use App\Models\Cart;
use App\Models\Gapoktan;
use App\Models\Order;
use App\Models\RoomChat;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\User;
use App\Models\PushNotification;
use App\Models\UserChat;

class ProductController extends Controller
{
    public function readNotif()
    {
        $readNotif = PushNotification::where('user_id', auth()->user()->id)->get();
        foreach ($readNotif as $read) {
            $read_notifs = PushNotification::find($read->id);
            $read_notifs->is_read = 1;
            $read_notifs->update();
        }

        return response()->json([
            'status' => 200,
        ]);
    }

    // public function readNotifData(Request $request)
    // {
    //     $id = $request->input('id');
    //     $readNotif = PushNotification::where('user_id', auth()->user()->id)->where('id', $id)->first();
    //     foreach ($readNotif as $read) {
    //         $read_notifs = PushNotification::find($read->id);
    //         if ($read->is_read == 0) {
    //             $read_notifs->is_read = 1;
    //         }
    //         $read_notifs->update();
    //     }

    //     return response()->json([
    //         'status' => 200,
    //     ]);
    // }

    public function index()
    {
        $category_product = ProductCategory::where('is_active', '=', 1)->take(12)->latest()->get();
        return view('pages.home.index', compact('category_product'));
    }

    public function fetchallHomeNewProduct(Request $request)
    {
        $product_new = Product::with('photo_product', 'review')
            ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
            ->join('users', 'products.user_id', '=', 'users.id')
            ->select('products.*', 'product_categories.name as category_name')
            ->where('product_categories.is_active', '=', 1)
            ->where('products.is_active', '=', 1)
            ->orderBy('products.updated_at', 'desc')
            ->take(8)
            ->get();
        $output = '';
        if ($product_new->count() > 0) {
            foreach ($product_new as $item) {
                $output .= '
                <div class="col-lg-3 col-md-6 col-12">';
                if ($item->stoke === 0) {
                    $output .= '<div class="single-product bg-light opacity-90" style="height: 26rem; border: 1px solid #16A085;">
                        <div class="product-image bg-light opacity-90">';
                } else {
                    $output .= '<div class="single-product" style="height: 26rem; border: 1px solid #16A085;">
                        <div class="product-image">';
                }
                $output .= '
                            <a href="home/' . $item->slug . '">';
                if ($item->stoke === 0) {
                    $output .= '<div style="z-index: 3" class="badge bg-danger px-3 position-absolute top-50 start-50 translate-middle"><h5 class="text-white">Stok Habis</h5></div>';
                }
                if ($item->photo_product->count() > 0) {
                    foreach ($item->photo_product->take(1) as $photos) {
                        if ($photos->name) {
                            $output .= '<img src="../storage/produk/' . $photos->name . '" alt="' . $item->name . '"
                                            style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                        } else {
                            $output .= '<img src="img/no-image.png" alt="' . $item->name . '"
                                            style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                        }
                    }
                } else {
                    $output .= '<img src="img/no-image.png" alt="' . $item->name . '"
                                    style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                }
                $output .= '</a>
                        </div>';
                if ($item->stoke === 0) {
                    $output .= '<div class="product-info bg-light opacity-90">';
                } else {
                    $output .= '<div class="product-info">';
                }
                if ($item->discount != 0) {
                    $output .= '<div class="d-flex justify-content-between">
                                    <a href="product-category/' . $item->product_category->slug . '">
                                        <span class="category">' . $item->category_name . '</span>
                                    </a>
                                    <p class="small badge bg-danger">' . $item->discount . '% OFF</p>
                                </div>';
                } else {
                    $output .= '<a href="product-category/' . $item->product_category->slug . '">
                                    <span class="category">' . $item->category_name . '</span>
                                </a>';
                }
                $output .= '<p class="small" style="color:#16A085;">Stok tersisa ' . $item->stoke . '</p>
                            <h4 class="title">
                                <a href="home/' . $item->slug . '"
                                    style="color:#16A085; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; overflow: hidden;">' . $item->name . '</a>
                            </h4>
                            <ul class="review">
                                <div>';
                if ($item->stock_out) {
                    $output .= '<span>' . $item->stock_out . ' Terjual</span>';
                } else {
                    $output .= '<span>0 Terjual</span>';
                }
                $output .= '</div>';
                $reviews = Review::where('product_id', $item->id)->get();
                $ratingSum = Review::where('product_id', $item->id)->sum('stars_rated');
                if ($reviews->count() > 0) {
                    $ratingValue = $ratingSum / $reviews->count();
                } else {
                    $ratingValue = 0;
                }
                $rateNum = number_format($ratingValue);
                for ($i = 1; $i <= $rateNum; $i++) {
                    $output .= '<li><i class="lni lni-star-filled"></i></li>';
                }
                for ($j = $rateNum + 1; $j <= 5; $j++) {
                    $output .= '<li><i class="lni lni-star"></i></li>';
                }
                $output .= '</ul>
                            <div class="price">';
                if ($item->price_discount) {
                    $output .= '<span class="text-decoration-line-through text-muted " style="font-size: 13px">Rp. ' . number_format($item->price_discount, 0) . ' <span>Rp. ' . number_format($item->price, 0) . '</span></span>';
                } else {
                    $output .= '<span>Rp. ' . number_format($item->price, 0) . '</span>';
                }
                $output .= '</div>
                        </div>
                    </div>
                    <!-- End Single Product -->
                </div>
                ';
            }
            echo $output;
        } else {
            if (request('pencarian')) {
                echo '<div id="app">
                    <section class="section">
                        <div class="container">
                            <div class="page-error">
                                <div class="page-inner">
                                    <img src="img/undraw_empty_re_opql.svg" alt="">
                                    <div class="page-description">
                                        Tidak ada produk terbaru!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>';
            } else {
                echo '<div id="app">
                    <section class="section">
                        <div class="container">
                            <div class="page-error">
                                <div class="page-inner">
                                    <img src="../img/undraw_empty_re_opql.svg" alt="">
                                    <div class="page-description">
                                        Tidak ada produk yang diposting!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>';
            }
        }
    }

    public function fetchallHomeSearchProduct(Request $request)
    {
        $product_search = Product::with('photo_product', 'review', 'orderItems')
            ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
            ->join('users', 'products.user_id', '=', 'users.id')
            ->select('products.*', 'product_categories.name as category_name')
            ->where('product_categories.is_active', '=', 1)
            ->where('products.is_active', '=', 1)
            ->orderBy('products.updated_at', 'desc')
            ->orderByRaw('RAND()')
            ->take(8)
            ->get();
        $output = '';
        if ($product_search->count() > 0) {
            foreach ($product_search as $item) {
                $output .= '
                <div class="col-lg-3 col-md-6 col-12">';
                if ($item->stoke === 0) {
                    $output .= '<div class="single-product bg-light opacity-90" style="height: 26rem; border: 1px solid #16A085;">
                        <div class="product-image bg-light opacity-90">';
                } else {
                    $output .= '<div class="single-product" style="height: 26rem; border: 1px solid #16A085;">
                        <div class="product-image">';
                }
                $output .= '
                            <a href="home/' . $item->slug . '">';
                if ($item->stoke === 0) {
                    $output .= '<div style="z-index: 3" class="badge bg-danger px-3 position-absolute top-50 start-50 translate-middle"><h5 class="text-white">Stok Habis</h5></div>';
                }
                if ($item->photo_product->count() > 0) {
                    foreach ($item->photo_product->take(1) as $photos) {
                        if ($photos->name) {
                            $output .= '<img src="../storage/produk/' . $photos->name . '" alt="' . $item->name . '"
                                            style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                        } else {
                            $output .= '<img src="img/no-image.png" alt="' . $item->name . '"
                                            style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                        }
                    }
                } else {
                    $output .= '<img src="img/no-image.png" alt="' . $item->name . '"
                                    style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                }
                $output .= '</a>
                        </div>';
                if ($item->stoke === 0) {
                    $output .= '<div class="product-info bg-light opacity-90">';
                } else {
                    $output .= '<div class="product-info">';
                }
                if ($item->discount != 0) {
                    $output .= '<div class="d-flex justify-content-between">
                                    <a href="product-category/' . $item->product_category->slug . '">
                                        <span class="category">' . $item->category_name . '</span>
                                    </a>
                                    <p class="small badge bg-danger">' . $item->discount . '% OFF</p>
                                </div>';
                } else {
                    $output .= '<a href="product-category/' . $item->product_category->slug . '">
                                    <span class="category">' . $item->category_name . '</span>
                                </a>';
                }
                $output .= '<p class="small" style="color:#16A085;">Stok tersisa ' . $item->stoke . '</p>
                            <h4 class="title">
                                <a href="home/' . $item->slug . '"
                                    style="color:#16A085; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; overflow: hidden;">' . $item->name . '</a>
                            </h4>
                            <ul class="review">
                                <div>';
                if ($item->stock_out) {
                    $output .= '<span>' . $item->stock_out . ' Terjual</span>';
                } else {
                    $output .= '<span>0 Terjual</span>';
                }
                $output .= '</div>';
                $reviews = Review::where('product_id', $item->id)->get();
                $ratingSum = Review::where('product_id', $item->id)->sum('stars_rated');
                if ($reviews->count() > 0) {
                    $ratingValue = $ratingSum / $reviews->count();
                } else {
                    $ratingValue = 0;
                }
                $rateNum = number_format($ratingValue);
                for ($i = 1; $i <= $rateNum; $i++) {
                    $output .= '<li><i class="lni lni-star-filled"></i></li>';
                }
                for ($j = $rateNum + 1; $j <= 5; $j++) {
                    $output .= '<li><i class="lni lni-star"></i></li>';
                }
                $output .= '</ul>
                            <div class="price">';
                if ($item->price_discount) {
                    $output .= '<span class="text-decoration-line-through text-muted " style="font-size: 13px">Rp. ' . number_format($item->price_discount, 0) . ' <span>Rp. ' . number_format($item->price, 0) . '</span></span>';
                } else {
                    $output .= '<span>Rp. ' . number_format($item->price, 0) . '</span>';
                }
                $output .= '</div>
                        </div>
                    </div>
                    <!-- End Single Product -->
                </div>
                ';
            }
            echo $output;
        } else {
            if (request('pencarian')) {
                echo '<div id="app">
                    <section class="section">
                        <div class="container">
                            <div class="page-error">
                                <div class="page-inner">
                                    <img src="img/undraw_empty_re_opql.svg" alt="">
                                    <div class="page-description">
                                        Tidak ada produk terbaru!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>';
            } else {
                echo '<div id="app">
                    <section class="section">
                        <div class="container">
                            <div class="page-error">
                                <div class="page-inner">
                                    <img src="../img/undraw_empty_re_opql.svg" alt="">
                                    <div class="page-description">
                                        Tidak ada produk yang diposting!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>';
            }
        }
    }

    public function detailProduct($slug)
    {
        if (Product::where('slug', $slug)->exists()) {
            $product = Product::with('photo_product')
                ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select(['products.*', 'product_categories.name as category_name','users.name'])
                ->where('products.slug', $slug)
                ->orderBy('products.updated_at', 'desc')
                ->first();

            $product_new = Product::with('photo_product', 'review')
                ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select('products.*', 'product_categories.name as category_name')
                ->where('product_categories.is_active', '=', 1)
                ->where('products.slug', '!=',  $slug)
                ->where('products.is_active', '=', 1)
                ->orderBy('products.updated_at', 'desc')
                ->get();

            $showReviews = Review::where('product_id', $product->id)->get();
            $reviews = Review::where('product_id', $product->id)->get();
            $ratingSum = Review::where('product_id', $product->id)->sum('stars_rated');
            if ($reviews->count() > 0) {
                $ratingValue = $ratingSum / $reviews->count();
            } else {
                $ratingValue = 0;
            }

            // $photoProduct = PhotoProduct::where('product_id', $product->id)->get();
            return view('pages.home.detail', compact('product', 'product_new', 'reviews', 'ratingValue', 'showReviews'));
        } else {
            notify()->warning("Produk tidak ditemukan!", "Peringatan", "topRight");
            return redirect('/');
        }
    }

    public function countCart()
    {
        if (Auth::user()) {
            $countCart = Cart::join('products', 'carts.product_id', 'products.id')
                ->select('carts.*', 'products.name as name')
                ->where('carts.user_id', auth()->user()->id)
                ->where('products.stoke', '!=', 0)
                ->sum('product_qty');
        } elseif (Auth::guest()) {
            $countCart = 0;
        }
        return response()->json(['count' => $countCart]);
    }

    public function countNotif()
    {
        if (Auth::user()) {
            $countNotif = PushNotification::where('user_id', Auth::id())->where('is_read', 0)->count();
        } elseif (Auth::guest()) {
            $countNotif = 0;
        }
        return response()->json(['count' => $countNotif]);
    }

    public function cartIncrement($id)
    {
        $cartItem = Cart::with('product')->where('id', $id)->latest()->get();
        foreach ($cartItem as $cartItem) {
            Cart::with('product')->where('id', $id)->update([
                'product_qty' => $cartItem->product_qty + 1,
            ]);
        }
        return response()->json();
    }

    public function cartDecrement($id)
    {
        $cartItem = Cart::with('product')->where('id', $id)->latest()->get();
        foreach ($cartItem as $cartItem) {
            Cart::with('product')->where('id', $id)->update([
                'product_qty' => $cartItem->product_qty - 1,
            ]);
        }
        return response()->json();
    }

    public function searchAllProduct(Request $request)
    {
        if ($request->harga_tertinggi == 'harga_tertinggi') {
            $product_new = Product::with('photo_product')
                ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select('products.*', 'product_categories.name as category_name')
                ->where('product_categories.is_active', '=', 1)
                ->where('products.is_active', '=', 1)
                ->filter(request(['pencarian']))
                ->orderBy('products.price', 'desc')
                ->get();
        } else if ($request->harga_terendah == 'harga_terendah') {
            $product_new = Product::with('photo_product')
                ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select('products.*', 'product_categories.name as category_name')
                ->where('product_categories.is_active', '=', 1)
                ->where('products.is_active', '=', 1)
                ->filter(request(['pencarian']))
                ->orderBy('products.price', 'asc')
                ->get();
        } else {
            $product_new = Product::with('photo_product')
                ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select('products.*', 'product_categories.name as category_name')
                ->where('product_categories.is_active', '=', 1)
                ->where('products.is_active', '=', 1)
                ->filter(request(['pencarian']))
                ->orderBy('products.updated_at', 'desc')
                ->get();
        }
        return view('pages.home.search_product', compact('product_new'));
    }

    public function newProduct()
    {
        $countProduct = Product::with('photo_product')
            ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
            ->join('users', 'products.user_id', '=', 'users.id')
            ->select('products.*', 'product_categories.name as category_name')
            ->where('product_categories.is_active', '=', 1)
            ->where('products.is_active', '=', 1)
            ->orderBy('products.updated_at', 'desc')
            ->count();
        return view('pages.home.product_new', compact('countProduct'));
    }

    public function fetchAllNewProduct(Request $request)
    {
        if ($request->max_price == 'max_price') {
            $product_new = Product::with('photo_product')
                ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select('products.*', 'product_categories.name as category_name')
                ->where('product_categories.is_active', '=', 1)
                ->where('products.is_active', '=', 1)
                ->orderBy('products.price', 'desc')
                ->get();
        } else if ($request->min_price == 'min_price') {
            $product_new = Product::with('photo_product')
                ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select('products.*', 'product_categories.name as category_name')
                ->where('product_categories.is_active', '=', 1)
                ->where('products.is_active', '=', 1)
                ->orderBy('products.price', 'asc')
                ->get();
        } else {
            $product_new = Product::with('photo_product')
                ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select('products.*', 'product_categories.name as category_name')
                ->where('product_categories.is_active', '=', 1)
                ->where('products.is_active', '=', 1)
                ->orderBy('products.updated_at', 'desc')
                ->get();
        }
        $output = '';
        if ($product_new->count() > 0) {
            foreach ($product_new as $item) {
                $output .= '
                <div class="col-lg-3 col-md-6 col-12">';
                if ($item->stoke === 0) {
                    $output .= '<div class="single-product bg-light opacity-90" style="height: 26rem; border: 1px solid #16A085;">
                        <div class="product-image bg-light opacity-90">';
                } else {
                    $output .= '<div class="single-product" style="height: 26rem; border: 1px solid #16A085;">
                        <div class="product-image">';
                }
                $output .= '
                            <a href="home/' . $item->slug . '">';
                if ($item->stoke === 0) {
                    $output .= '<div style="z-index: 3" class="badge bg-danger px-3 position-absolute top-50 start-50 translate-middle"><h5 class="text-white">Stok Habis</h5></div>';
                }
                if ($item->photo_product->count() > 0) {
                    foreach ($item->photo_product->take(1) as $photos) {
                        if ($photos->name) {
                            $output .= '<img src="../storage/produk/' . $photos->name . '" alt="' . $item->name . '"
                                            style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                        } else {
                            $output .= '<img src="img/no-image.png" alt="' . $item->name . '"
                                            style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                        }
                    }
                } else {
                    $output .= '<img src="img/no-image.png" alt="' . $item->name . '"
                                    style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                }
                $output .= '</a>
                        </div>';
                if ($item->stoke === 0) {
                    $output .= '<div class="product-info bg-light opacity-90">';
                } else {
                    $output .= '<div class="product-info">';
                }
                if ($item->discount != 0) {
                    $output .= '<div class="d-flex justify-content-between">
                                    <a href="product-category/' . $item->product_category->slug . '">
                                        <span class="category">' . $item->category_name . '</span>
                                    </a>
                                    <p class="small badge bg-danger">' . $item->discount . '% OFF</p>
                                </div>';
                } else {
                    $output .= '<a href="product-category/' . $item->product_category->slug . '">
                                    <span class="category">' . $item->category_name . '</span>
                                </a>';
                }
                $output .= '<p class="small" style="color:#16A085;">Stok tersisa ' . $item->stoke . '</p>
                            <h4 class="title">
                                <a href="home/' . $item->slug . '"
                                    style="color:#16A085; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; overflow: hidden;">' . $item->name . '</a>
                            </h4>
                            <ul class="review">
                                <div>';
                if ($item->stock_out) {
                    $output .= '<span>' . $item->stock_out . ' Terjual</span>';
                } else {
                    $output .= '<span>0 Terjual</span>';
                }
                $output .= '</div>';
                $reviews = Review::where('product_id', $item->id)->get();
                $ratingSum = Review::where('product_id', $item->id)->sum('stars_rated');
                if ($reviews->count() > 0) {
                    $ratingValue = $ratingSum / $reviews->count();
                } else {
                    $ratingValue = 0;
                }
                $rateNum = number_format($ratingValue);
                for ($i = 1; $i <= $rateNum; $i++) {
                    $output .= '<li><i class="lni lni-star-filled"></i></li>';
                }
                for ($j = $rateNum + 1; $j <= 5; $j++) {
                    $output .= '<li><i class="lni lni-star"></i></li>';
                }
                $output .= '</ul>
                            <div class="price">';
                if ($item->price_discount) {
                    $output .= '<span class="text-decoration-line-through text-muted " style="font-size: 13px">Rp. ' . number_format($item->price_discount, 0) . ' <span>Rp. ' . number_format($item->price, 0) . '</span></span>';
                } else {
                    $output .= '<span>Rp. ' . number_format($item->price, 0) . '</span>';
                }
                $output .= '</div>
                        </div>
                    </div>
                    <!-- End Single Product -->
                </div>
                ';
            }
            echo $output;
        } else {
            if (request('pencarian')) {
                echo '<div id="app">
                    <section class="section">
                        <div class="container">
                            <div class="page-error">
                                <div class="page-inner">
                                    <img src="img/undraw_empty_re_opql.svg" alt="">
                                    <div class="page-description">
                                        Produk yang anda cari tidak ada!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>';
            } else {
                echo '<div id="app">
                    <section class="section">
                        <div class="container">
                            <div class="page-error">
                                <div class="page-inner">
                                    <img src="../img/undraw_empty_re_opql.svg" alt="">
                                    <div class="page-description">
                                        Tidak ada produk yang diposting!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>';
            }
        }
    }

    public function basedSearch()
    {
        $countProduct = Product::with('photo_product')
            ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
            ->join('users', 'products.user_id', '=', 'users.id')
            ->select('products.*', 'product_categories.name as category_name')
            ->where('product_categories.is_active', '=', 1)
            ->where('products.is_active', '=', 1)
            ->orderBy('products.updated_at', 'desc')
            ->count();
        return view('pages.home.product_search', compact('countProduct'));
    }

    public function fetchAllBasedSearch(Request $request)
    {
        if ($request->max_price == 'max_price') {
            $based_search = Product::with('photo_product')
                ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select('products.*', 'product_categories.name as category_name')
                ->where('product_categories.is_active', '=', 1)
                ->where('products.is_active', '=', 1)
                ->orderBy('products.price', 'desc')
                ->orderByRaw('RAND()')
                ->get();
        } else if ($request->min_price == 'min_price') {
            $based_search = Product::with('photo_product')
                ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select('products.*', 'product_categories.name as category_name')
                ->where('product_categories.is_active', '=', 1)
                ->where('products.is_active', '=', 1)
                ->orderBy('products.price', 'asc')
                ->orderByRaw('RAND()')
                ->get();
        } else {
            $based_search = Product::with('photo_product')
                ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select('products.*', 'product_categories.name as category_name')
                ->where('product_categories.is_active', '=', 1)
                ->where('products.is_active', '=', 1)
                ->orderBy('products.updated_at', 'desc')
                ->orderByRaw('RAND()')
                ->get();
        }
        $output = '';
        if ($based_search->count() > 0) {
            foreach ($based_search as $item) {
                $output .= '
                <div class="col-lg-3 col-md-6 col-12">';
                if ($item->stoke === 0) {
                    $output .= '<div class="single-product bg-light opacity-90" style="height: 26rem; border: 1px solid #16A085;">
                        <div class="product-image bg-light opacity-90">';
                } else {
                    $output .= '<div class="single-product" style="height: 26rem; border: 1px solid #16A085;">
                        <div class="product-image">';
                }
                $output .= '
                            <a href="home/' . $item->slug . '">';
                if ($item->stoke === 0) {
                    $output .= '<div style="z-index: 3" class="badge bg-danger px-3 position-absolute top-50 start-50 translate-middle"><h5 class="text-white">Stok Habis</h5></div>';
                }
                if ($item->photo_product->count() > 0) {
                    foreach ($item->photo_product->take(1) as $photos) {
                        if ($photos->name) {
                            $output .= '<img src="../storage/produk/' . $photos->name . '" alt="' . $item->name . '"
                                            style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                        } else {
                            $output .= '<img src="img/no-image.png" alt="' . $item->name . '"
                                            style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                        }
                    }
                } else {
                    $output .= '<img src="img/no-image.png" alt="' . $item->name . '"
                                    style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                }
                $output .= '</a>
                        </div>';
                if ($item->stoke === 0) {
                    $output .= '<div class="product-info bg-light opacity-90">';
                } else {
                    $output .= '<div class="product-info">';
                }
                if ($item->discount != 0) {
                    $output .= '<div class="d-flex justify-content-between">
                                    <a href="product-category/' . $item->product_category->slug . '">
                                        <span class="category">' . $item->category_name . '</span>
                                    </a>
                                    <p class="small badge bg-danger">' . $item->discount . '% OFF</p>
                                </div>';
                } else {
                    $output .= '<a href="product-category/' . $item->product_category->slug . '">
                                    <span class="category">' . $item->category_name . '</span>
                                </a>';
                }
                $output .= '<p class="small" style="color:#16A085;">Stok tersisa ' . $item->stoke . '</p>
                            <h4 class="title">
                                <a href="home/' . $item->slug . '"
                                    style="color:#16A085; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; overflow: hidden;">' . $item->name . '</a>
                            </h4>
                            <ul class="review">
                                <div>';
                if ($item->stock_out) {
                    $output .= '<span>' . $item->stock_out . ' Terjual</span>';
                } else {
                    $output .= '<span>0 Terjual</span>';
                }
                $output .= '</div>';
                $reviews = Review::where('product_id', $item->id)->get();
                $ratingSum = Review::where('product_id', $item->id)->sum('stars_rated');
                if ($reviews->count() > 0) {
                    $ratingValue = $ratingSum / $reviews->count();
                } else {
                    $ratingValue = 0;
                }
                $rateNum = number_format($ratingValue);
                for ($i = 1; $i <= $rateNum; $i++) {
                    $output .= '<li><i class="lni lni-star-filled"></i></li>';
                }
                for ($j = $rateNum + 1; $j <= 5; $j++) {
                    $output .= '<li><i class="lni lni-star"></i></li>';
                }
                $output .= '</ul>
                            <div class="price">';
                if ($item->price_discount) {
                    $output .= '<span class="text-decoration-line-through text-muted " style="font-size: 13px">Rp. ' . number_format($item->price_discount, 0) . ' <span>Rp. ' . number_format($item->price, 0) . '</span></span>';
                } else {
                    $output .= '<span>Rp. ' . number_format($item->price, 0) . '</span>';
                }
                $output .= '</div>
                        </div>
                    </div>
                    <!-- End Single Product -->
                </div>
                ';
            }
            echo $output;
        } else {
            echo '<div id="app">
                <section class="section">
                    <div class="container">
                        <div class="page-error">
                            <div class="page-inner">
                                <img src="../img/undraw_empty_re_opql.svg" alt="">
                                <div class="page-description">
                                    Tidak ada produk yang diposting!
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>';
        }
    }

    public function allCategory()
    {
        $countProduct = Product::with('photo_product')
            ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
            ->join('users', 'products.user_id', '=', 'users.id')
            ->select('products.*', 'product_categories.name as category_name')
            ->where('product_categories.is_active', '=', 1)
            ->where('products.is_active', '=', 1)
            ->orderBy('products.updated_at', 'desc')
            ->count();
        return view('pages.category.allCategory', compact('countProduct'));
    }

    public function fetchallCategory(Request $request)
    {
        if ($request->max_price == 'max_price') {
            $product_new = Product::with('photo_product')
                ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select('products.*', 'product_categories.name as category_name')
                ->where('product_categories.is_active', '=', 1)
                ->where('products.is_active', '=', 1)
                ->orderBy('products.price', 'desc')
                ->get();
        } else if ($request->min_price == 'min_price') {
            $product_new = Product::with('photo_product')
                ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select('products.*', 'product_categories.name as category_name')
                ->where('product_categories.is_active', '=', 1)
                ->where('products.is_active', '=', 1)
                ->orderBy('products.price', 'asc')
                ->get();
        } else {
            $product_new = Product::with('photo_product')
                ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select('products.*', 'product_categories.name as category_name')
                ->where('product_categories.is_active', '=', 1)
                ->where('products.is_active', '=', 1)
                ->orderBy('products.updated_at', 'desc')
                ->get();
        }
        $output = '';
        if ($product_new->count() > 0) {
            foreach ($product_new as $item) {
                $output .= '
                <div class="col-lg-3 col-md-6 col-12">';
                if ($item->stoke === 0) {
                    $output .= '<div class="single-product bg-light opacity-90" style="height: 26rem; border: 1px solid #16A085;">
                        <div class="product-image bg-light opacity-90">';
                } else {
                    $output .= '<div class="single-product" style="height: 26rem; border: 1px solid #16A085;">
                        <div class="product-image">';
                }
                $output .= '
                            <a href="../home/' . $item->slug . '">';
                if ($item->stoke === 0) {
                    $output .= '<div style="z-index: 3" class="badge bg-danger px-3 position-absolute top-50 start-50 translate-middle"><h5 class="text-white">Stok Habis</h5></div>';
                }
                if ($item->photo_product->count() > 0) {
                    foreach ($item->photo_product->take(1) as $photos) {
                        if ($photos->name) {
                            $output .= '<img src="../storage/produk/' . $photos->name . '" alt="' . $item->name . '"
                                            style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                        } else {
                            $output .= '<img src="../img/no-image.png" alt="' . $item->name . '"
                                            style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                        }
                    }
                } else {
                    $output .= '<img src="../img/no-image.png" alt="' . $item->name . '"
                                    style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                }
                $output .= '</a>
                        </div>';
                if ($item->stoke === 0) {
                    $output .= '<div class="product-info bg-light opacity-90">';
                } else {
                    $output .= '<div class="product-info">';
                }
                if ($item->discount != 0) {
                    $output .= '<div class="d-flex justify-content-between">
                                    <a href="../product-category/' . $item->product_category->slug . '">
                                        <span class="category">' . $item->category_name . '</span>
                                    </a>
                                    <p class="small badge bg-danger">' . $item->discount . '% OFF</p>
                                </div>';
                } else {
                    $output .= '<a href="../product-category/' . $item->product_category->slug . '">
                                    <span class="category">' . $item->category_name . '</span>
                                </a>';
                }
                $output .= '<p class="small" style="color:#16A085;">Stok tersisa ' . $item->stoke . '</p>
                            <h4 class="title">
                                <a href="../home/' . $item->slug . '"
                                    style="color:#16A085; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; overflow: hidden;">' . $item->name . '</a>
                            </h4>
                            <ul class="review">
                                <div>';
                if ($item->stock_out) {
                    $output .= '<span>' . $item->stock_out . ' Terjual</span>';
                } else {
                    $output .= '<span>0 Terjual</span>';
                }
                $output .= '</div>';
                $reviews = Review::where('product_id', $item->id)->get();
                $ratingSum = Review::where('product_id', $item->id)->sum('stars_rated');
                if ($reviews->count() > 0) {
                    $ratingValue = $ratingSum / $reviews->count();
                } else {
                    $ratingValue = 0;
                }
                $rateNum = number_format($ratingValue);
                for ($i = 1; $i <= $rateNum; $i++) {
                    $output .= '<li><i class="lni lni-star-filled"></i></li>';
                }
                for ($j = $rateNum + 1; $j <= 5; $j++) {
                    $output .= '<li><i class="lni lni-star"></i></li>';
                }
                $output .= '</ul>
                            <div class="price">';
                if ($item->price_discount) {
                    $output .= '<span class="text-decoration-line-through text-muted " style="font-size: 13px">Rp. ' . number_format($item->price_discount, 0) . ' <span>Rp. ' . number_format($item->price, 0) . '</span></span>';
                } else {
                    $output .= '<span>Rp. ' . number_format($item->price, 0) . '</span>';
                }
                $output .= '</div>
                        </div>
                    </div>
                    <!-- End Single Product -->
                </div>
                ';
            }
            echo $output;
        } else {
            echo '<div id="app">
                <section class="section">
                    <div class="container">
                        <div class="page-error">
                            <div class="page-inner">
                                <img src="../img/undraw_empty_re_opql.svg" alt="">
                                <div class="page-description">
                                    Tidak ada produk yang diposting!
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>';
        }
    }

    public function viewCategory(Request $request, $slug)
    {
        if (ProductCategory::where('slug', $slug)->exists()) {
            $category_product = ProductCategory::where('slug', $slug)->first();

            $product = Product::with('photo_product')
                ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select('products.*', 'product_categories.name as category_name')
                ->where('category_product_id', $category_product->id)
                ->where('product_categories.is_active', '=', 1)
                ->where('products.is_active', '=', 1)
                ->orderBy('products.updated_at', 'desc')
                ->get();

            $countProduct = Product::with('photo_product')
                ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select('products.*', 'product_categories.name as category_name')
                ->where('category_product_id', $category_product->id)
                ->where('product_categories.is_active', '=', 1)
                ->where('products.is_active', '=', 1)
                ->orderBy('products.updated_at', 'desc')
                ->count();

            return view('pages.category.index', compact('category_product', 'product', 'countProduct'));
        } else {
            notify()->warning("Kategori produk tidak ditemukan!", "Peringatan", "topRight");
            return redirect('/');
        }
    }

    public function fetchallNameCategory(Request $request, $slug)
    {
        $category_product = ProductCategory::where('slug', $slug)->first();
        if ($request->max_price == 'max_price') {
            $product = Product::with('photo_product')
                ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select('products.*', 'product_categories.name as category_name')
                ->where('category_product_id', $category_product->id)
                ->where('product_categories.is_active', '=', 1)
                ->where('products.is_active', '=', 1)
                ->orderBy('products.price', 'desc')
                ->get();
        } else if ($request->min_price == 'min_price') {
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
        $output = '';
        if ($product->count() > 0) {
            foreach ($product as $item) {
                $output .= '
                <div class="col-lg-3 col-md-6 col-12">';
                if ($item->stoke === 0) {
                    $output .= '<div class="single-product bg-light opacity-90" style="height: 26rem; border: 1px solid #16A085;">
                        <div class="product-image bg-light opacity-90">';
                } else {
                    $output .= '<div class="single-product" style="height: 26rem; border: 1px solid #16A085;">
                        <div class="product-image">';
                }
                $output .= '
                            <a href="../home/' . $item->slug . '">';
                if ($item->stoke === 0) {
                    $output .= '<div style="z-index: 3" class="badge bg-danger px-3 position-absolute top-50 start-50 translate-middle"><h5 class="text-white">Stok Habis</h5></div>';
                }
                if ($item->photo_product->count() > 0) {
                    foreach ($item->photo_product->take(1) as $photos) {
                        if ($photos->name) {
                            $output .= '<img src="../storage/produk/' . $photos->name . '" alt="' . $item->name . '"
                                            style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                        } else {
                            $output .= '<img src="../img/no-image.png" alt="' . $item->name . '"
                                            style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                        }
                    }
                } else {
                    $output .= '<img src="../img/no-image.png" alt="' . $item->name . '"
                                    style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                }
                $output .= '</a>
                        </div>';
                if ($item->stoke === 0) {
                    $output .= '<div class="product-info bg-light opacity-90">';
                } else {
                    $output .= '<div class="product-info">';
                }
                if ($item->discount != 0) {
                    $output .= '<div class="d-flex justify-content-between">
                                    <a href="../product-category/' . $item->product_category->slug . '">
                                        <span class="category">' . $item->category_name . '</span>
                                    </a>
                                    <p class="small badge bg-danger">' . $item->discount . '% OFF</p>
                                </div>';
                } else {
                    $output .= '<a href="../product-category/' . $item->product_category->slug . '">
                                    <span class="category">' . $item->category_name . '</span>
                                </a>';
                }
                $output .= '<p class="small" style="color:#16A085;">Stok tersisa ' . $item->stoke . '</p>
                            <h4 class="title">
                                <a href="../home/' . $item->slug . '"
                                    style="color:#16A085; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; overflow: hidden;">' . $item->name . '</a>
                            </h4>
                            <ul class="review">
                                <div>';
                if ($item->stock_out) {
                    $output .= '<span>' . $item->stock_out . ' Terjual</span>';
                } else {
                    $output .= '<span>0 Terjual</span>';
                }
                $output .= '</div>';
                $reviews = Review::where('product_id', $item->id)->get();
                $ratingSum = Review::where('product_id', $item->id)->sum('stars_rated');
                if ($reviews->count() > 0) {
                    $ratingValue = $ratingSum / $reviews->count();
                } else {
                    $ratingValue = 0;
                }
                $rateNum = number_format($ratingValue);
                for ($i = 1; $i <= $rateNum; $i++) {
                    $output .= '<li><i class="lni lni-star-filled"></i></li>';
                }
                for ($j = $rateNum + 1; $j <= 5; $j++) {
                    $output .= '<li><i class="lni lni-star"></i></li>';
                }
                $output .= '</ul>
                            <div class="price">';
                if ($item->price_discount) {
                    $output .= '<span class="text-decoration-line-through text-muted " style="font-size: 13px">Rp. ' . number_format($item->price_discount, 0) . ' <span>Rp. ' . number_format($item->price, 0) . '</span></span>';
                } else {
                    $output .= '<span>Rp. ' . number_format($item->price, 0) . '</span>';
                }
                $output .= '</div>
                        </div>
                    </div>
                    <!-- End Single Product -->
                </div>
                ';
            }
            echo $output;
        } else {
            echo '<div id="app">
                <section class="section">
                    <div class="container">
                        <div class="page-error">
                            <div class="page-inner">
                                <img src="../img/undraw_empty_re_opql.svg" alt="">
                                <div class="page-description">
                                    Tidak ada produk yang diposting!
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>';
        }
    }

    public function productView($category_slug, $product_slug)
    {
        if (ProductCategory::where('slug', $category_slug)->exists()) {
            if (Product::where('slug', $product_slug)->exists()) {
                $product = Product::where('slug', $product_slug)->first();
                $product_new = Product::with('photo_product', 'review')
                    ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                    ->join('users', 'products.user_id', '=', 'users.id')
                    ->select('products.*', 'product_categories.name as category_name')
                    ->where('product_categories.is_active', '=', 1)
                    ->where('products.slug', '!=',  $product_slug)
                    ->where('products.is_active', '=', 1)
                    ->orderBy('products.updated_at', 'desc')
                    ->get();
                $showReviews = Review::where('product_id', $product->id)->get();
                $reviews = Review::where('product_id', $product->id)->get();
                $ratingSum = Review::where('product_id', $product->id)->sum('stars_rated');
                if ($reviews->count() > 0) {
                    $ratingValue = $ratingSum / $reviews->count();
                } else {
                    $ratingValue = 0;
                }
                $roomChats = RoomChat::all();
                return view('pages.home.detail', compact('product', 'product_new', 'reviews', 'ratingValue', 'showReviews', 'roomChats'));
            } else {
                notify()->warning("Tautannya rusak!", "Peringatan", "topRight");
                return redirect('/');
            }
        } else {
            notify()->warning("Tidak ditemukan kategori seperti itu!", "Peringatan", "topRight");
            return redirect('/');
        }
    }


    public function productListAjax(Request $request)
    {
        return Product::select('name')
            ->where('is_active', '1')
            ->where('name', 'like', "%{$request->term}%")
            ->pluck('name');
    }

    public function fetchAllFiveStar(Request $request, $id)
    {
        $fiverateds = Review::where('product_id', $id)->where('stars_rated', 5)->latest()->get();
        $output = '';
        function get_starred($str)
        {
            $len = strlen($str);
            return substr($str, 0, 1) . str_repeat('*', $len - 2) . substr($str, $len - 1, 1);
        }
        if ($fiverateds->count() > 0) {
            foreach ($fiverateds as $review) {
                $output .= '
                <div class="d-lg-flex border p-2 mb-2 rounded align-items-center justify-content-start">
                    <div class="col-lg-3">';
                foreach ($review->user->costumer as $potoProfile) {
                    if ($potoProfile->image) {
                        $output .= '<img src="../storage/profile/' . $potoProfile->image . '"
                                        class="rounded-circle shadow-sm" style="border: 1px solid #16A085; width: 70px; height: 70px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                        alt="">';
                    } else {
                        $output .= '<img src="../stisla/assets/img/avatar/avatar-1.png"
                                        style="max-width: 4rem;" class="img-fluid img-thumbnail rounded-circle"
                                        alt="">';
                    }
                }
                $output .= '';
                if ($review->hide == 1) {
                    $output .= '<span class="ms-3">' . get_starred(strtok($review->user->name, ' ')) . '</span>';
                } elseif ($review->hide == 0) {
                    $output .= '<span class="ms-3">' . strtok($review->user->name, ' ') . '</span>';
                }
                $output .= '
                    </div>
                    <div class="col-12 col-lg-9 mt-2 mt-lg-0">
                        <div class="normal-list mb-2">
                            <li>
                                <div class="ratings">
                                    <div class="star-icon" style="
                                        font-size: 20px;
                                        font-family: sans-serif;
                                        font-weight: 800;
                                        text-transform: uppercase;">';
                for ($i = 1; $i <= $review->stars_rated; $i++) {
                    $output .= '<i class="lni lni-star-filled ratings-color"></i>';
                }
                for ($j = $review->stars_rated + 1; $j <= 5; $j++) {
                    $output .= '<i class="lni lni-star-filled"></i>';
                }
                $output .= '</div>
                                    <p class="m-0">' . \App\Helpers\General::datetimeFormat($review->created_at) . '</p>
                                </div>
                            </li>
                            <span class="me-md-5">
                                ' . $review->review . '
                            </span>
                        </div>';
                if ($review->reply_review) {
                    $output .= '<div style="background: #16A085" class="border text-white rounded p-2 text-justify text-xs"><p class="text-xs m-0 fw-bold">Respon Penjual:</p>' . $review->reply_review . '</div>';
                }
                $output .= '</div>
                </div>
                ';
            }
            echo $output;
        } else {
            echo '<div class="border p-4 my-4 rounded">
                    <p class="h5 text-center" style="color: #16A085">Belum ada ulasan produk!</p>
                </div>';
        }
    }

    public function fetchAllFourStar(Request $request, $id)
    {
        $fiverateds = Review::where('product_id', $id)->where('stars_rated', 4)->latest()->get();
        $output = '';
        function get_starred($str)
        {
            $len = strlen($str);
            return substr($str, 0, 1) . str_repeat('*', $len - 2) . substr($str, $len - 1, 1);
        }
        if ($fiverateds->count() > 0) {
            foreach ($fiverateds as $review) {
                $output .= '
                <div class="d-lg-flex border p-2 mb-2 rounded align-items-center justify-content-start">
                    <div class="col-lg-3">';
                foreach ($review->user->costumer as $potoProfile) {
                    if ($potoProfile->image) {
                        $output .= '<img src="../storage/profile/' . $potoProfile->image . '"
                                        class="rounded-circle shadow-sm" style="border: 1px solid #16A085; width: 70px; height: 70px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                        alt="">';
                    } else {
                        $output .= '<img src="../stisla/assets/img/avatar/avatar-1.png"
                                        style="max-width: 4rem;" class="img-fluid img-thumbnail rounded-circle"
                                        alt="">';
                    }
                }
                $output .= '';
                if ($review->hide == 1) {
                    $output .= '<span class="ms-3">' . get_starred(strtok($review->user->name, ' ')) . '</span>';
                } elseif ($review->hide == 0) {
                    $output .= '<span class="ms-3">' . strtok($review->user->name, ' ') . '</span>';
                }
                $output .= '
                    </div>
                    <div class="col-12 col-lg-9 mt-2 mt-lg-0">
                        <div class="normal-list mb-2">
                            <li>
                                <div class="ratings">
                                    <div class="star-icon" style="
                                        font-size: 20px;
                                        font-family: sans-serif;
                                        font-weight: 800;
                                        text-transform: uppercase;">';
                for ($i = 1; $i <= $review->stars_rated; $i++) {
                    $output .= '<i class="lni lni-star-filled ratings-color"></i>';
                }
                for ($j = $review->stars_rated + 1; $j <= 5; $j++) {
                    $output .= '<i class="lni lni-star-filled"></i>';
                }
                $output .= '</div>
                                    <p class="m-0">' . \App\Helpers\General::datetimeFormat($review->created_at) . '</p>
                                </div>
                            </li>
                            <span class="me-md-5">
                                ' . $review->review . '
                            </span>
                        </div>';
                if ($review->reply_review) {
                    $output .= '<div style="background: #16A085" class="border text-white rounded p-2 text-justify text-xs"><p class="text-xs m-0 fw-bold">Respon Penjual:</p>' . $review->reply_review . '</div>';
                }
                $output .= '</div>
                </div>
                ';
            }
            echo $output;
        } else {
            echo '<div class="border p-4 my-4 rounded">
                    <p class="h5 text-center" style="color: #16A085">Belum ada ulasan produk!</p>
                </div>';
        }
    }

    public function fetchAllThreeStar(Request $request, $id)
    {
        $fiverateds = Review::where('product_id', $id)->where('stars_rated', 3)->latest()->get();
        $output = '';
        function get_starred($str)
        {
            $len = strlen($str);
            return substr($str, 0, 1) . str_repeat('*', $len - 2) . substr($str, $len - 1, 1);
        }
        if ($fiverateds->count() > 0) {
            foreach ($fiverateds as $review) {
                $output .= '
                <div class="d-lg-flex border p-2 mb-2 rounded align-items-center justify-content-start">
                    <div class="col-lg-3">';
                foreach ($review->user->costumer as $potoProfile) {
                    if ($potoProfile->image) {
                        $output .= '<img src="../storage/profile/' . $potoProfile->image . '"
                                        class="rounded-circle shadow-sm" style="border: 1px solid #16A085; width: 70px; height: 70px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                        alt="">';
                    } else {
                        $output .= '<img src="../stisla/assets/img/avatar/avatar-1.png"
                                        style="max-width: 4rem;" class="img-fluid img-thumbnail rounded-circle"
                                        alt="">';
                    }
                }
                $output .= '';
                if ($review->hide == 1) {
                    $output .= '<span class="ms-3">' . get_starred(strtok($review->user->name, ' ')) . '</span>';
                } elseif ($review->hide == 0) {
                    $output .= '<span class="ms-3">' . strtok($review->user->name, ' ') . '</span>';
                }
                $output .= '
                    </div>
                    <div class="col-12 col-lg-9 mt-2 mt-lg-0">
                        <div class="normal-list mb-2">
                            <li>
                                <div class="ratings">
                                    <div class="star-icon" style="
                                        font-size: 20px;
                                        font-family: sans-serif;
                                        font-weight: 800;
                                        text-transform: uppercase;">';
                for ($i = 1; $i <= $review->stars_rated; $i++) {
                    $output .= '<i class="lni lni-star-filled ratings-color"></i>';
                }
                for ($j = $review->stars_rated + 1; $j <= 5; $j++) {
                    $output .= '<i class="lni lni-star-filled"></i>';
                }
                $output .= '</div>
                                    <p class="m-0">' . \App\Helpers\General::datetimeFormat($review->created_at) . '</p>
                                </div>
                            </li>
                            <span class="me-md-5">
                                ' . $review->review . '
                            </span>
                        </div>';
                if ($review->reply_review) {
                    $output .= '<div style="background: #16A085" class="border text-white rounded p-2 text-justify text-xs"><p class="text-xs m-0 fw-bold">Respon Penjual:</p>' . $review->reply_review . '</div>';
                }
                $output .= '</div>
                </div>
                ';
            }
            echo $output;
        } else {
            echo '<div class="border p-4 my-4 rounded">
                    <p class="h5 text-center" style="color: #16A085">Belum ada ulasan produk!</p>
                </div>';
        }
    }

    public function fetchAllTwoStar(Request $request, $id)
    {
        $fiverateds = Review::where('product_id', $id)->where('stars_rated', 2)->latest()->get();
        $output = '';
        function get_starred($str)
        {
            $len = strlen($str);
            return substr($str, 0, 1) . str_repeat('*', $len - 2) . substr($str, $len - 1, 1);
        }
        if ($fiverateds->count() > 0) {
            foreach ($fiverateds as $review) {
                $output .= '
                <div class="d-lg-flex border p-2 mb-2 rounded align-items-center justify-content-start">
                    <div class="col-lg-3">';
                foreach ($review->user->costumer as $potoProfile) {
                    if ($potoProfile->image) {
                        $output .= '<img src="../storage/profile/' . $potoProfile->image . '"
                                        class="rounded-circle shadow-sm" style="border: 1px solid #16A085; width: 70px; height: 70px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                        alt="">';
                    } else {
                        $output .= '<img src="../stisla/assets/img/avatar/avatar-1.png"
                                        style="max-width: 4rem;" class="img-fluid img-thumbnail rounded-circle"
                                        alt="">';
                    }
                }
                $output .= '';
                if ($review->hide == 1) {
                    $output .= '<span class="ms-3">' . get_starred(strtok($review->user->name, ' ')) . '</span>';
                } elseif ($review->hide == 0) {
                    $output .= '<span class="ms-3">' . strtok($review->user->name, ' ') . '</span>';
                }
                $output .= '
                    </div>
                    <div class="col-12 col-lg-9 mt-2 mt-lg-0">
                        <div class="normal-list mb-2">
                            <li>
                                <div class="ratings">
                                    <div class="star-icon" style="
                                        font-size: 20px;
                                        font-family: sans-serif;
                                        font-weight: 800;
                                        text-transform: uppercase;">';
                for ($i = 1; $i <= $review->stars_rated; $i++) {
                    $output .= '<i class="lni lni-star-filled ratings-color"></i>';
                }
                for ($j = $review->stars_rated + 1; $j <= 5; $j++) {
                    $output .= '<i class="lni lni-star-filled"></i>';
                }
                $output .= '</div>
                                    <p class="m-0">' . \App\Helpers\General::datetimeFormat($review->created_at) . '</p>
                                </div>
                            </li>
                            <span class="me-md-5">
                                ' . $review->review . '
                            </span>
                        </div>';
                if ($review->reply_review) {
                    $output .= '<div style="background: #16A085" class="border text-white rounded p-2 text-justify text-xs"><p class="text-xs m-0 fw-bold">Respon Penjual:</p>' . $review->reply_review . '</div>';
                }
                $output .= '</div>
                </div>
                ';
            }
            echo $output;
        } else {
            echo '<div class="border p-4 my-4 rounded">
                    <p class="h5 text-center" style="color: #16A085">Belum ada ulasan produk!</p>
                </div>';
        }
    }

    public function fetchAllOneStar(Request $request, $id)
    {
        $fiverateds = Review::where('product_id', $id)->where('stars_rated', 1)->latest()->get();
        $output = '';
        function get_starred($str)
        {
            $len = strlen($str);
            return substr($str, 0, 1) . str_repeat('*', $len - 2) . substr($str, $len - 1, 1);
        }
        if ($fiverateds->count() > 0) {
            foreach ($fiverateds as $review) {
                $output .= '
                <div class="d-lg-flex border p-2 mb-2 rounded align-items-center justify-content-start">
                    <div class="col-lg-3">';
                foreach ($review->user->costumer as $potoProfile) {
                    if ($potoProfile->image) {
                        $output .= '<img src="../storage/profile/' . $potoProfile->image . '"
                                        class="rounded-circle shadow-sm" style="border: 1px solid #16A085; width: 70px; height: 70px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                        alt="">';
                    } else {
                        $output .= '<img src="../stisla/assets/img/avatar/avatar-1.png"
                                        style="max-width: 4rem;" class="img-fluid img-thumbnail rounded-circle"
                                        alt="">';
                    }
                }
                $output .= '';
                if ($review->hide == 1) {
                    $output .= '<span class="ms-3">' . get_starred(strtok($review->user->name, ' ')) . '</span>';
                } elseif ($review->hide == 0) {
                    $output .= '<span class="ms-3">' . strtok($review->user->name, ' ') . '</span>';
                }
                $output .= '
                    </div>
                    <div class="col-12 col-lg-9 mt-2 mt-lg-0">
                        <div class="normal-list mb-2">
                            <li>
                                <div class="ratings">
                                    <div class="star-icon" style="
                                        font-size: 20px;
                                        font-family: sans-serif;
                                        font-weight: 800;
                                        text-transform: uppercase;">';
                for ($i = 1; $i <= $review->stars_rated; $i++) {
                    $output .= '<i class="lni lni-star-filled ratings-color"></i>';
                }
                for ($j = $review->stars_rated + 1; $j <= 5; $j++) {
                    $output .= '<i class="lni lni-star-filled"></i>';
                }
                $output .= '</div>
                                    <p class="m-0">' . \App\Helpers\General::datetimeFormat($review->created_at) . '</p>
                                </div>
                            </li>
                            <span class="me-md-5">
                                ' . $review->review . '
                            </span>
                        </div>';
                if ($review->reply_review) {
                    $output .= '<div style="background: #16A085" class="border text-white rounded p-2 text-justify text-xs"><p class="text-xs m-0 fw-bold">Respon Penjual:</p>' . $review->reply_review . '</div>';
                }
                $output .= '</div>
                </div>
                ';
            }
            echo $output;
        } else {
            echo '<div class="border p-4 my-4 rounded">
                    <p class="h5 text-center" style="color: #16A085">Belum ada ulasan produk!</p>
                </div>';
        }
    }

    public function countStarsFive($id)
    {
        $countStarsFive = Review::where('product_id', $id)->where('stars_rated', 5)->count();
        return response()->json(['countStarsFive' => $countStarsFive]);
    }

    public function countStarsFour($id)
    {
        $countStarsFour = Review::where('product_id', $id)->where('stars_rated', 4)->count();
        return response()->json(['countStarsFour' => $countStarsFour]);
    }

    public function countStarsThree($id)
    {
        $countStarsThree = Review::where('product_id', $id)->where('stars_rated', 3)->count();
        return response()->json(['countStarsThree' => $countStarsThree]);
    }

    public function countStarsTwo($id)
    {
        $countStarsTwo = Review::where('product_id', $id)->where('stars_rated', 2)->count();
        return response()->json(['countStarsTwo' => $countStarsTwo]);
    }

    public function countStarsOne($id)
    {
        $countStarsOne = Review::where('product_id', $id)->where('stars_rated', 1)->count();
        return response()->json(['countStarsOne' => $countStarsOne]);
    }

    public function profileGapoktan($name)
    {
        $name = str_replace("-", " ", $name);
        // dd($name);
        if (User::where('name', $name)->exists()) {
            $user = User::where('name', $name)->first();
            $gapoktan = Gapoktan::where('user_id', $user->id)->first();

            $reviews = Review::join('products', 'reviews.product_id', '=', 'products.id')->where('products.user_id', $gapoktan->user_id)->get();
            $ratingSum = Review::join('products', 'reviews.product_id', '=', 'products.id')->where('products.user_id', $gapoktan->user_id)->sum('stars_rated');
            if ($reviews->count() > 0) {
                $ratingValue = $ratingSum / $reviews->count();
            } else {
                $ratingValue = 0;
            }
            return view('pages.profile.index', compact('name', 'gapoktan', 'ratingValue'));
        } else {
            notify()->warning("Maaf data tidak ada!", "Peringatan", "topRight");
            return redirect('/');
        }
    }

    public function fetchallprodukGapoktan(Request $request, $name)
    {
        if ($request->max_price == 'max_price') {
            $product_new = Product::with('photo_product', 'review')
                ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select('products.*', 'product_categories.name as category_name')
                ->where('product_categories.is_active', '=', 1)
                ->where('products.is_active', '=', 1)
                ->where('users.name', '=', $name)
                ->orderBy('products.price', 'desc')
                ->get();
        } else if ($request->min_price == 'min_price') {
            $product_new = Product::with('photo_product', 'review')
                ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select('products.*', 'product_categories.name as category_name')
                ->where('product_categories.is_active', '=', 1)
                ->where('products.is_active', '=', 1)
                ->where('users.name', '=', $name)
                ->orderBy('products.price', 'asc')
                ->get();
        } else {
            $product_new = Product::with('photo_product', 'review')
                ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select('products.*', 'product_categories.name as category_name')
                ->where('product_categories.is_active', '=', 1)
                ->where('products.is_active', '=', 1)
                ->where('users.name', '=', $name)
                ->orderBy('products.updated_at', 'desc')
                ->get();
        }
        $output = '';
        if ($product_new->count() > 0) {
            foreach ($product_new as $item) {
                $output .= '
                <div class="col-lg-3 col-md-6 col-12">';
                if ($item->stoke === 0) {
                    $output .= '<div class="single-product bg-light opacity-90" style="height: 26rem; border: 1px solid #16A085;">
                        <div class="product-image bg-light opacity-90">';
                } else {
                    $output .= '<div class="single-product" style="height: 26rem; border: 1px solid #16A085;">
                        <div class="product-image">';
                }
                $output .= '
                            <a href="../home/' . $item->slug . '">';
                if ($item->stoke === 0) {
                    $output .= '<div style="z-index: 3" class="badge bg-danger px-3 position-absolute top-50 start-50 translate-middle"><h5 class="text-white">Stok Habis</h5></div>';
                }
                if ($item->photo_product->count() > 0) {
                    foreach ($item->photo_product->take(1) as $photos) {
                        if ($photos->name) {
                            $output .= '<img src="../storage/produk/' . $photos->name . '" alt="' . $item->name . '"
                                            style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                        } else {
                            $output .= '<img src="img/no-image.png" alt="' . $item->name . '"
                                            style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                        }
                    }
                } else {
                    $output .= '<img src="img/no-image.png" alt="' . $item->name . '"
                                    style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                }
                $output .= '</a>
                        </div>';
                if ($item->stoke === 0) {
                    $output .= '<div class="product-info bg-light opacity-90">';
                } else {
                    $output .= '<div class="product-info">';
                }
                if ($item->discount != 0) {
                    $output .= '<div class="d-flex justify-content-between">
                                    <a href="product-category/' . $item->product_category->slug . '">
                                        <span class="category">' . $item->category_name . '</span>
                                    </a>
                                    <p class="small badge bg-danger">' . $item->discount . '% OFF</p>
                                </div>';
                } else {
                    $output .= '<a href="../product-category/' . $item->product_category->slug . '">
                                    <span class="category">' . $item->category_name . '</span>
                                </a>';
                }
                $output .= '<p class="small" style="color:#16A085;">Stok tersisa ' . $item->stoke . '</p>
                            <h4 class="title">
                                <a href="../home/' . $item->slug . '"
                                    style="color:#16A085; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; overflow: hidden;">' . $item->name . '</a>
                            </h4>
                            <ul class="review">
                                <div>';
                if ($item->stock_out) {
                    $output .= '<span>' . $item->stock_out . ' Terjual</span>';
                } else {
                    $output .= '<span>0 Terjual</span>';
                }
                $output .= '</div>';
                $reviews = Review::where('product_id', $item->id)->get();
                $ratingSum = Review::where('product_id', $item->id)->sum('stars_rated');
                if ($reviews->count() > 0) {
                    $ratingValue = $ratingSum / $reviews->count();
                } else {
                    $ratingValue = 0;
                }
                $rateNum = number_format($ratingValue);
                for ($i = 1; $i <= $rateNum; $i++) {
                    $output .= '<li><i class="lni lni-star-filled"></i></li>';
                }
                for ($j = $rateNum + 1; $j <= 5; $j++) {
                    $output .= '<li><i class="lni lni-star"></i></li>';
                }
                $output .= '</ul>
                            <div class="price">';
                if ($item->price_discount) {
                    $output .= '<span class="text-decoration-line-through text-muted " style="font-size: 13px">Rp. ' . number_format($item->price_discount, 0) . ' <span>Rp. ' . number_format($item->price, 0) . '</span></span>';
                } else {
                    $output .= '<span>Rp. ' . number_format($item->price, 0) . '</span>';
                }
                $output .= '</div>
                        </div>
                    </div>
                    <!-- End Single Product -->
                </div>
                ';
            }
            echo $output;
        } else {
            if (request('pencarian')) {
                echo '<div id="app">
                    <section class="section">
                        <div class="container">
                            <div class="page-error">
                                <div class="page-inner">
                                    <img src="img/undraw_empty_re_opql.svg" alt="">
                                    <div class="page-description">
                                        Tidak ada produk terbaru!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>';
            } else {
                echo '<div id="app">
                    <section class="section">
                        <div class="container">
                            <div class="page-error">
                                <div class="page-inner">
                                    <img src="../img/undraw_empty_re_opql.svg" alt="">
                                    <div class="page-description">
                                        Tidak ada produk yang diposting!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>';
            }
        }
    }
}
