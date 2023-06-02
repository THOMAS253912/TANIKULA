<?php

namespace App\Http\Controllers\Gapoktan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plant;
use App\Models\Poktan;
use App\Models\FieldRecapHarvest;
use App\Models\FieldCategory;
use App\Models\Gapoktan;
use Illuminate\Support\Facades\DB;
use App\Models\Farmer;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PlantingHistoryController extends Controller
{
    // set index page view
	public function index() {
		return view('gapoktan.riwayat_penanam.index');
	}

    // handle fetch all eamployees ajax request
	public function fetchAll(Request $request)
    {
        if(!empty($request->from_date))
        {
            $gapoktans = Gapoktan::where('user_id', auth()->user()->id)->first();
            $emps = FieldRecapHarvest::join('field_recap_plantings', 'field_recap_harvests.planting_id', '=', 'field_recap_plantings.id')
                    ->join('farmers', 'field_recap_harvests.farmer_id', '=', 'farmers.id')
                    ->select('field_recap_harvests.*', 'farmers.user_id as name')
                    ->where('farmers.gapoktan_id', '=', $gapoktans->id)
                    ->where('field_recap_harvests.status', 'panen')
                    ->whereBetween('field_recap_harvests.date_harvest', array($request->from_date, $request->to_date))
                    ->orderBy('field_recap_harvests.updated_at', 'desc')
                    ->get();
        }
            else
        {
            $gapoktans = Gapoktan::where('user_id', auth()->user()->id)->first();
            $emps = FieldRecapHarvest::join('field_recap_plantings', 'field_recap_harvests.planting_id', '=', 'field_recap_plantings.id')
                    ->join('farmers', 'field_recap_harvests.farmer_id', '=', 'farmers.id')
                    ->select('field_recap_harvests.*', 'farmers.user_id as name')
                    ->where('farmers.gapoktan_id', '=', $gapoktans->id)
                    ->where('field_recap_harvests.status', 'panen')
                    ->orderBy('field_recap_harvests.updated_at', 'desc')
                    ->get();
        }
		$output = '';
		if ($emps->count() > 0) {
			$output .= '<table class="table table-bordered table-sm text-center align-middle">
            <thead>
              <tr>
                <th class="align-middle text-center">No</th>
                <th class="align-middle text-center">Lahan</th>
                <th class="align-middle text-center">Petani</th>
                <th class="align-middle text-center">Tanggal Tandur</th>
                <th class="align-middle text-center">Tanggal Panen</th>
                <th class="align-middle text-center">Status</th>
              </tr>
            </thead>
            <tbody>';
            $nomor=1;
			foreach ($emps as $emp) {
				$output .= '<tr>';
                $output .= '<td class="align-middle text-center">' . $nomor++ . '</td>';
                $output .= '<td class="align-middle text-center">' . $emp->fieldRecapPlanting->field->fieldCategory->name . '</td>';
                $output .= '<td class="align-middle text-center">' . $emp->farmer->user->name . '</td>
                <td class="align-middle text-center">' . date("d-F-Y", strtotime($emp->fieldRecapPlanting->date_planting)) . '</td>
                <td class="align-middle text-center">' . date("d-F-Y", strtotime($emp->date_harvest)) . '</td>';
                if ($emp->status) {
                    $output .= '<td class="align-middle text-center"><span class="text-capitalize">' . $emp->status . '</span></td>';
                } else {
                    $output .= '<td class="align-middle text-center"><span class="text-danger">Belum ada status</span></td>';
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
