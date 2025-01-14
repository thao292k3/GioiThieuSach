@extends('admin.master')

@section('body')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.0/classic/ckeditor.js"></script>

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<!-- Hiển thị thông báo lỗi (nếu có) -->
@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<form method="POST" action="{{ route('book.update', $book->book_id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

<div class="container">
    <div class="row-5">
        <div class="col-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-blue h4">Sửa Sách</h4>
                        <p class="mb-30">Vui lòng điền thông tin chi tiết bên dưới</p>
                    </div>
                </div>

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

                <!-- Giá Sale -->
                <div class="form-group">
                    <label for="sale_price">Giá Sale</label>
                    <input class="form-control" name="sale_price" id="sale_price" placeholder="Nhập giá sale" value="{{ old('sale_price', $book->sale_price ?? '') }}">
                    @error('sale_price')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Trạng Thái -->
                <div class="form-group">
                    <label for="status">Trạng Thái</label>
                    <select class="form-control" name="status" id="status">
                        <option value="1" @selected(old('status', $book->status ?? '') == 1)>Hiển Thị</option>
                        <option value="0" @selected(old('status', $book->status ?? '') == 0)>Ẩn</option>
                    </select>
                </div>

                <!-- Danh Mục -->
                <div class="form-group">
                    <label for="category_id">Danh Mục</label>
                    <select class="form-control" name="category_id" id="category_id">
                        @foreach($cats as $cat)
                            <option value="{{ $cat->category_id }}" @selected(old('category_id', $book->category_id ?? '') == $cat->category_id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Ảnh Bìa -->
                <div class="form-group">
                    <label for="cover_image">Ảnh Bìa</label>
                    <input type="file" name="cover_image" id="cover_image" class="form-control-file">
                    @if(isset($book) && $book->cover_image)
                    <img src="{{ asset($book->cover_image) }}" alt="Current Cover" class="mt-2" width="100">
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

                
                <!-- Ảnh Bìa -->
                <div class="form-group">
                    <label for="pdf_file">File PDF</label>
                    <input type="file" name="pdf_file" id="pdf_file" class="form-control-file">
                    @if(isset($book) && $book->pdf_file)
                    <img src="{{ asset($book->pdf_file) }}" alt="Current Cover" class="mt-2" width="100">
                    @endif
                </div>

                <!-- Nút Gửi -->
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Lưu Sách</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

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