<section class="bg0 p-t-75 p-b-120">
    <div class="container">
        <div class="row p-b-148">
            <div class="col-md-7 col-lg-8">
                <div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md">
                    <h3 class="mtext-111 cl2 p-b-16">
                        Câu chuyện của chúng tôi - ChicWear
                    </h3>

                    <p class="stext-113 cl6 p-b-26">
                        Chào mừng bạn đến với ChicWear – nơi tôn vinh phong cách và sự tự tin của bạn!
                    </p>
                    <p class="stext-113 cl6 p-b-26">
                        ChicWear ra đời với mong muốn mang đến cho bạn những bộ trang phục không chỉ đẹp mà còn thể hiện
                        cá tính riêng. Chúng tôi tin rằng thời trang không chỉ là quần áo, mà còn là cách bạn thể hiện
                        bản thân với thế giới.
                    </p>

                    <p class="stext-113 cl6 p-b-26">
                        Với sự chọn lọc kỹ lưỡng từ chất liệu đến thiết kế, ChicWear luôn cập nhật những xu hướng mới
                        nhất, giúp bạn luôn nổi bật dù là trong công việc, dạo phố hay những buổi tiệc sang trọng.
                    </p>

                    <p class="stext-113 cl6 p-b-26">
                        Hãy để ChicWear đồng hành cùng bạn trên hành trình khẳng định phong cách!
                    </p>

                    <p class="stext-113 cl6 p-b-26">
                        Bạn có thắc mắc gì không? Nếu có hãy liên hệ cho chúng tôi theo số (+84) 96 716 687
                    </p>
                </div>
            </div>

            <div class="col-11 col-md-5 col-lg-4 m-lr-auto">
                <div class="how-bor1 ">
                    <div class="hov-img0">
                        <img src="images/about-01.jpg" alt="IMG">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="order-md-2 col-md-7 col-lg-8 p-b-30">
                <div class="p-t-7 p-l-85 p-l-15-lg p-l-0-md">
                    <h3 class="mtext-111 cl2 p-b-16">
                        Sứ mệnh của chúng tôi
                    </h3>

                    <p class="stext-113 cl6 p-b-26">
                        ChicWear ra đời với sứ mệnh mang đến cho bạn không chỉ những bộ trang phục đẹp mà còn giúp bạn
                        thể hiện cá tính và phong cách riêng. Chúng tôi tin rằng thời trang không chỉ là quần áo, mà còn
                        là cách bạn thể hiện bản thân với thế giới. Với sự chọn lọc kỹ lưỡng từ chất liệu đến thiết kế,
                        ChicWear luôn cập nhật những xu hướng mới nhất, giúp bạn tự tin tỏa sáng trong mọi khoảnh khắc –
                        từ công việc, dạo phố đến những buổi tiệc sang trọng. Cam kết của chúng tôi là mang đến những
                        sản phẩm chất lượng cao, đường may tinh tế, phù hợp với mọi phong cách, từ thanh lịch, cá tính
                        đến năng động. Không chỉ theo đuổi xu hướng, ChicWear đặt khách hàng lên hàng đầu, luôn nỗ lực
                        để mang đến trải nghiệm mua sắm tuyệt vời và giúp bạn tỏa sáng theo cách riêng của mình. Hãy để
                        ChicWear đồng hành cùng bạn trên hành trình khẳng định phong cách!
                    </p>

                    <div class="bor16 p-l-29 p-b-9 m-t-22">
                        <p class="stext-114 cl6 p-r-40 p-b-11">
                            Sáng tạo chỉ là kết nối mọi thứ. Khi bạn hỏi những người sáng tạo cách họ làm điều gì đó, họ
                            cảm thấy hơi tội lỗi vì họ không thực sự làm điều đó, họ chỉ thấy điều gì đó. Sau một thời
                            gian, điều đó có vẻ hiển nhiên với họ.
                        </p>

                        <span class="stext-111 cl8">
                            - Steve Job’s
                        </span>
                    </div>
                </div>
            </div>

            <div class="order-md-1 col-11 col-md-5 col-lg-4 m-lr-auto p-b-30">
                <div class="how-bor2">
                    <div class="hov-img0">
                        <img src="images/about-02.jpg" alt="IMG">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
    $admin = \App\Models\User::whereHas('roles', function($query) {
        $query->where('id', 1); // 1 là role Admin
    })->first();
    @endphp
    @if(auth()->check() && auth()->user()->hasRole([4, 5]) )
    {{-- Cộng tác viên (4) hoặc Khách hàng (5) --}}
    <a href="{{ url('chatify/' . $admin->id) }}" target="_blank" class="floating-button">
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
</section>
