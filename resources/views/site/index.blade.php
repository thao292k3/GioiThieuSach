@extends('site.master')

@section('title','Trang chủ')

@section('body')



<!-- Hero Section Begin -->
<section class="hero">
    
    <div class="container">
        <div class="row">
      
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>Thể loại sách</span>
                    </div>
                    
                    <!-- Hiển thị danh sách giới hạn -->
                    <ul id="category-list">
                        @foreach($limitedCategories as $item)
                            <li><a href="{{route('category',$item->category_id)}}">{{ $item->name }}</a></li>
                        @endforeach
                    </ul>
                    
                    <!-- Nút xem thêm -->
                    @if($data->count() > 11)
                        <a href="javascript:void(0);" id="see-more-btn" style="color: blue; text-decoration: underline;">See more</a>
                    @endif

                <a href="javascript:void(0);" id="go-back-btn" style="color: red; text-decoration: underline; display: none;">Go back</a>
                </div>
            </div>
            
            <!-- Thêm script để xử lý nút Xem Thêm -->
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
                    
                </div>
                <div class="hero__item set-bg" data-setbg="uploads/banner3.jpg">
                    
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- Categories Section Begin -->
<section class="categories">
    <div class="container">
        <div class="row">
            <div class="categories__slider owl-carousel">
                @foreach($categories as $category)
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="{{ asset($category->image) }}">
                            <h5>
                                <a href="{{ route('category', $category->category_id) }}">
                                    {{ $category->name }}
                                </a>
                            </h5>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Categories Section End -->

<!-- Featured Section Begin -->
<section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Sách nổi bật</h2>
                </div>
                <div class="featured__controls">
                    <ul class="category-list">
                        <li class="category-item active" data-filter="*">Tất cả</li>
                        @foreach($featuredBooks as $item)
                            <li class="category-item" data-filter=".{{ strtolower(str_replace(' ', '-', $item->cat->name)) }}">
                                <a href="javascript:void(0);">
                                    {{ $item->cat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="row featured__filter">
            @if(isset($featuredBooks) && $featuredBooks->isNotEmpty())
                @foreach($featuredBooks as $item)
                <div class="col-lg-3 col-md-4 col-sm-6 mix {{ strtolower(str_replace(' ', '-', $item->cat->name)) }}">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="{{ asset($item->cover_image) }}">
						   <ul class="featured__item__pic__hover">

                            <ul class="featured__item__pic__hover">
                                <li>
                                    @if(auth()->check())
                                        @if(auth()->user()->favorites()->where('favorites.book_id', $item->book_id)->exists()) 
                                            <a title="Bỏ thích" onclick="return confirm('Bạn có muốn bỏ thích không?')" href="{{ route('home.favorite', $item->book_id) }}">
                                                <i class="fas fa-heart" style="color: red;"></i>
                                            </a>
                                        @else
                                            <a title="Yêu thích" href="{{ route('home.favorite', $item->book_id) }}">
                                                <i class="far fa-heart"></i>
                                            </a>
                                        @endif
                                    @else
                                        <a title="Yêu thích" href="{{ route('account.login') }}" onclick="alert('Vui lòng đăng nhập để yêu thích sách!');">
                                            <i class="far fa-heart"></i>
                                        </a>
                                    @endif
                                </li>
                                
                                <li>
                                    @if(auth()->check())
                                        <a title="Thêm vào giỏ hàng" href="{{ route('cart.add', $item->book_id) }}">
                                            <i class="fa fa-shopping-cart"></i>
                                        </a>
                                    @else
                                        <a title="Thêm vào giỏ hàng" href="{{ route('account.login') }}" onclick="alert('Vui lòng đăng nhập để thêm sách vào giỏ hàng!');">
                                            <i class="fa fa-shopping-cart"></i>
                                        </a>
                                    @endif
                                </li>
                                
                                
                                <li>
                                    <a href="#"><i class="fa fa-retweet"></i></a>
                                </li>
                            </ul> 
                            </ul>
                        
                            <ul class="featured__item__pic__hover">
                                <a href="{{ route('shopdetail', ['slug' => $item->slug]) }}">Xem chi tiết</a>
                            </ul>
                        </div>    
                    </div>
                        {{-- @endif --}}

                        <div class="featured__item__text">
                            <p>{{ $item->cat->name }}</p>
                            <h6>{{ $item->title }}</h6>
                            <h5>{{ $item->price }}</h5>
                        </div>
                </div>
                
            @endforeach
            @else
                <p>Không có sách nổi bật.</p>
            @endif
        </div>
    </div>
</section>

<style>
   document.addEventListener('DOMContentLoaded', function () {
    const categoryItems = document.querySelectorAll('.category-item');
    const featuredItems = document.querySelectorAll('.featured__filter .mix');

    categoryItems.forEach(item => {
        item.addEventListener('click', function () {
            const filter = this.getAttribute('data-filter');

            // Thay đổi trạng thái active cho danh mục
            categoryItems.forEach(i => i.classList.remove('active'));
            this.classList.add('active');

            // Hiển thị hoặc ẩn các sản phẩm
            featuredItems.forEach(product => {
                if (filter === '*' || product.classList.contains(filter.substring(1))) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        });
    });
});

</style>
<!-- Featured Section End -->

 <!-- Banner Begin -->
<div class="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="uploads/banner2.jpg" alt="">
                    </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="uploads/banner7.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner End --> 
<!-- Latest Product Section Begin -->
<section class="latest-product spad">
    <div class="container">
        <div class="row">
            <!-- Sản phẩm mới nhất -->
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Sản phẩm mới nhất</h4>
                    <div class="latest-product__slider owl-carousel">
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
                                    <span>{{ number_format($book->price, 0, ',', '.') }} VNĐ</span>
                                </div>
                            </a>
                        @empty
                            <p>Không tìm thấy sản phẩm nào.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Đánh giá hàng đầu -->
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Đánh giá hàng đầu</h4>
                    <div class="latest-product__slider owl-carousel">
                        @if($topCommentedBooks->isNotEmpty())
                            @foreach($topCommentedBooks as $item)
                                <div class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{ asset($item->cover_image) }}" alt="{{ $item->title }}">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>
                                            <a href="{{ route('shopdetail', ['slug' => $item->slug]) }}">{{ $item->title }}</a>
                                        </h6>
                                        <span>{{ number_format($item->price, 0, ',', '.') }} VNĐ</span>
                                        <p><strong>{{ $item->comments_count }} bình luận</strong></p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>Chưa có sách nào được bình luận.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Review Products -->
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Review Products</h4>
                    <div class="latest-product__slider owl-carousel">
                        @foreach($reviewedBooks as $item)
                            <a href="{{ route('shopdetail', ['slug' => $item->slug]) }}" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    @if(!empty($item->cover_image) && file_exists(public_path($item->cover_image)))
                                        <img src="{{ asset($item->cover_image) }}" alt="{{ $item->title }}">
                                    @else
                                        <img src="{{ asset('default-image.jpg') }}" alt="No image available">
                                    @endif
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>{{ $item->title }}</h6>
                                    <span>{{ number_format($item->price, 0, ',', '.') }} VNĐ</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Latest Product Section End -->
<!-- Blog Section Begin -->
<section class="from-blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title from-blog__title">
                    <h2>From The Blog</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($blogs as $item)
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}">
                            
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> {{ date('M d, Y', strtotime($item->date)) }}</li>
                                <li><i class="fa fa-comment-o"></i> {{ $item->comment_count ?? 0 }}</li>
                            </ul>
                            <h5><a href="#">{{ $item->title }}</a></h5>
                            <p>{{ Str::limit($item->content, 100, '...') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
    </div>
</section>
<!-- Blog Section End -->

@stop()