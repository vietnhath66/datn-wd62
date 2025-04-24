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

    .update-password {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .update-password:hover {
        transform: translateY(-5px);
    }

    .update-password .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #222222;
        margin-bottom: 15px;
    }

    .update-password .section-desc {
        font-size: 0.95rem;
        color: #666;
        margin-bottom: 25px;
        line-height: 1.6;
    }

    .update-password .form-group {
        margin-bottom: 25px;
    }

    .update-password .form-group label {
        display: block;
        font-size: 0.95rem;
        font-weight: 500;
        color: #222222;
        margin-bottom: 8px;
    }

    .update-password .form-group input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        font-size: 0.95rem;
        color: #222222;
        background: #f8f9fa;
        transition: all 0.3s ease;
    }

    .update-password .form-group input:focus {
        outline: none;
        border-color: #222222;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(34, 34, 34, 0.1);
    }

    .update-password .form-group .error {
        color: #e74c3c;
        font-size: 0.85rem;
        margin-top: 5px;
        display: none;
    }

    .update-password .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
    }

    .update-password .form-actions button {
        padding: 12px 30px;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        font-size: 0.95rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .update-password .form-actions .save-btn {
        background: #222222;
        color: #fff;
    }

    .update-password .form-actions .cancel-btn {
        background: #e9ecef;
        color: #222222;
    }

    .update-password .form-actions button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .update-password .form-actions .save-btn:hover {
        background: #333;
    }

    .update-password .form-actions .cancel-btn:hover {
        background: #dfe6e9;
    }
</style>

<!-- Form Cập Nhật Mật Khẩu -->
<div class="update-password">
    <div class="section-title">Đổi mật khẩu</div>
    <div class="section-desc">
        Cập nhật mật khẩu mới để bảo mật tài khoản của bạn.
    </div>

    <!-- Hiển thị thông báo thành công khi mật khẩu được cập nhật -->
    <div id="success-toast" class="alert alert-success" style="display: none; margin-bottom: 20px;">
        Mật khẩu đã được cập nhật thành công!
    </div>

    <div id="error-toast" class="alert alert-danger" style="display: none; margin-bottom: 20px;">
        Đã có lỗi xảy ra. Vui lòng kiểm tra lại các trường thông tin.
    </div>

    <form id="password-form" method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')

        <!-- Mật khẩu hiện tại -->
        <div class="form-group">
            <label for="currentPassword">Mật khẩu hiện tại</label>
            <input type="password" id="password" name="current_password" required minlength="6" />
             <div class="error"></div>
        </div>

        <!-- Mật khẩu mới -->
        <div class="form-group">
            <label for="newPassword">Mật khẩu mới</label>
            <input type="password" id="newPassword" name="password" required minlength="8" />
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Xác nhận mật khẩu mới -->
        <div class="form-group">
            <label for="confirmPassword">Xác nhận mật khẩu mới</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required />
            @error('password_confirmation')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Các nút hành động -->
        <div class="form-actions">
            <button type="button" class="cancel-btn" onclick="window.location.href='{{ url()->previous() }}'">Hủy</button>
            <button type="submit" class="save-btn">Lưu thay đổi</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('password-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        // Xóa lỗi cũ trước khi gửi
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
            if (response.ok) {
                showToast('success-toast', 'Mật khẩu đã được cập nhật!');
                form.reset();
            } else if (response.status === 422) {
                const data = await response.json();
                if (data.errors) {
                    Object.keys(data.errors).forEach(key => {
                        const errorEl = form.querySelector(`[name="${key}"]`)?.parentElement.querySelector('.error');
                        if (errorEl) {
                            errorEl.textContent = data.errors[key][0];
                            errorEl.style.display = 'block';
                        }
                    });
                }
            } else {
                console.error('Lỗi không xác định:', await response.text());
                showToast('error-toast', 'Đã xảy ra lỗi. Vui lòng thử lại.');
            }
        })
        .catch(err => {
            console.error('Lỗi fetch:', err);
            showToast('error-toast', 'Không thể gửi yêu cầu. Vui lòng kiểm tra kết nối.');
        });

        function showToast(id, message) {
            const toast = document.getElementById(id);
            if (toast) {
                toast.textContent = message;
                toast.style.display = 'block';
                setTimeout(() => {
                    toast.style.display = 'none';
                }, 3000);
            }
        }
    });
</script>
