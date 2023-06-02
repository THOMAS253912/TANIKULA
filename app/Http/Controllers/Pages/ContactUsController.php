<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactUsController extends Controller
{
    public function index()
    {
        return view('pages.contact.index');
    }

    public function addContactUs (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|max:50',
            'email' => 'required|email|max:100',
            'subject' => 'required',
            'message' => 'required',
            'phone_number' => 'required',
            'screenshot' => 'required',
        ], [
            'fullname.required' => 'Nama diperlukan!',
            'fullname.max' => 'Nama maksimal 50 karakter!',
            'email.required' => 'Email diperlukan!',
            'email.max' => 'Email maksimal 100 karakter!',
            'subject.required' => 'Subjek diperlukan!',
            'message.required' => 'Pesan diperlukan!',
            'phone_number.required' => 'Nomor telp diperlukan!',
            'screenshot.required' => 'Foto diperlukan!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        }
            else
        {
            $contact = [
                'fullname' => $request['fullname'],
                'email' => $request['email'],
                'phone_number' => $request['phone_number'],
                'subject' => $request['subject'],
                'message' => $request['message'],
                'screenshot' => $request->file('screenshot')->store('contact', 'public')
            ];

            Mail::to('tanikula.app@gmail.com')->send(new ContactFormMail($contact));

            return response()->json([
                'status' => 200,
                'messages' => 'Berhasil terkirim!'
            ]);
        }
    }
}
