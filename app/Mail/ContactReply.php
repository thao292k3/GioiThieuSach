<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;         // Thuộc tính để chứa thông tin khách hàng
    public $reply_message;   // Thuộc tính để chứa nội dung phản hồi

    /**
     * Tạo một đối tượng ContactEmail mới.
     *
     * @param mixed $contact
     * @param string $reply_message
     */
    public function __construct($contact, $reply_message)
    {
        $this->contact = $contact;             // Gán thông tin khách hàng
        $this->reply_message = $reply_message; // Gán nội dung phản hồi
    }

    /**
     * Định nghĩa tiêu đề email.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Phản hồi từ quản trị viên', // Tiêu đề email
        );
    }

    /**
     * Định nghĩa nội dung email.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact_reply', // Đường dẫn view email
            with: [
                'contact' => $this->contact,           // Truyền thông tin khách hàng vào view
                'reply_message' => $this->reply_message, // Truyền nội dung phản hồi vào view
            ],
        );
    }

    /**
     * Định nghĩa tệp đính kèm (nếu có).
     */
    public function attachments(): array
    {
        return [];
    }
}
