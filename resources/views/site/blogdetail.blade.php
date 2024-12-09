@extends('site.master')

@section('title', $blog->title)

@section('body')

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>{{ $blog->title }}</h2>
                    <div class="breadcrumb__option">
                        <a href="./index.html">Home</a>
                        <span>Blog</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Blog Detail Section Begin -->
<section class="blog-detail spad">
    <div class="container">
        <div class="blog__detail">
            <img src="{{ asset($blog->image_path) }}" alt="{{ $blog->title }}">
            <h1>{{ $blog->title }}</h1>
            <div class="post-meta">
                <span>Ngày đăng: {{ $blog->created_at->format('d/m/Y') }}</span>
                <span>Lượt thích: {{ $blog->likes_count }}</span>
                <span>Bình luận: {{ $blog->comments_count }}</span>
            </div>
            <div class="content">
                <p>{{ $blog->content }}</p>
            </div>
        </div>

        <!-- Recent Posts Section -->
        <div class="recent-posts">
            <h4>Bài viết gần đây</h4>
            @foreach($recentBlogs as $recentBlog)
                <div class="recent-item">
                    <img src="{{ asset($recentBlog->image_path) }}" alt="{{ $recentBlog->title }}">
                    <div class="recent-title">
                        <a href="{{ route('blogdetail', $recentBlog->blog_id) }}">
                            {{ Str::limit($recentBlog->title, 50) }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Blog Detail Section End -->

@stop
