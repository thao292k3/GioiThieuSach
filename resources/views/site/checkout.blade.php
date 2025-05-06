@extends('site.master')

@section('title', 'Trang Giỏ Hàng')

@section('body')

    <!-- Hero Section Begin -->
    <section class="hero hero-normal">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>All departments</span>
                        </div>
                        <ul>
                            <li><a href="#">Fresh Meat</a></li>
                            <li><a href="#">Vegetables</a></li>
                            <li><a href="#">Fruit & Nut Gifts</a></li>
                            <li><a href="#">Fresh Berries</a></li>
                            <li><a href="#">Ocean Foods</a></li>
                            <li><a href="#">Butter & Eggs</a></li>
                            <li><a href="#">Fastfood</a></li>
                            <li><a href="#">Fresh Onion</a></li>
                            <li><a href="#">Papayaya & Crisps</a></li>
                            <li><a href="#">Oatmeal</a></li>
                            <li><a href="#">Fresh Bananas</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <form action="#">
                                <div class="hero__search__categories">
                                    All Categories
                                    <span class="arrow_carrot-down"></span>
                                </div>
                                <input type="text" placeholder="What do you need?">
                                <button type="submit" class="site-btn">SEARCH</button>
                            </form>
                        </div>
                        <div class="hero__search__phone">
                            <div class="hero__search__phone__icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="hero__search__phone__text">
                                <h5>+65 11.188.888</h5>
                                <span>support 24/7 time</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Order Checkout</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Home</a>
                            <span>Order Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <form action="{{ route('checkout.post') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên</label>
                            <input type="text" value="{{ $auth->name ?? old('name') }}" name="name" id="name" class="form-control" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" value="{{ $auth->email ?? old('email') }}" name="email" id="email" class="form-control" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="tel" value="{{ $auth->phone ?? old('phone') }}" name="phone" id="phone" class="form-control" required>
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="form-group">
                            <label for="address">Địa chỉ</label>
                            <input type="text" value="{{ $auth->address ?? old('address') }}" name="address" id="address" class="form-control" required>
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Đặt hàng</button>
                    </form>
                </div>
                <div class="col-md-8">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class="shoping__product">Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($carts as $item)
                                    <tr>
                                        <td scope="row">{{ $loop->iteration }}</td>
                                        <td>{{ $item->prod->title }}</td>
                                        <td>{{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>
                                            <img src="{{ asset('storage/uploads/' . $item->prod->cover_image) }}" width="40" alt="{{ $item->prod->title }}">
                                        </td>
                                        
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Your cart is empty.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <br>
                        <div class="text-center">
                            <a href="{{ route('shop') }}" class="btn btn-primary">CONTINUE SHOPPING</a>
                            @if($carts->count())
                                <a href="{{ route('cart.clear') }}" class="btn btn-danger"><i class="fa fa-trash"></i> CLEAR SHOPPING</a>
                                <a href="{{ route('order.verify', ['token' => $auth->token ?? 'default-token']) }}" class="btn btn-success">PLACE ORDER</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->
@stop