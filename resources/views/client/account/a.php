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
