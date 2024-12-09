@extends('admin.master')

@section('body')
<div class="container">
    <div class="row-5">
        <div class="col-12">
            <div class="card-box pd-20 mb-30">
                <h4 class="text-blue h4">Chi Tiết Sách</h4>

                <p><strong>ID Sách:</strong> {{ $book->book_id }}</p>
                <p><strong>Tên Sách:</strong> {{ $book->title }}</p>
                <p><strong>Tác Giả:</strong> {{ $book->author }}</p>
                <p><strong>Nhà Xuất Bản:</strong> {{ $book->publisher }}</p>
                <p><strong>Ngày Xuất Bản:</strong> {{ $book->published_date }}</p>
                <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
                <p><strong>Giá:</strong> {{ number_format($book->price, 0, ',', '.') }} VND</p>
                <p><strong>Mô Tả:</strong> {{ $book->description }}</p>
                <p><strong>Trạng Thái:</strong> 
                    {{ $book->status == 'published' ? 'Hiển Thị' : 'Ẩn' }}
                </p>
                <p><strong>Thể Loại:</strong> {{ $book->category->name ?? 'Không xác định' }}</p>
                <p><strong>Nổi bật :</strong> {{ $book->stock }}</p>
                <p><strong>Ảnh bìa:</strong></p>
                <img src="{{ asset( $book->cover_image) }}" alt="Cover Image" style="max-width: 200px; height: auto;">
                
                <p><strong>Ngày Tạo:</strong> {{ $book->created_at }}</p>
                <p><strong>Ngày Cập Nhật:</strong> {{ $book->updated_at }}</p>
                <p><strong>Giá sale:</strong> {{ number_format($book->price, 0, ',', '.') }} VND</p>
                <a href="{{ route('book.index') }}" class="btn btn-secondary">Quay Lại</a>
            </div>
        </div>
    </div>
</div>
@endsection