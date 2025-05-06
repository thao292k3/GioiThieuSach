@extends('admin.master')

@section('body')
<div class="container">
    <div class="row-5">
        <div class="col-12">
            <div class="card-box pd-20 mb-30">
                <h4 class="text-blue h4">Chi Tiết Sách</h4>

                <p><strong>ID Sách:</strong> {{ $book->book_id }}</p>
                <p><strong>Tên Sách:</strong> {{ $book->title }}</p>
                <p><strong>Slug:</strong> {{ $book->slug }}</p>
                <p><strong>Tác Giả:</strong> {{ $book->author }}</p>
                <p><strong>Nhà Xuất Bản:</strong> {{ $book->publisher }}</p>
                <p><strong>Ngày Xuất Bản:</strong> {{ $book->published_date }}</p>
                <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
                <p><strong>Giá:</strong> {{ number_format($book->price, 0, ',', '.') }} VND</p>
                <p><strong>Giá Sale:</strong> 
                    @if($book->sale_price)
                        {{ number_format($book->sale_price, 0, ',', '.') }} VND
                    @else
                        Không có giá sale
                    @endif
                </p>
                <p><strong>Mô Tả:</strong> {{ $book->description }}</p>
                <p><strong>Trạng Thái:</strong> 
                    {{ $book->status == 1 ? 'Hiển Thị' : 'Ẩn' }}
                </p>
                <p><strong>Thể Loại:</strong> {{ $book->category->name ?? 'Không xác định' }}</p>
                <p><strong>Nổi Bật:</strong> 
                    {{ $book->stock == 1 ? 'Có' : 'Không' }}
                </p>
                <p><strong>Ảnh bìa:</strong></p>
                <img src="{{ asset($book->cover_image) }}" alt="Cover Image" style="max-width: 200px; height: auto;">
                
                <p><strong>Ngày Tạo:</strong> {{ $book->created_at }}</p>
                <p><strong>Ngày Cập Nhật:</strong> {{ $book->updated_at }}</p>

                <p><strong>File PDF:</strong></p>
                @if($book->pdf_file)
                    <a href="{{ asset($book->pdf_file) }}" target="_blank" class="btn btn-info">Xem File PDF</a>
                @else
                    <p>Không có file PDF.</p>
                @endif

                <a href="{{ route('book.index') }}" class="btn btn-secondary mt-3">Quay Lại</a>
            </div>
        </div>
    </div>
</div>
@endsection
