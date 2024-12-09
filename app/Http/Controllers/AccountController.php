<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Customer;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{

    public function index() {}


    public function login(Request $request)
    {

        return view('site.account.login');
    }

    public function post_login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email', // Kiểm tra email có trong cơ sở dữ liệu
            'password' => 'required|min:3', // Kiểm tra mật khẩu
        ]);

        // Lấy thông tin email và password từ request
        $email = $request->email;
        $password = $request->password;

        // Tìm user theo email
        $user = User::where('email', $email)->first();

        // Kiểm tra user có tồn tại và mật khẩu có khớp không
        if ($user && $password == $user->password) {
            // Lưu thông tin user vào session (hoặc thực hiện đăng nhập thủ công)
            Auth::login($user);

            // Kiểm tra role
            if ($user->role == 0) {
                return redirect()->route('admin.index');
            } elseif ($user->role == 1) {
                return redirect()->route('home');
            }
        }

        // Sai email hoặc mật khẩu
        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput();
    }

    public function post_register(Request $request)
    {
        // Định nghĩa quy tắc xác thực cho dữ liệu đăng ký
        $rules = [
            'email' => 'required|email|unique:customers,email', // Kiểm tra email không trùng
            'name' => 'required|string|max:255', // Kiểm tra tên người dùng
            'password' => 'required|confirmed|min:6', // Kiểm tra mật khẩu và xác nhận mật khẩu
            'password_confirmation' => 'required|same:password', // Kiểm tra mật khẩu xác nhận trùng với mật khẩu
            'phone' => 'nullable|string|max:20', // Số điện thoại là tùy chọn
            'address' => 'nullable|string|max:255', // Địa chỉ là tùy chọn
            'birthDate' => 'nullable|date', // Ngày sinh là tùy chọn
            'gender' => 'nullable|in:Male,Female,Other', // Giới tính là tùy chọn
        ];

        // Xác thực dữ liệu từ người dùng
        $request->validate($rules);

        // Lấy dữ liệu cần thiết từ form đăng ký
        $data = $request->only(['name', 'email', 'phone', 'address', 'birthDate', 'gender']);
        // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
        $data['password'] = bcrypt($request->password);

        // Tạo khách hàng mới và lưu vào cơ sở dữ liệu
        if (Customer::create($data)) {
            // Sau khi đăng ký thành công, chuyển hướng về trang đăng nhập và hiển thị thông báo
            return redirect()->route('account.login')->with('yes', 'Đăng ký thành công');
        }

        // Nếu có lỗi khi tạo tài khoản, chuyển hướng về trang đăng ký và hiển thị thông báo lỗi
        return redirect()->back()->with('No', 'Đăng ký thất bại vui lòng thử lại');
    }





    public function logout()
    {
        auth('account')->logout();
        return redirect()->route('account.login');
    }


    public function register()
    {
        return view('site.account.register');
    }
}
