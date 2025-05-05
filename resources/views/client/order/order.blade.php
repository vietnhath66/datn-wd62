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

        /* === Bắt đầu: CSS để tùy chỉnh giao diện Select2 cho giống style form của bạn === */

        /* Container chính của Select2 - Áp dụng các style chung của form group */
        .select2-container {
            width: 100% !important;
            /* Đảm bảo Select2 chiếm đủ chiều rộng */
            box-sizing: border-box;
            /* Quan trọng để padding không làm tràn */
            /* Kế thừa hoặc điều chỉnh font và màu chữ cho khớp với input/select của bạn */
            font-family: inherit;
            font-size: 1rem;
            color: #495057;
            /* Màu chữ mặc định */
        }

        /* Khi Select2 được ẩn đi (original select) */
        .select2-container .select2-selection--single {
            /* Ẩn mũi tên mặc định của trình duyệt */
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }


        /* Phần hiển thị lựa chọn hiện tại (khung input giả của Select2) */
        .select2-container--default .select2-selection--single {
            /* Áp dụng các style từ .select-form hoặc input của bạn */
            height: auto;
            /* Chiều cao tự động dựa trên nội dung */
            min-height: 44px;
            /* Đặt chiều cao tối thiểu cho khớp với input khác */
            padding: 10px 15px;
            /* Kế thừa padding từ input/select-form */
            border: 1px solid #ced4da;
            /* Kế thừa viền */
            border-radius: 0.5rem;
            /* Kế thừa bo góc */
            background-color: #fff;
            /* Nền trắng */
            /* Các style khác để loại bỏ border/outline mặc định của Select2 */
            outline: none;
            box-shadow: none;
            /* Transition giống input */
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            /* Căn chỉnh nội dung bên trong */
            display: flex;
            align-items: center;
        }

        /* Khi Select2 được focus (khung input giả sáng lên) */
        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: #80bdff;
            /* Màu viền khi focus (giống style form-control focus) */
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            /* Đổ bóng khi focus */
        }


        /* Phần hiển thị text lựa chọn hiện tại bên trong khung Select2 */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #495057;
            /* Màu chữ của bạn */
            line-height: 1.5;
            /* Kế thừa line-height */
            padding-left: 0 !important;
            /* Bỏ padding-left mặc định của Select2 nếu có */
            padding-right: 20px;
            /* Đảm bảo có chỗ cho mũi tên */
            /* Ngăn tràn text nếu quá dài */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Placeholder text trong Select2 */
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #6c757d;
            /* Màu placeholder của bạn */
        }


        /* Mũi tên của Select2 */
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            /* Điều chỉnh vị trí và kích thước nếu cần */
            height: 100%;
            /* Chiều cao bằng selection */
            right: 8px;
            /* Vị trí từ phải sang */
            width: 20px;
            /* Chiều rộng mũi tên */
            display: flex;
            /* Căn giữa icon */
            align-items: center;
            justify-content: center;
            /* Tùy chỉnh màu mũi tên */
            color: #888;
            /* Màu mũi tên */
        }

        /* Tùy chỉnh icon mũi tên */
        .select2-container--default .select2-selection__arrow b {
            border-color: #888 transparent transparent transparent;
            /* Màu mũi tên */
            border-style: solid;
            border-width: 5px 4px 0 4px;
            height: 0;
            left: 50%;
            margin-left: -4px;
            margin-top: -2px;
            position: absolute;
            top: 50%;
            width: 0;
        }

        /* Giao diện mũi tên khi dropdown mở */
        .select2-container--default.select2-container--open .select2-selection__arrow b {
            border-color: transparent transparent #888 transparent !important;
            border-width: 0 4px 5px 4px !important;
        }


        /* Trạng thái Disabled */
        /* Select2 áp dụng class select2-container--disabled và select2-selection--disabled khi disabled */
        .select2-container--default.select2-container--disabled .select2-selection--single,
        .select2-container--default .select2-selection--single[aria-disabled=true] {
            background-color: #e9ecef;
            /* Nền nhạt hơn cho disabled */
            color: #6c757d;
            /* Màu chữ mờ hơn */
            opacity: 1;
            /* Đảm bảo không bị mờ quá */
            cursor: not-allowed;
            /* Con trỏ không cho phép */
            box-shadow: none;
            /* Bỏ đổ bóng khi disabled */
        }


        /* === Styling cho dropdown box và ô tìm kiếm bên trong === */

        /* Container chứa dropdown box mở ra */
        .select2-container--open .select2-dropdown {
            border: 1px solid #ccc;
            /* Viền dropdown box */
            border-radius: 4px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
            /* Đổ bóng cho dropdown box */
            margin-top: 1px;
            /* Khoảng cách với selection */
            overflow: hidden;
            /* Đảm bảo bo góc hoạt động */
            z-index: 1050;
            /* Đảm bảo hiển thị trên các modal/popup khác */
            background-color: #fff;
            /* Nền trắng */
        }

        /* Ô tìm kiếm trong dropdown */
        .select2-container--default .select2-search--dropdown .select2-search__field {
            /* Áp dụng style input của bạn */
            width: 100%;
            padding: 8px 12px;
            /* Padding cho ô tìm kiếm */
            font-size: 1rem;
            /* Kích thước font */
            color: #333;
            /* Màu chữ */
            border: 1px solid #ccc;
            /* Viền */
            border-radius: 4px;
            /* Bo góc */
            outline: none;
            /* Bỏ outline mặc định */
            /* Bỏ style background hoặc box-shadow mặc định của Select2 nếu có */
            background-color: #fff;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075);
        }

        /* Khi ô tìm kiếm focus */
        .select2-container--default .select2-search--dropdown .select2-search__field:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }


        /* Danh sách các tùy chọn trong dropdown */
        .select2-container--default .select2-results__options {
            max-height: 200px;
            /* Chiều cao tối đa trước khi scroll */
            overflow-y: auto;
            padding: 0;
            /* Bỏ padding mặc định */
        }

        /* Từng tùy chọn trong danh sách */
        .select2-container--default .select2-results__option {
            padding: 8px 12px;
            /* Padding cho mỗi dòng option */
            cursor: pointer;
            list-style: none;
            /* Bỏ bullet points */
            /* Màu chữ mặc định */
            color: #495057;
        }

        /* Tùy chọn khi hover hoặc active */
        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: #007bff;
            /* Màu nền khi hover */
            color: #fff;
            /* Màu chữ khi hover */
        }

        /* Tùy chọn đã chọn trong danh sách */
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #f8f9fa;
            /* Nền xám nhẹ cho tùy chọn đã chọn */
            color: #495057;
        }

        /* === Kết thúc: CSS tùy chỉnh Select2 === */

        /* Bạn vẫn giữ style .select-form ban đầu cho các select không dùng Select2 */
        /* .select-form { ... style ban đầu ... } */
    </style>
@endpush

@section('content')
    @include('client.order.titleOrder')
    @include('client.order.content')
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Lấy các select element (sử dụng ID mới)
            const provinceSelectNative = document.getElementById('province');
            const districtSelectNative = document.getElementById('district');
            const wardSelectNative = document.getElementById('ward');

            // Lấy đối tượng jQuery cho các select để dùng Select2
            const $provinceSelect = $(provinceSelectNative);
            const $districtSelect = $(districtSelectNative);
            const $wardSelect = $(wardSelectNative);

            // --- 1. Khởi tạo Select2 cho các dropdown ---
            $provinceSelect.select2({
                placeholder: 'Chọn tỉnh/thành phố',
                width: '100%'
            });
            $districtSelect.select2({
                placeholder: 'Chọn quận/huyện',
                width: '100%'
            });
            $wardSelect.select2({
                placeholder: 'Chọn phường/xã',
                width: '100%'
            });

            // Ban đầu disable district và ward (Select2 cũng sẽ hiển thị trạng thái disabled)
            $districtSelect.prop('disabled', true);
            $wardSelect.prop('disabled', true);


            // --- 2. Logic Load dữ liệu động khi thay đổi dropdown cha ---

            // Khi thay đổi tỉnh (province)
            $provinceSelect.on('change', function() { // Sử dụng listener của jQuery cho Select2
                // Lấy mã tỉnh từ value
                const provinceCode = $(this).val();


                // Reset và disable các dropdown con
                $districtSelect.html('<option value="">Chọn quận/huyện</option>');
                $districtSelect.prop('disabled', true);
                $districtSelect.trigger('change'); // Thông báo cho Select2 biết options đã thay đổi

                $wardSelect.html('<option value="">Chọn phường/xã</option>');
                $wardSelect.prop('disabled', true);
                $wardSelect.trigger('change'); // Thông báo cho Select2 biết options đã thay đổi

                // Nếu có chọn tỉnh
                if (provinceCode) {
                    // Gọi API lấy quận huyện theo mã tỉnh
                    fetch(`/get-districts/${provinceCode}`) // Route đã định nghĩa trong web.php
                        .then(response => response.json())
                        .then(data => {
                            if (data.message) {
                                $districtSelect.html(`<option value="">${data.message}</option>`);
                                $districtSelect.prop('disabled', true);
                            } else {
                                let optionsHtml = '<option value="">Chọn quận/huyện</option>';
                                data.forEach(item => {
                                    optionsHtml +=
                                        `<option value="${item.code}" data-code="${item.code}">${item.full_name}</option>`;
                                });
                                $districtSelect.html(optionsHtml);
                                $districtSelect.prop('disabled', false);
                            }
                            $districtSelect.trigger('change'); // Trigger change để Select2 cập nhật
                        })
                        .catch(error => {
                            console.error('Lỗi khi lấy quận/huyện:', error);
                            $districtSelect.html('<option value="">Lỗi khi tải quận/huyện</option>');
                            $districtSelect.prop('disabled', true);
                            $districtSelect.trigger('change');
                            $wardSelect.prop('disabled', true);
                            $wardSelect.trigger('change');
                        });
                }
            });

            // Khi thay đổi quận huyện (district)
            $districtSelect.on('change', function() { // Sử dụng listener của jQuery cho Select2
                // Lấy mã quận huyện từ value
                const districtCode = $(this).val();

                // Reset và disable dropdown con
                $wardSelect.html('<option value="">Chọn phường/xã</option>');
                $wardSelect.prop('disabled', true);
                $wardSelect.trigger('change'); // Thông báo cho Select2 biết options đã thay đổi

                // Nếu có chọn quận huyện
                if (districtCode) {
                    // Gọi API lấy phường xã theo mã quận huyện
                    fetch(`/get-wards/${districtCode}`) // Route đã định nghĩa trong web.php
                        .then(response => response.json())
                        .then(data => {
                            if (data.message) {
                                $wardSelect.html(`<option value="">${data.message}</option>`);
                                $wardSelect.prop('disabled', true);
                            } else {
                                let optionsHtml = '<option value="">Chọn phường/xã</option>';
                                data.forEach(item => {
                                    optionsHtml +=
                                        `<option value="${item.code}" data-code="${item.code}">${item.full_name}</option>`;
                                });
                                $wardSelect.html(optionsHtml);
                                $wardSelect.prop('disabled', false);
                            }
                            $wardSelect.trigger('change'); // Trigger change để Select2 cập nhật
                        })
                        .catch(error => {
                            console.error('Lỗi khi lấy phường/xã:', error);
                            $wardSelect.html('<option value="">Lỗi khi tải phường/xã</option>');
                            $wardSelect.prop('disabled', true);
                            $wardSelect.trigger('change');
                        });
                }
            });


            // --- 3. Xử lý giá trị cũ khi load trang (nếu có) ---
            // Nếu bạn có truyền old values từ server khi validate thất bại
            // hoặc load dữ liệu địa chỉ đã lưu của user, bạn cần set lại giá trị cho Select2
            // và trigger change để nó load dropdown con tương ứng.
            // Biến $userAddress được truyền từ Controller OrderController@viewOrder
            const oldProvinceCode =
                '{{ old('province_code', $userAddress->province_code ?? '') }}'; // Lấy code tỉnh đã lưu/old
            const oldDistrictCode =
                '{{ old('district_code', $userAddress->district_code ?? '') }}'; // Lấy code huyện đã lưu/old
            const oldWardCode = '{{ old('ward_code', $userAddress->ward_code ?? '') }}'; // Lấy code xã đã lưu/old

            if (oldProvinceCode) {
                // Set giá trị cho provinceSelect
                $provinceSelect.val(oldProvinceCode); // Set giá trị

                // Lắng nghe sự kiện change của district chỉ 1 lần
                $districtSelect.one('change',
                    function() { // Dùng .one() để listener chỉ chạy 1 lần sau load dữ liệu tỉnh
                        if (oldDistrictCode) {
                            // Set giá trị cho districtSelect và trigger change để load ward
                            $districtSelect.val(oldDistrictCode); // Set giá trị
                            $districtSelect.trigger('change'); // Trigger change để load ward

                            // Lắng nghe sự kiện change của ward chỉ 1 lần
                            $wardSelect.one('change',
                                function() { // Dùng .one() để listener chỉ chạy 1 lần sau load dữ liệu huyện
                                    if (oldWardCode) {
                                        $wardSelect.val(oldWardCode); // Set giá trị
                                        // Không cần trigger change cho ward cuối cùng trừ khi có logic khác phụ thuộc
                                    }
                                });
                        } else {
                            // Nếu có province nhưng không có district (trường hợp user chỉ lưu province)
                            // Cần đảm bảo trigger change để load districts
                            $provinceSelect.trigger('change');
                        }
                    });
                // Quan trọng: Trigger change cho provinceSelect để bắt đầu chuỗi load dữ liệu con
                // Điều này cần xảy ra SAU KHI Select2 đã được khởi tạo
                // Sử dụng timeout nhỏ để đảm bảo Select2 đã sẵn sàng
                setTimeout(() => {
                    $provinceSelect.trigger('change');
                }, 100); // 100ms hoặc nhỏ hơn


                // Việc xử lý old values này cần cẩn thận để đảm bảo các dropdown con được load tuần tự.
                // Đoạn code mẫu trên giả định bạn lưu code tỉnh/huyện/xã, nếu lưu tên thì cần điều chỉnh.
                // Bạn cần điều chỉnh dựa trên cách bạn truyền old values hoặc dữ liệu địa chỉ đã lưu.


                // ... các hàm khác cho toast, updateSelectedTotal, showEmptyCartMessage, v.v.
                // ... logic xử lý quantity buttons và checkout form submission ...
            };
        }); // End DOMContentLoaded
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('addressForm');

            form.addEventListener('submit', function(e) {
                // Đợi form submit thành công rồi reset form
                // Nếu bạn redirect lại thì dùng đoạn này ở trang load lại

                // Reset sau 500ms nếu form không redirect (AJAX hoặc không có lỗi)
                setTimeout(() => {
                    form.reset();

                    // Nếu bạn dùng Select2 hoặc plugin khác thì cần reset thủ công
                    // Reset Select2 dropdowns
                    $('#city').val('').trigger(
                        'change'); // Reset city và trigger change để reset con
                    // district và ward sẽ được reset bởi listener change của city
                }, 500); // Có thể cần điều chỉnh thời gian timeout

            });
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
                            $('#applied-coupon-discount_value').text(response.discount_value);
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

            $('#checkoutForm').on('submit', function(event) {
                let isValid = true;
                let missingFieldLabels = []; // Mảng lưu tên các trường bị thiếu

                // Xóa trạng thái lỗi cũ
                $(this).find('.form-control').removeClass('is-invalid');

                // Danh sách các trường BẮT BUỘC và Nhãn tương ứng
                const requiredFieldsMap = {
                    '#fullName': 'Họ và Tên',
                    '#phone': 'Số Điện Thoại',
                    '#email': 'Email',
                    '#address': 'Địa chỉ cụ thể',
                    '#ward': 'Phường/Xã',
                    '#district': 'Quận/Huyện',
                    '#province': 'Tỉnh/Thành phố'
                };

                // Kiểm tra từng trường bắt buộc
                $.each(requiredFieldsMap, function(fieldSelector, fieldLabel) {
                    const field = $(fieldSelector);
                    if (!field.length || field.val().trim() === '') {
                        isValid = false;
                        missingFieldLabels.push(fieldLabel);
                        field.addClass('is-invalid'); // Vẫn nên giữ lại highlight ô lỗi
                    }
                });

                // --- Xử lý nếu form KHÔNG hợp lệ ---
                if (!isValid) {
                    event.preventDefault(); // Ngăn chặn submit form

                    // Tạo nội dung thông báo lỗi
                    let errorMessage = "Vui lòng điền đầy đủ thông tin cho các trường sau:\n\n";
                    missingFieldLabels.forEach(function(label) {
                        errorMessage += "- " + label + "\n";
                    });

                    // --- THAY ĐỔI Ở ĐÂY: Chỉ dùng alert() ---
                    alert(errorMessage);
                    // --- KẾT THÚC THAY ĐỔI ---

                    // Tùy chọn: Focus vào ô lỗi đầu tiên
                    if (missingFieldLabels.length > 0) {
                        let firstErrorSelector = Object.keys(requiredFieldsMap).find(selector =>
                            requiredFieldsMap[selector] === missingFieldLabels[0]);
                        if (firstErrorSelector) {
                            $(firstErrorSelector).focus();
                        }
                    }

                } else {
                    // Form hợp lệ, cho phép submit
                    $(this).find('button[type="submit"]').prop('disabled', true).html('Đang xử lý...');
                    console.log('Client validation passed. Submitting form...');
                }
            }); // Kết thúc on submit

        }); // Kết thúc $(document).ready
    </script>
@endpush
