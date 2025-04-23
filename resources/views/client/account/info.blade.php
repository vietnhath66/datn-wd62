    <div class="update-info">
        <div class="section-title">Cập nhật thông tin</div>
        <div class="section-desc">
            Cập nhật và chỉnh sửa thông tin cá nhân của bạn một cách dễ dàng.
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <form id="accountForm" action="{{ route('update.profile') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="form-group">
                <label>Ảnh đại diện</label>
                <input type="file" id="avatar" name="avatar" accept="image/*" />
                @if (Auth::user()->avt)
                    <img src="{{ asset('storage/avatars/' .  Auth::user()->avt) }}" alt="Avatar" width="100" />
                @endif
                <div class="error" id="avatarError">
                    Vui lòng chọn một file ảnh.
                </div>
            </div>

            <div class="form-group">
                <label>Tên người dùng</label>
                <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" required
                    pattern="^[\p{L}\s]+$" minlength="2" />
                <div class="error" id="nameError">
                    Tên chỉ được chứa chữ cái và khoảng trắng, tối thiểu 2 ký tự.
                </div>
            </div>

            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="tel" id="phone" name="phone" value="{{ Auth::user()->phone }}" required
                    pattern="[0-9\s]+" minlength="10" />
                <div class="error" id="phoneError">
                    Số điện thoại phải bắt đầu bằng "+" và chỉ chứa số, tối thiểu 10 ký tự.
                </div>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" required />
                <div class="error" id="emailError">Vui lòng nhập email hợp lệ.</div>
            </div>
            <div class="form-actions">
                <button type="button" class="cancel-btn">Hủy</button>
                <button type="submit" class="save-btn">Lưu thay đổi</button>
            </div>
        </form>
    </div>
