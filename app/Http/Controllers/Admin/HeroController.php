<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hero;
use App\Models\EducationCategory;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class HeroController extends Controller
{
    // set index page view
	public function index() {
		return view('admin.hero.index');
	}

    // handle fetch all eamployees ajax request
	public function fetchAll()
    {
		$emps = Hero::latest()->get();
		$output = '';
		if ($emps->count() > 0) {
			$output .= '<table id="example1" class="table table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Gambar</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>';
            $nomor=1;
			foreach ($emps as $emp) {
				$output .= '<tr>
                <td>' . $nomor++ . '</td>
                <td>' . $emp->name . '</td>';
                if ($emp->image) {
                    $output .= '<td><img src="../storage/hero/' . $emp->image . '" class="img-fluid img-thumbnail" style="width: 100px; height: 65px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"></td>';
                } else {
                    $output .= '<td><img src="../stisla/assets/img/example-image.jpg" class="img-fluid img-thumbnail" style="width: 100px; height: 65px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"></td>';
                }
                $output .= '<td>
                  <a href="#" id="' . $emp->id . '" class="text-success mx-1 editIcon" data-toggle="modal" data-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>
                  <a href="#" id="' . $emp->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">Tidak ada data Hero!</h1>';
		}
	}

    // handle insert a new employee ajax request
	public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'image' => 'required',
        ], [
            'name.required' => 'Nama Hero diperlukan!',
            'name.max' => 'Nama Hero maksimal 255 karakter!',
            'image.required' => 'Foto Hero diperlukan!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            if ($request->file('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('hero', $fileName);

                $empData = ['name' => $request->name, 'image' => $fileName];
            }
            Hero::create($empData);
            return response()->json([
                'status' => 200,
            ]);
        }
	}

    // handle edit an employee ajax request
	public function edit(Request $request)
    {
		$id = $request->id;
		$emp = Hero::find($id);
		return response()->json($emp);
	}

    // handle update an employee ajax request
	public function update(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ], [
            'name.required' => 'Nama Hero diperlukan!',
            'name.max' => 'Nama Hero maksimal 255 karakter!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $fileName = '';
            $emp = Hero::find($request->emp_id);
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('hero', $fileName);
                if ($emp->image) {
                    Storage::delete('hero/' . $emp->image);
                }
                $empData = ['name' => $request->name, 'image' => $fileName];
            } else {
                $fileName = $request->emp_avatar;
                $empData = ['name' => $request->name];
            }
            $emp->update($empData);
            return response()->json([
                'status' => 200,
            ]);
        }
	}

    // handle delete an employee ajax request
	public function delete(Request $request)
    {
		$id = $request->id;
		$emp = Hero::find($id);
		if (Storage::delete('hero/' . $emp->image)) {
			Hero::destroy($id);
		} else {
            $emp->delete();
        }
	}
}
