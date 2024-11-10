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
    <div class="row">
        <div class="col-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-blue h4">Sửa Sách</h4>
                        <p class="mb-30">Vui lòng điền thông tin chi tiết bên dưới</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('book.update', $book->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Tên Sách -->
                    <div class="form-group">
                        <label for="title">Tên Sách</label>
                        <input class="form-control" type="text" name="title" id="title" placeholder="Nhập tên sách" value="{{ old('title', $book->title ?? '') }}">
                        @error('title')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Tác Giả -->
                    <div class="form-group">
                        <label for="author">Tác Giả</label>
                        <input class="form-control" name="author" id="author" placeholder="Nhập tên tác giả" value="{{ old('author', $book->author ?? '') }}">
                        @error('author')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Nhà Xuất Bản -->
                    <div class="form-group">
                        <label for="publisher">Nhà Xuất Bản</label>
                        <input class="form-control" name="publisher" id="publisher" placeholder="Nhập nhà xuất bản" value="{{ old('publisher', $book->publisher ?? '') }}">
                        @error('publisher')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Ngày Xuất Bản -->
                    <div class="form-group">
                        <label for="published_date">Ngày Xuất Bản</label>
                        <input class="form-control" name="published_date" id="published_date" type="date" value="{{ old('published_date', $book->published_date ?? '') }}">
                        @error('published_date')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- ISBN -->
                    <div class="form-group">
                        <label for="isbn">ISBN</label>
                        <input class="form-control" name="isbn" id="isbn" placeholder="Nhập mã ISBN" value="{{ old('isbn', $book->isbn ?? '') }}">
                        @error('isbn')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Giá -->
                    <div class="form-group">
                        <label for="price">Giá</label>
                        <input class="form-control" name="price" id="price" placeholder="Nhập giá" value="{{ old('price', $book->price ?? '') }}">
                        @error('price')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Trạng Thái -->
                    <div class="form-group">
                        <label for="status">Trạng Thái</label>
                        <select class="form-control" name="status" id="status">
                            <option value="1" {{ old('status', $book->status ?? '') == 1 ? 'selected' : '' }}>Hiển Thị</option>
                            <option value="0" {{ old('status', $book->status ?? '') == 0 ? 'selected' : '' }}>Ẩn</option>
                        </select>
                    </div>


                    <!-- Danh Mục -->
                    <div class="form-group">
                        <label for="category_id">Danh Mục</label>
                        <select class="form-control" name="category_id" id="category_id">
                            @foreach($cats as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $book->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Ảnh Bìa -->
                    <div class="form-group">
                        <label for="cover_image">Ảnh Bìa</label>
                        <input type="file" name="cover_image" id="cover_image" class="form-control-file">
                        @if(isset($book) && $book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Current Cover" class="mt-2" width="100">
                        @endif
                    </div>

                    <!-- Mô Tả -->
                    <div class="form-group">
                        <label for="description">Mô Tả</label>
                        <textarea class="form-control" name="description" id="description" rows="4" placeholder="Nhập mô tả sách">{{ old('description', $book->description ?? '') }}</textarea>
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