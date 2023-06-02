<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Gapoktan;
use App\Models\User;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    // set index page view
	public function index()
    {
        $user = Gapoktan::latest()->get();
		return view('admin.produk-kategori.index', compact('user'));
	}

    // handle fetch all eamployees ajax request
	public function fetchAll()
    {
		$emps = ProductCategory::latest()->get();
		$output = '';
		if ($emps->count() > 0) {
			$output .= '<table id="example1" class="table table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Status Kategori</th>
                <th>Icon</th>
                <th>Dibuat</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>';
            $nomor=1;
			foreach ($emps as $emp) {
				$output .= '<tr>
                <td>' . $nomor++ . '</td>
                <td>' . $emp->name . '</td>';
                if ($emp->is_active == 1) {
                    $output .= '<td><div class="badge badge-success">Aktif</div></td>';
                } elseif ($emp->is_active == 0) {
                    $output .= '<td><div class="badge badge-danger">Tidak Aktif</div></td>';
                }
                $output .= '<td>';
                if ($emp->icon) {
                        $output .= '<img src="../storage/icon/' . $emp->icon . '" class="img-fluid img-thumbnail" style="width: 100px; height: 65px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                    } else {
                        $output .= '<img src="../stisla/assets/img/example-image.jpg" class="img-fluid img-thumbnail" style="width: 100px; height: 65px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                    }
                $output .= '</td>
                <td>' . $emp->gapoktan->user->name . '</td>';
                $output .= '<td>
                  <a href="#" id="' . $emp->id . '" class="text-success mx-1 editIcon" data-toggle="modal" data-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">Tidak ada data Kategori Produk!</h1>';
		}
	}

    // handle insert a new employee ajax request
	public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:product_categories|max:50',
            'icon' => 'required',
            'gapoktan_id' => 'required',
        ], [
            'gapoktan_id.required' => 'Gapoktan diperlukan!',
            'name.required' => 'Nama kategori produk diperlukan!',
            'name.max' => 'Nama kategori produk maksimal 50 karakter!',
            'name.unique' => 'Nama Kategori Produk yang anda masukkan sudah ada!',
            'icon.required' => 'Foto maupun video edukasi diperlukan!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $file = $request->file('icon');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('icon', $fileName);
            $is_active = $request->is_active ? 1 : 0;
            $empData = ['gapoktan_id' => $request->gapoktan_id, 'name' => $request->name, 'slug' => $request->slug, 'is_active' => $is_active, 'icon' => $fileName];

            ProductCategory::create($empData);
            return response()->json([
                'status' => 200,
            ]);
        }
	}

    // handle edit an employee ajax request
	public function edit(Request $request)
    {
		$id = $request->id;
		$emp = ProductCategory::with('gapoktan')
                ->join('gapoktans', 'product_categories.gapoktan_id', '=', 'gapoktans.id')
                ->join('users', 'gapoktans.user_id', '=', 'users.id')
                ->select('product_categories.*', 'gapoktans.chairman as gapoktan_name')
                ->find($id);
		return response()->json($emp);
	}

    // handle update an employee ajax request
	public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
        ], [
            'name.required' => 'Nama kategori produk diperlukan!',
            'name.max' => 'Nama kategori produk maksimal 50 karakter!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $fileName = '';
            $emp = ProductCategory::find($request->emp_id);
            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('icon', $fileName);
                if ($emp->icon) {
                    Storage::delete('icon/' . $emp->icon);
                }
            } else {
                $fileName = $request->emp_avatar;
            }

            if ($request->gapoktan_id) {
                $emp->gapoktan_id = $request->gapoktan_id;
            }

            $emp->is_active = $request->is_active ? 1 : 0;
            $emp->name = $request->name;
            $emp->icon = $fileName;
            $emp->slug = $request->slug;
            $emp->update();
            return response()->json([
                'status' => 200,
            ]);
        }
	}

    public function checkSlug(Request $request)
    {
        // Old version: without uniqueness
        $slug = $request->name;

        // New version: to generate unique slugs
        $slug = SlugService::createSlug(ProductCategory::class, 'slug', $request->name);

        return response()->json(['slug' => $slug]);
    }
}
