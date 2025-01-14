@extends('site.master')

@section('title', 'Trang Gio Hang ')

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
                                <input type="text" placeholder="What do yo u need?">
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
                        <h2>Shopping Cart</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Home</a>
                            <span>Shopping Cart</span>
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
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th >ID</th>
                                    <th class="shoping__product">Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Image</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $item)
                                    <tr>
                                        <td scope="row">{{ $loop->iteration }}</td>
                                        <td>{{ $item->prod->title }}</td>
                                        <td>{{ number_format($item->price, 2) }}</td>
                                        <td>
                                            <!-- Sử dụng phương thức GET để gửi số lượng -->
                                            <form action="{{ route('cart.update', $item->book_id) }}" method="get">
                                                <input type="number" value="{{ $item->quantity }}" name="quantity" style="width: 60px; text-align:center">
                                                <button type="submit"><i class="icon_loading"></i></button>
                                            </form>
                                        </td>
                                        <td>     
                                            <img src="{{ asset('storage/uploads/' . $item->prod->cover_image) }}" width="60" alt="{{ $item->prod->title }}">
                                        </td>
                                        <td>
                                            <a title="Xóa sản phẩm khỏi giỏ hàng" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm khỏi giỏ hàng không?')" href="{{ route('cart.delete', $item->book_id) }}">
                                                <i class="fas fa-trash" style="color: red;"></i>
                                            </a>                                 
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            
                            
                        </table>

                        <br>
                      <div class="text-center">
                        <a href="" class="btn btn-primary">CONTINUE SHOPPING</a>
                        @if($carts->count() )
                            <a href="{{route('cart.clear')}}" class="btn btn-danger"> <i class="fa fa-trash"></i> CLEAR SHOPPING</a>
                            <a href="{{route('order.checkout')}}" class="btn btn-success">PLACE ORDER</a>
                        @endif

                      </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
    <!-- Shoping Cart Section End -->
@stop
