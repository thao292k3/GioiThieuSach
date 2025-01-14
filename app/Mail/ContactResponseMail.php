<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $response; // Thuộc tính public để truyền tới view

    public function __construct($responseContent)
    {
        $this->response = $responseContent; // Gán đúng biến
    }

    public function build()
    {
        return $this->subject('Phản hồi từ quản trị viên')
            ->view('email.contact_response')
            ->with('response', $this->response); // Truyền biến $response đến view
    }
}
