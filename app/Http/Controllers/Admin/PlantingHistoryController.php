<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FieldRecapHarvest;
use App\Models\Poktan;
use Illuminate\Support\Facades\DB;
use App\Models\Farmer;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PlantingHistoryController extends Controller
{
    // set index page view
	public function index() {
		return view('admin.riwayat_penanam.index');
	}

    // handle fetch all eamployees ajax request
	public function fetchAll(Request $request) {
		if(!empty($request->from_date))
        {
            $emps = FieldRecapHarvest::join('field_recap_plantings', 'field_recap_harvests.planting_id', '=', 'field_recap_plantings.id')
                    ->join('farmers', 'field_recap_harvests.farmer_id', '=', 'farmers.id')
                    ->select('field_recap_harvests.*', 'farmers.user_id as name')
                    ->where('field_recap_harvests.status', 'panen')
                    ->whereBetween('field_recap_harvests.date_harvest', array($request->from_date, $request->to_date))
                    ->orderBy('field_recap_harvests.updated_at', 'desc')
                    ->get();
        }
            else
        {
            $emps = FieldRecapHarvest::join('field_recap_plantings', 'field_recap_harvests.planting_id', '=', 'field_recap_plantings.id')
                    ->join('farmers', 'field_recap_harvests.farmer_id', '=', 'farmers.id')
                    ->select('field_recap_harvests.*', 'farmers.user_id as name')
                    ->where('field_recap_harvests.status', 'panen')
                    ->orderBy('field_recap_harvests.updated_at', 'desc')
                    ->get();
        }
		$output = '';
		if ($emps->count() > 0) {
			$output .= '<table id="recapPlanting" class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>No</th>
                <th>Lahan</th>
                <th>Petani</th>
                <th>Tanggal Tandur</th>
                <th>Tanggal Panen</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>';
            $nomor=1;
			foreach ($emps as $emp) {
				$output .= '<tr>';
                $output .= '<td>' . $nomor++ . '</td>';
                $output .= '<td>' . $emp->fieldRecapPlanting->field->fieldCategory->name . ' (' . $emp->fieldRecapPlanting->field->fieldCategory->details . ')</td>';
                $output .= '<td>' . $emp->farmer->user->name . '</td>
                <td>' . date("d-F-Y", strtotime($emp->fieldRecapPlanting->date_planting)) . '</td>
                <td>' . date("d-F-Y", strtotime($emp->date_harvest)) . '</td>';
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
