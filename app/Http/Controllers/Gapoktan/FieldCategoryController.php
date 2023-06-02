<?php

namespace App\Http\Controllers\Gapoktan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FieldCategory;
use App\Models\Gapoktan;
use Illuminate\Support\Facades\Validator;

class FieldCategoryController extends Controller
{
    // set index page view
	public function index() {
		return view('gapoktan.lahan-kategori.index');
	}

    // handle fetch all eamployees ajax request
	public function fetchAll()
    {
        $gapoktan = Gapoktan::where('user_id', auth()->user()->id)->first();
		$emps = FieldCategory::where('gapoktan_id', $gapoktan->id)->latest()->get();
		$output = '';
		if ($emps->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Lahan</th>
                <th>Keterangan Lahan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>';
            $nomor=1;
			foreach ($emps as $emp) {
				$output .= '<tr>
                <td>' . $nomor++ . '</td>
                <td>' . $emp->name . '</td>
                <td>' . $emp->details . '</td>';
                $output .= '<td>
                  <a href="#" id="' . $emp->id . '" class="text-success mx-1 editIcon" data-toggle="modal" data-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">Tidak ada data Kategori Lahan!</h1>';
		}
	}

    // handle insert a new employee ajax request
	public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'details' => 'required|max:255',
        ], [
            'name.required' => 'Nama Lahan diperlukan!',
            'name.max' => 'Nama lahan maksimal 50 karakter!',
            'details.required' => 'Nama keterangan lahan diperlukan!',
            'details.max' => 'Nama keterangan lahan maksimal 255 karakter!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $gapoktan = Gapoktan::where('user_id', auth()->user()->id)->first();
            $empData = ['gapoktan_id' => $gapoktan->id, 'name' => $request->name, 'details' => $request->details];

            FieldCategory::create($empData);
            return response()->json([
                'status' => 200,
            ]);
        }
	}

    // handle edit an employee ajax request
	public function edit(Request $request)
    {
		$id = $request->id;
		$emp = FieldCategory::find($id);
		return response()->json($emp);
	}

    // handle update an employee ajax request
	public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'details' => 'required|max:255',
        ], [
            'name.required' => 'Nama Lahan diperlukan!',
            'name.max' => 'Nama lahan maksimal 50 karakter!',
            'details.required' => 'Nama keterangan lahan diperlukan!',
            'details.max' => 'Nama keterangan lahan maksimal 255 karakter!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $gapoktan = Gapoktan::where('user_id', auth()->user()->id)->first();
            $emp = FieldCategory::find($request->emp_id);
            $empData = ['gapoktan_id' => $gapoktan->id, 'name' => $request->name, 'details' => $request->details];
            $emp->update($empData);

            return response()->json([
                'status' => 200,
            ]);
        }
	}
}
