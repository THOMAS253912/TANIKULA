<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Poktan;
use App\Models\Farmer;
use App\Models\NotificationUser;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login() {
        return view('petani.login.index');
    }

    public function loginPetani(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
            'password' => 'required|min:6|max:50',
        ], [
            'email.required' => 'Email diperlukan!',
            'password.required' => 'Kata sandi diperlukan!',
        ]);

        $credentials = $request->except(['_token']);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            // $user = User::where('email', $request->email)->first();
            $farmer = Farmer::join('users', 'farmers.user_id', '=', 'users.id')
                    ->select('farmers.*', 'users.password as password')
                    ->where('users.email', $request->email)
                    ->first();
            if($farmer){
                if(Hash::check($request->password, $farmer->password)) {
                    if (auth()->attempt($credentials)) {
                        if (auth()->check() && $farmer->user->hasRole('petani')) {
                            if (!$farmer->is_active) {
                                auth()->logout();
                                return response()->json([
                                    'status' => 401,
                                    'messages' => 'Akun anda belum diverifikasi oleh Poktan!'
                                ]);
                            } else {
                                return response()->json([
                                    'status' => 200,
                                    'messages' => 'Berhasil Masuk'
                                ]);
                            }
                        } else {
                            \Auth::logout();
                            return response()->json([
                                'status' => 401,
                                'messages' => 'Hak akses hanya untuk Petani!'
                            ]);
                        }
                    } else {
                        return response()->json([
                            'status' => 401,
                            'messages' => 'Kredensial tidak valid!'
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => 401,
                        'messages' => 'Email atau Kata Sandi salah!',
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 401,
                    'messages' => 'Akun tidak ditemukan!'
                ]);
            }
        }
    }

    public function registerPetani(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:100',
            'password' => 'required|min:6|max:50',
            'cpassword' => 'required|min:6|same:password'
        ], [
            'cpassword.same' => 'Kata sandi tidak cocok!',
            'name.required' => 'Nama diperlukan!',
            'email.required' => 'Email diperlukan!',
            'email.unique' => 'Email yang anda masukkan sudah ada!',
            'password.required' => 'Kata sandi diperlukan!',
            'cpassword.required' => 'Konfirmasi kata sandi diperlukan!',
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
            Farmer::create([
              'user_id' => $user->id,
              'poktan_id' => $poktan_id,
            ]);

            $notification = new NotificationUser();
            $notification->user_id = $user->id;
            $notification->save();

            return response()->json([
                'status' => 200,
                'messages' => 'Akun Anda Berhasil Terdaftar'
            ]);
        }
    }

    public function register() {
        $poktan = Poktan::all();
        return view('petani.register.index', compact('poktan'));
    }

    public function logout(Request $request) {
        Auth::logout();

        return redirect()->route('home');
    }
}
