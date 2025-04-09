<section class="bg0 p-t-75 p-b-120">
    <div class="container">
        <div class="row p-b-148">
            <div class="col-md-7 col-lg-8">
                <div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md">
                    <h3 style="font-size: 40px" class="mtext-111 cl2 p-b-16">
                        Chính Sách Đổi Trả
                    </h3>

                    <p style="font-size: 18px" class="stext-113 cl6 p-b-26">
                        Điều kiện: Sản phẩm còn nguyên tem, chưa qua sử dụng. Yêu cầu đổi trả trong 7 ngày.
                    </p>
                    <p style="font-size: 18px" class="stext-113 cl6 p-b-26">
                        Trường hợp: Lỗi từ nhà sản xuất hoặc giao sai mẫu, kích thước.
                    </p>

                    <p style="font-size: 18px" class="stext-113 cl6 p-b-26">
                        Chi phí: Miễn phí với lỗi từ chúng tôi. Khách chịu phí vận chuyển nếu đổi theo sở thích.
                    </p>

                    <p style="font-size: 18px" class="stext-113 cl6 p-b-26">
                        Quy trình: Liên hệ CSKH, cung cấp thông tin, gửi sản phẩm và nhận đổi trả trong 3-5 ngày làm
                        việc.
                    </p>

                </div>
            </div>

            <div class="col-11 col-md-5 col-lg-4 m-lr-auto">
                <div class="how-bor1 ">
                    <div class="hov-img0">
                        <img src="images/policy-01.png" alt="IMG">
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="order-md-2 col-md-7 col-lg-8 p-b-30">
                <div class="p-t-7 p-l-85 p-l-15-lg p-l-0-md">
                    <h3 style="font-size: 40px" class="mtext-111 cl2 p-b-16">
                        Chính Sách Giao Hàng
                    </h3>

                    <p style="font-size: 18px" class="stext-113 cl6 p-b-26">
                        Phạm vi: Toàn quốc.
                    </p>
                    <p style="font-size: 18px" class="stext-113 cl6 p-b-26">
                        Thời gian: Nội thành: 1-3 ngày, ngoại thành: 3-7 ngày.
                    </p>

                    <p style="font-size: 18px" class="stext-113 cl6 p-b-26">
                        Phí: Miễn phí từ 1.000.000 VNĐ; dưới 1.000.000 VNĐ: 30.000đ.
                    </p>

                </div>
            </div>

            <div class="order-md-1 col-11 col-md-5 col-lg-4 m-lr-auto p-b-30">
                <div class="how-bor2">
                    <div class="hov-img0">
                        <img src="images/policy-02.png" alt="IMG">
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 100px" class="row p-b-148">
            <div class="col-md-7 col-lg-8">
                <div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md">
                    <h3 style="font-size: 40px" class="mtext-111 cl2 p-b-16">
                        Chính Sách Bảo Mật
                    </h3>

                    <p style="font-size: 18px" class="stext-113 cl6 p-b-26">
                        Thông tin thu thập: Họ tên, SĐT, địa chỉ, email.
                    </p>
                    <p style="font-size: 18px" class="stext-113 cl6 p-b-26">
                        Cam kết: Không chia sẻ thông tin trừ khi có yêu cầu pháp lý. Bảo mật thông tin bằng các biện
                        pháp an toàn.
                    </p>

                </div>
            </div>

            <div class="col-11 col-md-5 col-lg-4 m-lr-auto">
                <div class="how-bor1 ">
                    <div class="hov-img0">
                        <img src="images/policy-04.png" alt="IMG">
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="order-md-2 col-md-7 col-lg-8 p-b-30">
                <div class="p-t-7 p-l-85 p-l-15-lg p-l-0-md">
                    <h3 style="font-size: 40px" class="mtext-111 cl2 p-b-16">
                        Chính Sách Thanh Toán
                    </h3>

                    <p style="font-size: 18px" class="stext-113 cl6 p-b-26">
                        Phương thức: COD, chuyển khoản ngân hàng, ví điện tử (Momo, VNPay,...). </p>
                    <p style="font-size: 18px" class="stext-113 cl6 p-b-26">
                        Xác nhận: Qua email hoặc điện thoại trong 24 giờ.
                    </p>

                </div>
            </div>

            <div class="order-md-1 col-11 col-md-5 col-lg-4 m-lr-auto p-b-30">
                <div class="how-bor2">
                    <div class="hov-img0">
                        <img src="images/policy-03.png" alt="IMG">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@if(auth()->check() && auth()->user()->hasRole([4, 5]))
    {{-- Cộng tác viên (4) hoặc Khách hàng (5) --}}
    <a href="{{ url('chatify/2') }}" target="_blank" class="floating-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" style="color: #fff" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
            <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
            <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2"/>
        </svg>
    </a>
@elseif(auth()->check() && auth()->user()->hasRole([1, 2, 3]))
    {{-- Admin (1), Nhân viên bán hàng (2), Super Admin (3) --}}
    <a href="{{ url('chatify') }}" target="_blank" class="floating-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" style="color: #fff" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
            <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
            <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2"/>
        </svg>
    </a>
@endif
