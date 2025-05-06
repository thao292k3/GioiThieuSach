<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>Trang quản trị viên</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/vendors/images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('vendors/images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('vendors/images/favicon-16x16.png') }}">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/core.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/icon-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/style.css') }}">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-119386393-1');
    </script>
</head>

<body class="login-page">
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="login.html">
                    <img src="{{ asset('vendors/images/deskapp-logo.svg') }}" alt="">
                </a>
            </div>
            <div class="login-menu">
                <ul>
                    <li><a href="{{ route('account.register') }}">Register</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <img src="{{ asset('vendors/images/login-page-img.png') }}" alt="">
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-primary">Login To DeskApp</h2>
                        </div>

                        <!-- Form đăng nhập -->
                        <form form method="POST" action="{{ route('account.login.post') }}" enctype="multipart/form-data">
                      
                            @csrf

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if (session('message'))
                                <h5 class="text-alert">{{ session('message') }}</h5>
                            @endif

                        <div class="input-group custom">
                            <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" required>
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="icon-copy dw dw-email"></i></span>
                            </div>
                        </div>

    <div class="input-group custom">
        <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
        @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="input-group-append custom">
            <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
        </div>
    </div>

    <div class="form-group">
                    <label for="role">Quyền</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="1">Người dùng</option>
                        <option value="0">Quản trị viên</option>
                    </select>
                    @error('role')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

    <div class="row pb-30">
        <div class="col-6">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="remember" class="custom-control-input" id="customCheck1">
                <label class="custom-control-label" for="customCheck1">Remember</label>
            </div>
        </div>
        <div class="col-6">
            <div class="forgot-password"><a href="">Forgot Password</a></div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="input-group mb-0">
                <input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
            </div>
            <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">OR</div>
            <div class="input-group mb-0">
                <a class="btn btn-outline-primary btn-lg btn-block" href="{{ route('account.register')}}">Register To Create Account</a>
            </div>
        </div>
    </div>
</form>
                        <!-- Kết thúc form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- js -->
    <script src="{{ asset('public/vendors/scripts/core.js') }}"></script>
    <script src="{{ asset('public/vendors/scripts/script.min.js') }}"></script>
    <script src="{{ asset('public/vendors/scripts/process.js') }}"></script>
    <script src="{{ asset('public/vendors/scripts/layout-settings.js') }}"></script>
</body>

</html>