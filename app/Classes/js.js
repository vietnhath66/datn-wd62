{/* <script>
document.addEventListener('DOMContentLoaded', function () {
    console.log('JavaScript đã được tải');

    // Kiểm tra lại các giá trị của variants để đảm bảo dữ liệu được truyền đúng
    const variants = @json($variants);
    console.log('Dữ liệu variants:', variants);

    const colorSelectElement = document.getElementById('color-select');
    const sizeSelect = document.getElementById('size-select');

    if (!colorSelectElement || !sizeSelect) {
        console.log('Không tìm thấy dropdown màu sắc hoặc size');
        return;
    }

    // Lắng nghe sự kiện thay đổi màu
    colorSelectElement.addEventListener('change', function() {
        console.log('Sự kiện change đã được kích hoạt'); // Kiểm tra sự kiện có chạy không

        const selectedColor = this.value.trim();
        console.log('Màu đã chọn:', selectedColor); // Kiểm tra giá trị màu đã chọn

        // Clear dropdown size trước khi thêm các size mới
        sizeSelect.innerHTML = '<option value="">Choose a size</option>';

        if (selectedColor) {
            // Lọc các biến thể với màu đã chọn
            const availableSizes = variants.filter(variant => variant.name_variant_color.trim() === selectedColor);
            console.log('Các size có sẵn cho màu:', availableSizes);

            // Lọc và lấy các size duy nhất
            const uniqueSizes = [...new Set(availableSizes.map(variant => variant.name_variant_size))];
            console.log('Các size duy nhất:', uniqueSizes);

            if (uniqueSizes.length > 0) {
                // Thêm các size vào dropdown
                uniqueSizes.forEach(size => {
                    const option = document.createElement('option');
                    option.value = size;
                    option.textContent = size;
                    sizeSelect.appendChild(option);
                });
                sizeSelect.disabled = false; // Kích hoạt dropdown size
            } else {
                sizeSelect.disabled = true; // Nếu không có size thì vô hiệu hóa dropdown size
            }
        } else {
            sizeSelect.disabled = true; // Nếu không có màu thì vô hiệu hóa dropdown size
        }
    });
});
</script> */}