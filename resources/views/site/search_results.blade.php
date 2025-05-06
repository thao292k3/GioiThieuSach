@extends('site.master')

@section('title', 'Kết quả tìm kiếm')

@section('body')
<section class="search-results spad">
    <div class="container">
        <h2>Kết quả tìm kiếm cho: "{{ $keyword }}"</h2>

        @if($books->isEmpty())
            <p>Không tìm thấy sách nào phù hợp.</p>
        @else
            <div class="row">
                @foreach($books as $book)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{ asset($book->cover_image) }}">
                                <ul class="product__item__pic__hover">
                                    <li>
                                        <a href="{{ route('shopdetail', ['slug' => $book->slug]) }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('cart.add', $book->book_id) }}">
                                            <i class="fa fa-shopping-cart"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="{{ route('shopdetail', ['slug' => $book->slug]) }}">{{ $book->title }}</a></h6>
                                <h5>{{ number_format($book->price, 0, ',', '.') }} VNĐ</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@stop