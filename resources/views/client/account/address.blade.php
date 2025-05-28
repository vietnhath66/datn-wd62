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
        height: 50px !important;
        /* CHÍNH chỗ để set chiều cao */
        padding: 10px 12px;
        border-radius: 0.5rem;
        font-size: 16px;
        border: 1px solid #ccc;
        display: flex;
        align-items: center;
        /* căn giữa văn bản theo chiều dọc */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 1.2;
        padding-left: 0;
        /* tránh padding đè lên text */
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
    /* Form Section */
.address-section {
  background: #fefefe;
  border: 1px solid #ddd;
  padding: 24px;
  border-radius: 12px;
  max-width: 700px;
  margin: 0 auto;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.section-title {
  font-size: 24px;
  font-weight: 600;
  color: #333;
  margin-bottom: 8px;
}

.section-desc {
  font-size: 14px;
  color: #777;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 16px;
}

.form-group label {
  display: block;
  font-weight: 500;
  margin-bottom: 6px;
  color: #444;
}

.form-group input,
.form-group select {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 14px;
}

.form-group select:disabled {
  background-color: #f9f9f9;
}

.form-actions {
  margin-top: 20px;
  text-align: right;
}

.save-btn {
  background-color: #3490dc;
  color: white;
  padding: 10px 20px;
  border: none;
  font-weight: 500;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.3s ease;
}

.save-btn:hover {
  background-color: #2779bd;
}

/* Address Table Display */
#addressDetailContainer h3,
#addressSummaryContainer h3 {
  font-size: 18px;
  margin-top: 30px;
  margin-bottom: 12px;
  color: #2c3e50;
}

#addressDetailContainer table {
  width: 100%;
  border-collapse: collapse;
  background-color: #fff;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 1px 4px rgba(0,0,0,0.05);
}

#addressDetailContainer th,
#addressDetailContainer td {
  padding: 12px;
  border-bottom: 1px solid #eee;
  text-align: left;
  font-size: 14px;
}

#addressDetailContainer tr:last-child td {
  border-bottom: none;
}

#addressDetailContainer button {
  margin-right: 8px;
  padding: 6px 14px;
  font-size: 13px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

#editBtn {
  background-color: #ffc107;
  color: #fff;
}

#deleteBtn {
  background-color: #e3342f;
  color: #fff;
}

#editBtn:hover {
  background-color: #e0a800;
}

#deleteBtn:hover {
  background-color: #cc1f1a;
}

/* Address Summary List */
#addressList {
  list-style: none;
  padding-left: 0;
}

#addressList li {
  background-color: #f1f5f9;
  padding: 10px 14px;
  border-radius: 6px;
  margin-bottom: 8px;
  font-size: 14px;
  color: #333;
  box-shadow: 0 1px 3px rgba(0,0,0,0.04);
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
            <input type="text" name="address" required placeholder="Nhập địa chỉ cụ thể" />
        </div>

        <div class="form-group">
            <label>Tỉnh/Thành phố</label>
            <select id="city" name="city" required>
                <option value="">Chọn tỉnh/thành phố</option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->name }}" data-code="{{ $province->code }}">{{ $province->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Quận/Huyện</label>
            <select id="district" name="district" required disabled>
                <option value="">Chọn quận/huyện</option>
            </select>
        </div>

        <div class="form-group">
            <label>Phường/Xã</label>
            <select id="ward" name="neighborhood" required disabled>
                <option value="">Chọn phường/xã</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="save-btn">Lưu thay đổi</button>
        </div>
    </form>
</div>
<div id="addressDetailContainer" style="margin-top: 20px;"></div>

<div id="addressSummaryContainer" style="margin-top: 20px;">
  <h3>Danh sách địa chỉ cụ thể</h3>
  <ul id="addressList"></ul>
</div>

<script>
  const form = document.getElementById('addressForm');
  const detailContainer = document.getElementById('addressDetailContainer');
  const summaryList = document.getElementById('addressList');

  let currentAddress = null; // lưu địa chỉ đang hiển thị sửa/xoá

  form.addEventListener('submit', function(e) {
    e.preventDefault();

    // Lấy dữ liệu từ form
    const address = form.address.value.trim();
    const city = form.city.options[form.city.selectedIndex]?.text || '';
    const district = form.district.options[form.district.selectedIndex]?.text || '';
    const neighborhood = form.ward.options[form.ward.selectedIndex]?.text || '';

    currentAddress = {address, city, district, neighborhood};

    // Hiển thị chi tiết đầy đủ (bảng + nút Sửa/Xoá)
    renderDetail(currentAddress);

    // Cập nhật danh sách địa chỉ cụ thể chỉ hiển thị địa chỉ cụ thể
    updateSummaryList([currentAddress]); // giả sử chỉ 1 địa chỉ, sau này bạn mở rộng mảng

    form.reset();
    form.district.disabled = true;
    form.ward.disabled = true;
  });

  function renderDetail(addr) {
    detailContainer.innerHTML = `
      <h3>Thông tin địa chỉ vừa nhập</h3>
      <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; max-width: 600px; width: 100%;">
        <tr><th style="text-align:left; width: 150px;">Địa chỉ cụ thể</th><td>${addr.address}</td></tr>
        <tr><th style="text-align:left;">Tỉnh/Thành phố</th><td>${addr.city}</td></tr>
        <tr><th style="text-align:left;">Quận/Huyện</th><td>${addr.district}</td></tr>
        <tr><th style="text-align:left;">Phường/Xã</th><td>${addr.neighborhood}</td></tr>
      </table>
      <div style="margin-top: 10px;">
        <button id="editBtn" type="button">Sửa</button>
        <button id="deleteBtn" type="button">Xoá</button>
      </div>
    `;

    document.getElementById('editBtn').addEventListener('click', () => {
      form.address.value = addr.address;
      selectOptionByText(form.city, addr.city);
      selectOptionByText(form.district, addr.district);
      selectOptionByText(form.ward, addr.neighborhood);
      form.address.focus();
    });

    document.getElementById('deleteBtn').addEventListener('click', () => {
      currentAddress = null;
      detailContainer.innerHTML = '';
      summaryList.innerHTML = '';
      form.reset();
      form.district.disabled = true;
      form.ward.disabled = true;
    });
  }

  // Cập nhật danh sách địa chỉ cụ thể (chỉ hiển thị địa chỉ)
  function updateSummaryList(addresses) {
    summaryList.innerHTML = '';
    addresses.forEach(addr => {
      const li = document.createElement('li');
li.textContent = addr.address;
      summaryList.appendChild(li);
    });
  }

  function selectOptionByText(selectElement, text) {
    for(let i=0; i < selectElement.options.length; i++) {
      if(selectElement.options[i].text === text) {
        selectElement.selectedIndex = i;
        return;
      }
    }
    selectElement.selectedIndex = 0;
  }
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const citySelectNative = document.getElementById('city');
        const districtSelectNative = document.getElementById('district');
        const wardSelectNative = document.getElementById('ward');

        // Lấy đối tượng jQuery cho các select để dùng Select2
        const $citySelect = $(citySelectNative);
        const $districtSelect = $(districtSelectNative);
        const $wardSelect = $(wardSelectNative);


        // --- 1. Khởi tạo Select2 cho các dropdown ---
        // Sử dụng placeholder và cho phép xóa (allowClear)
        $citySelect.select2({
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

        // Khi thay đổi tỉnh (city)
        $citySelect.on('change', function() { // Sử dụng listener của jQuery cho Select2
            const cityCode = $(this).find(':selected').data('code'); // Lấy mã thành phố từ data-code

            // Reset và disable các dropdown con
            $districtSelect.html('<option value="">Chọn quận/huyện</option>');
            $districtSelect.prop('disabled', true);
            $districtSelect.trigger('change'); // Thông báo cho Select2 biết options đã thay đổi

            $wardSelect.html('<option value="">Chọn phường/xã</option>');
            $wardSelect.prop('disabled', true);
            $wardSelect.trigger('change'); // Thông báo cho Select2 biết options đã thay đổi

            // Nếu có chọn thành phố
            if (cityCode) {
                // Gọi API lấy quận huyện theo mã thành phố
                fetch(`/get-districts/${cityCode}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            // Xử lý trường hợp không có dữ liệu hoặc lỗi trả về message
                            $districtSelect.html(`<option value="">${data.message}</option>`);
                            $districtSelect.prop('disabled',
                                true); // Vô hiệu hóa nếu không có dữ liệu
                        } else {
                            // Thêm options mới và enable dropdown
                            let optionsHtml = '<option value="">Chọn quận/huyện</option>';
                            data.forEach(item => {
                                optionsHtml +=
                                    `<option value="${item.full_name}" data-code="${item.code}">${item.full_name}</option>`;
                            });
                            $districtSelect.html(optionsHtml);
                            $districtSelect.prop('disabled', false); // Enable nếu có dữ liệu
                        }
                        // Trigger change để Select2 cập nhật giao diện sau khi thêm options
                        $districtSelect.trigger('change');
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
            const districtCode = $(this).find(':selected').data(
                'code'); // Lấy mã quận huyện từ data-code

            // Reset và disable dropdown con
            $wardSelect.html('<option value="">Chọn phường/xã</option>');
            $wardSelect.prop('disabled', true);
            $wardSelect.trigger('change'); // Thông báo cho Select2 biết options đã thay đổi

            // Nếu có chọn quận huyện
            if (districtCode) {
                // Gọi API lấy phường xã theo mã quận huyện
                fetch(`/get-wards/${districtCode}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            // Xử lý trường hợp không có dữ liệu hoặc lỗi trả về message
                            $wardSelect.html(`<option value="">${data.message}</option>`);
                            $wardSelect.prop('disabled', true); // Vô hiệu hóa nếu không có dữ liệu
                        } else {
                            // Thêm options mới và enable dropdown
                            let optionsHtml = '<option value="">Chọn phường/xã</option>';
                            data.forEach(item => {
                                optionsHtml +=
                                    `<option value="${item.full_name}" data-code="${item.code}">${item.full_name}</option>`;
                            });
                            $wardSelect.html(optionsHtml);
                            $wardSelect.prop('disabled', false); // Enable nếu có dữ liệu
                        }
                        // Trigger change để Select2 cập nhật giao diện sau khi thêm options
                        $wardSelect.trigger('change');
                    })
                    .catch(error => {
                        console.error('Lỗi khi lấy phường/xã:', error);
                        $wardSelect.html('<option value="">Lỗi khi tải phường/xã</option>');
                        $wardSelect.prop('disabled', true);
                        $wardSelect.trigger('change');
                    });
            }
        });
    });
</script>
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
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('addressForm');

        form.addEventListener('submit', function(e) {
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
    document.addEventListener('DOMContentLoaded', function() {
        const citySelect = document.getElementById('city');
        const districtSelect = document.getElementById('district');
        const wardSelect = document.getElementById('ward');

        // Khi thay đổi tỉnh (city)
        citySelect.addEventListener('change', function() {
            const cityCode = this.selectedOptions[0].dataset.code; // Lấy mã thành phố từ data-code

            // Nếu chưa chọn thành phố, vô hiệu hóa quận huyện và phường xã
            if (!cityCode) {
                districtSelect.disabled = true;
                districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
                wardSelect.disabled = true;
                wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
                return;
            }

            // Bật quận huyện và gọi API lấy quận huyện theo mã thành phố
            districtSelect.disabled = false;
            fetch(`/get-districts/${cityCode}`)
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        districtSelect.innerHTML = `<option value="">${data.message}</option>`;
                        wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
                        wardSelect.disabled = true;
                    } else {
                        districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
                        data.forEach(item => {
                            districtSelect.innerHTML +=
                                `<option value="${item.full_name}" data-code="${item.code}">${item.full_name}</option>`;
                        });
                        wardSelect.disabled = true;
                        wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi lấy quận/huyện:', error);
                    districtSelect.innerHTML = '<option value="">Lỗi khi tải quận/huyện</option>';
                    wardSelect.disabled = true;
                    wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
                });
        });

        // Khi thay đổi quận huyện
        districtSelect.addEventListener('change', function() {
            const districtCode = this.selectedOptions[0].dataset.code; // Lấy mã quận huyện từ data-code

            // Nếu chưa chọn quận huyện, vô hiệu hóa phường xã
            if (!districtCode) {
                wardSelect.disabled = true;
                wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
                return;
            }

            // Bật phường xã và gọi API lấy phường xã theo mã quận huyện
            wardSelect.disabled = false;
            fetch(`/get-wards/${districtCode}`)
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        wardSelect.innerHTML = `<option value="">${data.message}</option>`;
                    } else {
                        wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
                        data.forEach(item => {
                            wardSelect.innerHTML +=
                                `<option value="${item.full_name}" data-code="${item.code}">${item.full_name}</option>`;
                        });
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi lấy phường/xã:', error);
                    wardSelect.innerHTML = '<option value="">Lỗi khi tải phường/xã</option>';
                });
        });
    });
</script>
