<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseApiController as BaseController;
use App\Models\Costumer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



class LoginCustomerApiController  extends BaseController
{
    public function login(Request $request)
    {
        // if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
        //     $user = Auth::user(); 
        //     $customer_id =   Costumer::where('user_id', $user->id)->first();
        //     $success['token'] =  $user->createToken('MyApp')->accessToken; 
        //     $success['id'] =  $user->id;
        //     $success['email'] =  $user->email;
        //     $success['name'] =  $user->name;
        //     $success['customer_id'] =  $customer_id->id;
        //     $success['hasRole'] =  $user->hasRole('pembeli');

        //     if ($success['hasRole'] == 'pembeli') {
        //         return $this->sendResponse($success, 'User login successfully.');
        //     } else {
        //         return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        //     }
        // } 
        // else{ 
        //     return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        // } 

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
            $user = User::where('email', $request->email)->first();
            $customer = Costumer::where('user_id', $user->id)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    if (auth()->attempt($credentials)) {
                        if (auth()->check() && $user->hasRole('pembeli')) {
                            if (!$customer->is_email_verified) {
                                auth()->logout();
                                return response()->json([
                                    'status' => 401,
                                    'messages' => 'Akun anda belum teraktivasi, silakan periksa email Anda!'
                                ]);
                            } else {
                                return response()->json([
                                    'status' => 200,
                                    'messages' => 'Berhasil Masuk',
                                    'data' => [
                                        'users' => $user,
                                        'customers' => $customer,
                                        'token' => $user->createToken('MyApp')->accessToken,
                                    ],
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
            } else {
                return response()->json([
                    'status' => 401,
                    'messages' => 'Akun tidak ditemukan!'
                ]);
            }
        }
    }
}
