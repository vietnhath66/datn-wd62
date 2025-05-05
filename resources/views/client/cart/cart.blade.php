@extends('client.master')

@section('title', 'Giỏ Hàng')

@push('style')
    <style>
        .cart-table {
            width: 100%;
            border-collapse: collapse;
        }

        .cart-table th,
        .cart-table td {
            padding: 15px;
            text-align: center;
            vertical-align: middle;
        }

        .cart-table th {
            background: #e9ecef;
            font-size: 14px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .cart-table td {
            font-size: 14px;
            color: #555;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.3s ease;
        }

        .cart-table tr:hover td {
            background-color: #f8f9fa;
        }

        .cart-table .product-img {
            width: 60px;
            height: 60px;
            border-radius: 6px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .cart-table .product-img:hover {
            transform: scale(1.1);
        }

        .cart-table .product-name {
            font-size: 15px;
            color: #333;
            text-align: center;
            font-weight: 500;
        }

        .cart-table .quantity-control {
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 20px;
            overflow: hidden;
            width: 110px;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .cart-table .quantity-btn {
            width: 35px;
            height: 35px;
            border: none;
            background: #f8f9fa;
            color: #555;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .cart-table .quantity-btn:hover {
            background: #e9ecef;
            transform: scale(1.1);
        }

        .cart-table .quantity-input {
            width: 40px;
            text-align: center;
            border: none;
            padding: 0;
            height: 35px;
            line-height: 35px;
            font-size: 14px;
        }

        .cart-table .btn-delete-cart-item {
            background: #f8d7da;
            color: #721c24;
            border: none;
            padding: 12px;
            border-radius: 15px;
            font-size: 14px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .cart-table .btn-delete-cart-item:hover {
            background: #f5c6cb;
            transform: scale(1.1);
        }

        .cart-table .empty-cart {
            padding: 20px;
            color: #777;
            font-size: 16px;
            text-align: center;
        }

        .cart-table .continue-shopping {
            padding: 8px 16px;
            display: inline-block;
            border-radius: 20px;
            background: #28a745;
            color: white;
            text-decoration: none;
            transition: transform 0.2s ease;
        }

        .cart-table .continue-shopping:hover {
            transform: scale(1.05);
        }
    </style>
@endpush

@section('content')
    @include('client.cart.titleCart')
    @include('client.cart.content')
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Hàm cập nhật số lượng qua AJAX
            function updateCartQuantity(cartItemId, newQuantity, quantityInput) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('client.cart.updateCart') }}',
                    data: {
                        cart_item_id: cartItemId,
                        quantity: newQuantity
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            console.log('AJAX Success Response:', response);
                            quantityInput.val(response.newQuantity);

                            // let stockDisplayElement = quantityInput.closest('td').find(
                            //     '.stock-quantity-display');

                            // if (stockDisplayElement.length && response.newStockQuantity !== undefined &&
                            //     response.newQuantity !== undefined) {
                            //     let remainingStockForUser = response.newStockQuantity - response
                            //         .newQuantity;
                            //     remainingStockForUser = Math.max(0, remainingStockForUser);
                            //     stockDisplayElement.text('Còn: ' + remainingStockForUser);
                            // }

                            let lineTotalCell = $(`.cart-table td[data-id='${cartItemId}']`);
                            if (lineTotalCell.length) {
                                let formattedLineTotal = new Intl.NumberFormat('vi-VN', {
                                    style: 'currency',
                                    currency: 'VND'
                                }).format(response.newLineTotal);
                                lineTotalCell.text(formattedLineTotal.replace(/\s*₫/, ' VND'));
                            }

                            let cartTotalElement = $('.cart-total');
                            if (cartTotalElement.length) {
                                let formattedCartTotal = new Intl.NumberFormat('vi-VN', {
                                    style: 'currency',
                                    currency: 'VND'
                                }).format(response.newCartTotal);

                                cartTotalElement.text(formattedCartTotal.replace(/\s*₫/, ' VND'));
                            }
                            updateSelectedTotal();
                        } else {
                            alert(response.message || "Có lỗi xảy ra từ server.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        alert("Số lượng của đơn hàng này đã hết.");
                    }
                });
            }


            function showEmptyCartMessage() {
                // console.log("Running showEmptyCartMessage...");
                $('.cart-items-container').hide(); // Ẩn div chứa bảng sản phẩm
                $('.cart-empty-message').show(); // Hiện div chứa thông báo trống
                $('.cart-summary-column').hide(); // Ẩn cột tổng tiền và nút đặt hàng
                console.log("Toggled visibility for empty cart.");
            }

            var $cartPlusButtons = $('.cart-table .btn-num-product-up');
            var $cartMinusButtons = $('.cart-table .btn-num-product-down');
            $cartPlusButtons.off('click');
            $cartMinusButtons.off('click');

            // Nút giảm
            $cartMinusButtons.on('click', function(e) {
                e.preventDefault();
                let button = $(this);
                let quantityInput = button.siblings('.quantity-input');
                let currentQuantity = parseInt(quantityInput.val());
                let cartItemId = button.closest('tr').find('.btn-delete-cart-item').data('cart-item-id');

                if (currentQuantity > 1) {
                    let newQuantity = currentQuantity - 1;
                    updateCartQuantity(cartItemId, newQuantity, quantityInput);
                } else {
                    alert("Số lượng ít nhất phải là 1");
                }
            });

            // Nút tăng
            $cartPlusButtons.on('click', function(e) {
                e.preventDefault();

                let button = $(this);
                let quantityInput = button.siblings('.quantity-input');
                let currentQuantity = parseInt(quantityInput.val());

                let cartItemId = button.closest('tr').find('.btn-delete-cart-item').data('cart-item-id');

                let newQuantity = currentQuantity + 1;
                updateCartQuantity(cartItemId, newQuantity, quantityInput);
            });


            $('#checkout-form').on('submit', function(event) {
                console.log("Sự kiện submit của #checkout-form đã được kích hoạt.");
                event.preventDefault();
                console.log("Đã ngăn chặn submit mặc định.");

                let checkedProducts = $('.product-checkbox:checked');

                console.log("Số lượng checkbox '.product-checkbox:checked' tìm thấy (toàn trang):",
                    checkedProducts.length);

                if (checkedProducts.length === 0) {
                    console.log("Điều kiện (length === 0) đúng. Chuẩn bị hiển thị alert.");
                    alert("Vui lòng chọn ít nhất một sản phẩm để đặt hàng.");
                    return false;
                } else {
                    console.log("Điều kiện (length > 0) đúng. Chuẩn bị lấy ID và submit.");

                    let selectedProductIds = [];
                    checkedProducts.each(function() {

                        let cartItemId = $(this).data('id');
                        if (cartItemId) {
                            selectedProductIds.push(cartItemId);
                        }
                    });
                    console.log("Các ID sản phẩm được chọn:", selectedProductIds);

                    if (selectedProductIds.length === 0) {
                        console.log("Lỗi: Không lấy được ID sản phẩm nào dù checkbox đã được chọn.");
                        alert("Đã xảy ra lỗi khi lấy thông tin sản phẩm được chọn. Vui lòng thử lại.");
                        return false;
                    }

                    $('#selected-products').val(selectedProductIds.join(','));
                    console.log("Đã gán giá trị cho #selected-products:", selectedProductIds.join(','));


                    console.log("Chuẩn bị submit form...");
                    this.submit();
                }
            });

            // Chức năng xoá
            $('.cart-table').on('click', '.btn-delete-cart-item', function(e) {
                e.preventDefault();

                let deleteButton = $(this);
                let cartItemId = deleteButton.data('cart-item-id');

                if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?")) {
                    let deleteUrl = '{{ route('client.cart.deleteCart', ['id' => ':id']) }}';
                    deleteUrl = deleteUrl.replace(':id', cartItemId);
                    $.ajax({
                        type: 'DELETE',
                        url: deleteUrl,
                        dataType: 'json',

                        success: function(response) {
                            if (response.success) {
                                alert(response.message || "Đã xóa sản phẩm thành công!");

                                deleteButton.closest('tr').fadeOut(300, function() {
                                    $(this).remove();

                                    if ($('.cart-table tbody tr').length === 0) {
                                        showEmptyCartMessage();
                                    }
                                });

                                let cartTotalElement = $('.cart-total');
                                if (cartTotalElement.length) {
                                    let formattedCartTotal = new Intl.NumberFormat('vi-VN', {
                                        style: 'currency',
                                        currency: 'VND'
                                    }).format(response.newCartTotal);
                                    cartTotalElement.text(formattedCartTotal.replace(/\s*₫/,
                                        ' VND'));
                                }

                                updateSelectedTotal();

                            } else {
                                alert(response.message || "Xóa sản phẩm thất bại.");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", status, error, xhr.responseText);
                            alert("Đã xảy ra lỗi kết nối hoặc lỗi server khi xóa sản phẩm.");
                        }
                    });
                }
            });

            // Cập nhật tổng tiền cho "Sản phẩm bạn chọn"
            function updateSelectedTotal() {
                let selectedTotal = 0;
                $('.product-checkbox:checked').each(function() {
                    let row = $(this).closest('tr');
                    let quantity = parseInt(row.find('.quantity-input').val());
                    let unitPrice = parseFloat(row.data('unit-price')) || 0;

                    if (quantity > 0 && unitPrice > 0) {
                        selectedTotal += unitPrice * quantity;
                    }
                });

                let formattedSelectedTotal = new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(selectedTotal);
                $('.selected-total').text(formattedSelectedTotal.replace(/\s*₫/, ' VND'));
            }

            $('.product-checkbox').on('change', function() {
                updateSelectedTotal();
            });

            updateSelectedTotal();

        });
    </script>
@endpush
