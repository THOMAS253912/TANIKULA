<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Api\BaseApiController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Costumer;
use App\Models\UserVerify;
use Illuminate\Support\Str;

class RegisterCustomerApiController extends BaseController
{
    public function register(Request $request)
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

            Mail::send('costumer.register.emailVerificationEmail', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Verifikasi Email');
            });

            return response()->json([
                'status' => 200,
                'messages' => 'Akun Anda Berhasil Terdaftar, Silahkan verifikasi email anda!'
            ]);
        }

        // $input = $request->all();
        // $input['password'] = bcrypt($input['password']);
        // $user = User::create($input);
        // $user->assignRole('pembeli');
        // $success['token'] =  $user->createToken('MyApp')->accessToken;
        // $success['name'] =  $user->name;
        // $datas = Costumer::create([
        //     'user_id' => $user->id,
        // ]);

        // return $this->sendResponse($success, 'User register successfully.');
    }
}
