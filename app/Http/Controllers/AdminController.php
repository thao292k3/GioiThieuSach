<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }


    public function post_login(Request $request)
    {

        if (Auth::guard('admin')->attempt(["admin_email" => $request->admin_email, "admin_password" => $request->admin_password])) {
            $request->session()->put("messenge", ["style" => "success", "msg" => "Đăng nhập quyền quản trị thành công"]);
            return redirect()->route("home.index");
        }


        // Trường hợp thất bại
        return redirect()->back()->withErrors(['login' => 'Email hoặc mật khẩu không chính xác.']);
    }

    public function index()
    {
        return view('admin.index'); // Trả về view admin.index
    }

    public function logout()
    {
        auth('admin')->logout();
        return redirect()->route('admin.login');
    }
}
