<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $auth = auth('web')->user();
        return view('site.checkout', compact('auth'));
    }

    public function post_checkout(Request $req)
    {
        $auth = auth('web')->user();

        $req->validate([
            'email' => 'required|email',
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $data = $req->only('email', 'name', 'phone', 'address');
        $data['user_id'] = $auth->user_id;

        if ($order = Order::create($data)) {
            $token = Str::random(40);

            foreach ($auth->carts as $cart) {
                $data1 = [
                    'order_id' => $order->id,
                    'book_id' => $cart->book_id,
                    'price' => $cart->price,
                    'quantity' => $cart->quantity,
                ];

                OrderDetails::create($data1);
            }

            $order->token = $token;
            $order->save();

            Mail::to($auth->email)->send(new OrderMail($order, $token));
        }
    }

    public function verify($token) {}
}
