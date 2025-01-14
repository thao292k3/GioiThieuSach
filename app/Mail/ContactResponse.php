<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $response;

    /**
     * Tạo một đối tượng Mailable mới.
     *
     * @param string $responseContent Nội dung phản hồi
     */
    public function __construct($responseContent)
    {
        $this->response = $responseContent; // Gán giá trị cho biến $response
    }

    /**
     * Xây dựng email.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Phản hồi từ quản trị viên')
            ->view('email.contact_response')
            ->with('response', $this->response); // Truyền biến $response đến view
    }
}
