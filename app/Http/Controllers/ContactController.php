<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Mail\ContactEmail;
use App\Mail\ContactReplyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $data = Contact::orderBy('contact_id', 'asc')->paginate(6);
        $data = Contact::all();
        return view('contact.index', compact('data'));
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required',
        ]);

        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            // 'status' => 0,
        ]);

        return redirect()->back()->with('success', 'Thông tin của bạn đã được gửi!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }
    public function showReplyForm($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contact.reply', compact('contact'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }

    public function reply(Request $request)
    {
        // Kiểm tra thông tin phản hồi
        $request->validate([
            'contact_id' => 'required|exists:contacts,contact_id', // Đúng cột khóa chính
            'response' => 'required|string',
        ]);

        // Lấy thông tin liên hệ từ contact_id
        $contact = Contact::where('contact_id', $request->contact_id)->first();
        if (!$contact) {
            return redirect()->back()->with('error', 'Không tìm thấy liên hệ!');
        }

        $contact->response = $request->response;
        $contact->response_date = now();
        $contact->save();

        // Gửi email phản hồi
        Mail::to($contact->email)->send(new ContactReplyMail($request->response));

        // Trả về phản hồi
        return redirect()->back()->with('success', 'Phản hồi đã được gửi thành công!');
    }

    public function sendReply(Request $request)
    {
        $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'response' => 'required|string',
        ]);

        $contact = Contact::findOrFail($request->contact_id);
        $contact->update([
            'response' => $request->response,
            'response_date' => now(),
        ]);
        Mail::to($contact->email)->send(new ContactReplyMail($request->response));

        // Chuyển hướng với thông báo thành công
        return redirect()->route('contact.index')->with('success', 'Phản hồi đã được gửi thành công!');
    }
}
