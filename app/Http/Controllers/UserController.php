<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Hiển thị danh sách người dùng
    public function index()
    {
        $data = User::orderBy('user_id', 'asc')->paginate(6);
        return view('user.index', compact('data'));
    }

    // Hiển thị form thêm người dùng
    public function create()
    {
        return view('user.create');
    }

    // Lưu người dùng mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'phone' => 'nullable|numeric',
            'address' => 'nullable|string|max:50',
            'birthday' => 'nullable|date',
            'email' => 'required|email|max:200|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'birthday' => $request->birthday,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        session()->flash('success', 'Thêm người dùng thành công!');

        return redirect()->route('user.index');
    }

    public function show($user_id)
    {
        $user = User::findOrFail($user_id);
        return view('user.show', compact('user'));
    }


    // Hiển thị form sửa người dùng
    public function edit($id)
    {
        $data = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    // Cập nhật thông tin người dùng
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'phone' => 'nullable|numeric',
            'address' => 'nullable|string|max:50',
            'birthday' => 'nullable|date',
            'email' => 'required|email|max:200|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
        ]);

        $data = User::findOrFail($id);
        $data->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'birthday' => $request->birthday,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $data->password,
        ]);

        return redirect()->route('user.index');
    }

    // Xóa người dùng
    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();

        session()->flash('success', 'Xóa người dùng thành công!');

        return redirect()->route('user.index');
    }
}
