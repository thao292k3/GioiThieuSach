@extends('site.master')

@section('body')

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Vegetable’s Package</h2>
                    <div class="breadcrumb__option">
                        <a href="./index.html">Home</a>
                        <a href="./index.html">Vegetables</a>
                        <span>Vegetable’s Package</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Product Details Section Begin -->
<section class="product-details spad">
    <div class="container">
        <div class="row">
            <!-- Product Image Column -->
            <div class="col-lg-6 col-md-6">
                <div class="product__details__pic">
                    <div class="product__details__pic__item">
                        <img src="{{ asset($book->cover_image ?? 'path/to/default-image.jpg') }}" 
                             alt="{{ $book->title }}" 
                             class="img-fluid" 
                             width="300" 
                             height="auto">
                    </div>
                    @if ($book->cover_images && $book->cover_images->isNotEmpty())
                        <div class="product__details__pic__slider owl-carousel">
                            @foreach($book->cover_images as $image)
                                <img data-imgbigurl="{{ asset($image->image_path ?? 'path/to/default-image.jpg') }}" 
                                     src="{{ asset($image->image_path ?? 'path/to/default-image.jpg') }}" 
                                     alt="{{ $book->title }}">
                            @endforeach
                        </div>
                    @else
                        <p>Không có hình ảnh bổ sung.</p>
                    @endif
                </div>
            </div>
            
            <!-- Product Information Column -->
            <div class="col-lg-6 col-md-6">
                <div class="product__details__text">
                    <h3>{{ $book->title }}</h3>
                    <div class="product__details__rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fa {{ $i <= 4.5 ? 'fa-star' : 'fa-star-half-o' }}"></i>
                        @endfor
                        <span>(18 reviews)</span>
                    </div>
                    <div class="product__details__price">
                        @if ($book->sale_price)
                            <span style="text-decoration: line-through; color: #aaa;">
                                {{ number_format($book->price, 0) }} VNĐ
                            </span>
                            <span class="text-danger">{{ number_format($book->sale_price, 0) }} VNĐ</span>
                        @else
                            <span>{{ number_format($book->price, 0) }} VNĐ</span>
                        @endif
                    </div>
                    <p>{{ $book->description }}</p>

                    @if ($book->pdf_file && file_exists(public_path($book->pdf_file)))
                        <object data="{{ asset($book->pdf_file) }}" 
                                type="application/pdf" 
                                class="pdf-viewer" 
                                width="100%" 
                                height="500">
                            <p>PDF không thể tải. <a href="{{ asset($book->pdf_file) }}">Tải về tại đây</a>.</p>
                        </object>
                    @else
                        <p>Không có file PDF để hiển thị.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="product__details__tab mt-5">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab" aria-selected="true">Description</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab" aria-selected="false">Information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab" aria-selected="false">Reviews ({{ $reviews->count() }})</a>
                </li>
            </ul>
            <div class="tab-content">
                <!-- Description Tab -->
                <div class="tab-pane active" id="tabs-1" role="tabpanel">
                    <div class="product__details__tab__desc">
                        <h6>Product Description</h6>
                        <p>{{ $book->description }}</p>
                    </div>
                </div>
                <!-- Information Tab -->
                <div class="tab-pane" id="tabs-2" role="tabpanel">
                    <div class="product__details__tab__desc">
                        <h6>Product Information</h6>
                        <ul>
                            <li><b>Publisher:</b> {{ $book->publisher }}</li>
                            <li><b>ISBN:</b> {{ $book->isbn }}</li>
                            <li><b>Published Date:</b> {{ $book->published_date }}</li>
                            <li><b>Author:</b> {{ $book->author }}</li>
                            <li><b>Availability:</b> {{ $book->stock ? 'In Stock' : 'Out of Stock' }}</li>
                        </ul>
                    </div>
                </div>
                <!-- Reviews Tab -->
                <div class="tab-pane" id="tabs-3" role="tabpanel">
                    <div class="reviews">
                        @forelse ($reviews as $review)
                            <div class="review">
                                <h5>{{ $review->customer_name }}</h5>
                                <p><strong>Rating:</strong> {{ $review->rating }} / 5</p>
                                <p>{{ $review->review }}</p>
                                <p><small>Posted on: {{ $review->created_at->format('d/m/Y') }}</small></p>
                                <hr>
                            </div>
                        @empty
                            <div class="alert alert-info">Hiện chưa có đánh giá nào. Hãy là người đầu tiên đánh giá sản phẩm này!</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <h3>Comments</h3>
        @if(auth()->check())
            <form action="{{ route('home.comment', $book->book_id) }}" method="POST" role="form">
                @csrf
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Your Name *" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Your Email *" required>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <textarea name="comment" class="form-control" cols="30" rows="8" placeholder="Your Comment *" required></textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-primary">Post Comment</button>
                    </div>
                </div>
            </form>
        @else
            <div class="alert alert-danger">
                <strong>Vui lòng đăng nhập để bình luận.</strong> <a href="{{ route('account.login') }}">Đăng nhập</a>
            </div>
        @endif

        @forelse ($comments as $comm)
            <div class="media mt-4">
                <img class="mr-3 rounded-circle" width="50" src="{{ $comm->avatar ?? 'path/to/default-avatar.jpg' }}" alt="{{$comm->user->name }}">
                <div class="media-body">
                    <h4 class="mt-0">{{ $comm->user->name }} <small>{{ optional($comm->created_at)->format('d/m/Y') }}</small></h4>
                    <p>{{ $comm->comment }}</p>
                    @can('my-comment',$comm)
                    <p class="text-right">
                        <a href="" class="btn btn-primary btn-sm">Sửa</a>
                        <a href="" class="btn btn-danger btn-sm">Xóa</a>
                    </p>
                    @endcan
                </div>
            </div>
        @empty
            <p>Chưa có bình luận nào.</p>
        @endforelse
    </div>
</section>

<!-- Product Details Section End -->

<!-- Related Product Section Begin -->
<section class="related-product">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title related__product__title">
                    <h2>Related Product</h2>
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
                                @if ($item->sale_price && $item->sale_price > 0)
                                    <span style="text-decoration: line-through; color: gray;">{{ number_format($item->price) }} VNĐ</span>
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
</section>
<!-- Related Product Section End -->

@stop