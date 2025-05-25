<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function sendContact(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|max:1000',
        ]);

        $data = [
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ];

        Mail::send('emails.contact.contact', ['contact' => $data], function ($message) use ($data) {
            $message->to('chicwear68@gmail.com', 'Admin')
                ->subject('Yêu cầu hỗ trợ từ khách hàng')
                ->replyTo($data['email']);
        });

        return redirect()->back()->with('success', 'Cảm ơn bạn đã liên hệ. Chúng tôi sẽ phản hồi sớm nhất!');
    }

    public function viewContact()
    {
        return view('client.contact.contact');
    }
}
