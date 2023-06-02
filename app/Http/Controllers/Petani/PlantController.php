<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FieldRecapPlanting;
use App\Models\Poktan;
use Illuminate\Support\Facades\DB;
use App\Models\Farmer;
use App\Models\Field;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PlantController extends Controller
{
    // set index page view
    public function index()
    {
        $farmer = Farmer::where('user_id', '=', auth()->user()->id)->get();
        return view('petani.tandur.index', compact('farmer'));
    }

    // handle fetch all eamployees ajax request
    public function fetchAll(Request $request)
    {
        // $emps = Poktan::with('user', 'gapoktan')->latest()->get();
        $emps = FieldRecapPlanting::join('fields', 'field_recap_plantings.field_id', '=', 'fields.id')
            ->join('farmers', 'field_recap_plantings.farmer_id', '=', 'farmers.id')
            ->select('field_recap_plantings.*', 'fields.farmer_id as name')
            ->where('farmers.user_id', '=', auth()->user()->id)
            ->orderBy('field_recap_plantings.updated_at', 'desc')
            ->get();
        $output = '';
        if ($emps->count() > 0) {
            $output .= '<table id="recapPlanting" class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Petani</th>
                <th>Lahan</th>
                <th>Tanggal Tandur</th>
              </tr>
            </thead>
            <tbody>';
            $nomor = 1;
            foreach ($emps as $emp) {
                $output .= '<tr>';
                $output .= '<td>' . $nomor++ . '</td>';
                $output .= '<td>' . $emp->farmer->user->name . '</td>
                <td>' . $emp->field->fieldCategory->name . ' (' . $emp->field->fieldCategory->details . ')</td>';
                if ($emp->date_planting) {
                    $output .= '<td>' . date("d-F-Y", strtotime($emp->date_planting)) . '</td>';
                } else {
                    $output .= '<td><span class="text-danger">Belum diisi</span></td>';
                }
                $output .= '
            </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">Tidak ada data tandur!</h1>';
        }
    }

    // handle fetch all eamployees ajax request
    public function fetchAllFields(Request $request)
    {
        $farmers = Farmer::where('user_id', auth()->user()->id)->first();
        $emps = Field::join('field_categories', 'fields.field_category_id', '=', 'field_categories.id')
            ->join('gapoktans', 'fields.gapoktan_id', '=', 'gapoktans.id')
            ->join('farmers', 'fields.farmer_id', '=', 'farmers.id')
            ->select('fields.*', 'field_categories.name as name')
            ->where('fields.farmer_id', $farmers->id)
            ->where('fields.status', '!=', 'tandur')
            ->where('fields.status', '!=', 'panen')
            ->where('fields.status', '!=', 'belum selesai panen')
            ->orderBy('fields.updated_at', 'desc')
            ->get();
        $output = '';
        if ($emps->count() > 0) {
            $output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>No</th>
                <th>Lahan</th>
                <th>Gapoktan</th>
                <th>Petani</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>';
            $nomor = 1;
            foreach ($emps as $emp) {
                $output .= '<tr>';
                $output .= '<td>' . $nomor++ . '</td>';
                $output .= '<td>' . $emp->fieldCategory->name . ' (' . $emp->fieldCategory->details . ')</td>';
                $output .= '<td>' . $emp->gapoktan->user->name . '</td>
                <td>' . $emp->farmer->user->name . '</td>';
                $output .= '<td>
                    <a href="#" id="' . $emp->id . '" class="text-success mx-1 editIcon" data-toggle="modal" data-target="#editEmployeeModal" data-dismiss="modal">Melakukan Tandur</a>
                </td>
              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">Tidak ada data tandur!</h1>';
        }
    }

    // handle insert a new employee ajax request
    // public function store(Request $request)
    // {
    // 	$plant = new Plant();
    //     $plant->farmer_id = $request->farmer_id;
    //     $plant->poktan_id = $request->poktan_id;
    //     $plant->plant_tanaman = $request->plant_tanaman;
    //     $plant->surface_area = $request->surface_area;
    //     $plant->address = $request->address;
    //     $plant->status = "tandur";
    //     $plant->plating_date = Carbon::createFromFormat('d-M-Y', $request->plating_date)->format('Y-m-d h:i:s');
    //     $plant->save();

    //     $notification = new NotificationPlant();
    //     $notification->plant_id = $plant->id;
    //     $notification->save();

    // 	return response()->json([
    // 		'status' => 200,
    // 	]);
    // }

    // handle edit an employee ajax request
    public function edit(Request $request)
    {
        $id = $request->id;
        $emp = Field::find($id);
        return response()->json($emp);
    }

    // handle update an employee ajax request
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_planting' => 'required',
        ], [
            'date_planting.required' => 'Tanggal tandur diperlukan!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $plant = Field::find($request->emp_id);
            $plant->status = 'tandur';
            $plant->save();

            $planting = FieldRecapPlanting::where('field_id', $request->emp_id)->create([
                'field_id' => $request->field_id,
                'farmer_id' => $request->farmer_id,
                'date_planting' => Carbon::createFromFormat('d-M-Y', $request->date_planting)->format('Y-m-d h:i:s'),
                'status' => 'melakukan tandur',
            ]);

            return response()->json([
                'status' => 200,
            ]);
        }
    }

    // handle delete an employee ajax request
    public function delete(Request $request)
    {
        $id = $request->id;
        $emp = Plant::with('poktan', 'farmer')->where('id', $id);
        $emp->delete();
    }
}
