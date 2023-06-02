<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Support;
use Carbon\Carbon;

class PengaturanController extends Controller
{
    public function pengaturan() {
        $data = ['userInfo' => Support::with('user')
            ->where('user_id', auth()->user()->id)
            ->first()
        ];
        return view('support.pengaturan.index', $data);
    }

    public function pengaturanImage(Request $request) {
        $user_id = $request->user_id;
        $user = Support::find($user_id);

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('profile', $fileName);

            if($user->image) {
                Storage::delete('profile/' . $user->image );
            }
        }

        Support::where('id', $user_id)->update([
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
            'phone' => 'required',
            'street' => 'required',
            'number' => 'required',
        ], [
            'name.required' => 'Nama gapoktan diperlukan!',
            'name.max' => 'Nama gapoktan maksimal 50 karakter!',
            'email.required' => 'Email diperlukan!',
            'email.max' => 'Email maksimal 100 karakter!',
            'phone.required' => 'Nomor telephone diperlukan!',
            'street.required' => 'Jalan diperlukan!',
            'number.required' => 'Nomor jalan/gang diperlukan!',
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

            if ($request->province_id && $request->city_id && $request->district_id && $request->village_id) {
                Support::where('id', $request->id)->update([
                    'province_id' => $request->province_id,
                    'city_id' => $request->city_id,
                    'district_id' => $request->district_id,
                    'village_id' => $request->village_id,
                    'street' => $request->street,
                    'number' => $request->number,
                    'phone' => $request->phone,
                ]);
            } else {
                Support::where('id', $request->id)->update([
                    'street' => $request->street,
                    'number' => $request->number,
                    'phone' => $request->phone,
                ]);
            }

            return response()->json([
                'status' => 200,
                'messages' => 'Biodata Support berhasil diupdate!'
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
}
