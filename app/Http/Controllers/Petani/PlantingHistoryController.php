<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plant;
use App\Models\Poktan;
use App\Models\Field;
use App\Models\FieldCategory;
use Illuminate\Support\Facades\DB;
use App\Models\Farmer;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PlantingHistoryController extends Controller
{
    // set index page view
	public function index() {
		return view('petani.riwayat_penanam.index');
	}

    // handle fetch all eamployees ajax request
	public function fetchAll(Request $request) {
		if(!empty($request->from_date))
        {
            $emps = Field::join('field_categories', 'fields.field_category_id', '=', 'field_categories.id')
                    ->join('gapoktans', 'fields.gapoktan_id', '=', 'gapoktans.id')
                    ->join('farmers', 'fields.farmer_id', '=', 'farmers.id')
                    ->select('fields.*', 'field_categories.name as name')
                    ->where('fields.farmer_id', auth()->user()->id)
                    ->where('fields.status', 'panen')
                    ->whereBetween('fields.created_at', array($request->from_date, $request->to_date))
                    ->orderBy('fields.updated_at', 'desc')
                    ->get();
        }
            else
        {
            $emps = Field::join('field_categories', 'fields.field_category_id', '=', 'field_categories.id')
                    ->join('gapoktans', 'fields.gapoktan_id', '=', 'gapoktans.id')
                    ->join('farmers', 'fields.farmer_id', '=', 'farmers.id')
                    ->select('fields.*', 'field_categories.name as name')
                    ->where('fields.gapoktan_id', auth()->user()->id)
                    ->where('fields.status', 'panen')
                    ->orderBy('fields.updated_at', 'desc')
                    ->get();
        }
		$output = '';
		if ($emps->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>No</th>
                <th>Lahan</th>
                <th>Gapoktan</th>
                <th>Petani</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>';
            $nomor=1;
			foreach ($emps as $emp) {
				$output .= '<tr>';
                $output .= '<td>' . $nomor++ . '</td>';
                $output .= '<td>' . $emp->fieldCategory->name . '</td>';
                $output .= '<td>' . $emp->gapoktan->user->name . '</td>
                <td>' . $emp->farmer->user->name . '</td>';
                if ($emp->status) {
                    $output .= '<td><span class="text-capitalize">' . $emp->status . '</span></td>';
                } else {
                    $output .= '<td><span class="text-danger">Belum ada status</span></td>';
                }
                $output .= '
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">Tidak ada data Riwayat Penanam!</h1>';
		}
	}

    // handle edit an employee ajax request
	public function edit(Request $request) {
		$id = $request->id;
		$emp = Plant::with('poktan', 'farmer')->where('id', $id)->first();
		return response()->json($emp);
	}
}
