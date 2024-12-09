@extends('site.master')

@section('title','Trang San Pham')



@section('body')





<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Organi Shop</h2>
                    <div class="breadcrumb__option">
                        <a href="./index.html">Home</a>
                        <span>Shop</span>
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
                        <h4>Thể loại sách </h4>
                        
                        <ul id="category-list">
                            <!-- Hiển thị danh sách giới hạn -->
                            @foreach ($data->take(5) as $item)
                                <li><a href="#">{{ $item->name }}</a></li>
                            @endforeach
                        </ul>
                    
                        <!-- Nút "Xem thêm" -->
                        @if ($data->count() > 5)
                            <a href="javascript:void(0);" id="see-more-btn" style="color: blue; text-decoration: underline;">Xem thêm</a>
                            <a href="javascript:void(0);" id="go-back-btn" style="color: red; text-decoration: underline; display: none;">Quay lại</a>
                        @endif
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
    const categories = @json($data); // Dữ liệu toàn bộ thể loại
    const categoryList = document.getElementById('category-list');
    const seeMoreBtn = document.getElementById('see-more-btn');
    const goBackBtn = document.getElementById('go-back-btn');

    // Ban đầu chỉ hiển thị 5 mục
    let displayedCategories = categories.slice(0, 5);
    displayedCategories.forEach(item => {
        const li = document.createElement('li');
        li.innerHTML = `<a href="#">${item.name}</a>`;
        categoryList.appendChild(li);
    });

    // Khi nhấn nút "Xem thêm"
    if (seeMoreBtn) {
        seeMoreBtn.addEventListener('click', function () {
            // Hiển thị toàn bộ danh sách
            categoryList.innerHTML = '';
            categories.forEach(item => {
                const li = document.createElement('li');
                li.innerHTML = `<a href="#">${item.name}</a>`;
                categoryList.appendChild(li);
            });

            // Ẩn nút "Xem thêm" và hiện nút "Quay lại"
            seeMoreBtn.style.display = 'none';
            goBackBtn.style.display = 'inline';
        });
    }

    // Khi nhấn nút "Quay lại"
    if (goBackBtn) {
        goBackBtn.addEventListener('click', function () {
            // Hiển thị lại danh sách giới hạn
            categoryList.innerHTML = '';
            displayedCategories.forEach(item => {
                const li = document.createElement('li');
                li.innerHTML = `<a href="#">${item.name}</a>`;
                categoryList.appendChild(li);
            });

            // Hiện nút "Xem thêm" và ẩn nút "Quay lại"
            this.style.display = 'none';
            seeMoreBtn.style.display = 'inline';
        });
    }
});

                    </script>
                    
                    <div class="sidebar__item">
                        <h4>Price</h4>
                        <div class="price-range-wrap">
                            <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                data-min="10" data-max="540">
                                <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                            </div>
                            <div class="range-slider">
                                <div class="price-input">
                                    <input type="text" id="minamount">
                                    <input type="text" id="maxamount">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                   
                    <div class="sidebar__item">
                        <div class="latest-product__text">
                            <h4>Latest Products</h4>
                            <div class="latest-product__slider owl-carousel">
                                <div class="latest-prdouct__slider__item">
                                    @forelse($latestBooks as $book)
                                        <a href="{{ route('book.show', $book->book_id) }}" class="latest-product__item">
                                            <div class="latest-product__item__pic">
                                                @if(!empty($book->cover_image) && file_exists(public_path($book->cover_image)))
                                                    <img src="{{ asset($book->cover_image) }}" alt="{{ $book->title }}">
                                                @else
                                                    <img src="{{ asset('default-image.jpg') }}" alt="No image available">
                                                @endif
                                            </div>
                                            <div class="latest-product__item__text">
                                                <h6>{{ $book->title }}</h6>
                                                <span>{{ number_format($book->price) }} VNĐ</span>
                                            </div>
                                        </a>
                                    @empty
                                        <p>No products found.</p>
                                    @endforelse
                                </div>
                            </div> 
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-7">
                <div class="product__discount">
                    <div class="section-title product__discount__title">
                        <h2>Sale Off</h2>
                    </div>
                    <div class="row">
                        <div class="product__discount__slider owl-carousel">
                            @foreach($saleBooks as $item)
                            <div class="col-lg-4">
                                <div class="product__discount__item">
                                    <div class="product__discount__item__pic set-bg"
                                        data-setbg="{{ asset( $item->cover_image) }}">
                                        <div class="product__discount__percent">
                                            @if($item->price > 0 && $item->sale_price > 0)
                                                -{{ round((($item->price - $item->sale_price) / $item->price) * 100) }}%
                                            @else
                                                Không giảm giá
                                            @endif
                                        </div>
                                        <ul class="product__item__pic__hover">
                                           
                                            <a href="{{ route('shopdetail', ['slug' => $item->slug]) }}">Xem chi tiết</a>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <!-- Hiển thị tên danh mục -->
                                        <h8><a href="#">{{ $item->cat->name ?? 'Không xác định' }}</a></h8>
                                        <!-- Hiển thị tiêu đề sách -->
                                        <h6><a href="#">{{ $item->title }}</a></h6>
                                        <!-- Hiển thị giá -->
                                        <h7>
                                            <span style="text-decoration: line-through; color: #999;">
                                                {{ number_format($item->price) }} VNĐ
                                               
                                            </span>
                                            <span style="color: #e74c3c; font-weight: bold;">
                                                {{ number_format($item->sale_price) }} VNĐ
                                            </span>
                                        </h7>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <div class="filter__item">
                    <div class="row">
                        <div class="col-lg-4 col-md-5">
                            <div class="filter__sort">
                                <span>Sort By</span>
                                <select id="sort-options">
                                    <option value="default">Default</option>
                                    <option value="price_asc">Price: Low to High</option>
                                    <option value="price_desc">Price: High to Low</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="filter__found">
                                <h6>Products found</h6>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-3">
                            <div class="filter__option">
                                <span class="icon_grid-2x2"></span>
                                <span class="icon_ul"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($books as $item)
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

                
                
                
                
                
                <!-- Phân trang -->
                {{ $books->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->


@stop()