@extends('admin.master')

@section('body')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.0/classic/ckeditor.js"></script>

<!-- Form Sửa Thể Loại Sách -->
<div class="container">
    <div class="row-4">
        <div class="col-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-blue h4">Cập nhật damh mục sách</h4>
                        <p class="mb-30">Vui lòng điền thông tin chi tiết bên dưới</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('category.update', $category->category_id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="category_id" value="{{$category->category_id}}">
                    <!-- Tên Thể Loại -->
                    <div class="form-group">
                        <label for="name">Tên Thể Loại</label>
                        <input class="form-control" type="text" name="name" id="name" placeholder="Nhập tên thể loại" value="{{ old('name', $category->name ?? '') }}">
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="parent_id">Danh mục cha</label>
                        <select class="form-control" id="parent_id" name="parent_id">
                            <option value="">Chọn danh mục cha</option>
                            @foreach($data as $model)
                                <option 
                                    value="{{ $model->category_id }}" 
                                    {{ isset($category->parent_id) && $category->parent_id == $model->category_id ? 'selected' : '' }}>
                                    {{ $model->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    

                    <!-- Trạng Thái -->
                    <div class="form-group">
                        <label for="status">Trạng Thái</label>
                        <select class="form-control" name="status" id="status">
                            <option value="0" {{ old('status', $category->status ?? '') == '0' ? 'selected' : '' }}>Hiển Thị</option>
                            <option value="1" {{ old('status', $category->status ?? '') == '1' ? 'selected' : '' }}>Ẩn</option>
                        </select>
                    </div>

                    <!-- Mô Tả -->
                    <div class="form-group">
                        <label for="description">Mô Tả</label>
                        <textarea class="form-control" name="description" id="description" rows="10" placeholder="Nhập mô tả thể loại">{{ old('description', $category->description ?? '') }}</textarea>
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

<script>
    ClassicEditor
        .create(document.querySelector('#description'), {
            // Các tùy chọn cấu hình khác
            toolbar: [
                'heading',
                '|',
                'bold',
                'italic',
                'underline',
                'link',
                'imageUpload',
                '|',
                'bulletedList',
                'numberedList',
                '|',
                'blockQuote',
                'code',
                '|',
                'insertTable',
                'mediaEmbed',
                '|',
                'undo',
                'redo'
            ],
            language: 'vi', // Đặt ngôn ngữ là tiếng Việt (tùy chọn)
            image: {
                toolbar: ['imageTextAlternative', 'imageStyle:full', 'imageStyle:side'],
                uploadUrl: '/upload-image' // Đường dẫn đến API upload ảnh của bạn
            },
            table: {
                contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
            },
            licenseKey: 'YOUR_LICENSE_KEY' // Nếu bạn sử dụng phiên bản thương mại
        })
        .then(editor => {
            console.log('Editor was initialized', editor);
        })
        .catch(error => {
            console.error('There was a problem', error);
        });
</script>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
@endsection