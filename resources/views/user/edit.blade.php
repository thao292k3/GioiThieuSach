@extends('admin.master')
@section('title', 'Category Manager')
@section('body')
<h1>Sửa Người Dùng</h1>

<form action="{{ route('user.update', $user->user_id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Họ Tên</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
    </div>
    <div class="form-group">
        <label for="phone">Số Điện Thoại</label>
        <input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone }}">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
    </div>
    <div class="form-group">
        <label for="password">Mật Khẩu</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Cập Nhật</button>
</form>
@endsection