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

class HarvestController extends Controller
{
    // set index page view
	public function index() {
		return view('admin.panen.index');
	}

    // handle fetch all eamployees ajax request
	public function fetchAll(Request $request) {
		$emps = FieldRecapHarvest::latest()->get();
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
			echo '<h1 class="text-center text-secondary my-5">Tidak ada data Laporan Panen!</h1>';
		}
	}

    // handle edit an employee ajax request
	public function edit(Request $request) {
		$id = $request->id;
		$emp = Plant::with('poktan', 'farmer')->where('id', $id)->first();
		return response()->json($emp);
	}
}
