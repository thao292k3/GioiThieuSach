@extends('site.master')

@section('title', 'Trang Liên Hệ')

@section('body')

<div class="contact-form spad">
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sách </th>
                    <th>Giá sách</th>
                    <th>Ngày yêu thích </th>
                    <th>Hình ảnh sách </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($favorites as $item)
                <tr>
                    <td scope="row">{{ $loop->index + 1 }}</td>
                    <td>{{ $item->prod->title }}</td>
                    <td>{{ $item->prod->price }} / {{ $item->prod->sale_price }}</td>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>
                        <img src="{{ asset("storage/uploads/". $item->prod->cover_image) }}" width="60" alt="{{ $item->prod->title }}">
                    </td>
                    <td>
                            <a title="Bỏ thích" onclick="return confirm('Bạn có muốn bỏ thích không?')" href="{{ route('home.favorite', $item->book_id) }}">
                                <i class="fas fa-heart" style="color: red;"></i>
                            </a>                                
                    </td>
                </tr>
                @endforeach
            </tbody>
            
        </table>
    </div>
</div>

@stop
