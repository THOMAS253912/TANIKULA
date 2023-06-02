<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Hero;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseApiController as BaseController;

class HeroesApiController extends BaseController
{
    public function index()
    {
        $datas = Hero::get();

        return $this->sendResponse($datas, 'Data fetched');
    }
}
