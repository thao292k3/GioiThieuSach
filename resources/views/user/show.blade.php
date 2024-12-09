@extends('admin.master')

@section('body')
<div class="container">
    <div class="row-5">
        <div class="col-12">
            <div class="card-box pd-20 mb-30">
                <h4 class="text-blue h4">Chi Tiết Sách</h4>
                <p><strong>Tên người dùng:</strong> {{ $user->name }}</p>
                <p><strong>Điện thoại:</strong> {{ $user->phone }}</p>
                <p><strong>Địa chỉ:</strong> {{ $user->address }}</p>
                <p><strong>Ngày sinh:</strong> {{ $user->birthday }}</p>
                <p><strong>Mô Tả:</strong> {{ $user->description }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Email_verified_at:</strong> {{ $user->email_verified_at}}</p>
                <p><strong>Mật khẩu:</strong> {{ $user->password }}</p>

                <p><strong>Ảnh avta:</strong> {{ $user->image}}</p>

                <a href="{{ route('user.index') }}" class="btn btn-secondary">Quay Lại</a>

            </div>
        </div>
    </div>
    @endsection