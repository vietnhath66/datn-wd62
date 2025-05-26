<div class="user-info">
    <div class="avatar">
        <img src="{{ asset('storage/' . Auth::user()->avt) }}" alt="" class="rounded-circle" width="90"
            height="90">
    </div>
    <div class="details">
        <div class="name">{{ Auth::user()->name }}</div>
        <div class="role">{{ Auth::user()->roles->name ?? 'Không xác định' }}</div>
        <div class="stats">
            <div class="stat-item">
                <i class="fas fa-shopping-cart"></i> 0 VND
            </div>
            <div class="stat-item">
                <i class="fas fa-clock"></i> Đơn hàng đã đặt: 0
            </div>
            <div class="stat-item">
                <i class="fas fa-clock"></i> Đơn hàng đã hủy: 0
            </div>
        </div>
    </div>
</div>

<!-- Navigation Tabs -->
<div class="nav-tabs">
    <a href="#" data-page="profile" class="active">Thông tin tài khoản</a>
    <a href="#" data-page="password">Mật khẩu</a>
    <a href="#" data-page="addresses">Địa chỉ</a>
    <a href="#" data-page="coupons">Phiếu giảm giá</a>
</div>



