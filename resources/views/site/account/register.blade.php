@extends('site.master')

@section('title', 'Trang Đăng Ký')

@section('body')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg rounded-3">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Đăng Ký Tài Khoản</h4>
                </div>
                <div class="card-body">

                    {{-- Thông báo --}}
                    @if (session('yes'))
                        <div class="alert alert-success">{{ session('yes') }}</div>
                    @endif

                    @if (session('No'))
                        <div class="alert alert-danger">{{ session('No') }}</div>
                    @endif

                    <form method="POST" action="{{ route('account.register') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="name"><i class="fas fa-user"></i> Họ và tên</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="email"><i class="fas fa-envelope"></i> Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="phone"><i class="fas fa-phone"></i> Số điện thoại</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" required>
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="address"><i class="fas fa-map-marker-alt"></i> Địa chỉ</label>
                            <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}" required>
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password"><i class="fas fa-lock"></i> Mật khẩu</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation"><i class="fas fa-lock"></i> Xác nhận mật khẩu</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            @error('password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="role"><i class="fas fa-user-tag"></i> Vai trò</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Người dùng</option>
                                <option value="0" {{ old('role') == '0' ? 'selected' : '' }}>Quản trị viên</option>
                            </select>
                            @error('role')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@stop
@section('script')
    <script>
        $(document).ready(function() {
            // Custom JavaScript code can go here
        });
    </script>
@stop
@section('style')
    <style>
        /* Custom CSS styles can go here */
        .container {
            margin-top: 50px;
        }
        .card {
            border-radius: 15px;
        }
        .card-header {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
    </style>
@stop
@section('meta')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Đăng ký tài khoản mới">
    <meta name="keywords" content="đăng ký, tài khoản, người dùng">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.mCustomScrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-fileinput.css') }}">   