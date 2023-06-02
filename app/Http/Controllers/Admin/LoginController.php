<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Admin;
use App\Models\Support;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login() {
        return view('admin.login.index');
    }

    public function loginAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
            'password' => 'required|min:6|max:50',
        ], [
            'email.required' => 'Email diperlukan!',
            'email.max' => 'Email maksimal 100 karakter!',
            'password.min' => 'Kata sandi harus minimal 6 karakter!',
            'password.max' => 'Kata sandi maksimal 50 karakter!',
            'password.required' => 'Kata sandi diperlukan!',
        ]);

        $credentials = $request->except(['_token']);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $admins = Admin::join('users', 'admins.user_id', '=', 'users.id')
                        ->select('admins.*', 'users.name as name')
                        ->where('users.email', $request->email)
                        ->first();
            $supports = Support::join('users', 'supports.user_id', '=', 'users.id')
                        ->select('supports.*', 'users.name as name')
                        ->where('users.email', $request->email)
                        ->first();
            if ($admins) {
                if(Hash::check($request->password, $admins->user->password)) {
                    if (auth()->attempt($credentials)) {
                        if (auth()->check() && $admins->user->hasRole('admin')) {
                            return response()->json([
                                'status' => 200,
                                'messages' => 'Berhasil Masuk',
                            ]);
                        } else {
                            \Auth::logout();
                            return response()->json([
                                'status' => 401,
                                'messages' => 'Hak akses hanya untuk Admin!'
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
            } elseif ($supports) {
                if(Hash::check($request->password, $supports->user->password)) {
                    if (auth()->attempt($credentials)) {
                        if (auth()->check() && $supports->user->hasRole('support')) {
                            return response()->json([
                                'status' => 201,
                                'messages' => 'Berhasil Masuk',
                            ]);
                        } else {
                            \Auth::logout();
                            return response()->json([
                                'status' => 401,
                                'messages' => 'Hak akses hanya untuk Admin!'
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

    public function forgotPassword() {
        return view('admin.login.password.forgot');
    }

    public function forgotPasswordEmail(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $token = Str::uuid();
            $user = DB::table('users')->where('email', $request->email)->first();
            $details = [
                'body' => route('resetPass-admin', ['email' => $request->email, 'token' => $token])
            ];

            if ($user) {
                User::where('email', $request->email)->update([
                    'token' => $token,
                    'token_expire' => Carbon::now()->addMinutes(10)->toDateTimeString()
                ]);

                Mail::to($request->email)->send(new ForgotPassword($details));
                return response()->json([
                    'status' => 200,
                    'messages' => 'Tautan Atur Ulang Kata Sandi telah dikirim ke email Anda!'
                ]);
            } else {
                return response()->json([
                    'status' => 401,
                    'messages' => 'Email ini tidak terdaftar pada kami!'
                ]);
            }
        }
    }

    public function reset(Request $request) {
        $email = $request->email;
        $token = $request->token;
        return view('admin.login.password.reset', [
            'email' => $email,
            'token' => $token
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'npass' => 'required|min:6|max:50',
            'cnpass' => 'required|min:6|max:50|same:npass',
        ], [
            'cnpass.same' => 'Kata sandi tidak cocok!',
            'npass.required' => 'Kata sandi diperlukan!',
            'npass.min' => 'Kata sandi harus minimal 6 karakter!',
            'npass.max' => 'Kata sandi maksimal 50 karakter!',
            'cnpass.required' => 'Konfirmasi kata sandi diperlukan!',
            'cnpass.min' => 'Kata sandi harus minimal 6 karakter!',
            'cnpass.max' => 'Kata sandi maksimal 50 karakter!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $user = DB::table('users')->where('email', $request->email)
                ->whereNotNull('token')
                ->where('token', $request->token)
                ->where('token_expire', '>', Carbon::now())->exists();

            if ($user) {
                User::where('email', $request->email)->update([
                    'password' => Hash::make($request->npass),
                    'token' => null,
                    'token_expire' => null
                ]);

                return response()->json([
                    'status' => 200,
                    'success' => '<span>Klik disini untuk <a href="/administrator/login" class="text-decoration" style="font-weight: bold; color: black;">Masuk Sekarang!</a></span>',
                    'messages' => 'Kata Sandi Baru Diperbarui!'
                ]);
            } else {
                return response()->json([
                    'status' => 401,
                    'messages' => 'Tautan atur ulang kedaluwarsa, Minta tautan atur ulang kata sandi baru!'
                ]);
            }
        }
    }

    public function logout(Request $request) {
        Auth::logout();

        return redirect()->route('home');
    }
}
