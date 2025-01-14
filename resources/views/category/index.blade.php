@extends('admin.master')
@section('title', 'Category Manager')
@section('body')
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.1/classic/ckeditor.js"></script>


<div class="main-container">

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
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <!-- Simple Datatable start -->
            <div class="card-box mb-30">
                <div class="d-flex justify-content-between align-items-center pd-20">
                    <h4 class="text-blue h4">Quản lý danh mục sách</h4>
                    <a href="{{route('category.create')}}" class="btn btn-warning btn-sm"><i class="fa fa-plus mr-1"></i>Add New</a>
                </div>
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort">STT</th>
                                <th>Tên danh mục</th>
                                <th>Danh mục cha</th>
                                <th>Mô tả</th>
                                <th>Ngày tạo</th>
                                <th>Trạng thái</th>
                                <th>Số sách</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $model)
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $model->name }}</td>
                            <td>{{ $model->parent_id }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($model->description, 50) }}</td>
                            <td>{{ \Carbon\Carbon::parse($model->create_at)->format('d/m/Y') }}</td>
                            <td>
                                {!! $model->status == 0 
                                    ? "<span class='label label-success'>Hiển thị</span>" 
                                    : "<span class='label label-danger'>Ẩn</span>" !!}
                            </td>                            
                            <td>{{ $model->books->count()}}</td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <form method="post" action="{{ route('category.destroy', $model->category_id) }}">
                                        @csrf
                                        @method('DELETE') <!-- Xác định phương thức DELETE cho route destroy -->
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                          
                                            <a class="dropdown-item" href="{{ route('category.edit', $model->category_id) }}"><i class="dw dw-edit2"></i> Edit</a>

                                            <button class="dropdown-item" type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                <i class="dw dw-delete-3"></i> Delete
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$data->links('pagination::bootstrap-4')}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection