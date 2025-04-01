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
        document.addEventListener("DOMContentLoaded", function() {
            const quantityInputs = document.querySelectorAll(".quantity-input");
            const checkboxes = document.querySelectorAll(".product-checkbox");
            const selectedTotal = document.querySelector(".selected-total");
            const placeOrderBtn = document.getElementById("placeOrderBtn");
            const selectedProductsInput = document.getElementById("selected-products");

            placeOrderBtn.addEventListener("click", function(event) {
                event.preventDefault();

                let selectedProducts = [];
                document.querySelectorAll(".product-checkbox:checked").forEach(checkbox => {
                    selectedProducts.push({
                        product_id: checkbox.dataset.id,
                        product_variant_id: checkbox.dataset.variant,
                        quantity: checkbox.dataset.quantity,
                        price: checkbox.dataset.price
                    });
                });

                if (selectedProducts.length === 0) {
                    alert("Bạn phải chọn ít nhất 1 sản phẩm để đặt hàng!");
                    return;
                }

                selectedProductsInput.value = JSON.stringify(selectedProducts);
                document.getElementById("checkout-form").submit();
            });

            document.querySelectorAll('.btn-delete-cart-item').forEach(button => {
                button.addEventListener('click', function() {
                    // e.preventDefault();

                    let cartItemId = this.dataset.cartItemId;
                    let url = `delete-cart/${cartItemId}`;
                    let token = document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content');

                    if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này?")) {
                        fetch(url, {
                                method: "DELETE",
                                headers: {
                                    "X-CSRF-TOKEN": token,
                                    "X-Requested-With": "XMLHttpRequest"
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                alert(data.message);
                                location.reload();
                            })
                            .catch(error => console.error('Lỗi:', error));
                    }
                });
            });

            function updateSelectedTotal() {
                let total = 0;
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        total += parseFloat(checkbox.getAttribute("data-price"));
                    }
                });
                selectedTotal.textContent = total.toLocaleString("vi-VN") + " VND";
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", updateSelectedTotal);
            });

            quantityInputs.forEach(input => {
                input.addEventListener("change", function() {
                    const form = this.closest("form");
                    form.submit();
                });
            });

            const buttons = document.querySelectorAll(".btn-num-product-up, .btn-num-product-down");
            buttons.forEach(button => {
                button.addEventListener("click", function() {
                    const input = this.closest(".quantity-control").querySelector(
                        ".quantity-input");
                    let newValue = parseInt(input.value);

                    if (this.classList.contains("btn-num-product-up")) {
                        newValue++;
                    } else if (this.classList.contains("btn-num-product-down") && newValue > 1) {
                        newValue--;
                    }

                    input.value = newValue;
                    input.dispatchEvent(new Event(
                        "change"));
                });
            });
        });
    </script>
@endpush
