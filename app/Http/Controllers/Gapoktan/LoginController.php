<?php

namespace App\Http\Controllers\Gapoktan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Gapoktan;
use App\Models\UserGapoktan;
use App\Models\CertificateGapoktan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login() {
        return view('gapoktan.login.index');
    }

    public function loginGapoktan(Request $request) {
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
            $user = User::where('email', $request->email)->first();
            if($user){
                if(Hash::check($request->password, $user->password)) {
                    if (auth()->attempt($credentials)) {
                        if (auth()->check() && $user->hasRole('gapoktan')) {
                            return response()->json([
                                'status' => 200,
                                'messages' => 'Berhasil Masuk',
                            ]);
                        } else {
                            \Auth::logout();
                            return response()->json([
                                'status' => 401,
                                'messages' => 'Hak akses hanya untuk Gapoktan!'
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

    public function registerGapoktan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users|max:50',
            'email' => 'required|email|unique:users|max:100',
            'password' => 'required|min:6|max:50',
            'cpassword' => 'required|min:6|same:password',
            'images' => 'required',
        ], [
            'cpassword.same' => 'Kata sandi tidak cocok!',
            'name.required' => 'Nama diperlukan!',
            'name.max' => 'Nama maksimal 50 karakter!',
            'name.unique' => 'Nama Gapoktan yang anda masukkan sudah ada!',
            'email.required' => 'Email diperlukan!',
            'email.unique' => 'Email yang anda masukkan sudah ada!',
            'password.required' => 'Kata sandi diperlukan!',
            'password.min' => 'Kata sandi harus minimal 6 karakter!',
            'password.max' => 'Kata sandi maksimal 50 karakter!',
            'cpassword.required' => 'Konfirmasi kata sandi diperlukan!',
            'cpassword.min' => 'Kata sandi harus minimal 6 karakter!',
            'cpassword.max' => 'Kata sandi maksimal 50 karakter!',
            'images.required' => 'Unggahan bukti gapoktan diperlukan!',
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

            // $chairman = $request->chairman;
            $gapoktan = new Gapoktan();
            $gapoktan->user_id = $user->id;
            $gapoktan->save();

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
                'messages' => 'Akun Anda Berhasil Terdaftar'
            ]);
        }
    }

    public function register() {
        return view('gapoktan.register.index');
    }

    public function logout(Request $request) {
        Auth::logout();

        return redirect()->route('home');
    }
}
