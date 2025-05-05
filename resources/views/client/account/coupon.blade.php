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

    .coupons-section {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .coupons-section:hover {
        transform: translateY(-5px);
    }

    .coupons-section .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #222222;
        margin-bottom: 15px;
    }

    .coupons-section .section-desc {
        font-size: 0.95rem;
        color: #666;
        margin-bottom: 25px;
        line-height: 1.6;
    }

    .coupon-list {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .coupon-item {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        width: calc(33.33% - 14px);
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }

    .coupon-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .coupon-item .code {
        font-size: 1.1rem;
        font-weight: 600;
        color: #222222;
        margin-bottom: 10px;
    }

    .coupon-item .discount {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 10px;
    }

    .coupon-item .expiry {
        font-size: 0.85rem;
        color: #999;
    }

    .coupon-item .status {
        margin-top: 10px;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .coupon-item .status.active {
        background: #55efc4;
        color: #006266;
    }

    .coupon-item .status.expired {
        background: #ff7675;
        color: #fff;
    }

    .no-coupons {
        text-align: center;
        color: #666;
        font-size: 1rem;
        padding: 20px;
    }
</style>

<div class="coupons-section">
    <div class="section-title">Phiếu giảm giá</div>
    <div class="section-desc">
        Danh sách các phiếu giảm giá bạn có thể sử dụng.
    </div>

    <div class="coupon-list">
        @forelse($coupons as $coupon)
            <div class="coupon-item">
                <div class="code">{{ $coupon->code }}</div>
                <div class="discount">{{ $coupon->discount_type }}: {{ $coupon->discount_value }}%</div>
                <div class="expiry">Hết hạn: {{ \Carbon\Carbon::parse($coupon->end_date)->format('d/m/Y') }}</div>
                <div class="status {{ $coupon->end_date >= now() ? 'active' : 'expired' }}">
                    {{ $coupon->end_date >= now() ? 'Còn hiệu lực' : 'Hết hạn' }}
                </div>
            </div>
        @empty
            <div class="no-coupons">Bạn chưa có phiếu giảm giá nào.</div>
        @endforelse
    </div>
</div>
