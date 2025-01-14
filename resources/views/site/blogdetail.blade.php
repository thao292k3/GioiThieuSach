@extends('site.master')

@section('title', $blog->title)

@section('body')

<section class="blog-detail-section bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="blog-post">
                    <img src="{{ asset($blog->image_path) }}" alt="{{ $blog->title }}" class="img-fluid mb-4 rounded">
                    <h1 class="mb-3">{{ $blog->title }}</h1>
                    <p class="text-muted mb-4">
                        <i class="far fa-calendar-alt"></i> {{ $blog->created_at->format('d/m/Y') }}
                        <i class="far fa-heart"></i> {{ $blog->likes_count }}
                        <i class="far fa-comments"></i> {{ $blog->comments_count }}
                    </p>

                    <div class="blog-content">
                        {!! $blog->content !!} 
                    </div>
                </div>

                <div class="comments-section mt-5">
                    <h4>Comments ({{ $blog->comments_count }})</h4>
                    <hr>

                    @if($blog->comments->count() > 0)
                        @foreach($blog->comments as $comment)
                            <div class="media mb-4">
                                <img src="{{ asset('assets/images/avatar/1.jpg') }}" alt="Avatar" class="mr-3 rounded-circle" width="40">
                                <div class="media-body">
                                    <h5 class="mt-0">{{ $comment->user->name }}</h5>
                                    <p>{{ $comment->comment }}</p>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>Be the first to comment!</p>
                    @endif

                    <h4 class="mt-4">Leave a Comment</h4>
                    <hr>

                    <form class="comment-form" method="POST" action="{{ route('blog.comment', $blog->blog_id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="Enter your comment" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Comment</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sidebar">
                    <h4 class="mb-3">Recent Posts</h4>
                    <ul class="list-group">
                        @foreach($recentBlogs as $recentBlog)
                            <li class="list-group-item">
                                <a href="{{ route('blogdetail', $recentBlog->blog_id) }}">{{ Str::limit($recentBlog->title, 50) }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@stop