@extends('admin.master')

@section('body')
<div class="container mt-5">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="card-box mb-30">
                <div class="d-flex justify-content-between align-items-center pd-20">
    <h4 class="text-blue h4">{{ isset($comment) ? 'Sửa Bình Luận' : 'Thêm Bình Luận' }}</h4>

    <form action="{{ isset($comment) ? route('comment.update', $comment->comment_id) : route('comment.store') }}" method="POST">
        @csrf
        @if(isset($comment))
            @method('PUT') <!-- Dùng PUT cho chỉnh sửa -->
        @endif

        <!-- ID Sách -->
        <div class="form-group">
            <label for="book_id">ID Sách</label>
            <input type="number" id="book_id" name="book_id" class="form-control" 
                   value="{{ old('book_id', $comment->book_id ?? '') }}" required>
        </div>

        <!-- Nội Dung -->
        <div class="form-group">
            <label for="comment">Nội Dung</label>
            <textarea id="comment" name="comment" class="form-control" rows="4" required>{{ old('comment', $comment->comment ?? '') }}</textarea>
        </div>

        <!-- Trạng Thái -->
        <div class="form-group">
            <label for="status">Trạng Thái</label>
            <select id="status" name="status" class="form-control">
                <option value="1" {{ (isset($comment) && $comment->status == 1) ? 'selected' : '' }}>Duyệt</option>
                <option value="0" {{ (isset($comment) && $comment->status == 0) ? 'selected' : '' }}>Chưa Duyệt</option>
            </select>
        </div>

        <!-- Nút Lưu -->
        <button type="submit" class="btn btn-primary">{{ isset($comment) ? 'Cập Nhật' : 'Thêm Mới' }}</button>
        <a href="{{ route('comment.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Thêm CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#comment'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
