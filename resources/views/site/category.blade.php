@extends('site.master')




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
                        <h2>{{$cat->name}}</h2>
                         <div class="breadcrumb__option">
                            <a href="{{route('home')}}">Home</a>
                            <span>{{$cat->name}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">
                        <div class="sidebar__item">
                            <h4>Thể loại sách</h4>
                            <ul id="category-list">
                                @foreach($limitedCategories as $item)
                                    <li>
                                        <a href="{{ route('category', $item->category_id) }}">
                                            {{ $item->name }} 
                                            <span class="category-book-count">({{ $item->books->count() }})</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            @if($data->count() > 11)
                                <a href="javascript:void(0);" id="see-more-btn" style="color: blue; text-decoration: underline;">See more</a>
                            @endif
                            <a href="javascript:void(0);" id="go-back-btn" style="color: red; text-decoration: underline; display: none;">Go back</a>
                        </div>
                        
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const data = @json($data); // Tất cả thể loại từ server
                                const categoryList = document.getElementById('category-list');
                                const seeMoreBtn = document.getElementById('see-more-btn');
                                const goBackBtn = document.getElementById('go-back-btn');
                        
                                // Lưu trạng thái danh sách ban đầu
                                const initialCategories = data.slice(0, 11);
                        
                                if (seeMoreBtn) {
                                    seeMoreBtn.addEventListener('click', function () {
                                        // Hiển thị danh sách đầy đủ
                                        data.slice(11).forEach(item => {
                                            const li = document.createElement('li');
                                            li.innerHTML = `<a href="#">${item.name}</a>`;
                                            categoryList.appendChild(li);
                                        });
                        
                                        // Ẩn "See more" và hiện "Go back"
                                        this.style.display = 'none';
                                        goBackBtn.style.display = 'inline';
                                    });
                                }
                        
                                if (goBackBtn) {
                                    goBackBtn.addEventListener('click', function () {
                                        // Xóa danh sách hiện tại và phục hồi danh sách ban đầu
                                        categoryList.innerHTML = '';
                                        initialCategories.forEach(item => {
                                            const li = document.createElement('li');
                                            li.innerHTML = `<a href="#">${item.name}</a>`;
                                            categoryList.appendChild(li);
                                        });
                        
                                        // Hiện "See more" và ẩn "Go back"
                                        seeMoreBtn.style.display = 'inline';
                                        this.style.display = 'none';
                                    });
                                }
                            });
                        </script>

                    </div>
                </div>
                <div class="col-lg-9 col-md-7">
                    <div class="product__discount">
                        <div class="section-title product__discount__title">
                            <h2>{{$cat->name}}</h2>
                        </div>
                        <div class="row">
                            @foreach ($books as $item)
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="{{ asset($item->cover_image) }}">
                                        <ul class="product__item__pic__hover">
                                            <a href="{{ route('shopdetail', ['slug' => $item->slug]) }}">Xem chi tiết</a>
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a href="#">{{ $item->title }}</a></h6>
                                        <h5>
                                            @if (!is_null($item->sale_price) && $item->sale_price > 0)
                                                <span style="text-decoration: line-through; color: gray;">
                                                    {{ number_format($item->price) }} VNĐ
                                                </span>
                                                <span style="color: red;">{{ number_format($item->sale_price) }} VNĐ</span>
                                            @else
                                                {{ number_format($item->price) }} VNĐ
                                            @endif
                                        </h5>
                                       
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->
    @endsection
 