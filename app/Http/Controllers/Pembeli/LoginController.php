<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\ForgotPassword;
use App\Mail\RegisterAccount;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Costumer;
use App\Models\UserGapoktan;
use App\Models\Farmer;
use App\Models\Poktan;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;
use Socialite;
use Exception;

class LoginController extends Controller
{
    public function login()
    {
        return view('costumer.login.index');
    }

    public function loginPembeli(Request $request)
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

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $costumers = Costumer::join('users', 'costumers.user_id', '=', 'users.id')
                ->select('costumers.*', 'users.name as name')
                ->where('users.email', $request->email)
                ->first();
            $userGapoktan = UserGapoktan::join('users', 'user_gapoktans.user_id', '=', 'users.id')
                ->join('gapoktans', 'user_gapoktans.gapoktan_id', '=', 'gapoktans.id')
                ->select('user_gapoktans.*', 'users.name as name')
                ->where('users.email', $request->email)
                ->first();
            $poktans = Poktan::join('users', 'poktans.user_id', '=', 'users.id')
                ->join('gapoktans', 'poktans.gapoktan_id', '=', 'gapoktans.id')
                ->select('poktans.*', 'users.name as name')
                ->where('users.email', $request->email)
                ->first();
            $farmers = Farmer::join('users', 'farmers.user_id', '=', 'users.id')
                ->select('farmers.*', 'users.name as name')
                ->where('users.email', $request->email)
                ->first();
            if ($costumers) {
                if (Hash::check($request->password, $costumers->user->password)) {
                    if (auth()->attempt($credentials)) {
                        if (auth()->check() && $costumers->user->hasRole('pembeli')) {
                            if (!$costumers->is_email_verified) {
                                auth()->logout();
                                return response()->json([
                                    'status' => 401,
                                    'messages' => 'Akun anda belum teraktivasi, silakan periksa email Anda!'
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
                                'messages' => 'Hak akses hanya untuk pembeli!'
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
                        'messages' => 'Gagal Masuk, Pastikan Email dan Password anda benar!'
                    ]);
                }
            } elseif ($userGapoktan) {
                if (Hash::check($request->password, $userGapoktan->user->password)) {
                    if (auth()->attempt($credentials)) {
                        if (auth()->check() && $userGapoktan->user->hasRole('gapoktan')) {
                            if (!$userGapoktan->is_active) {
                                auth()->logout();
                                return response()->json([
                                    'status' => 401,
                                    'messages' => 'Akun anda belum teraktivasi!'
                                ]);
                            } else {
                                return response()->json([
                                    'status' => 201,
                                    'messages' => 'Berhasil Masuk'
                                ]);
                            }
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
                        'messages' => 'Gagal Masuk, Pastikan Email dan Password anda benar!'
                    ]);
                }
            } elseif ($poktans) {
                if (Hash::check($request->password, $poktans->user->password)) {
                    if (auth()->attempt($credentials)) {
                        if (auth()->check() && $poktans->user->hasRole('poktan')) {
                            if (!$poktans->is_active) {
                                auth()->logout();
                                return response()->json([
                                    'status' => 401,
                                    'messages' => 'Akun anda belum teraktivasi!'
                                ]);
                            } else {
                                return response()->json([
                                    'status' => 202,
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
                        'messages' => 'Gagal Masuk, Pastikan Email dan Password anda benar!'
                    ]);
                }
            } elseif ($farmers) {
                if (Hash::check($request->password, $farmers->user->password)) {
                    if (auth()->attempt($credentials)) {
                        if (auth()->check() && $farmers->user->hasRole('petani')) {
                            if (!$farmers->is_active) {
                                auth()->logout();
                                return response()->json([
                                    'status' => 401,
                                    'messages' => 'Akun anda belum teraktivasi!'
                                ]);
                            } else {
                                return response()->json([
                                    'status' => 203,
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
                        'messages' => 'Gagal Masuk, Pastikan Email dan Password anda benar!'
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

    public function registerPembeli(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:100',
            'password' => 'required|min:6|max:50',
            'cpassword' => 'required|min:6|same:password'
        ], [
            'cpassword.same' => 'Kata sandi tidak cocok!',
            'name.required' => 'Nama diperlukan!',
            'name.max' => 'Nama maksimal 50 karakter!',
            'email.required' => 'Email diperlukan!',
            'email.unique' => 'Email yang anda masukkan sudah ada!',
            'email.max' => 'Email maksimal 100 karakter!',
            'password.required' => 'Kata sandi diperlukan!',
            'password.min' => 'Kata sandi harus minimal 6 karakter!',
            'password.max' => 'Kata sandi maksimal 50 karakter!',
            'cpassword.required' => 'Konfirmasi kata sandi diperlukan!',
            'cpassword.min' => 'Kata sandi harus minimal 6 karakter!',
            'cpassword.max' => 'Kata sandi maksimal 50 karakter!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->assignRole('pembeli');
            $user->save();

            $costumer = new Costumer();
            $costumer->user_id = $user->id;
            $costumer->save();

            $token = Str::random(64);
            UserVerify::create([
                'costumer_id' => $costumer->id,
                'token' => $token
            ]);

            Mail::to($request->email)->send(new RegisterAccount($token));
            // Mail::send('costumer.register.emailVerificationEmail', ['token' => $token], function ($message) use ($request) {
            //     $message->to($request->email);
            //     $message->subject('Verifikasi Email');
            // });

            return response()->json([
                'status' => 200,
                'messages' => 'Akun Anda Berhasil Terdaftar, Silahkan verifikasi email anda!'
            ]);
        }
    }

    public function register()
    {
        return view('costumer.register.index');
    }

    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();

        // notify()->warning("Maaf email Anda tidak dapat diidentifikasi.", "Warning", "topRight");
        // $messageDanger = 'Maaf email Anda tidak dapat diidentifikasi.';

        if (!is_null($verifyUser)) {
            $costumer = $verifyUser->costumer;

            if (!$costumer->is_email_verified) {
                $verifyUser->costumer->is_email_verified = 1;
                $verifyUser->costumer->save();
                notify()->success("Email Anda telah diverifikasi. Anda sekarang dapat masuk website dan aplikasi TaniKula.", "Success", "topRight");
                // $message = "Email Anda telah diverifikasi. Anda sekarang dapat masuk.";
            } else {
                notify()->success("Email Anda sudah diverifikasi. Anda sekarang dapat masuk website dan aplikasi TaniKula.", "Success", "topRight");
                // $message = "Email Anda sudah diverifikasi. Anda sekarang dapat masuk website dan aplikasi TaniKula.";
            }
        }

        return redirect()->route('login');
    }

    public function forgotPassword()
    {
        return view('costumer.login.password.forgot');
    }

    public function forgotPasswordEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $token = Str::uuid();
            $user = DB::table('users')->where('email', $request->email)->first();
            $details = [
                'body' => route('resetPassword-pembeli', ['email' => $request->email, 'token' => $token])
            ];

            if ($user) {
                User::where('email', $request->email)->update([
                    'token' => $token,
                    'token_expire' => Carbon::now()->addMinutes(10)->toDateTimeString()
                ]);

                Mail::to($request->email)->send(new ForgotPassword($details));
                return response()->json([
                    'status' => 200,
                    'messages' => 'Tautan atur ulang kata sandi telah dikirim ke email anda!'
                ]);
            } else {
                return response()->json([
                    'status' => 401,
                    'messages' => 'Email ini tidak terdaftar pada kami!'
                ]);
            }
        }
    }

    public function reset(Request $request)
    {
        $email = $request->email;
        $token = $request->token;
        return view('costumer.login.password.reset', [
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

        if ($validator->fails()) {
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
                    'success' => '<span>Klik disini untuk <a href="/login" class="text-decoration" style="font-weight: bold; color: black;">Masuk Sekarang!</a></span>',
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

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('home');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user_google    = Socialite::driver('google')->user();
            $user           = User::where('email', $user_google->getEmail())->first();
            //jika user ada maka langsung di redirect ke halaman home
            //jika user tidak ada maka simpan ke database
            //$user_google menyimpan data google account seperti email, foto, dsb
            if($user != null){
                \auth()->login($user, true);
                if ($user->hasRole('pembeli')) {
                    // notify()->success("Berhasil melakukan login!", "Berhasil", "topRight");
                    return redirect()->route('pembeli');
                } elseif ($user->hasRole('gapoktan')) {
                    // notify()->success("Berhasil melakukan login!", "Berhasil", "topRight");
                    return redirect()->route('gapoktan');
                } elseif ($user->hasRole('poktan')) {
                    // notify()->success("Berhasil melakukan login!", "Berhasil", "topRight");
                    return redirect()->route('poktan');
                } elseif ($user->hasRole('petani')) {
                    // notify()->success("Berhasil melakukan login!", "Berhasil", "topRight");
                    return redirect()->route('petani');
                }
            }else{
                $create = User::Create([
                    'email'             => $user_google->getEmail(),
                    'name'              => $user_google->getName(),
                    'password'          => 0,
                    'email_verified_at' => now(),
                ]);

                $create = User::where('id', $create->id)->first();
                $create->google_id = $create->id;
                $create->update();

                $create->assignRole('pembeli');

                $costumer = new Costumer();
                $costumer->user_id = $create->id;
                $costumer->save();
                \auth()->login($create, true);
                return redirect()->route('pembeli');
            }
        } catch (\Exception $e) {
            return redirect()->route('redirectToGoogle');
        }
    }
}
