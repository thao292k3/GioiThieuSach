@extends('admin.master')

@section('body')

<!-- Hiển thị thông báo thành công -->
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<!-- Hiển thị thông báo lỗi -->
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Form Sửa Bài Viết -->
<div class="container">
    <div class="row-4">
        <div class="col-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-blue h4">Chỉnh sửa bài viết</h4>
                        <p class="mb-30">Cập nhật thông tin bài viết</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('blog.update', $blog->blog_id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="title">Tiêu đề bài viết</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $blog->title) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="content">Nội dung</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content', $blog->content) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="category_id">Danh mục</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            @foreach ($categories as $category)
                            <option value="{{ $category->category_id }}" {{ $blog->category_id == $category->category_id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="pending" {{ $blog->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $blog->status == 'approved' ? 'selected' : '' }}>Approved</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="image_path">Hình ảnh (nếu muốn thay đổi)</label>
                        <input type="file" class="form-control" id="image_path" name="image_path">
                        @if ($blog->image_path)
                        <img src="{{ asset('storage/' . $blog->image_path) }}" alt="Blog Image" style="max-width: 150px; margin-top: 10px;">
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <a href="{{ route('blog.index') }}" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
