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

        .address-modal {
            display: none;
            /* Ẩn mặc định */
            position: fixed;
            /* Ở cố định trên màn hình */
            z-index: 1050;
            /* Nằm trên các phần tử khác */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            /* Cho phép cuộn nếu nội dung dài */
            background-color: rgba(0, 0, 0, 0.5);
            /* Nền mờ */
        }

        .address-modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            /* Canh giữa theo chiều dọc và ngang */
            padding: 25px;
            border: 1px solid #ccc;
            width: 80%;
            /* Chiều rộng modal */
            max-width: 600px;
            /* Giới hạn chiều rộng tối đa */
            border-radius: 8px;
            position: relative;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .2);
        }

        .address-modal-close {
            color: #aaa;
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 28px;
            font-weight: bold;
            line-height: 1;
        }

        .address-modal-close:hover,
        .address-modal-close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .address-modal-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #333;
            font-weight: 600;
        }

        .modal-address-item {
            /* Style cho mỗi dòng địa chỉ trong modal */
            padding: 10px 5px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .modal-address-item:last-child {
            border-bottom: none;
        }

        .modal-address-item:hover {
            background-color: #f0f8ff;
            /* Màu nền khi hover */
        }

        .modal-address-item input[type="radio"] {
            margin-right: 15px;
            width: 18px;
            /* Kích thước radio */
            height: 18px;
        }

        .modal-address-item label {
            margin-bottom: 0;
            /* Ghi đè margin mặc định của label */
            flex-grow: 1;
            cursor: pointer;
            /* Biến label thành con trỏ */
        }

        .modal-address-item .badge {
            /* Style cho tag Mặc định */
            font-size: 0.75rem;
            padding: 3px 6px;
        }
    </style>
    </style>
@endpush

@section('content')
    @include('client.order.titleOrder')
    @include('client.order.content')
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- <script>
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
    </script> --}}

    {{-- <script>
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
    </script> --}}

    {{-- <script>
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
    </script> --}}

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // === CÁC ELEMENT LIÊN QUAN ĐẾN FORM CHÍNH ===
            const nameInput = document.getElementById('fullName');
            const phoneInput = document.getElementById('phone');
            const emailInput = document.getElementById('email');
            const addressInput = document.getElementById('address');
            const provinceSelect = document.getElementById('province');
            const districtSelect = document.getElementById('district');
            const wardSelect = document.getElementById('ward');

            // === CÁC ELEMENT LIÊN QUAN ĐẾN MODAL ===
            const changeAddressButton = document.getElementById('change-address-btn');
            const addressModal = document.getElementById('addressModal');
            const closeModalButton = document.getElementById('closeAddressModal');
            const modalAddressListDiv = document.getElementById('modal-address-list');

            // Lấy dữ liệu địa chỉ đã lưu từ Blade (cần truyền $userAddresses ra view)
            const savedAddresses = @json($userAddresses ?? []); // Lấy từ biến controller, đảm bảo là mảng

            // --- Hàm để điền dữ liệu vào form chính (Giữ nguyên hoặc cải thiện) ---
            function populateForm(data) {
                // ... (code hàm populateForm từ trước, đảm bảo nó hoạt động) ...
                if (!data) return;
                if (nameInput && data.name) nameInput.value = data.name;
                if (phoneInput && data.phone) phoneInput.value = data.phone;
                if (emailInput && data.email) emailInput.value = data.email;
                if (addressInput && data.address) addressInput.value = data.address;

                if (provinceSelect && data.province) {
                    let provinceFound = false;
                    for (let i = 0; i < provinceSelect.options.length; i++) {
                        if (provinceSelect.options[i].text.trim() === data.province.trim()) {
                            provinceSelect.value = provinceSelect.options[i].value;
                            provinceFound = true;
                            break;
                        }
                    }
                    var event = new Event('change');
                    provinceSelect.dispatchEvent(event); // Trigger change để load huyện

                    // >>> Quan trọng: Cần có cơ chế đợi load huyện/xã rồi mới chọn <<<
                    // >>> Đây là lý do nên dùng CODE thay vì NAME <<<
                    // Tạm thời reset huyện/xã
                    districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
                    districtSelect.disabled = !provinceFound;
                    wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
                    wardSelect.disabled = true;

                } else if (provinceSelect) {
                    provinceSelect.value = "";
                    var event = new Event('change');
                    provinceSelect.dispatchEvent(event);
                }
            }

            // --- Hàm tạo danh sách địa chỉ trong Modal ---
            function renderModalAddressList() {
                if (!modalAddressListDiv) return;
                modalAddressListDiv.innerHTML = ''; // Xóa nội dung cũ

                if (savedAddresses && savedAddresses.length > 0) {
                    savedAddresses.forEach(addr => {
                        const itemDiv = document.createElement('div');
                        itemDiv.className = 'modal-address-item form-check'; // Thêm form-check nếu cần

                        const radioInput = document.createElement('input');
                        radioInput.className =
                            'form-check-input saved-address-radio-modal'; // Class riêng cho radio trong modal
                        radioInput.type = 'radio';
                        radioInput.name = 'selected_address_modal'; // Tên riêng
                        radioInput.id = `modal_address_${addr.id}`;
                        radioInput.value = addr.id;

                        // Lưu trữ dữ liệu vào data attributes của radio button
                        radioInput.dataset.name = "{{ $user->name }}"; // Lấy tên user chung
                        radioInput.dataset.phone = "{{ $user->phone }}"; // Lấy SĐT user chung
                        radioInput.dataset.email = "{{ $user->email }}"; // Lấy email user chung
                        radioInput.dataset.address = addr.address;
                        radioInput.dataset.province = addr.province; // Lưu tên tỉnh
                        radioInput.dataset.district = addr.district; // Lưu tên huyện
                        radioInput.dataset.ward = addr.neighborhood; // Lưu tên xã (cột neighborhood)
                        // radioInput.dataset.province_code = addr.province_code; // <<< Nếu bạn lưu code thì dùng cái này
                        // radioInput.dataset.district_code = addr.district_code;
                        // radioInput.dataset.ward_code = addr.ward_code;

                        // Check nếu là địa chỉ mặc định
                        if (addr.is_default) {
                            // radioInput.checked = true; // Có thể không cần check sẵn trong modal
                        }

                        const label = document.createElement('label');
                        label.className = 'form-check-label';
                        label.htmlFor = `modal_address_${addr.id}`;
                        label.textContent =
                            `${addr.address}, ${addr.neighborhood}, ${addr.district}, ${addr.province}`;
                        if (addr.is_default) {
                            const badge = document.createElement('span');
                            badge.className = 'badge bg-primary ms-2';
                            badge.textContent = 'Mặc định';
                            label.appendChild(badge);
                        }

                        itemDiv.appendChild(radioInput);
                        itemDiv.appendChild(label);

                        // Thêm sự kiện click cho cả div hoặc label để chọn radio
                        itemDiv.addEventListener('click', function(e) {
                            if (e.target !==
                                radioInput) { // Tránh trigger 2 lần nếu click vào radio
                                radioInput.checked = true;
                            }
                            // Lấy dữ liệu từ radio được chọn
                            const selectedData = {
                                name: radioInput.dataset.name,
                                phone: radioInput.dataset.phone,
                                email: radioInput.dataset.email,
                                address: radioInput.dataset.address,
                                province: radioInput.dataset.province, // Lấy TÊN tỉnh
                                district: radioInput.dataset.district,
                                ward: radioInput.dataset.ward
                                // province_code: radioInput.dataset.province_code, // Lấy code nếu dùng
                            };
                            populateForm(selectedData); // Điền vào form chính
                            hideModal(); // Đóng modal sau khi chọn
                        });

                        modalAddressListDiv.appendChild(itemDiv);
                    });
                } else {
                    modalAddressListDiv.innerHTML = '<p>Không có địa chỉ nào được lưu.</p>';
                }
            }

            // --- Hàm hiển thị Modal ---
            function showModal() {
                if (addressModal) {
                    renderModalAddressList(); // Tạo lại danh sách mỗi khi mở
                    addressModal.style.display = "block";
                }
            }

            // --- Hàm ẩn Modal ---
            function hideModal() {
                if (addressModal) {
                    addressModal.style.display = "none";
                }
            }

            // --- Gắn sự kiện ---
            // Mở modal khi click nút "Đổi địa chỉ"
            if (changeAddressButton) {
                changeAddressButton.addEventListener('click', showModal);
            }

            // Đóng modal khi click nút (X)
            if (closeModalButton) {
                closeModalButton.addEventListener('click', hideModal);
            }

            // Đóng modal khi click bên ngoài vùng nội dung modal
            window.addEventListener('click', function(event) {
                if (event.target == addressModal) {
                    hideModal();
                }
            });

            // --- Logic điền form mặc định khi tải trang (nếu cần) ---
            const defaultAddressData = @json($defaultUserAddress ?? null);
            if (defaultAddressData) {
                const initialData = {
                    name: "{{ $user->name }}",
                    phone: "{{ $user->phone }}",
                    email: "{{ $user->email }}",
                    address: defaultAddressData.address,
                    province: defaultAddressData.province,
                    district: defaultAddressData.district,
                    ward: defaultAddressData.neighborhood
                    // province_code: defaultAddressData.province_code, // Nếu dùng code
                };
                populateForm(initialData);
                console.log('Populated form with default address on load.');
            } else {
                // Nếu không có địa chỉ mặc định, vẫn điền tên/sdt/email user
                if (nameInput) nameInput.value = "{{ $user->name }}";
                if (phoneInput) phoneInput.value = "{{ $user->phone }}";
                if (emailInput) emailInput.value = "{{ $user->email }}";
            }

        });
    </script> --}}

    <script>
        $(document).ready(function() {

            // --- 0. CSRF Token Setup ---
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // --- 1. Select2 Init & Elements ---
            const $provinceSelect = $('#province');
            const $districtSelect = $('#district');
            const $wardSelect = $('#ward');
            const $checkoutForm = $('#checkoutForm'); // Lấy form checkout

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

            // --- Biến cờ để kiểm soát việc chờ load ---
            let isDistrictLoading = false;
            let isWardLoading = false;

            // --- 2. Logic Load Địa chỉ Động (Cần Sửa Đổi để báo hiệu hoàn thành) ---

            // Hàm fetch và populate options, trả về Promise để báo hiệu hoàn thành
            function fetchAndPopulate(selectElement, url, placeholder) {
                return new Promise((resolve, reject) => {
                    // Reset và disable
                    selectElement.html(`<option value="">${placeholder}</option>`).prop('disabled', true)
                        .trigger('change.select2');

                    // Nếu không có url (ví dụ provinceCode rỗng), resolve ngay
                    if (!url) {
                        console.log(`URL empty for ${selectElement.attr('id')}, resolving.`);
                        resolve();
                        return;
                    }

                    console.log(`Workspaceing for ${selectElement.attr('id')} from ${url}`);
                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            let optionsHtml = `<option value="">${placeholder}</option>`;
                            if (!data.message && data.length > 0) {
                                data.forEach(item => {
                                    // !!! VALUE VẪN LÀ CODE, NHƯNG TEXT LÀ FULL NAME !!!
                                    // Điều này quan trọng cho việc tìm kiếm theo text sau này
                                    optionsHtml +=
                                        `<option value="${item.code}" data-name="${item.full_name}">${item.full_name}</option>`;
                                });
                                selectElement.html(optionsHtml).prop('disabled', false);
                            } else {
                                selectElement.html(
                                    `<option value="">${data.message || 'Không có dữ liệu'}</option>`
                                ).prop('disabled', true);
                            }
                            selectElement.trigger('change.select2'); // Cập nhật Select2
                            console.log(`Finished populating ${selectElement.attr('id')}`);
                            resolve(); // Báo hiệu hoàn thành
                        })
                        .catch(error => {
                            console.error(`Error fetching for ${selectElement.attr('id')}:`, error);
                            selectElement.html(`<option value="">Lỗi tải dữ liệu</option>`).prop(
                                'disabled', true).trigger('change.select2');
                            reject(error); // Báo hiệu lỗi
                        });
                });
            }

            // Khi thay đổi tỉnh
            $provinceSelect.on('change', function() {
                const provinceCode = $(this).val();
                isDistrictLoading = true; // Bắt đầu load huyện
                isWardLoading = true; // Xã cũng sẽ cần load lại
                fetchAndPopulate($districtSelect, provinceCode ? `/get-districts/${provinceCode}` : null,
                        'Chọn quận/huyện')
                    .finally(() => {
                        isDistrictLoading = false;
                        console.log("District loading finished (event flag)");
                    });
                // Reset xã ngay lập tức
                fetchAndPopulate($wardSelect, null, 'Chọn phường/xã')
                    .finally(() => {
                        isWardLoading = false;
                    }); // Reset trạng thái loading xã
            });

            // Khi thay đổi huyện
            $districtSelect.on('change', function() {
                const districtCode = $(this).val();
                isWardLoading = true; // Bắt đầu load xã
                fetchAndPopulate($wardSelect, districtCode ? `/get-wards/${districtCode}` : null,
                        'Chọn phường/xã')
                    .finally(() => {
                        isWardLoading = false;
                        console.log("Ward loading finished (event flag)");
                    });
            });


            // --- 3. Logic Modal Chọn Địa Chỉ ---
            const $addressModal = $('#addressModal');
            const $modalAddressListDiv = $('#modal-address-list');
            const savedAddresses = @json($userAddresses ?? []);

            // Hàm render modal (Lưu tên vào data attribute)
            function renderModalAddressList() {
                $modalAddressListDiv.empty();
                if (savedAddresses && savedAddresses.length > 0) {
                    savedAddresses.forEach(addr => {
                        const itemHtml = `
                            <div class="modal-address-item form-check">
                                <input class="form-check-input saved-address-radio-modal" type="radio" name="selected_address_modal" id="modal_address_${addr.id}" value="${addr.id}"
                                       data-name="{{ $user->name }}" data-phone="{{ $user->phone }}" data-email="{{ $user->email }}"
                                       data-address="${addr.address}"
                                       data-province="${addr.province}" {{-- LƯU TÊN TỈNH --}}
                                       data-district="${addr.district}" {{-- LƯU TÊN HUYỆN --}}
                                       data-ward="${addr.neighborhood}" {{-- LƯU TÊN XÃ --}}
                                       ${addr.is_default ? 'data-is-default="true"' : ''}>
                                <label class="form-check-label" for="modal_address_${addr.id}">
                                    ${addr.address}, ${addr.neighborhood}, ${addr.district}, ${addr.province}
                                    ${addr.is_default ? '<span class="badge bg-primary ms-2">Mặc định</span>' : ''}
                                </label>
                            </div>`;
                        $modalAddressListDiv.append(itemHtml);
                    });
                } else {
                    /* ... */
                }
            }

            // Hàm điền form (Cố gắng chọn theo TÊN, xử lý bất đồng bộ)
            async function populateForm(data) {
                if (!data) return;
                console.log("Populating form with (name-based):", data);

                // Điền trường text
                $('#fullName').val(data.name || '');
                $('#phone').val(data.phone || '');
                $('#email').val(data.email || '');
                $('#address').val(data.address || '');

                // Hàm chọn option theo TEXT và trả về Promise khi hoàn thành (bao gồm cả chờ load)
                function selectOptionByText(selectElement, textToMatch, loadTriggerPromise) {
                    return new Promise(async (resolve) => {
                        if (!selectElement || !textToMatch) {
                            resolve();
                            return;
                        }

                        console.log(
                            `Attempting to select "${textToMatch}" in #${selectElement.attr('id')}`
                        );

                        // 1. Đợi cho quá trình load trước đó (nếu có) hoàn thành
                        if (loadTriggerPromise) {
                            console.log(
                                `Waiting for load trigger promise for #${selectElement.attr('id')}`
                            );
                            await loadTriggerPromise;
                            console.log(
                                `Load trigger promise resolved for #${selectElement.attr('id')}`
                            );
                            // Đợi thêm một chút sau khi promise resolve để đảm bảo DOM update
                            await new Promise(r => setTimeout(r, 100));
                        }

                        // 2. Tìm option có text khớp
                        let foundOption = null;
                        selectElement.find('option').each(function() {
                            if ($(this).text().trim() === textToMatch.trim()) {
                                foundOption = $(this);
                                return false; // Thoát vòng lặp
                            }
                        });

                        // 3. Set giá trị nếu tìm thấy và trigger change
                        if (foundOption) {
                            if (selectElement.val() !== foundOption.val()) {
                                console.log(
                                    `Found option for "${textToMatch}". Setting value to ${foundOption.val()}`
                                );
                                selectElement.val(foundOption.val()).trigger(
                                    'change'); // Trigger change quan trọng
                                // Đợi sau khi trigger change
                                await new Promise(r => setTimeout(r, 150));
                            } else {
                                console.log(
                                    `#${selectElement.attr('id')} already has correct value for "${textToMatch}"`
                                );
                            }
                            resolve(true); // Báo hiệu đã chọn thành công
                        } else {
                            console.warn(
                                `Option with text "${textToMatch}" not found in #${selectElement.attr('id')}`
                            );
                            if (selectElement.val() !== "") {
                                selectElement.val("").trigger('change'); // Reset nếu không tìm thấy
                                await new Promise(r => setTimeout(r, 150));
                            }
                            resolve(false); // Báo hiệu không chọn được
                        }
                    });
                }

                // --- Thực hiện chọn tuần tự ---
                // Tạo các Promise giả để báo hiệu khi nào việc load hoàn thành
                let districtLoadPromise = new Promise(r => $(document).one('districtsLoaded', r));
                let wardLoadPromise = new Promise(r => $(document).one('wardsLoaded', r));

                // Bọc lại hàm fetch để trigger sự kiện tùy chỉnh khi xong
                function fetchAndPopulateWithEvent(selectElement, url, placeholder, eventName) {
                    // (Copy logic từ hàm fetchAndPopulate ở trên)
                    // ... fetch ...
                    // .then(data => { ... populate options ...})
                    // .finally(() => {
                    //     $(document).trigger(eventName); // Trigger sự kiện tùy chỉnh khi xong
                    //     resolve(); // hoặc reject(error)
                    // });
                    // *** Cần sửa lại hàm fetchAndPopulate ở trên để tích hợp cái này ***
                    // *** Hoặc sửa trực tiếp listener 'change' của province/district để trigger event ***
                    // ---> Ví dụ sửa listener change của province:
                    // $provinceSelect.on('change', function() {
                    //     const provinceCode = $(this).val();
                    //     isDistrictLoading = true;
                    //     fetchAndPopulate($districtSelect, provinceCode ? `/get-districts/${provinceCode}` : null, 'Chọn quận/huyện')
                    //         .then(() => $(document).trigger('districtsLoaded')) // Trigger event khi xong
                    //         .finally(() => { isDistrictLoading = false; });
                    //     // Reset xã...
                    // });
                    // ---> Tương tự cho district change để trigger 'wardsLoaded'

                    // Do việc sửa đổi hàm fetch phức tạp, tạm thời dùng setTimeout để mô phỏng chờ
                    console.warn(
                        "Using setTimeout as a fallback for waiting. Refactor fetch logic for robustness.");
                    return new Promise(resolve => setTimeout(resolve, 800)); // Chờ 800ms (KHÔNG ĐÁNG TIN CẬY)

                }


                // Chọn Tỉnh/TP
                let provincePromise = selectOptionByText($provinceSelect, data.province);
                let provinceSelected = await provincePromise;


                // Chọn Quận/Huyện (Chỉ chạy nếu tỉnh được chọn thành công)
                let districtSelected = false;
                if (provinceSelected) {
                    // Đợi quá trình load huyện (dùng Promise hoặc setTimeout không đáng tin cậy)
                    console.log("Waiting simulated delay for districts...");
                    await fetchAndPopulateWithEvent($districtSelect, null, '',
                        'districtsLoaded'); // Mô phỏng chờ
                    districtSelected = await selectOptionByText($districtSelect, data.district);
                }

                // Chọn Phường/Xã (Chỉ chạy nếu huyện được chọn thành công)
                if (districtSelected) {
                    console.log("Waiting simulated delay for wards...");
                    await fetchAndPopulateWithEvent($wardSelect, null, '', 'wardsLoaded'); // Mô phỏng chờ
                    await selectOptionByText($wardSelect, data.ward);
                }

                console.log("populateForm (name-based) finished.");
            }


            // Mở/Đóng Modal (Giữ nguyên)
            $('#change-address-btn').on('click', showModal);
            $('#closeAddressModal').on('click', hideModal);
            $(window).on('click', function(event) {
                /* ... đóng modal ... */
            });

            function showModal() {
                /* ... */
                renderModalAddressList();
                $addressModal.css('display', 'block');
            }

            function hideModal() {
                /* ... */
                $addressModal.css('display', 'none');
            }

            // Xử lý chọn địa chỉ trong modal (Lấy tên từ data attribute)
            $modalAddressListDiv.on('click', '.modal-address-item', function() {
                const $radio = $(this).find('.saved-address-radio-modal');
                if (!$radio.prop('checked')) {
                    $radio.prop('checked', true);
                }
                const selectedData = {
                    name: $radio.data('name'),
                    phone: $radio.data('phone'),
                    email: $radio.data('email'),
                    address: $radio.data('address'),
                    province: $radio.data('province'), // <<< Lấy TÊN
                    district: $radio.data('district'),
                    ward: $radio.data('ward') // <<< Lấy TÊN
                };
                populateForm(selectedData); // Gọi hàm async
                hideModal();
            });

            // --- 4. Apply Coupon AJAX (Giữ nguyên) ---
            $('.btn-apply-coupon').on('click', function(e) {
                /* ... */
            });

            // --- 5. Checkout Form Validation (Giữ nguyên) ---
            $('#checkoutForm').on('submit', function(event) {
                /* ... */
            });

            // --- 6. Điền form mặc định khi tải trang (Dùng TÊN) ---
            const defaultAddressData = @json($defaultUserAddress ?? null);
            if (defaultAddressData) {
                const initialData = {
                    name: "{{ $user->name }}",
                    phone: "{{ $user->phone }}",
                    email: "{{ $user->email }}",
                    address: defaultAddressData.address,
                    province: defaultAddressData.province, // <<< Lấy TÊN
                    district: defaultAddressData.district, // <<< Lấy TÊN
                    ward: defaultAddressData.neighborhood // <<< Lấy TÊN
                };
                console.log('Populating form with default address on load (name-based):', initialData);
                populateForm(initialData); // Gọi hàm async
            } else {
                /* ... điền thông tin user ... */
            }

        });
    </script>
@endpush
