<?php

namespace App\Http\Controllers\Poktan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FieldRecapHarvest;
use App\Models\Poktan;
use Illuminate\Support\Facades\DB;
use App\Models\Farmer;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;

class HarvestController extends Controller
{
    // set index page view
	public function index() {
		return view('poktan.panen.index');
	}

    // handle fetch all eamployees ajax request
	public function fetchAll(Request $request)
    {
        $poktan = Poktan::where('user_id', auth()->user()->id)->first();
        $emps = FieldRecapHarvest::join('field_recap_plantings', 'field_recap_harvests.planting_id', '=', 'field_recap_plantings.id')
                    ->join('farmers', 'field_recap_harvests.farmer_id', '=', 'farmers.id')
                    ->select('field_recap_harvests.*', 'farmers.user_id as name')
                    ->where('farmers.gapoktan_id', '=', $poktan->gapoktan_id)
                    ->orderBy('field_recap_harvests.updated_at', 'desc')
                    ->get();
		$output = '';
		if ($emps->count() > 0) {
			$output .= '<table id="recapHarvest" class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Petani</th>
                <th>Lahan</th>
                <th>Tanggal Tandur</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>';
            $nomor=1;
			foreach ($emps as $emp) {
                $output .= '<tr>';
                $output .= '<td>' . $nomor++ . '</td>';
                $output .= '<td>' . $emp->farmer->user->name . '</td>
                <td>' . $emp->fieldRecapPlanting->field->fieldCategory->name . ' (' . $emp->fieldRecapPlanting->field->fieldCategory->details . ')</td>';
                if ($emp->date_harvest) {
                    $output .= '<td>'. date("d-F-Y", strtotime($emp->date_harvest)) .'</td>';
                } else {
                    $output .= '<td><span class="text-danger">Belum diisi</span></td>';
                }
                if ($emp->status) {
                    $output .= '<td><span class="text-capitalize">'. $emp->status .'</span></td>';
                } else {
                    $output .= '<td><span class="text-danger">Belum diisi</span></td>';
                }
                $output .= '
            </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">Tidak ada data Panen!</h1>';
		}
	}

    // handle edit an employee ajax request
	public function edit(Request $request) {
		$id = $request->id;
		$emp = Plant::with('poktan', 'farmer')->where('id', $id)->first();
		return response()->json($emp);
	}
}
