<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Farmer;
use App\Models\Plant;
use App\Models\Product;
use App\Models\Education;
use App\Models\Activity;
use App\Models\Poktan;
use App\Models\Gapoktan;
use Redirect, Response;
Use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
    	return view('support.dashboard.index');
    }

    // handle fetch all eamployees ajax request
	public function fetchAll(Request $request) {
        $countGapoktan = Gapoktan::join('users', 'gapoktans.user_id', '=', 'users.id')->count();
		$output = '';
            $output .= '
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-light">
                    <div class="inner">
                        <h5 class="font-weight-bold">Akun Gapoktan</h5>
                        <p>'. $countGapoktan .' Akun</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-solid fa-user text-warning"></i>
                    </div>
                    <a href="support/verifikasi-gapoktan" class="mt-3 small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>';
			echo $output;
	}

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('home');
    }
}
