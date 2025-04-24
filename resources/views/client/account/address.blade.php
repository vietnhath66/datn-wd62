<style>
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .header .breadcrumb {
        font-size: 0.9rem;
        color: #666;
    }

    .header .breadcrumb a {
        color: #222222;
        text-decoration: none;
        font-weight: 500;
    }

    .header .actions {
        display: flex;
        gap: 12px;
    }

    .header .actions button {
        padding: 10px 20px;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .header .actions .contact-btn {
        background: #e9ecef;
        color: #222222;
    }

    .header .actions .hire-btn {
        background: #222222;
        color: #fff;
    }

    .header .actions .more-btn {
        background: #e9ecef;
        color: #222222;
    }

    .header .actions button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .header .actions .contact-btn:hover {
        background: #dfe6e9;
    }

    .header .actions .hire-btn:hover {
        background: #333;
    }

    .user-info {
        display: flex;
        align-items: center;
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
        transition: transform 0.3s ease;
    }

    .user-info:hover {
        transform: translateY(-5px);
    }

    .user-info .avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: linear-gradient(135deg, #222222 0%, #444 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: #fff;
        margin-right: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .user-info .details {
        flex: 1;
    }

    .user-info .details .name {
        font-size: 1.8rem;
        font-weight: 600;
        color: #222222;
    }

    .user-info .details .role {
        font-size: 0.95rem;
        color: #666;
        margin-bottom: 15px;
        font-weight: 500;
    }

    .user-info .stats {
        display: flex;
        gap: 25px;
        margin-top: 10px;
    }

    .user-info .stats .stat-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        color: #666;
        background: #f8f9fa;
        padding: 8px 15px;
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .user-info .stats .stat-item:hover {
        background: #e9ecef;
    }

    .user-info .stats .stat-item i {
        color: #222222;
    }

    .nav-tabs {
        display: flex;
        gap: 15px;
        margin-bottom: 30px;
        border-bottom: 1px solid #e9ecef;
    }

    .nav-tabs a {
        padding: 12px 25px;
        text-decoration: none;
        color: #666;
        font-size: 1rem;
        font-weight: 500;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
    }

    .nav-tabs a.active {
        color: #222222;
        border-bottom: 3px solid #222222;
        font-weight: 600;
    }

    .nav-tabs a:hover {
        color: #222222;
        background: #f8f9fa;
        border-radius: 5px 5px 0 0;
    }

    .address-section {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    /* .address-section:hover {
        transform: translateY(-5px);
    } */

    .address-section .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #222222;
        margin-bottom: 15px;
    }

    .address-section .section-desc {
        font-size: 0.95rem;
        color: #666;
        margin-bottom: 25px;
        line-height: 1.6;
    }

    .address-section .form-group {
        margin-bottom: 25px;
    }

    .address-section .form-group label {
        display: block;
        font-size: 0.95rem;
        font-weight: 500;
        color: #222222;
        margin-bottom: 8px;
    }

    .address-section .form-group input,
    .address-section .form-group select {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        font-size: 0.95rem;
        color: #222222;
        background: #f8f9fa;
        transition: all 0.3s ease;
    }

    .address-section .form-group input:focus,
    .address-section .form-group select:focus {
        outline: none;
        border-color: #222222;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(34, 34, 34, 0.1);
    }

    .address-section .form-group .error {
        color: #e74c3c;
        font-size: 0.85rem;
        margin-top: 5px;
        display: none;
    }

    .address-section .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
    }

    .address-section .form-actions button {
        padding: 12px 30px;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        font-size: 0.95rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .address-section .form-actions .save-btn {
        background: #222222;
        color: #fff;
    }

    .address-section .form-actions .cancel-btn {
        background: #e9ecef;
        color: #222222;
    }

    .address-section .form-actions button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .address-section .form-actions .save-btn:hover {
        background: #333;
    }

    .address-section .form-actions .cancel-btn:hover {
        background: #dfe6e9;
    }

    .select2-container--default .select2-selection--single {
    height: 50px !important; /* CHÍNH chỗ để set chiều cao */
    padding: 10px 12px;
    border-radius: 4px;
    font-size: 16px;
    border: 1px solid #ccc;
    display: flex;
    align-items: center; /* căn giữa văn bản theo chiều dọc */
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 1.2;
    padding-left: 0; /* tránh padding đè lên text */
    color: #495057;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 50px !important;
}

select:disabled {
    background-color: #f0f0f0;
    color: #999;
    cursor: not-allowed;
}
</style>

<div id="snackbar" class="snackbar"></div>
<!-- Form Cập Nhật Địa Chỉ -->
<div class="address-section">
    <div class="section-title">Cập nhật địa chỉ</div>
    <div class="section-desc">
        Thêm hoặc chỉnh sửa địa chỉ giao hàng của bạn.
    </div>


    <form id="addressForm" method="POST" action="{{ route('address.store') }}">
        @csrf
        <div class="form-group">
            <label>Địa chỉ cụ thể</label>
            <input type="text" id="address" placeholder="Nhập địa chỉ cụ thể của bạn" name="address" required minlength="5" />
        </div>
        <div class="form-group">
            <label>Tỉnh/Thành phố</label>
            <select id="city" name="city" required>
                <option value="">Chọn tỉnh/thành phố</option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->name }}">{{ $province->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Quận/Huyện</label>
            <select id="district" name="district" required>
                <option value="">Chọn quận/huyện</option>
                @foreach ($districts as $district)
                    <option value="{{ $district->name }}">{{ $district->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Phường/Xã</label>

            <select id="ward" name="neighborhood" required>
                <option value="">Chọn phường/xã</option>
                @foreach ($wards as $ward)
                    <option value="{{ $ward->name }}">{{ $ward->name }}</option>
                @endforeach

            </select>
        </div>

        <div class="form-actions">
            <button type="button" class="cancel-btn">Hủy</button>
            <button type="submit" class="save-btn">Lưu thay đổi</button>
        </div>

    </form>
</div>
<script>
    // Hàm hiển thị toast
    function showToast(id, message) {
        const snackbar = document.getElementById('snackbar');
        if (!snackbar) return;

        snackbar.textContent = message;
        snackbar.className = 'snackbar show';

        // Ẩn sau 3 giây
        setTimeout(() => {
            snackbar.className = 'snackbar';
        }, 3000);
    }

    document.addEventListener('DOMContentLoaded', function() {

        const form = document.getElementById('addressForm');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(form);


            // Xóa lỗi cũ (nếu có)
            form.querySelectorAll('.error').forEach(el => {
                el.style.display = 'none';
                el.textContent = '';
            });

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                })
                .then(async response => {
                    let data;
                    try {
                        data = await response.json();

                    } catch (err) {

                        return showToast('error-toast', 'Lỗi xử lý phản hồi từ server.');
                    }
                    if (response.ok) {
                        showToast('success-toast', data.message || 'Địa chỉ đã được cập nhật!');
                        form.reset(); // Xóa form sau khi thêm thành công (nếu muốn)
                    } else if (response.status === 422) {
                        showToast('error-toast', 'Vui lòng kiểm tra lại thông tin.');
                    } else {
                        showToast('error-toast', data.message ||
                            'Đã xảy ra lỗi. Vui lòng thử lại.');
                    }
                })
                .catch(err => {
                    showToast('error-toast', 'Không thể gửi yêu cầu.');
                });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#city').select2({
            placeholder: 'Chọn tỉnh/thành phố',
            allowClear: true,
            width: '100%' // rất quan trọng để giữ giao diện full như form-control
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#district').select2({
            placeholder: 'Chọn quận/huyện',
            allowClear: true,
            width: '100%' // rất quan trọng để giữ giao diện full như form-control
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#ward').select2({
            placeholder: 'Chọn phường/xã',
            allowClear: true,
            width: '100%' // rất quan trọng để giữ giao diện full như form-control
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('addressForm');

        form.addEventListener('submit', function (e) {
            // Đợi form submit thành công rồi reset form
            // Nếu bạn redirect lại thì dùng đoạn này ở trang load lại

            // Reset sau 500ms nếu form không redirect (AJAX hoặc không có lỗi)
            setTimeout(() => {
                form.reset();

                // Nếu bạn dùng Select2 hoặc plugin khác thì cần reset thủ công
                $('#city').val('').trigger('change');
                $('#district').val('').trigger('change');
                $('#ward').val('').trigger('change');
            }, 500);
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const citySelect = $('#city');
        const districtSelect = $('#district');
        const wardSelect = $('#ward');

        // Khởi tạo select2
        citySelect.select2();
        districtSelect.select2();
        wardSelect.select2();

        // Kiểm tra xem có giá trị không (old value)
        const hasCity = citySelect.val() !== '';
        const hasDistrict = districtSelect.val() !== '';
        const hasWard = wardSelect.val() !== '';

        districtSelect.prop('disabled', !hasCity);
        wardSelect.prop('disabled', !hasDistrict);

        // Khi chọn Tỉnh
        citySelect.on('change', function () {
            districtSelect.val('').trigger('change');
            wardSelect.val('').trigger('change');

            districtSelect.prop('disabled', !this.value);
            wardSelect.prop('disabled', true);
        });

        // Khi chọn Quận
        districtSelect.on('change', function () {
            wardSelect.val('').trigger('change');
            wardSelect.prop('disabled', !this.value);
        });
    });
</script>
