<?php

namespace App\Http\Controllers\Api\Petani;

use App\Http\Controllers\Api\BaseApiController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Farmer;
use App\Models\User;

class LoginPetaniApiController extends BaseController
{
    // public function login(Request $request)
    // {
    //     if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
    //         $user = Auth::user(); 
    //         $success['token'] =  $user->createToken('MyApp')->accessToken; 
    //         $success['id'] =  $user->id;
    //         $success['hasRole'] =  $user->hasRole('petani');

    //         if ($success['hasRole'] == 'petani') {
    //             return $this->sendResponse($success, 'User login successfully.');
    //         } else {
    //             return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
    //         }
    //     } else {
    //         return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
    //     }
    // }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
            'password' => 'required|min:6|max:50',
        ], [
            'email.required' => 'Email diperlukan!',
            'password.required' => 'Kata sandi diperlukan!',
        ]);

        $credentials = $request->except(['_token']);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $user = User::where('email', $request->email)->first();
            $farmer = Farmer::join('users', 'farmers.user_id', '=', 'users.id')
                ->select('farmers.*', 'users.password as password')
                ->where('users.email', $request->email)
                ->first();
            if ($farmer) {
                if (Hash::check($request->password, $farmer->password)) {
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
                                    'messages' => 'Berhasil Masuk',
                                    'data' => [
                                        // 'users' => $user,
                                        'farmers' => $farmer,
                                        'token' => $user->createToken('MyApp')->accessToken,
                                    ],
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
}
