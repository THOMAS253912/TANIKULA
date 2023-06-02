<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Farmer;
use App\Models\Poktan;
use App\Models\Gapoktan;
use App\Models\ActivityCategory;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ActivityController extends Controller
{
    // set index page view
	public function index() {
		return view('petani.kegiatan.index');
	}

    // handle fetch all eamployees ajax request
	public function fetchAll()
    {
        // $farmer = Farmer::where('user_id', auth()->user()->id)->first();
        // $checkPosted = [$farmer->gapoktan->user_id, $farmer->poktan->user_id];

        $gapoktan = Gapoktan::join('farmers', 'gapoktans.id', '=', 'farmers.gapoktan_id')
                ->join('users', 'farmers.user_id', '=', 'users.id')
                ->select('gapoktans.*', 'users.name as name')
                ->where('farmers.user_id', auth()->user()->id)
                ->orderBy('gapoktans.updated_at', 'desc')
                ->first();
        $poktan = Poktan::join('gapoktans', 'poktans.gapoktan_id', '=', 'gapoktans.id')
                ->join('users', 'poktans.user_id', '=', 'users.id')
                ->select('poktans.*', 'users.name as name')
                ->where('gapoktans.id', $gapoktan->id)
                ->orderBy('poktans.updated_at', 'desc')
                ->get();
        foreach($poktan as $poktan){
            $userIdPoktan = $poktan['user_id'];
            $checkPosted[] = $userIdPoktan;
        }
        $checkPosted[] = $gapoktan->user_id;
        // dd($checkPosted);
		$emps = Activity::join('activity_categories', 'activities.category_activity_id', '=', 'activity_categories.id')
                    ->join('users', 'activities.user_id', '=', 'users.id')
                    ->select('activities.*', 'activity_categories.name as name')
                    ->where('activity_categories.is_active', '=', 1)
                    ->where(static function ($query) use ($checkPosted) {
                        return $query->whereIn('user_id', $checkPosted);
                    })
                    ->orderBy('activities.updated_at', 'desc')
                    ->get();
		$output = '';
		if ($emps->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>No</th>
                <th>Dibuat Oleh</th>
                <th>Judul Kegiatan</th>
                <th>Tanggal Kegiatan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>';
            $nomor=1;
			foreach ($emps as $emp) {
				$output .= '<tr>';
                $output .= '<td>' . $nomor++ . '</td>';
                $output .= '<td>' . $emp->user->name . '</td>';
                $output .= '<td>' . $emp->title . '</td>';
                $output .= '<td>' . date("d F Y", strtotime($emp->date)) . '</td>
                <td>
                  <a href="#" id="' . $emp->id . '" class="text-success mx-1 editIcon" data-toggle="modal" data-target="#editEmployeeModal"><i class="bi-eye h4"></i></a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">Tidak ada data Kegiatan!</h1>';
		}
	}

    // handle edit an employee ajax request
	public function edit(Request $request) {
		$id = $request->id;
		$emp = Activity::with('user', 'activity_category')->find($id);
		return response()->json($emp);
	}

}
