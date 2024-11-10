@extends('admin.master')

@section('body')

<!-- Form Sửa Thể Loại Sách -->
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-blue h4">Sửa Thể Loại Sách</h4>
                        <p class="mb-30">Vui lòng điền thông tin chi tiết bên dưới</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('category.update', $category->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Tên Thể Loại -->
                    <div class="form-group">
                        <label for="name">Tên Thể Loại</label>
                        <input class="form-control" type="text" name="name" id="name" placeholder="Nhập tên thể loại" value="{{ old('name', $category->name ?? '') }}">
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Trạng Thái -->
                    <div class="form-group">
                        <label for="status">Trạng Thái</label>
                        <select class="form-control" name="status" id="status">
                            <option value="1" {{ old('status', $category->status ?? '') == '1' ? 'selected' : '' }}>Hiển Thị</option>
                            <option value="0" {{ old('status', $category->status ?? '') == '0' ? 'selected' : '' }}>Ẩn</option>
                        </select>
                    </div>

                    <!-- Mô Tả -->
                    <div class="form-group">
                        <label for="description">Mô Tả</label>
                        <textarea class="form-control" name="description" id="description" rows="4" placeholder="Nhập mô tả thể loại">{{ old('description', $category->description ?? '') }}</textarea>
                        @error('description')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Nút Gửi -->
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Lưu Thể Loại</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection