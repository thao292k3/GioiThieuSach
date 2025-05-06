<div style="border: 3px solid green; padding: 20px; background: lightblue; border-radius: 8px; font-family: Arial, sans-serif; color: #333; max-width: 700px; margin: auto;">
    <h3 style="margin-top: 0;">Xin chào {{ $order->name }}</h3>
    <p>Cảm ơn bạn đã đặt hàng. Dưới đây là chi tiết đơn hàng của bạn:</p>

    <h4>Thông tin người nhận</h4>
    <p><strong>Email:</strong> {{ $order->email }}</p>
    <p><strong>Điện thoại:</strong> {{ $order->phone }}</p>
    <p><strong>Địa chỉ giao hàng:</strong> {{ $order->address }}</p>

    <h4 style="margin-top: 30px;">Chi tiết đơn hàng</h4>
    <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; background: #fff;">
        <thead style="background: #ddd;">
            <tr>
                <th style="text-align: center;">STT</th>
                <th style="text-align: left;">Sản phẩm</th>
                <th style="text-align: right;">Giá</th>
                <th style="text-align: center;">Số lượng</th>
                <th style="text-align: right;">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->details as $detail)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $detail->book->title ?? '[Sách đã xóa]' }}</td>
                    <td style="text-align: right;">{{ number_format($detail->price) }} VND</td>
                    <td style="text-align: center;">{{ $detail->quantity }}</td>
                    <td style="text-align: right;">{{ number_format($detail->price * $detail->quantity) }} VND</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 25px;">Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi.</p>
</div>