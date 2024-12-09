@extends('admin.master')

@section('body')
<div class="container">
    <div class="row-5">
        <div class="col-12">
            <div class="card-box pd-20 mb-30">
                <h4 class="text-blue h4">Chi Tiết bài viết </h4>
                <p><strong>Tiêu đề bài viết :</strong> {{ $blog->title}}</p>
                <p><strong>Nội dung:</strong> {{ $blog->content }}</p>
                <p><strong>Hình ảnh bài viết :</strong></p>
                <img src="{{ asset($blog->image_path) }}" alt="{{ $blog->title }}" style="max-width: 100%; height: auto;">

                <p><strong>Người dùng:</strong> {{ $blog->user->name ?? 'Không xác định' }}</p>
                <p><strong>Ngày đăng:</strong> {{ \Carbon\Carbon::parse($blog->date)->format('d/m/Y H:i') }}</p>

                <p><strong>Lượt thích:</strong> {{ $blog->likes}}</p>
                <p><strong>Số lượng comment:</strong> {{ $blog->comment_count }}</p>
                <p><strong>Trạng thái:</strong> {{ $blog->status}}</p>
                <p><strong>Thể loại:</strong> {{ $blog->category->name ?? 'Không xác định' }}</p>
                <p><strong>Số lượng lượt thích :</strong> {{ $blog->likes_count }}</p>
                
                <a href="{{ route('blog.index') }}" class="btn btn-secondary">Quay Lại</a>

            </div>
        </div>
    </div>
    @endsection