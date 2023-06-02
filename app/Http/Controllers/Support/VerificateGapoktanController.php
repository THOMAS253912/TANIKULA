<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gapoktan;
use App\Models\CertificateGapoktan;
use App\Models\UserGapoktan;
use Illuminate\Support\Facades\Validator;

class VerificateGapoktanController extends Controller
{
    // set index page view
	public function index() {
		return view('support.verifikasi_gapoktan.index');
	}

    // handle fetch all eamployees ajax request
	public function fetchAll() {
		$emps = Gapoktan::latest()->get();
		$output = '';
		if ($emps->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Gapoktan</th>
                <th>Bukti</th>
                <th>Status Gapoktan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>';
            $nomor=1;
			foreach ($emps as $emp) {
				$output .= '<tr>';
                $output .= '<td>' . $nomor++ . '</td>';
                $output .= '<td>' . $emp->user->name . '</td>';
                if ($emp->certificateGapoktan->count() > 0) {
                    foreach ($emp->certificateGapoktan->take(1) as $photos) {
                        if (empty($photos->evidence)) {
                            $output .= '<td><img src="../stisla/assets/img/example-image.jpg" class="img-fluid img-thumbnail" style="width: 100px; height: 65px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"></td>';
                        } else {
                            $output .= '<td><img src="../storage/sertifikat/' . $photos->evidence . '" class="img-fluid img-thumbnail" style="width: 100px; height: 65px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"></td>';
                        }
                    }
                } else {
                    $output .= '<td><img src="../stisla/assets/img/example-image.jpg" class="img-fluid img-thumbnail" style="width: 100px; height: 65px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"></td>';
                }
                $output .= '<td>';
                if ($emp->is_verified == 1) {
                    $output .= '<p class="badge badge-success">Terverifikasi</p>';
                } elseif ($emp->is_verified == 0){
                    $output .= '<p class="badge badge-danger">Belum diverifikasi</p>';
                }
                $output .= '</td>
                <td>
                  <a href="/support/verifikasi-gapoktan/detail/' . $emp->id . '" class="text-success mx-1"><i class="bi-pencil-square h4"></i></a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h5 class="text-center text-secondary my-5">Tidak ada data Gapoktan!</h5>';
		}
	}

    public function edit($id)
    {
        $gapoktans = Gapoktan::find($id);
        return view('support.verifikasi_gapoktan.detail', compact('gapoktans'));
    }

    // // handle edit an employee ajax request
	// public function edit(Request $request)
    // {
	// 	$id = $request->id;
	// 	$emp = Gapoktan::with('certificateGapoktan')->find($id);
	// 	// $emp = CertificateGapoktan::with('gapoktan')->where('gapoktan_id', $id)->get();
	// 	return response()->json($emp);
	// }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //
        ], [
            //
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $gapoktans = Gapoktan::find($request->gapoktan_id);
            $gapoktans->is_verified = 1;
            $gapoktans->update();

            $userGapoktans = new UserGapoktan();
            $userGapoktans->user_id = $request->user_id;
            $userGapoktans->gapoktan_id = $request->gapoktan_id;
            $userGapoktans->is_active = 1;
            $userGapoktans->save();
            return response()->json([
                'status' => 200,
            ]);
        }
	}
}
