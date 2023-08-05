<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\CmsController;
use App\Models\Product;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cms = (new CmsController())->get();

        $cms['app_slider'] = json_decode($cms['app_slider']);

        // user_id disesuaikan dengan sri makmur nantinya {2} hanya sebagai contoh
        $product = Product::where('user_id', 2)->get();
        return view('company.index', compact('cms', 'product'));
    }
}
