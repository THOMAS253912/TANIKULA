<?php

namespace App\Http\Controllers\Poktan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poktan;
use App\Models\Farmer;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;

class FarmerController extends Controller
{
    // set index page view
	public function index()
    {
        $poktan = Poktan::all();
		return view('poktan.petani.index', compact('poktan'));
	}

    // handle fetch all eamployees ajax request
	public function fetchAll(Request $request)
    {
		// $emps = Poktan::with('user', 'gapoktan')->latest()->get();
        $emps = Farmer::join('poktans', 'farmers.poktan_id', '=', 'poktans.id')
                    ->join('users', 'farmers.user_id', '=', 'users.id')
                    ->select('farmers.*', 'users.name as farmer_name')
                    ->where('poktans.user_id', '=', auth()->user()->id)
                    ->orderBy('updated_at', 'desc')
                    ->get();
		$output = '';
		if ($emps->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama Petani</th>
                <th>Alamat</th>
                <th>No.Telp</th>
                <th>Status Akun</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>';
            $nomor=1;
			foreach ($emps as $emp) {
                // if ($emp->gapoktan->user->name == auth()->user()->name) {
                    $output .= '<tr>';
                    $output .= '<td>' . $nomor++ . '</td>';
                    if (empty($emp->image)) {
                        $output .= '<td><img alt="image" src="../assets/img/avatar/avatar-5.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Wildan Ahdian"></td>';
                    } else {
                        $output .= '<td><img alt="image" src="../assets/img/avatar/avatar-5.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Wildan Ahdian"></td>';
                    }
                    $output .= '
                    <td>' . $emp->farmer_name . '</td>';
                    if ($emp->street && $emp->number) {
                        $output .= '<td>' . $emp->street . ', ' . $emp->number . '. ';
                        if ($emp->village_id && $emp->district_id && $emp->city_id && $emp->province_id != null) {
                            $output .= '' . $emp->village->name . ', Kecamatan '. $emp->district->name .', '. $emp->city->name .', Provinsi '. $emp->province->name .'.';
                        }
                        $output .= '</td>';
                    } else {
                        $output .= '<td><span class="text-danger">Belum diisi</span></td>';
                    }
                    if ($emp->phone) {
                        $output .= '<td>(+62) ' . $emp->phone . '</td>';
                    } else {
                        $output .= '<td><span class="text-danger">Belum diisi</span></td>';
                    }
                    if ($emp->is_active == 1) {
                        $output .= '<td><div class="badge badge-success">Aktif</div></td>';
                    } elseif ($emp->is_active == 0) {
                        $output .= '<td><div class="badge badge-danger">Belum Aktif</div></td>';
                    }
                    $output .= '<td>
                    <a href="#" id="' . $emp->id . '" class="text-success mx-1 editIcon" data-toggle="modal" data-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>
                    <a href="#" id="' . $emp->user->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                    </td>
                </tr>';
                // }
                // elseif ($emp->gapoktan->user->name == !auth()->user()->name) {
                //     $output .= '<h1 class="text-center text-secondary my-5">Tidak ada data Poktan!</h1>';
                // }
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">Tidak ada data Petani!</h1>';
		}
	}

    // handle insert a new employee ajax request
	public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users|max:50',
            'email' => 'required|email|unique:users|max:100',
            'poktan_id' => 'required',
            'password' => 'required|min:6',
            'cpassword' => 'required|same:password',
        ], [
            'name.required' => 'Nama petani diperlukan!',
            'name.max' => 'Nama petani maksimal 50 karakter!',
            'name.unique' => 'Nama petani yang anda masukkan sudah ada!',
            'email.required' => 'Email diperlukan!',
            'email.unique' => 'Email yang anda masukkan sudah ada!',
            'email.max' => 'Email maksimal 100 karakter!',
            'password.required' => 'Kata sandi diperlukan!',
            'password.min' => 'Kata sandi harus minimal 6 karakter!',
            'cpassword.same' => 'Konfirmasi kata sandi tidak cocok!',
            'cpassword.required' => 'Konfirmasi kata sandi diperlukan!',
            'cpassword.min' => 'Kata sandi harus minimal 6 karakter!',
            'poktan_id.required' => 'Nama poktan diperlukan!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->assignRole('petani');
            $user->save();

            $poktan_id = $request->poktan_id;
            $is_active = $request->is_active ? 1 : 0;
            Farmer::create([
                'user_id' => $user->id,
                'gapoktan_id' => $request->gapoktan_id,
                'poktan_id' => $poktan_id,
                'is_active' => $is_active,
            ]);
            return response()->json([
                'status' => 200,
            ]);
        }
	}

    // handle edit an employee ajax request
	public function edit(Request $request) {
		$id = $request->id;
		$emp = Farmer::with('user', 'poktan')->where('id', $id)->first();
		return response()->json($emp);
	}

	// handle update an employee ajax request
	public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'required|email|max:100',
            'cpassword' => 'same:password',
        ], [
            'name.required' => 'Nama petani diperlukan!',
            'name.max' => 'Nama petani maksimal 50 karakter!',
            'email.required' => 'Email diperlukan!',
            'email.max' => 'Email maksimal 100 karakter!',
            'cpassword.same' => 'Konfirmasi kata sandi tidak cocok!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $user = User::find($request->user_id);
            if($request->password) {
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
            } else {
                $user->name = $request->name;
                $user->email = $request->email;
            }
            $user->save();

            $emp = Farmer::with('user', 'poktan')->find($request->emp_id);
            $emp->poktan_id = $request->input('poktan_id');
            // if ($request->is_active == 0) {
                $emp->is_active = $request->is_active ? 1 : 0;
            // } elseif ($request->is_active == 1) {
            //     $emp->is_active = $request->is_active ? 0 : 1;
            // }
            $emp->gapoktan_id = $request->gapoktan_id;
            $emp->save();

            return response()->json([
                'status' => 200,
            ]);
        }
	}

    // handle delete an employee ajax request
	public function delete(Request $request) {
		$id = $request->id;
		Farmer::where('user_id', $id)->delete();
        User::where('id', $id)->delete();
	}
}
