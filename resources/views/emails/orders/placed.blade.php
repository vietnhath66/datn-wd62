<x-mail::message>
# Đặt hàng thành công!

Xin chào **{{ $order->user->name }}**,

Cảm ơn bạn đã đặt hàng tại ChicWear!

Đơn hàng của bạn với mã **#{{ $order->barcode ?? $order->id }}** đã được nhận và đang chờ xử lý.

**Chi tiết đơn hàng:**

<x-mail::table>
| Sản phẩm                 | Số lượng | Đơn giá        | Thành tiền      |
| :----------------------- | :------: | -------------: | --------------: |
@foreach ($order->items as $item)
| {{ optional($item->product)->name ?? 'N/A' }} <br> <small>{{ optional($item->productVariant)->color_name ?? '' }} {{ optional($item->productVariant)->size_name ?? '' }}</small> | {{ $item->quantity }} | {{ number_format($item->price, 0, ',', '.') }} đ | {{ number_format($item->quantity * $item->price, 0, ',', '.') }} đ |
@endforeach
| **Tổng cộng** |          |                | **{{ number_format($order->total, 0, ',', '.') }} đ** |
</x-mail::table>

**Thông tin giao hàng:**

* **Người nhận:** {{ $order->user->name }}
* **Điện thoại:** {{ $order->phone }}
* **Địa chỉ:** {{ implode(', ', array_filter([$order->number_house, $order->address, $order->neighborhood, $order->district, $order->province])) }}

**Phương thức thanh toán:** {{ $order->payment_method == 'cod' ? 'Thanh toán khi nhận hàng (COD)' : 'Thanh toán MOMO' }}

Bạn có thể xem lại chi tiết đơn hàng của mình bằng cách nhấn vào nút bên dưới:

<x-mail::button :url="$orderUrl">
Xem chi tiết đơn hàng
</x-mail::button>

Cảm ơn bạn,<br>
{{ config('app.name') }}
</x-mail::message>