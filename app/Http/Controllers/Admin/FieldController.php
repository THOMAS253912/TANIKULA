<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Field;
use App\Models\FieldCategory;
use App\Models\Gapoktan;
use App\Models\Farmer;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FieldController extends Controller
{
    // set index page view
	public function index() {
		$category = FieldCategory::latest()->get();
        $gapoktans = Gapoktan::all();
        $farmers = Farmer::join('poktans', 'farmers.poktan_id', '=', 'poktans.id')
                    ->join('gapoktans', 'poktans.gapoktan_id', '=', 'gapoktans.id')
                    ->join('users', 'farmers.user_id', '=', 'users.id')
                    ->select('farmers.*', 'users.name as farmer_name')
                    ->orderBy('updated_at', 'desc')
                    ->get();
		return view('admin.lahan.index', compact('category', 'farmers', 'gapoktans'));
	}

    public function farmer($id)
    {
        $farmers = DB::table("farmers")
                    ->join('users', 'farmers.user_id', '=', 'users.id')
                    ->where("gapoktan_id", $id)
                    ->pluck('users.name','farmers.id');
        return json_encode($farmers);
    }

    // handle fetch all eamployees ajax request
	public function fetchAll()
    {
		$emps = Field::latest()->get();
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
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>';
            $nomor=1;
			foreach ($emps as $emp) {
				$output .= '<tr>';
                $output .= '<td>' . $nomor++ . '</td>';
                $output .= '<td>' . $emp->fieldCategory->name . ' (' . $emp->fieldCategory->details . ')</td>';
                $output .= '<td>' . $emp->gapoktan->user->name . '</td>
                <td>' . $emp->farmer->user->name . '</td>';
                if ($emp->status) {
                    $output .= '<td><span class="text-capitalize">' . $emp->status . '</span></td>';
                } else {
                    $output .= '<td><span class="text-danger">Belum ada status</span></td>';
                }
                    $output .= '<td>
                    <a href="#" id="' . $emp->id . '" class="text-success mx-1 editIcon" data-toggle="modal" data-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>
                    <a href="#" id="' . $emp->id . '" class="text-danger mx-1 recycleField"><i class="bi-recycle h4"></i></a>
                </td>
              </tr>';
                // <a href="#" id="' . $emp->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">Tidak ada data Lahan!</h1>';
		}
	}

    // handle insert a new employee ajax request
	public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'field_category_id' => 'required',
            'gapoktan_id' => 'required',
            'farmer_id' => 'required',
            // 'status' => 'required',
        ], [
            'field_category_id.required' => 'Kategori lahan diperlukan!',
            'gapoktan_id.required' => 'Gapoktan diperlukan!',
            'farmer_id.required' => 'Petani diperlukan!',
            // 'status.required' => 'Status diperlukan!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $fields = new Field();
            $fields->field_category_id = $request->field_category_id;
            $fields->gapoktan_id = $request->gapoktan_id;
            $fields->farmer_id = $request->farmer_id;
            $fields->status = 'Belum ada status';
            // $fields->status = $request->status;
            $fields->save();

            return response()->json([
                'status' => 200,
            ]);
        }
	}

    // handle edit an employee ajax request
	public function edit(Request $request) {
		$id = $request->id;
		$emp = Field::find($id);
		return response()->json($emp);
	}

	// handle update an employee ajax request
	public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'field_category_id' => 'required',
            'gapoktan_id' => 'required',
            'farmer_id' => 'required',
            // 'status' => 'required',
        ], [
            'field_category_id.required' => 'Kategori lahan diperlukan!',
            'gapoktan_id.required' => 'Gapoktan diperlukan!',
            'farmer_id.required' => 'Petani diperlukan!',
            // 'status.required' => 'Status diperlukan!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $fields = Field::find($request->emp_id);
            $fields->field_category_id = $request->field_category_id;
            if ($request->edit_gapoktan_id && $request->edit_farmer_id) {
                $fields->gapoktan_id = $request->edit_gapoktan_id;
                $fields->farmer_id = $request->edit_farmer_id;
            }
            // $fields->status = $request->status;
            $fields->update();

            return response()->json([
                'status' => 200,
            ]);
        }
	}

    // handle delete an employee ajax request
	public function delete(Request $request)
    {
		$id = $request->id;
		// $emp = Activity::find($id);
		$emp = Field::find($id);
        $emp->delete();
	}

    // handle delete an employee ajax request
	public function recycleField(Request $request)
    {
		$id = $request->id;
		// $emp = Activity::find($id);
		$fields = Field::find($id);
        $fields->status = 'Belum ada status';
        $fields->update();
	}

    public function checkSlug(Request $request)
    {
        // Old version: without uniqueness
        $slug = $request->title;

        // New version: to generate unique slugs
        $slug = SlugService::createSlug(Activity::class, 'slug', $request->title);

        return response()->json(['slug' => $slug]);
    }
}
