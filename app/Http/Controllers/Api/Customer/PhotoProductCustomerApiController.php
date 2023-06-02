<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\PhotoProductResource;
use App\Models\PhotoProduct;
use App\Models\User;
use Illuminate\Http\Request;

class PhotoProductCustomerApiController extends Controller
{
    public function index()
    {
        $datas = PhotoProduct::get();

        $result = PhotoProductResource::collection($datas);
        return $this->sendResponse($result, 'Data fetched');
    }
}
