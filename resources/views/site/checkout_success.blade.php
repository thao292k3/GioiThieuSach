
@extends('site.master')

@section('title', 'Đặt hàng thành công')

@section('body')
<section class="checkout-success spad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="success-message">
                    <h2 class="text-success">Đặt hàng thành công!</h2>
                    <p>Cảm ơn bạn đã đặt hàng tại cửa hàng của chúng tôi. Chúng tôi sẽ xử lý đơn hàng của bạn trong thời gian sớm nhất.</p>
                    <p>Vui lòng kiểm tra email của bạn để xem chi tiết đơn hàng.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary mt-3">Tiếp tục mua sắm</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection