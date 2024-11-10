@extends('admin.master')

@section('body')

<!-- Hiển thị thông báo thành công -->
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
<!-- Form Thêm Mới Sách -->
<div class="container">
    <div class="row-1">
        <div class="col-10">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-blue h4">Thêm Mới Sách</h4>
                        <p class="mb-30">Vui lòng điền thông tin chi tiết bên dưới</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('book.store') }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Tên Sách -->
                    <div class="form-group">
                        <label for="name">Tên Sách</label>
                        <input class="form-control" type="text" name="title" id="title" placeholder="Nhập tên sách">
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Tác Giả -->
                    <div class="form-group">
                        <label for="author">Tác Giả</label>
                        <input class="form-control" name="author" id="author" placeholder="Nhập tên tác giả">
                        @error('author')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Nhà Xuất Bản -->
                    <div class="form-group">
                        <label for="publisher">Nhà Xuất Bản</label>
                        <input class="form-control" name="publisher" id="publisher" type="">
                        @error('publisher')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Ngày Xuất Bản -->
                    <div class="form-group">
                        <label for="published_date">Ngày Xuất Bản</label>
                        <input class="form-control" name="published_date" id="published_date" type="date">
                        @error('publisher')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- ISBN -->
                    <div class="form-group">
                        <label for="isbn">ISBN</label>
                        <input class="form-control" name="isbn" id="isbn" placeholder="Nhập mã ISBN">
                        @error('isbn')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Giá -->
                    <div class="form-group">
                        <label for="price">Giá</label>
                        <input class="form-control" name="price" id="price" placeholder="Nhập giá">
                        @error('price')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Trạng Thái -->
                    <div class="form-group">
                        <label for="status">Trạng Thái</label>
                        <select class="form-control" name="status" id="status">
                            <option value="published">Hiển Thị</option>
                            <option value="draft">Ẩn</option>
                        </select>
                    </div>

                    <!-- Danh Mục -->
                    <div class="form-group">
                        <label for="category_id">Danh Mục</label>
                        <select class="form-control" name="category_id" id="category_id">
                            @foreach($cats as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Ảnh Bìa -->
                    <div class="form-group">
                        <label for="image">Ảnh Bìa</label>
                        <input type="file" name="cover_image" id="cover_image" class="form-control-file">
                    </div>

                    <!-- Mô Tả -->
                    <div class="form-group">
                        <label for="description">Mô Tả</label>
                        <textarea class="form-control" name="description" id="description" rows="4" placeholder="Nhập mô tả sách"></textarea>
                        @error('description')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Nút Gửi -->
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Lưu Sách</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection