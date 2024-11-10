@extends('admin.master')

@section('body')

<!-- Form Thêm Mới Thể Loại Sách -->
<div class="container">
    <div class="row-2">
        <div class="col-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-blue h4">Thêm Mới Thể Loại Sách</h4>
                        <p class="mb-30">Vui lòng điền thông tin chi tiết bên dưới</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('category.store') }}">
                    @csrf

                    <!-- Tên Thể Loại -->
                    <div class="form-group">
                        <label for="name">Tên Thể Loại</label>
                        <input class="form-control" type="text" name="name" id="name" placeholder="Nhập tên thể loại" value="{{ old('name') }}">
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Trạng Thái -->
                    <div class="form-group">
                        <label for="status">Trạng Thái</label>
                        <select class="form-control" name="status" id="status">
                            <option value="1">Hiển Thị</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>

                    <!-- Mô Tả -->
                    <div class="form-group">
                        <label for="description">Mô Tả</label>
                        <textarea class="form-control" name="description" id="description" rows="4" placeholder="Nhập mô tả thể loại">{{ old('description') }}</textarea>
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