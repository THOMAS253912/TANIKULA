<?php

namespace App\Http\Controllers\Poktan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Gapoktan;
use App\Models\Poktan;
use App\Models\NotificationUser;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login() {
        return view('poktan.login.index');
    }

    public function loginPoktan(Request $request) {
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
            // $user = Poktan::where('email', $request->email)->first();
            $poktan = Poktan::join('users', 'poktans.user_id', '=', 'users.id')
                    ->select('poktans.*', 'users.password as password')
                    ->where('users.email', $request->email)
                    ->first();
            if($poktan){
                if(Hash::check($request->password, $poktan->password)) {
                    if (auth()->attempt($credentials)) {
                        if (auth()->check() && $poktan->user->hasRole('poktan')) {
                            if (!$poktan->is_active) {
                                auth()->logout();
                                return response()->json([
                                    'status' => 401,
                                    'messages' => 'Akun anda belum diverifikasi oleh Gapoktan!'
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
                                'messages' => 'Hak akses hanya untuk Poktan!'
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

    public function registerPoktan(Request $request) {
        $validator = Validator::make($request->all(), [
            'gapoktan_id' => 'required',
            'name' => 'required|unique:users|max:50',
            'chairman' => 'required|max:255',
            'email' => 'required|email|unique:users|max:100',
            'password' => 'required|min:6|max:50',
            'cpassword' => 'required|min:6|same:password'
        ], [
            'gapoktan_id.required' => 'Nama ketua gapoktan diperlukan!',
            'cpassword.same' => 'Kata sandi tidak cocok!',
            'name.required' => 'Nama diperlukan!',
            'name.max' => 'Nama maksimal 50 karakter!',
            'name.unique' => 'Nama Poktan yang anda masukkan sudah ada!',
            'chairman.required' => 'Nama Ketua diperlukan!',
            'chairman.max' => 'Nama Ketua maksimal 255 karakter!',
            'email.required' => 'Email diperlukan!',
            'email.unique' => 'Email yang anda masukkan sudah ada!',
            'password.required' => 'Kata sandi diperlukan!',
            'password.min' => 'Kata sandi harus minimal 6 karakter!',
            'password.max' => 'Kata sandi maksimal 50 karakter!',
            'cpassword.required' => 'Konfirmasi kata sandi diperlukan!',
            'cpassword.min' => 'Kata sandi harus minimal 6 karakter!',
            'cpassword.max' => 'Kata sandi maksimal 50 karakter!',
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
            $user->assignRole('poktan');
            $user->save();

            $gapoktan_id = $request->gapoktan_id;
            $chairman = $request->chairman;
            Poktan::create([
              'user_id' => $user->id,
              'gapoktan_id' => $gapoktan_id,
              'chairman' => $chairman,
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
        $gapoktan = Gapoktan::all();
        return view('poktan.register.index', compact('gapoktan'));
    }

    public function logout(Request $request) {
        Auth::logout();

        return redirect()->route('home');
    }
}
