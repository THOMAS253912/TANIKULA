<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Costumer;

class PengaturanController extends Controller
{
    public function pengaturan() {
        $data = ['userInfo' => Costumer::with('user')
            ->where('user_id', '=', auth()->user()->id)
            ->first()
        ];

        $data2 = ['checkUser' => Costumer::with('user')
            ->join('users', 'costumers.user_id', '=', 'users.id')
            ->where('costumers.user_id', '=', auth()->user()->id)
            ->whereNotNull('users.name')
            ->whereNotNull('users.email')
            ->whereNotNull('costumers.birth')
            ->whereNotNull('costumers.gender')
            ->select('costumers.*', 'users.name as name')
            ->first()
        ];

        return view('costumer.profile.index', $data, $data2);
    }

    public function pengaturanImage(Request $request) {
        $id = $request->id;
        $user = Costumer::find($id);

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('profile', $fileName);

            if($user->image) {
                Storage::delete('profile/' . $user->image );
            }
        }

        Costumer::where('id', $id)->update([
            'image' => $fileName
        ]);

        return response()->json([
            'status' => 200,
            'messages' => 'Foto profil berhasil diperbarui!'
        ]);
    }

    public function pengaturanUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'required|email|max:100',
            'telp' => 'required',
            'gender' => 'required',
        ], [
            'name.required' => 'Nama gapoktan diperlukan!',
            'name.max' => 'Nama gapoktan maksimal 50 karakter!',
            'email.required' => 'Email diperlukan!',
            'email.max' => 'Email maksimal 100 karakter!',
            'telp.required' => 'Nomor telephone diperlukan!',
            'gender.required' => 'Jenis kelamin diperlukan!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            User::where('id', auth()->user()->id)->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            if ($request->birth) {
                Costumer::with('user')->where('id', $request->id)->update([
                    'telp' => $request->telp,
                    'birth' => Carbon::createFromFormat('d-M-Y', $request->birth)->format('Y-m-d h:i:s'),
                    'gender' => $request->gender,
                ]);
            } else {
                Costumer::with('user')->where('id', $request->id)->update([
                    'telp' => $request->telp,
                    'gender' => $request->gender,
                ]);
            }

            return response()->json([
                'status' => 200,
                'messages' => 'Biodata diri berhasil diupdate!'
            ]);
        }
    }

    public function pengaturanUpdatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|max:50',
        ], [
            'password.required' => 'Kata sandi diperlukan!',
            'password.min' => 'Kata sandi harus minimal 6 karakter!',
            'password.max' => 'Kata sandi maksimal 50 karakter!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            User::where('id', auth()->user()->id)->update([
                'password' => Hash::make($request->password)
            ]);
            return response()->json([
                'status' => 200,
                'messages' => 'Password berhasil diperbarui!'
            ]);
        }
    }

    // handle delete an employee ajax request
	public function delete(Request $request)
    {
		$id = $request->id;
		$emp = Costumer::find($id);
        Storage::delete('profile/' . $emp->image);
		$emp->image = null;
        $emp->update();
	}
}
