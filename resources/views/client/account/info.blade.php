    <div class="update-info">
        <div class="section-title">Cập nhật thông tin</div>
        <div class="section-desc">
            Cập nhật và chỉnh sửa thông tin cá nhân của bạn một cách dễ dàng.
        </div>
        <form id="accountForm" novalidate>
            <div class="form-group">
                <label>Ảnh đại diện</label>
                <input type="file" id="avatar" name="avatar" accept="image/*" />
                <div class="error" id="avatarError">
                    Vui lòng chọn một file ảnh.
                </div>
            </div>
            <div class="form-group">
                <label>Tên người dùng</label>
                <input type="text" id="name" name="name" value="Nguyen Viet Nhat" required
                    pattern="[A-Za-z\s]+" minlength="2" />
                <div class="error" id="nameError">
                    Tên chỉ được chứa chữ cái và khoảng trắng, tối thiểu 2 ký tự.
                </div>
            </div>
            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="tel" id="phone" name="phone" value="+855 8456 555 23" required
                    pattern="\+[0-9\s]+" minlength="10" />
                <div class="error" id="phoneError">
                    Số điện thoại phải bắt đầu bằng "+" và chỉ chứa số, tối thiểu 10
                    ký tự.
                </div>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" id="email" name="email" value="user@example.com" required />
                <div class="error" id="emailError">Vui lòng nhập email hợp lệ.</div>
            </div>
            <div class="form-actions">
                <button type="button" class="cancel-btn">Hủy</button>
                <button type="submit" class="save-btn">Lưu thay đổi</button>
            </div>
        </form>
    </div>
