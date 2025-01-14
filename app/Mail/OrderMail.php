<?php

namespace App\Mail;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;



class OrderMail extends Mailable
{
    use Queueable, SerializesModels;
    public $order;
    public $token;


    /**
     * Create a new message instance.
     */
    public function __construct($order, $token)
    {
        $this->order = $order;
        $this->order = $token;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Order shopping',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.order_verify',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function placeOrder(Request $request)
    {
        $user_id = auth()->id();
        $cartItems = Cart::where('user_id', $user_id)->with('prod')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        // Tạo đơn hàng mới
        $order = Order::create([
            'user_id' => $user_id,
            'email' => $request->email,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => 'pending', // Hoặc trạng thái khác tùy theo hệ thống
            'token' => Str::random(32), // Tạo mã token cho đơn hàng
            'total_amount' => $cartItems->sum('price'),
        ]);

        // Thêm các sản phẩm vào bảng order_details
        foreach ($cartItems as $item) {
            OrderDetails::create([
                'order_id' => $order->id,
                'book_id' => $item->book_id,
                'price' => $item->price,
                'quantity' => $item->quantity,
            ]);
        }

        // Xóa sản phẩm trong giỏ hàng sau khi đặt hàng thành công
        Cart::where('user_id', $user_id)->delete();

        // Gửi email xác nhận đơn hàng
        Mail::to($order->email)->send(new OrderMail($order));

        return redirect()->route('order.thankyou')->with('ok', 'Đơn hàng của bạn đã được đặt thành công!');
    }
}
