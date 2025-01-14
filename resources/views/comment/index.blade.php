@extends('admin.master')

@section('body')
<div class="container mt-5">
    <div class="pd-ltr-50 xs-pd-30-30">
        <div class="min-height-200px">
            <div class="card-box mb-80">
                <div class="d-flex justify-content-between align-items-center pd-10">
                    <h4 class="text-blue h4">Quản Lý Bình Luận</h4>
                    <a href="{{ route('comment.create') }}" class="btn btn-primary mb-3">Thêm Bình Luận</a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ID Sách</th>
                            <th>Nội Dung</th>
                            <th>Người Dùng</th>
                            <th>Trạng Thái</th>
                            <th>Ngày Tạo</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comments as $comment)
                            <tr>
                                <td>{{ $comment->comment_id }}</td>
                                <td>{{ $comment->book_id }}</td>
                                <td>{{ $comment->comment }}</td>
                                <td>{{ $comment->user_id }}</td>
                                <td>
                                    @if($comment->status == 1)
                                        <span class="badge badge-success">Đã Duyệt</span>
                                    @else
                                        <span class="badge badge-secondary">Chưa Duyệt</span>
                                    @endif
                                </td>
                                <td>{{ $comment->created_up }}</td>
                                <td>
                                    <a href="{{ route('comment.edit', $comment->comment_id) }}" class="btn btn-sm btn-warning">Sửa</a>
                                    <form action="{{ route('comment.destroy', $comment->comment_id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                    </form>
                                    <form action="{{ route('comment.approve', $comment->comment_id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-info">
                                            {{ $comment->status == 1 ? 'Hủy Duyệt' : 'Duyệt' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
