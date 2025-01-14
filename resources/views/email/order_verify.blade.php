<div style="border: 3px solid green; padding: 20px; background: lightblue; border-radius: 8px; font-family: Arial, sans-serif; color: #333;">

    <h3>Hi {{ $order->user->name ?? 'Guest' }}</h3>
    <p>Cảm ơn bạn đã đặt hàng. Dưới đây là chi tiết đơn hàng của bạn:</p>
    
    <h4>Chi tiết đơn hàng</h4>
    <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>STT</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @if($order->details && $order->details->isNotEmpty())

                @foreach ($order->details as $detail)
                <tr>
                    <td style="text-align: center;">{{ $loop->index + 1 }}</td>
                    <td>{{ $detail->book->title ?? 'N/A' }}</td>
                    <td>{{ number_format($detail->price) }} VND</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ number_format($detail->price * $detail->quantity) }} VND</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" style="text-align: center; color: red;">Không có sản phẩm nào trong đơn hàng.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <p>
        <a href="{{ route('order.verify', $token) }}" style="display: inline-block; margin-top: 15px; padding: 10px 25px; background: darkblue; color: #fff; text-decoration: none; border-radius: 5px;">Click here to verify your order</a>
    </p>
    
    <p style="margin-top: 20px;">Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi.</p>
</div>
