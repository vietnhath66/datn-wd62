@extends('client.master')

@section('title', 'Thanh Toán')

@push('style')
    <style>
        h4 {
            font-weight: 600;
            color: #1a2e44;
            margin-bottom: 20px;
        }

        .text-primary {
            color: #1e90ff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .text-primary:hover {
            color: #104e8b;
        }

        .shipping-info,
        .payment-info {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .shipping-info:hover,
        .payment-info:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .product-img {
            width: 130px;
            height: 130px;
            border-radius: 6px;
            object-fit: cover;
            transition: transform 0.3s ease;
            margin-right: 10px
        }

        .product-img:hover {
            transform: scale(1.1);
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #ced4da;
            padding: 12px;
            font-size: 0.95rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: #1e90ff;
            box-shadow: 0 0 10px rgba(30, 144, 255, 0.2);
        }

        .form-label {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .btn-custom {
            background: linear-gradient(90deg, #1e90ff, #00b4d8);
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            color: white;
            font-weight: 500;
            transition: transform 0.3s ease, background 0.3s ease;
        }

        .btn-custom:hover {
            transform: scale(1.05);
            background: linear-gradient(90deg, #104e8b, #008cba);
        }

        .btn-apply-coupon {
            background: #1e90ff;
            border: none;
            border-radius: 10px;
            padding: 5px 20px;
            color: white;
            font-weight: 500;
            font-size: px;
            transition: background 0.3s ease;
        }

        .btn-apply-coupon:hover {
            background: #104e8b;
        }

        .payment-method {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .payment-method:hover {
            border-color: #1e90ff;
            box-shadow: 0 0 10px rgba(30, 144, 255, 0.2);
        }

        .payment-method input[type="radio"] {
            margin-right: 10px;
        }

        .payment-method img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .total-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
        }

        .total-price {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1a2e44;
        }

        hr {
            border-top: 1px solid #e0e0e0;
            margin: 15px 0;
        }

        .coupon-section {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .coupon-section .form-control {
            flex-grow: 1;
        }

        .shipping-info {
            margin-left: 30px;
            /* margin-right: 20px; */
        }

        .payment-info {
            /* margin-left: 20px; */
            margin-right: 30px;
        }

        .title {
            margin-left: 30px;

        }

        .img-product-payment {
            width: 100px;
            height: auto;
            margin-right: 15px
        }

        .suggestions {
            position: absolute;
            background: #1a1d24;
            color: white;
            width: 100%;
            max-height: 300px;
            overflow-y: auto;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            z-index: 1000;
            display: none;
            margin-top: 3px;
            border: 1px solid #3f4451;
        }

        .suggestion-item {
            padding: 12px 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #3f4451;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            background: #292e3a;
        }

        .suggestion-item:hover {
            background: #3a4150;
            color: #ffffff;
            padding-left: 24px;
        }

        .suggestion-item:before {
            content: "📍";
            margin-right: 10px;
            font-size: 1.1em;
            transition: transform 0.3s ease;
        }
    </style>
@endpush

@section('content')
    @include('client.order.titleOrder')
    @include('client.order.content')
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const apiKey = "0RrqS6ilxPu2hdpgvOQScXvGjycxiUwDaVnHMfkG"; // https://account.goong.io/keys
        const addressInput = document.getElementById("address");
        const suggestionsContainer = document.getElementById("suggestions");
        const provinceInput = document.getElementById("province");
        const districtInput = document.getElementById("district");
        const neighborhoodInput = document.getElementById("neighborhood");
        let sessionToken = crypto.randomUUID();

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        const debouncedSearch = debounce((query) => {
            if (query.length < 2) {
                suggestionsContainer.style.display = "none";
                return;
            }

            fetch(
                    `https://rsapi.goong.io/Place/AutoComplete?api_key=${apiKey}&input=${encodeURIComponent(query)}&sessiontoken=${sessionToken}`
                )
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === "OK") {
                        suggestionsContainer.innerHTML = "";
                        suggestionsContainer.style.display = "block";

                        data.predictions.forEach((prediction) => {
                            const div = document.createElement("div");
                            div.className = "suggestion-item";
                            div.textContent = prediction.description;
                            div.addEventListener("click", () => {
                                addressInput.value = prediction.description;
                                suggestionsContainer.style.display = "none";

                                if (prediction.compound) {
                                    provinceInput.value = prediction.compound.province || "";
                                    districtInput.value = prediction.compound.district || "";
                                    neighborhoodInput.value = prediction.compound.commune || "";
                                }
                            });
                            suggestionsContainer.appendChild(div);
                        });
                    }
                })
                .catch((error) => console.error("Lỗi:", error));
        }, 300);

        addressInput.addEventListener("input", (e) => debouncedSearch(e.target.value));

        document.addEventListener("click", function(e) {
            if (!suggestionsContainer.contains(e.target) && e.target !== addressInput) {
                suggestionsContainer.style.display = "none";
            }
        });

        document.getElementById("checkoutForm").addEventListener("submit", function(e) {
            e.preventDefault();
            sessionToken = crypto.randomUUID();
            alert("Theo dõi mình để xem thêm các video công nghệ nhé!");
        });
    </script>

    <script>
        $(document).ready(function() {

            // --- Setup AJAX CSRF Token (Quan trọng) ---
            // Đảm bảo chỉ chạy một lần duy nhất trong toàn bộ trang
            if (typeof $.ajaxSetup === 'function') {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            } else {
                console.error("jQuery chưa được tải!");
                alert("Có lỗi xảy ra với thư viện jQuery!");
                return; // Dừng nếu chưa có jQuery
            }

            // --- Bắt sự kiện click nút "Áp Dụng" coupon ---
            // Sử dụng class 'btn-apply-coupon' làm ví dụ
            $('.btn-apply-coupon').on('click', function(e) {
                e.preventDefault(); // Ngăn nút bấm gửi form (nếu nó là type="submit")

                let applyButton = $(this);
                let couponInput = $('#coupon'); // Lấy ô nhập coupon
                let couponCode = couponInput.val().trim(); // Lấy mã người dùng nhập, bỏ khoảng trắng thừa

                // --- Validate cơ bản ---
                if (!couponCode) {
                    alert('Vui lòng nhập mã giảm giá.');
                    couponInput.focus(); // Focus vào ô nhập liệu
                    return;
                }

                // (Tùy chọn) Hiển thị trạng thái đang xử lý
                applyButton.prop('disabled', true).text('Đang xử lý...');
                // Xóa thông báo lỗi cũ (nếu có)
                // $('.coupon-error-message').remove(); // Giả sử có thẻ div để báo lỗi coupon

                // --- Gửi yêu cầu AJAX ---
                $.ajax({
                    type: 'POST',
                    // *** ĐẢM BẢO TÊN ROUTE NÀY ĐÚNG VỚI FILE routes/web.php ***
                    // Ví dụ: 'order.applyCoupon' hoặc 'client.order.applyCoupon'
                    url: '{{ route('client.order.applyCoupon') }}',
                    data: {
                        coupon_code: couponCode // Dữ liệu gửi lên server
                    },
                    dataType: 'json', // Mong muốn nhận về dữ liệu dạng JSON

                    // --- HÀM SUCCESS: Xử lý khi Server trả về thành công (HTTP 200 và success: true) ---
                    success: function(response) {
                        console.log('Apply Coupon Response:', response); // Xem log để debug

                        if (response.success) {
                            // 1. Cập nhật giá chính bằng giá mới
                            $('.total-price').text(response.new_total_price_display);

                            // 2. Cập nhật và hiển thị giá gốc bị gạch ngang
                            $('.original-price')
                                .text(response.original_total_price_display)
                                .show(); // Hiển thị thẻ <del>

                            // 3. (Tùy chọn) Hiển thị mã coupon đã áp dụng
                            $('#applied-coupon-code').text(response.coupon_code);
                            $('#applied-coupon-div').show();

                            // 4. Vô hiệu hóa ô nhập và nút bấm
                            couponInput.prop('disabled', true);
                            applyButton.text(
                                'Đã áp dụng'); // Không disable nút nữa mà chỉ đổi text

                            // 5. Hiển thị thông báo thành công
                            if (typeof swal === 'function') { // Ưu tiên SweetAlert
                                swal("Thành công!", response.message ||
                                    "Áp dụng mã giảm giá thành công!", "success");
                            } else {
                                alert(response.message || "Áp dụng mã giảm giá thành công!");
                            }

                        } else {
                            // --- Xử lý khi Server trả về success: false (Lỗi logic như mã sai, hết hạn...) ---
                            if (typeof swal === 'function') {
                                swal("Lỗi", response.message || "Áp dụng mã giảm giá thất bại.",
                                    "error");
                            } else {
                                alert(response.message || "Áp dụng mã giảm giá thất bại.");
                            }
                            // Kích hoạt lại nút và ô nhập nếu áp dụng lỗi
                            applyButton.prop('disabled', false).text('Áp Dụng');
                            couponInput.prop('disabled', false);
                            // (Tùy chọn) Hiển thị lỗi gần ô input
                            // couponInput.after('<div class="coupon-error-message text-danger">'+response.message+'</div>');
                        }
                    },

                    // --- HÀM ERROR: Xử lý khi có lỗi kết nối hoặc lỗi server (HTTP 500, 404...) ---
                    error: function(xhr, status, error) {
                        console.error("AJAX Apply Coupon Error:", status, error, xhr
                            .responseText);
                        let errorMsg = "Đã xảy ra lỗi kết nối hoặc lỗi server khi áp dụng mã.";
                        // Cố gắng lấy lỗi chi tiết hơn nếu server trả về JSON lỗi
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        if (typeof swal === 'function') {
                            swal("Lỗi", errorMsg, "error");
                        } else {
                            alert(errorMsg);
                        }
                        // Kích hoạt lại nút và ô nhập khi có lỗi AJAX
                        applyButton.prop('disabled', false).text('Áp Dụng');
                        couponInput.prop('disabled', false);
                    },

                    // --- HÀM COMPLETE: Luôn chạy sau khi success hoặc error hoàn thành ---
                    // complete: function() {
                    //      // Ví dụ: Ẩn biểu tượng loading nếu có
                    // }

                }); // Kết thúc $.ajax
            }); // Kết thúc .on('click')

        }); // Kết thúc $(document).ready
    </script>
@endpush
