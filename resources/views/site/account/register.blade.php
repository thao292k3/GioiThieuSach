@extends('site.master')

@section('title', 'Trang Liên Hệ')

@section('body')

<div class="contact-form spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="contact__form__title">
                    @if (session('yes'))
                        <div class="alert alert-success">
                            {{ session('yes') }}
                        </div>
                    @endif

                    @if (session('No'))
                        <div class="alert alert-danger">
                            {{ session('No') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('account.register') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="form-group">
                            <label for="password">Mật khẩu</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="form-group">
                            <label for="password_confirmation">Xác nhận mật khẩu</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            @error('password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <button type="submit" class="btn btn-primary">Đăng ký</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

@stop
