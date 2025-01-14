@extends('admin.master')

@section('body')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.0/classic/ckeditor.js"></script>

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

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('category.store') }}" novalidate>
                    @csrf

                    <!-- Tên Thể Loại -->
                    <div class="form-group @error('name') has-danger @enderror">
                        <label for="name" class="form-control-label">Tên Thể Loại</label>
                        <input 
                            class="form-control @error('name') form-control-danger @enderror" 
                            type="text" 
                            name="name" 
                            id="name" 
                            placeholder="Nhập tên thể loại" 
                            value="{{ old('name')  }}"
                        >
                        @error('name')
                        <div class="form-control-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Danh Mục Cha -->
                    <div class="form-group">
                        <label for="parent_id">Danh mục cha</label>
                        <select class="form-control" id="parent_id" name="parent_id">
                            <option value="">Chọn danh mục cha</option>
                            @foreach($data as $model)
                                <option 
                                    value="{{ $model->category_id }}" 
                                    {{ old('parent_id') == $model->category_id ? 'selected' : '' }}>
                                    {{ $model->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Trạng Thái -->
                    <div class="form-group">
                        <label for="status">Trạng Thái</label>
                        <select class="form-control" name="status" id="status">
                            <option value="0" {{ old('status', 0) == '0' ? 'selected' : '' }}>Hiển Thị</option>
                            <option value="1" {{ old('status', 0) == '1' ? 'selected' : '' }}>Ẩn</option>
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

@push('scripts')
<script>
    ClassicEditor
        .create(document.querySelector('#description'))
        .catch(error => {
            console.error(error);
        });
</script>
@endpush
@endsection
