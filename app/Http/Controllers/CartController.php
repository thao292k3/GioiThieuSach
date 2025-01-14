<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->id();
        $carts = Cart::where('user_id', $user_id)->with('prod')->get(); // Dùng with để eager load quan hệ sản phẩm
        return view('site.shoping-cart', compact('carts'));
    }

    public function add(Book $book, Request $req)
    {
        $quantity = $req->quantity ? (int) $req->quantity : 1; // Đảm bảo quantity là INT

        // Kiểm tra người dùng đã đăng nhập chưa
        $user_id = auth()->id();

        if (!$user_id) {
            return redirect()->route('account.login')->with('no', 'Bạn cần đăng nhập để thêm sách vào giỏ hàng!');
        }

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng của người dùng chưa
        $cartExist = Cart::where([
            'user_id' => $user_id,
            'book_id' => $book->book_id,
        ])->first();

        if ($cartExist) {
            // Nếu sản phẩm đã có, chỉ cần cập nhật số lượng
            $cartExist->quantity += $quantity;
            $cartExist->save();

            return redirect()->route('cart.index')->with('ok', 'Sản phẩm đã được cập nhật số lượng trong giỏ hàng!');
        }

        // Nếu sản phẩm chưa có, tạo mới giỏ hàng
        $data = [
            'user_id' => $user_id,
            'book_id' => $book->book_id,
            'price' => $book->sale_price ?? $book->price, // Sử dụng giá bán nếu có
            'quantity' => $quantity, // Đảm bảo quantity là INT
        ];

        try {
            // Thêm sản phẩm vào giỏ hàng
            Cart::create($data);
            return redirect()->route('cart.index')->with('ok', 'Sản phẩm đã được thêm vào giỏ hàng thành công!');
        } catch (\Exception $e) {
            dd($e->getMessage()); // Hiển thị lỗi nếu có
        }
    }

    public function update(Book $book, Request $req)
    {
        // Lấy số lượng từ tham số URL
        $quantity = $req->get('quantity') ? (int) $req->get('quantity') : 1;
        $user_id = auth()->id();

        // Tìm sản phẩm trong giỏ hàng của người dùng
        $cartExist = Cart::where([
            'user_id' => $user_id,
            'book_id' => $book->book_id,
        ])->first();

        if ($cartExist) {
            // Nếu sản phẩm đã có, cập nhật số lượng mới
            $cartExist->quantity = $quantity; // Cập nhật đúng số lượng
            $cartExist->save();

            return redirect()->route('cart.index')->with('ok', 'Sản phẩm đã được cập nhật số lượng trong giỏ hàng!');
        }

        // Nếu sản phẩm chưa có trong giỏ hàng, tạo mới
        $data = [
            'user_id' => $user_id,
            'book_id' => $book->book_id,
            'price' => $book->sale_price ?? $book->price,
            'quantity' => $quantity,
        ];

        try {
            // Thêm sản phẩm vào giỏ hàng
            Cart::create($data);

            return redirect()->route('cart.index')->with('ok', 'Sản phẩm đã được thêm vào giỏ hàng thành công!');
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            return redirect()->route('cart.index')->with('error', 'Đã xảy ra lỗi khi thêm sản phẩm vào giỏ hàng! Vui lòng thử lại.');
        }
    }

    public function delete($book_id)
    {
        $user_id = auth()->id();
        Cart::where([
            'user_id' => $user_id,
            'book_id' => $book_id
        ])->delete();
        // return view('site.shoping-cart');
        return redirect()->back()->with('ok', 'Sản phẩm đã được xóa thành côngcông!');
    }

    public function clear()
    {
        $user_id = auth()->id();
        Cart::where([
            'user_id' => $user_id
        ])->delete();
        return redirect()->back()->with('ok', 'Tất cả sản phẩm đã được xóa thành côngcông!');
    }
}
