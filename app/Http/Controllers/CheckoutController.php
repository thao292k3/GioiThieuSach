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
//     $auth = auth('web')->user();

//     if (!$auth) {
//         return redirect()->back()->withErrors(['auth' => 'Bạn cần đăng nhập để thanh toán.']);
//     }

//     $req->validate([
//         'user_id' => 'required',
//         'email' => 'required|email',
//         'name' => 'required',
//         'phone' => 'required',
//         'address' => 'required',
//     ]);
//     $data = $req->only('email', 'name', 'phone', 'address');
//     $data['user_id'] = $auth->id;
    

//     if ($order = Order::create($data)) {
//         $token = Str::random(40);

//         foreach ($auth->carts as $cart) {
//             $data1 = [
//                 'order_id' => $order->id,
//                 'book_id' => $cart->book_id,
//                 'price' => $cart->price,
//                 'quantity' => $cart->quantity,
//             ];

//             OrderDetails::create($data1);
//         }

//         $order->token = $token;
//         $order->save();

// try {
//     Mail::to($auth->email)->send(new OrderMail($order, $token));
// } catch (\Exception $e) {
//     return redirect()->back()->withErrors(['email' => 'Không thể gửi email: ' . $e->getMessage()]);
// }
//         // Xóa giỏ hàng sau khi đặt hàng thành công
//         $auth->carts()->delete();

//         return redirect()->route('order.verify')->with('success', 'Đặt hàng thành công! Vui lòng kiểm tra email để xác nhận.');
//     }
//     return redirect()->back()->withErrors(['order' => 'Đặt hàng không thành công.']);

//     return redirect()->route('order.verify'); // Thêm route phù hợp
// }


//     public function verify($token) {}
$auth = auth('web')->user();

        if (!$auth) {
            return redirect()->route('account.login')->withErrors(['auth' => 'Bạn cần đăng nhập để thanh toán.']);
  }

    $req->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'address' => 'required',
    ]);

    $data = $req->only('name', 'email', 'phone', 'address');
    $data['user_id'] = auth()->id(); // Lấy ID của người dùng hiện tại

    if ($order = Order::create($data)) {
        $token = Str::random(40);

        foreach ($auth->carts as $cart) {
            $order->details()->create([
                'book_id' => $cart->book_id,
                'price' => $cart->price,
                'quantity' => $cart->quantity,
            ]);
        }

        $order->token = $token;
        $order->save();

        // Gửi email
        try {
            Mail::to($order->email)->send(new OrderMail($order));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['email' => 'Không thể gửi email: ' . $e->getMessage()]);
        }

        // Xóa giỏ hàng sau khi đặt hàng thành công
        $auth->carts()->delete();

        return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công! Vui lòng kiểm tra email để xác nhận.');
    }

    return redirect()->back()->withErrors(['order' => 'Đặt hàng không thành công.']);
}

    public function verify($token)
    {
        $order = Order::where('token', $token)->first();

        if (!$order) {
            return redirect()->route('home')->withErrors(['order' => 'Đơn hàng không tồn tại.']);
        }

        return view('email.order_verify', compact('order'));
    }
    public function success()
    {
        return view('site.success');
    }
    public function cancel()
    {
        return view('site.cancel');
    }
    public function order()
    {
        $auth = auth('web')->user();
        $orders = Order::where('user_id', $auth->id)->with('details')->get();
        return view('site.order', compact('orders'));
    }
    public function orderDetail($id)
    {
        $order = Order::with('details')->findOrFail($id);
        return view('site.order_detail', compact('order'));
    }
    public function orderCancel($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'cancelled';
        $order->save();

        return redirect()->route('order')->with('success', 'Đơn hàng đã được hủy thành công.');
    }
    public function orderDelete($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('order')->with('success', 'Đơn hàng đã được xóa thành công.');
    }
    public function orderPrint($id)
    {
        $order = Order::with('details')->findOrFail($id);
        return view('site.order_print', compact('order'));
    }
    public function orderPrintAll()
    {
        $auth = auth('web')->user();
        $orders = Order::where('user_id', $auth->id)->with('details')->get();
        return view('site.order_print_all', compact('orders'));
    }
    public function orderPrintAllPDF()
    {
        $auth = auth('web')->user();
        $orders = Order::where('user_id', $auth->id)->with('details')->get();
        return view('site.order_print_all_pdf', compact('orders'));
    }
    public function orderPrintPDF($id)
    {
        $order = Order::with('details')->findOrFail($id);
        return view('site.order_print_pdf', compact('order'));
    }
    public function orderPrintPDFAll()
    {
        $auth = auth('web')->user();
        $orders = Order::where('user_id', $auth->id)->with('details')->get();
        return view('site.order_print_pdf_all', compact('orders'));
    }
    public function orderPrintPDFAllDownload()
    {
        $auth = auth('web')->user();
        $orders = Order::where('user_id', $auth->id)->with('details')->get();
        return view('site.order_print_pdf_all_download', compact('orders'));
    }
    public function orderPrintPDFDownload($id)
    {
        $order = Order::with('details')->findOrFail($id);
        return view('site.order_print_pdf_download', compact('order'));
    }
    public function orderPrintPDFDownloadAll()
    {
        $auth = auth('web')->user();
        $orders = Order::where('user_id', $auth->id)->with('details')->get();
        return view('site.order_print_pdf_download_all', compact('orders'));
    }
    public function orderPrintPDFDownloadAllAll()
    {
        $auth = auth('web')->user();
        $orders = Order::where('user_id', $auth->id)->with('details')->get();
        return view('site.order_print_pdf_download_all_all', compact('orders'));
    }
    public function orderPrintPDFDownloadAllAllAll()
    {
        $auth = auth('web')->user();
        $orders = Order::where('user_id', $auth->id)->with('details')->get();
        return view('site.order_print_pdf_download_all_all_all', compact('orders'));
    }
    public function orderPrintPDFDownloadAllAllAllAll()
    {
        $auth = auth('web')->user();
        $orders = Order::where('user_id', $auth->id)->with('details')->get();
        return view('site.order_print_pdf_download_all_all_all_all', compact('orders'));
    }
    public function orderPrintPDFDownloadAllAllAllAllAll()
    {
        $auth = auth('web')->user();
        $orders = Order::where('user_id', $auth->id)->with('details')->get();
        return view('site.order_print_pdf_download_all_all_all_all_all', compact('orders'));
}
}
