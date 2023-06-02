<?php

namespace App\Http\Controllers\Poktan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Poktan;

class PengaturanController extends Controller
{
    public function pengaturan() {
        $data = ['userInfo' => Poktan::with('user')
            ->where('user_id', auth()->user()->id)
            ->first()
        ];
        return view('poktan.pengaturan.index', $data);
    }

    public function pengaturanImage(Request $request) {
        $user_id = $request->user_id;
        $user = Poktan::find($user_id);

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('profile', $fileName);

            if($user->image) {
                Storage::delete('profile/' . $user->image );
            }
        }

        Poktan::where('id', $user_id)->update([
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
            'chairman' => 'required',
            'phone' => 'required',
            'street' => 'required',
            'number' => 'required',
        ], [
            'name.required' => 'Nama poktan diperlukan!',
            'name.max' => 'Nama poktan maksimal 50 karakter!',
            'email.required' => 'Email diperlukan!',
            'email.max' => 'Email maksimal 100 karakter!',
            'chairman.required' => 'Nama ketua poktan diperlukan!',
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
                Poktan::where('id', $request->id)->update([
                    'province_id' => $request->province_id,
                    'city_id' => $request->city_id,
                    'district_id' => $request->district_id,
                    'village_id' => $request->village_id,
                    'chairman' => $request->chairman,
                    'street' => $request->street,
                    'number' => $request->number,
                    'phone' => $request->phone,
                ]);
            } else {
                Poktan::where('id', $request->id)->update([
                    'chairman' => $request->chairman,
                    'street' => $request->street,
                    'number' => $request->number,
                    'phone' => $request->phone,
                ]);
            }

            return response()->json([
                'status' => 200,
                'messages' => 'Biodata Poktan berhasil diupdate!'
            ]);
        }
    }

    public function pengaturanUpdatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|max:50',
            'cpassword' => 'required|min:6|same:password',
        ], [
            'password.required' => 'Kata sandi diperlukan!',
            'password.min' => 'Kata sandi harus minimal 6 karakter!',
            'password.max' => 'Kata sandi maksimal 50 karakter!',
            'cpassword.same' => 'Konfirmasi kata sandi tidak cocok!',
            'cpassword.required' => 'Konfirmasi kata sandi diperlukan!',
            'cpassword.min' => 'Kata sandi harus minimal 6 karakter!',
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
