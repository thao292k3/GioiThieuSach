@extends('admin.master')
@section('title', 'Category Manager')
@section('body')

<div class="container">
    <div class="row-1">
        <div class="col-md-9">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4>Thêm Người Dùng</h4>

<form action="{{ route('user.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Họ Tên</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="phone">Số Điện Thoại</label>
        <input type="text" name="phone" id="phone" class="form-control">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="password">Mật Khẩu</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Thêm Người Dùng</button>
</form>
@endsection