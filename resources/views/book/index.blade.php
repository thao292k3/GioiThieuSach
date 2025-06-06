@extends('admin.master')

@section('body')

<!-- Hiển thị thông báo thành công -->


<!-- Form Thêm Mới Sách -->
<div class="container">

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
    <div class="row-4">
        
        <div class="col-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-blue h4">Danh Sách Sách</h4>
                        <p class="mb-30">Danh sách các sách hiện có</p>
                       
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên Sách</th>
                                <th>Tác Giả</th>
                                <th>Nhà Xuất Bản</th>
                                <th>ISBN</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $book)
                            <tr>
                                <td>{{ $book->book_id }}</td>
                                <td>{{ $book->title }}</td>
                                <!-- <td>{{ $book->slug }}</td> -->
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->publisher }}</td>
                                <td>{{ $book->isbn }}</td>
                                
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" href="{{ route('book.show', $book->book_id) }}"><i class="dw dw-eye"></i> View</a>
                                            <a class="dropdown-item" href="{{ route('book.edit', $book->book_id) }}"><i class="dw dw-edit2"></i> Edit</a>
                                            <form method="post" action="{{ route('book.destroy', $book->book_id) }}" style="display: inline;">
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