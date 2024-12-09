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

<!-- Form Thêm Mới Bài Viết -->
<div class="container">
    <div class="row-4">
        <div class="col-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-blue h4">Thêm bài viết mới</h4>
                        <p class="mb-30">Điền thông tin bài viết để thêm mới</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('blog.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="title">Tiêu đề bài viết</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Nhập tiêu đề bài viết" required>
                    </div>

                    <div class="form-group">
                        <label for="content">Nội dung</label>
                        <textarea class="form-control" id="content" name="content" rows="5" placeholder="Nhập nội dung bài viết" required>{{ old('content') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="category_id">Danh mục</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="" disabled selected>Chọn danh mục</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="image_path">Hình ảnh</label>
                        <input type="file" name="image_path" id="image_path" class="form-control-file">
                        @if(isset($blog) && $blog->image_path)
                        <img src="{{ asset($blog->image_path) }}" alt="Current Image" class="mt-2" width="100">
                        @endif
                    </div>
                    

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                        <a href="{{ route('blog.index') }}" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
