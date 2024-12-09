@extends('admin.master')

@section('body')

<!-- Hiển thị thông báo thành công -->
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<!-- Hiển thị thông báo lỗi -->
@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<!-- Form Thêm Mới Sách -->
<div class="container">
    <div class="row-4">
        <div class="col-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-blue h4">Danh bài viết </h4>
                        <p class="mb-30">Danh sách bài viết hiện có</p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tiêu đề</th>
                                <th>Nội dung</th>
                                <th>Ngày đăng</th>
                                <th>Lượt thích</th>
                                <th>Số comment</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $blog)
                            <tr>
                                <td>{{ $blog->blog_id }}</td>
                                <td>{{ $blog->title }}</td>
                                <td>{{ $blog->content }}</td>
                                <td>{{ $blog->date ? \Carbon\Carbon::parse($blog->date)->format('d/m/Y') : 'N/A' }}</td>
                                <td>{{ $blog->likes }}</td>
                                <td>{{ $blog->comment_count }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" href="{{ route('blog.show', $blog->blog_id) }}"><i class="dw dw-eye"></i> View</a>
                                            <a class="dropdown-item" href="{{ route('blog.edit', $blog->blog_id) }}"><i class="dw dw-edit2"></i> Edit</a>
                                            <form method="post" action="{{ route('blog.destroy', $blog->blog_id) }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item" type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                    <i class="dw dw-delete-3"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Phân trang -->
                {{ $data->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

@endsection