<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poktan;
use App\Models\Gapoktan;
use App\Models\CertificateGapoktan;
use App\Models\UserGapoktan;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class GapoktanController extends Controller
{
    // set index page view
	public function index() {
        $gapoktan = Gapoktan::all();
		return view('admin.gapoktan.index', compact('gapoktan'));
	}

    // handle fetch all eamployees ajax request
	public function fetchAll(Request $request) {
		// $emps = Poktan::with('user', 'gapoktan')->latest()->get();
        $emps = Gapoktan::join('users', 'gapoktans.user_id', '=', 'users.id')
                    ->select('gapoktans.*', 'users.name as gapoktan_name')
                    ->orderBy('updated_at', 'desc')
                    ->get();
		$output = '';
		if ($emps->count() > 0) {
			$output .= '<table id="example1" class="table table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama Gapoktan</th>
                <th>Ketua Gapoktan</th>
                <th>Alamat</th>
                <th>No.Telp</th>
                <th>Status Gapoktan</th>
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
                    $output .= '<td>' . $emp->gapoktan_name . '</td>
                    <td>' . $emp->chairman . '</td>';
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
                    if ($emp->is_verified == 1) {
                        $output .= '<td><span class="badge badge-success">Terverifikasi</span></td>';
                    } elseif ($emp->is_verified == 0) {
                        $output .= '<td><span class="badge badge-danger">Belum diverifikasi</span></td>';
                    }
                    $output .= '<td>
                    <a href="#" id="' . $emp->id . '" class="text-success mx-1 addPhotoProductIcon" data-toggle="modal" data-target="#addPhotoProduct"><i class="bi bi-images h4"></i></a>
                    <a href="#" id="' . $emp->id . '" class="text-success mx-1 viewPhotoProductIcon" data-toggle="modal" data-target="#viewPhotoProduct"><i class="bi bi-eye h4"></i></a>
                    <a href="#" id="' . $emp->id . '" class="text-success mx-1 editIcon" data-toggle="modal" data-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>
                    <a href="#" id="' . $emp->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
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
			echo '<h1 class="text-center text-secondary my-5">Tidak ada data Poktan!</h1>';
		}
	}

    // handle insert a new employee ajax request
	public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users|max:50',
            'email' => 'required|email|unique:users|max:100',
            'chairman' => 'required',
            'password' => 'required|min:6',
            'cpassword' => 'required|same:password',
        ], [
            'name.required' => 'Nama Gapoktan diperlukan!',
            'name.max' => 'Nama Gapoktan maksimal 50 karakter!',
            'name.unique' => 'Nama Gapoktan yang anda masukkan sudah ada!',
            'email.required' => 'Email diperlukan!',
            'email.unique' => 'Email yang anda masukkan sudah ada!',
            'email.max' => 'Email maksimal 100 karakter!',
            'password.required' => 'Kata sandi diperlukan!',
            'password.min' => 'Kata sandi harus minimal 6 karakter!',
            'cpassword.same' => 'Konfirmasi kata sandi tidak cocok!',
            'cpassword.required' => 'Konfirmasi kata sandi diperlukan!',
            'cpassword.min' => 'Kata sandi harus minimal 6 karakter!',
            'chairman.required' => 'Nama ketua Gapoktan diperlukan!',
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
            $user->assignRole('gapoktan');
            $user->save();

            $gapoktan = new Gapoktan();
            $gapoktan->user_id = $user->id;
            $gapoktan->chairman = $request->chairman;
            $gapoktan->is_verified = 1;
            $gapoktan->save();

            $userGapoktans = new UserGapoktan();
            $userGapoktans->user_id = $user->id;
            $userGapoktans->gapoktan_id = $gapoktan->id;
            $userGapoktans->is_active = 1;
            $userGapoktans->save();

            for ($x = 0; $x < $request->TotalImages; $x++)
            {
                if ($request->file('images'.$x))
                {
                    $file = $request->file('images'.$x);
                    $fileName = $file->getClientOriginalName() . '.' . $file->getClientOriginalExtension();
                    if ($fileName) {
                        $file->storeAs('sertifikat', $fileName);
                        $insert[$x]['gapoktan_id'] = $gapoktan->id;
                        $insert[$x]['evidence'] = $fileName;
                        $insert[$x]['created_at'] = Carbon::now();
                        $insert[$x]['updated_at'] = Carbon::now();
                    }
                }
            }

            CertificateGapoktan::insert($insert);

            return response()->json([
                'status' => 200,
            ]);
        }
	}

    // handle edit an employee ajax request
	public function edit(Request $request) {
		$id = $request->id;
		$emp = Gapoktan::with('user')->where('id', $id)->first();
		return response()->json($emp);
	}

	// handle update an employee ajax request
	public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'required|email|max:100',
            // 'chairman' => 'required',
            'cpassword' => 'same:password',
        ], [
            'name.required' => 'Nama Gapoktan diperlukan!',
            'name.max' => 'Nama Gapoktan maksimal 50 karakter!',
            'email.required' => 'Email diperlukan!',
            'email.max' => 'Email maksimal 100 karakter!',
            // 'chairman.required' => 'Nama ketua Gapoktan diperlukan!',
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

            // if ($request->is_verified == 0) {
                $gapoktan = Gapoktan::with('user')->find($request->emp_id);
                $gapoktan->user_id = $user->id;
                $gapoktan->chairman = $request->chairman;
                $gapoktan->is_verified = $request->is_verified ? 1 : 0;
                $gapoktan->save();

                $userGapoktans = UserGapoktan::where('gapoktan_id', $request->emp_id)->first();
                $userGapoktans->is_active = $request->is_verified ? 1 : 0;
                $userGapoktans->save();
            // } elseif ($request->is_verified == 1) {
            //     $gapoktan = Gapoktan::with('user')->find($request->emp_id);
            //     $gapoktan->user_id = $user->id;
            //     $gapoktan->chairman = $request->chairman;
            //     $gapoktan->is_verified = $request->is_verified ? 0 : 1;
            //     $gapoktan->save();

            //     $userGapoktans = UserGapoktan::where('gapoktan_id', $request->emp_id)->first();
            //     $userGapoktans->is_active = $request->is_verified ? 0 : 1;
            //     $userGapoktans->save();
            // }

            return response()->json([
                'status' => 200,
            ]);
        }
	}

    // handle delete an employee ajax request
	public function delete(Request $request) {
		$id = $request->id;
		$emp = Gapoktan::where('id', $id)->first();
        $data = CertificateGapoktan::where('gapoktan_id', $id)->get();
        foreach ($data as $key => $value) {
            Storage::delete('sertifikat/' . $value->evidence);
        }
        CertificateGapoktan::where('gapoktan_id', $id)->delete();
        UserGapoktan::where('gapoktan_id', $id)->delete();
        User::where('id', $emp->user_id)->delete();
        $emp->delete();
	}

    // handle edit an employee ajax request
	public function viewPhoto(Request $request)
    {
		$id = $request->id;
		$emp = CertificateGapoktan::distinct()->join('gapoktans', 'certificate_gapoktans.gapoktan_id', '=', 'gapoktans.id')
                    ->select('certificate_gapoktans.*', 'gapoktans.chairman as name_chairman')
                    ->where('certificate_gapoktans.gapoktan_id', '=', $id)
                    ->get();
		return response()->json($emp);
	}

    // handle delete an employee ajax request
	public function deletePhoto(Request $request) {
        $id = $request->id;
		$emp = CertificateGapoktan::find($id);
		if (Storage::delete('sertifikat/' . $emp->evidence)) {
			CertificateGapoktan::destroy($id);
		} else {
            $emp->delete();
        }
	}

    // handle edit an employee ajax request
	public function addPhoto(Request $request) {
		$id = $request->id;
		$emp = Gapoktan::join('users', 'gapoktans.user_id', '=', 'users.id')
                    ->leftJoin('certificate_gapoktans', function ($join) {
                            $join->on('gapoktans.id', '=', 'certificate_gapoktans.gapoktan_id');
                        })
                    ->select('gapoktans.*', 'users.name as gapoktan_name')
                    ->find($id);
		return response()->json($emp);
	}

    // handle update an employee ajax request
	public function addPhotoProduct(Request $request) {
        $validator = Validator::make($request->all(), [
            'images' => 'required',
        ], [
            'images.required' => 'Unggah bukti gapoktan diperlukan!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            if($request->TotalImages > 0)
            {
                $gapoktan = Gapoktan::find($request->id);
                $gapoktan->chairman = $request->chairman;
                $gapoktan->update();

                for ($x = 0; $x < $request->TotalImages; $x++)
                {
                    if ($request->hasFile('images'.$x))
                    {
                        $file = $request->file('images'.$x);
                        $fileName = $file->getClientOriginalName() . '.' . $file->getClientOriginalExtension();
                        if ($fileName) {
                            $file->storeAs('sertifikat', $fileName);
                            $insert[$x]['gapoktan_id'] = $gapoktan->id;
                            $insert[$x]['evidence'] = $fileName;
                            $insert[$x]['created_at'] = Carbon::now();
                            $insert[$x]['updated_at'] = Carbon::now();
                        }
                    }
                }
                CertificateGapoktan::insert($insert);
                return response()->json([
                    'status' => 200,
                ]);
            }
            else
            {
            return response()->json([
                    'status' => 401,
                ]);
            }
        }
	}
}
