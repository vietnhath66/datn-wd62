console.log("File product.js đã được load thành công");

document.addEventListener("DOMContentLoaded", function () {
    const quantityInput = document.querySelector(".num-product");
    const btnIncrease = document.querySelector(".btn-num-product-up");
    const btnDecrease = document.querySelector(".btn-num-product-down");
    const stockInfo = document.getElementById("stock-info");
    const addToCartBtn = document.getElementById("add-to-cart");
    const colorSelect = document.getElementById("color-select");
    const sizeSelect = document.getElementById("size-select");

    let maxStock = 0; // Số lượng tối đa trong kho
    let currentStock = 0; // Số lượng hiện có trong kho
    let productId = 40; // ID sản phẩm (lấy từ blade hoặc biến JavaScript)

    // Khi chọn màu -> Load size tương ứng
    colorSelect.addEventListener("change", function () {
        const selectedColor = this.value;
        sizeSelect.innerHTML = '<option value="">Chọn size</option>';
        sizeSelect.disabled = true;

        if (!selectedColor) return;

        fetch(`/get-stock?product_id=${productId}&color=${selectedColor}`)
            .then(response => response.json())
            .then(data => {
                if (data.stock > 0) {
                    stockInfo.textContent = `Số lượng trong kho: ${data.stock}`;
                    stockInfo.style.color = "black";
                    sizeSelect.disabled = false; // Mở khóa dropdown size
                } else {
                    stockInfo.textContent = "Sản phẩm này đã hết hàng!";
                    stockInfo.style.color = "red";
                    addToCartBtn.disabled = true;
                }
            });
    });

    // Khi chọn size -> Load số lượng tồn kho
    sizeSelect.addEventListener("change", function () {
        const selectedColor = colorSelect.value;
        const selectedSize = this.value;

        if (!selectedColor || !selectedSize) return;

        fetch(`/get-stock?product_id=${productId}&color=${selectedColor}&size=${selectedSize}`)
            .then(response => response.json())
            .then(data => {
                maxStock = data.stock;
                currentStock = data.stock;
                quantityInput.value = 1;
                quantityInput.max = maxStock;

                if (maxStock > 0) {
                    stockInfo.textContent = `Số lượng trong kho: ${maxStock}`;
                    stockInfo.style.color = "black";
                    addToCartBtn.disabled = false;
                } else {
                    stockInfo.textContent = "Sản phẩm này đã hết hàng!";
                    stockInfo.style.color = "red";
                    addToCartBtn.disabled = true;
                }
            });
    });

    // Xử lý khi nhấn nút tăng số lượng
    btnIncrease.addEventListener("click", function () {
        let currentValue = parseInt(quantityInput.value);
        if (currentValue < maxStock) {
            quantityInput.value = currentValue + 1;
            currentStock -= 1;
        } else {
            alert("Số lượng sản phẩm đã đạt tối đa trong kho!");
        }
        updateDisplay();
    });

    // Xử lý khi nhấn nút giảm số lượng
    btnDecrease.addEventListener("click", function () {
        let currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
            currentStock += 1;
        }
        updateDisplay();
    });

    // Kiểm tra trạng thái kho
    function updateDisplay() {
        stockInfo.textContent = `Số lượng trong kho: ${currentStock}`;
        if (currentStock === 0) {
            stockInfo.textContent = "Sản phẩm này đã hết hàng!";
            stockInfo.style.color = "red";
            addToCartBtn.disabled = true;
        } else {
            stockInfo.style.color = "black";
            addToCartBtn.disabled = false;
        }
    }
});
<script src="{{ asset('js/product.js') }}"></script>