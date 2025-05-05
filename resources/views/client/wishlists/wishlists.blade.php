@extends ('client.master')

@section('title', 'Sản phẩm yêu thích')

<style>
    /* Ví dụ CSS (Giữ nguyên hoặc sửa đổi từ code trước) */
    .wishlist-product-item {
        display: flex;
        align-items: center;
        padding: 15px;
        border: 1px solid #eee;
        margin-bottom: 15px;
        border-radius: 8px;
        background-color: #fff;
        /* Thêm nền trắng */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        /* Thêm bóng đổ nhẹ */
        transition: box-shadow 0.3s ease;
    }

    .wishlist-product-item:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Hiệu ứng khi hover */
    }

    .wishlist-product-item img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        margin-right: 20px;
        /* Tăng khoảng cách */
        border-radius: 4px;
        border: 1px solid #eee;
        /* Thêm viền nhẹ cho ảnh */
    }

    .wishlist-product-info {
        flex-grow: 1;
    }

    .wishlist-product-info a.stext-104 {
        font-size: 1rem;
        /* Tăng cỡ chữ tên SP */
        font-weight: 500;
        color: #333;
    }

    .wishlist-product-info .stext-105 {
        font-size: 0.95rem;
        /* Cỡ chữ giá */
        font-weight: 600;
        color: #e65540;
        /* Màu giá */
        margin-top: 5px;
    }

    .wishlist-actions {
        margin-left: auto;
        /* Đẩy nút sang phải */
        padding-left: 20px;
        /* Thêm khoảng cách trái */
        white-space: nowrap;
        /* Ngăn nút xuống dòng */
        display: flex;
        /* Dùng flex cho các nút */
        align-items: center;
        /* Căn giữa các nút */
        gap: 10px;
        /* Khoảng cách giữa các nút */
    }

    .wishlist-actions form {
        display: inline-block;
    }

    .wishlist-actions .btn {
        /* Style chung cho các nút */
        padding: 6px 12px;
        font-size: 0.85rem;
    }

    /* CSS cho thông báo danh sách trống */
    .empty-wishlist-message {
        text-align: center;
        padding: 50px 20px;
        border: 1px dashed #ccc;
        border-radius: 8px;
        background-color: #f8f9fa;
    }

    .empty-wishlist-message p {
        font-size: 1.1rem;
        color: #6c757d;
        margin-bottom: 20px;
    }
</style>

@section('content')
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="index.html" class="stext-109 cl8 hov-cl1 trans-04" style="font-size: 16px">
                Trang chủ
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4" style="font-size: 16px">
                Sản phẩm yêu thích
            </span>
        </div>
    </div>

    {{-- Nội dung trang --}}
    <div class="container bg0 p-t-50 p-b-85">
        <h4 class="mtext-109 cl2 p-b-30 txt-center"> Danh Sách Yêu Thích Của Bạn </h4>

        {{-- Hiển thị thông báo (nếu có từ controller remove) --}}
        @if (session('success'))
            <div class="alert alert-success"> {{ session('success') }} </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger"> {{ session('error') }} </div>
        @endif
        @if (session('info'))
            <div class="alert alert-info"> {{ session('info') }} </div>
        @endif

        <div class="row">
            <div class="col-lg-12">

                {{-- === SỬ DỤNG VÒNG LẶP VÀ DỮ LIỆU ĐỘNG === --}}
                @forelse ($wishlistProducts as $product)
                    <div class="wishlist-product-item">
                        @php
                            $imageUrl = $product->image
                                ? Storage::url($product->image)
                                : asset('client/images/no-image-available.png');
                        @endphp
                        <a href="{{ route('client.product.show', $product->id) }}">
                            <img src="{{ $imageUrl }}" alt="{{ $product->name }}">
                        </a>
                        <div class="wishlist-product-info">
                            <a href="{{ route('client.product.show', $product->id) }}"
                                class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                {{ $product->name }}
                            </a>
                            <div class="stext-105 cl3">
                                {{-- Hiển thị giá - có thể cần kiểm tra giá khuyến mãi nếu có --}}
                                {{ number_format($product->price, 0, ',', '.') }} VNĐ
                            </div>
                            {{-- Có thể thêm thông tin khác nếu cần --}}
                        </div>
                        <div class="wishlist-actions">
                            {{-- Nút xem chi tiết --}}
                            <a href="{{ route('client.product.show', $product->id) }}"
                                class="btn btn-sm btn-outline-primary">Xem chi tiết</a>
                            {{-- Nút Xóa khỏi Wishlist (Form trỏ đến route thật) --}}
                            <form action="{{ route('client.removeWishlist', $product->id) }}" method="POST"
                                onsubmit="return confirm('Bạn chắc chắn muốn xóa sản phẩm này khỏi danh sách yêu thích?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fa fa-trash"></i> Xóa
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    {{-- Hiển thị nếu danh sách trống --}}
                    <div class="empty-wishlist-message">
                        <p>Danh sách yêu thích của bạn đang trống.</p>
                        <a href="{{ route('client.product.index') }}"
                            class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                            Tiếp tục mua sắm
                        </a>
                    </div>
                @endforelse
                {{-- === KẾT THÚC SỬ DỤNG VÒNG LẶP === --}}

            </div>
        </div>

        {{-- Phân trang --}}
        <div class="d-flex justify-content-center p-t-30">
            {{ $wishlistProducts->links() }} {{-- Hiển thị links phân trang --}}
        </div>

    </div>
@endsection
