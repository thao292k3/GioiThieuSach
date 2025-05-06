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


//     public function post_login(Request $request)
//     {
//         $credentials = $request->only('email', 'password');
//         if ($user && Hash::check($password, $user->password)) {
//             // Lưu thông tin user vào session (hoặc thực hiện đăng nhập thủ công)
//             Auth::login($user);

//             // Kiểm tra role
//             if ($user->role == 0) {
//                 return redirect()->route('admin.index');
//             } elseif ($user->role == 1) {
//                 return redirect()->route('home');
//             }
//     } else {
//         return redirect()->back()->withErrors(['error' => 'Email hoặc mật khẩu không đúng.']);
//     }
//     return redirect()->route('dashboard'); // Chuyển hướng sau khi đăng nhập thành công
// }

    // 
    
public function post_login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // Kiểm tra quyền (role)
        if ($user->role == 0) {
            // Quản trị viên
            return redirect()->route('admin.index')->with('success', 'Đăng nhập thành công với quyền Quản trị viên.');
        } elseif ($user->role == 1) {
            // Người dùng
            return redirect()->route('home')->with('success', 'Đăng nhập thành công với quyền Người dùng.');
        }
    }

    // Sai email hoặc mật khẩu
    return redirect()->back()->withErrors(['error' => 'Email hoặc mật khẩu không đúng.'])->withInput();
}
    
    public function account()
    {
        $user = auth()->user();
        return view('site.account.account', compact('user'));
    }
    public function update_account(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);

        $user->update($request->all());
        return redirect()->back()->with('yes', 'Cập nhật thông tin thành công');
    }
    public function change_password(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (Hash::check($request->old_password, $user->password)) {
            $user->update(['password' => Hash::make($request->new_password)]);
            return redirect()->back()->with('yes', 'Đổi mật khẩu thành công');
        } else {
            return redirect()->back()->with('No', 'Mật khẩu cũ không đúng');
        }
    }
   

    public function favorite()
    {
        $favorites = auth()->user()->favorites;
        return view('site.account.favorite', compact('favorites'));
    }

    // public function post_login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email|exists:users,email', // Kiểm tra email có trong cơ sở dữ liệu
    //         'password' => 'required|min:3', // Kiểm tra mật khẩu
    //     ]);

    //     // Lấy thông tin email và password từ request
    //     $email = $request->email;
    //     $password = $request->password;

    //     // Tìm user theo email
    //     $user = User::where('email', $email)->first();

    //     // Kiểm tra user có tồn tại và mật khẩu có khớp không
    //     if ($user && $password == $user->password) {
    //         // Lưu thông tin user vào session (hoặc thực hiện đăng nhập thủ công)
    //         Auth::login($user);

    //         // Kiểm tra role
    //         if ($user->role == 0) {
    //             return redirect()->route('admin.index');
    //         } elseif ($user->role == 1) {
    //             return redirect()->route('home');
    //         }
    //     }

    //     // Sai email hoặc mật khẩu
    //     return back()->withErrors([
    //         'email' => 'Invalid email or password.',
    //     ])->withInput();
    // }

    public function post_register(Request $request)
    {
        // Định nghĩa quy tắc xác thực cho dữ liệu đăng ký
        // $rules = [
        //     'email' => 'required|email|unique:customers,email', // Kiểm tra email không trùng
        //     'name' => 'required|string|max:255', // Kiểm tra tên người dùng
        //     'password' => 'required|confirmed|min:6', // Kiểm tra mật khẩu và xác nhận mật khẩu
        //     'password_confirmation' => 'required|same:password',
        //     'role' => 'required|in:0,1', // Kiểm tra mật khẩu xác nhận trùng với mật khẩu

        // ];

        // Xác thực dữ liệu từ người dùng
        $request->validate([
            'role' => 'required|in:0,1', // Chỉ chấp nhận 0 (Admin) hoặc 1 (User)
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|max:255',
            'password' => 'required|confirmed|min:6',
            'role' => 'required|in:0,1',
        ]);

        User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);


        // Lấy dữ liệu cần thiết từ form đăng ký
        $data = $request->only(['name', 'email', 'phone', 'address', 'role']);
        // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
        $data = $request->only(['name', 'email', 'role']);
        $data['password'] = bcrypt($request->password);
        // Tạo khách hàng mới và lưu vào cơ sở dữ liệu
        if (User::create($data)) {
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
