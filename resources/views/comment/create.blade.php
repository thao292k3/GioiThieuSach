@extends('admin.master')

@section('body')
<div class="container mt-5">
    <h4 class="text-blue h4">{{ isset($comment) ? 'Sửa Bình Luận' : 'Thêm Bình Luận' }}</h4>

    <form method="POST" action="{{ isset($comment) ? route('comments.update', $comment->comment_id) : route('comments.store') }}">
        @csrf
        <div class="form-group">
            <label>ID Sách</label>
            <input type="text" name="book_id" class="form-control" value="{{ $comment->book_id ?? '' }}">
        </div>
        <div class="form-group">
            <label>Nội Dung</label>
            <textarea name="comment" class="form-control">{{ $comment->comment ?? '' }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
</div>
@endsection
