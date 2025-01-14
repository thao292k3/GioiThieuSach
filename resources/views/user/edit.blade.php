@extends('admin.master')
@section('title', 'Category Manager')
@section('body')
<h1>Sửa Người Dùng</h1>
<div class="container">
    <div class="row-4">
        <div class="col-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-blue h4">Cập nhật thông tin người dùng </h4>
                        <p class="mb-30">Vui lòng điền thông tin chi tiết bên dưới</p>
                    </div>
                </div>
<form action="{{ route('user.update', $data->user_id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Họ Tên</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ $data->name }}" required>
    </div>
    <div class="form-group">
        <label for="phone">Số Điện Thoại</label>
        <input type="text" name="phone" id="phone" class="form-control" value="{{ $data->phone }}">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ $data->email }}" required>
    </div>
    <div class="form-group">
        <label for="password">Mật Khẩu</label>
        <div class="input-group">
            <input type="password" name="password" id="password" class="form-control" value="{{ $data->password }}" required>
            <div class="input-group-append">
                <span class="input-group-text" onclick="togglePasswordVisibility()" style="cursor: pointer;">
                    👁️
                </span>
            </div>
        </div>
    </div>
    
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = event.target;
    
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.textContent = '🙈'; // Icon ẩn mật khẩu
            } else {
                passwordInput.type = 'password';
                eyeIcon.textContent = '👁️'; // Icon hiển thị mật khẩu
            }
        }
    </script>
    
    <button type="submit" class="btn btn-primary">Cập Nhật</button>
</form>
            </div>
        </div>
    </div>
</div>
@endsection