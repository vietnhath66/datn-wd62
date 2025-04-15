@extends('shipper.master-shipper')

@section('title', 'Tài Khoản')

@push('style')
@endpush

@section('content-shipper')
    <div class="container mt-4 animate__animated animate__fadeIn">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="account-card">
                    <div class="account-card-header">
                        <h4 class="m-0">
                            <i class="fas fa-user-circle mr-2"></i> Tài Khoản Của Tôi
                        </h4>
                        <button class="btn btn-sm btn-info btn-action" data-toggle="modal" data-target="#editAccountModal">
                            <i class="fas fa-edit mr-2"></i> Chỉnh sửa
                        </button>
                    </div>
                    <div class="account-card-body">
                        <h5 class="account-section-title">
                            <i class="fas fa-id-card mr-2"></i> Thông Tin Cá Nhân
                        </h5>

                        {{-- Hiển thị thông tin động --}}
                        @if (Auth::check())
                            @php
                                // Controller nên truyền biến $user đã load profile sang
                                // Nếu không thì dùng Auth::user() và tự load
                                $currentUser = $user ?? Auth::user(); // Ưu tiên biến $user từ controller
                                $shipperProfile = optional($currentUser->shipperProfile);
                            @endphp
                            <div class="account-info-item">
                                <i class="fas fa-signature account-info-icon"></i>
                                <span>Họ và Tên: <span
                                        class="account-name">{{ $currentUser->name ?? 'Chưa cập nhật' }}</span></span>
                            </div>
                            <div class="account-info-item">
                                <i class="fas fa-envelope account-info-icon"></i>
                                <span>Email: <span
                                        class="account-email">{{ $currentUser->email ?? 'Chưa cập nhật' }}</span></span>
                            </div>
                            <div class="account-info-item">
                                <i class="fas fa-phone account-info-icon"></i>
                                <span>Số Điện Thoại: <span
                                        class="account-phone">{{ $currentUser->phone ?? 'Chưa cập nhật' }}</span></span>
                            </div>
                            <div class="account-info-item">
                                <i class="fas fa-birthday-cake account-info-icon"></i>
                                <span>Ngày Sinh: <span
                                        class="account-dob">{{ optional($shipperProfile->date_of_birth)->format('d/m/Y') ?? '' }}</span></span>
                            </div>

                            <h5 class="account-section-title mt-4">
                                <i class="fas fa-motorcycle mr-2"></i> Thông Tin Phương Tiện
                            </h5>
                            <div class="account-info-item">
                                <i class="fas fa-car account-info-icon"></i>
                                <span>Loại Xe: <span
                                        class="account-vehicle-type">{{ $shipperProfile->vehicle_type ?? 'Chưa cập nhật' }}</span></span>
                            </div>
                            <div class="account-info-item">
                                <i class="fas fa-id-badge account-info-icon"></i>
                                <span>Biển Số: <span
                                        class="account-license-plate">{{ $shipperProfile->license_plate ?? 'Chưa cập nhật' }}</span></span>
                            </div>
                        @else
                            <p class="text-danger">Không thể tải thông tin.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Chỉnh sửa Tài khoản --}}
    <div class="modal fade" id="editAccountModal" tabindex="-1" role="dialog" aria-labelledby="editAccountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAccountModalLabel"><i class="fas fa-edit mr-2"></i> Chỉnh sửa tài khoản
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editAccountForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editName">Họ và tên:</label>
                                    {{-- Thêm optional() và ?? '' --}}
                                    <input type="text" class="form-control" id="editName" name="editName"
                                        value="{{ optional($currentUser)->name ?? '' }}" required minlength="2"
                                        maxlength="255">
                                    <div class="invalid-feedback" id="editNameError">Vui lòng nhập họ và tên. Tối thiểu 2 ký
                                        tự.</div>
                                </div>
                                <div class="form-group">
                                    <label for="editEmail">Email:</label>
                                    {{-- Thêm optional() và ?? '' --}}
                                    <input type="email" class="form-control" id="editEmail" name="editEmail"
                                        value="{{ optional($currentUser)->email ?? '' }}" required>
                                    <div class="invalid-feedback" id="editEmailError">Vui lòng nhập email hợp lệ.</div>
                                </div>
                                <div class="form-group">
                                    <label for="editPhone">Số điện thoại:</label>
                                    {{-- Thêm optional() và ?? '' --}}
                                    <input type="tel" class="form-control" id="editPhone" name="editPhone"
                                        value="{{ optional($currentUser)->phone ?? '' }}" required pattern="[0-9]{10,12}">
                                    <div class="invalid-feedback" id="editPhoneError">Vui lòng nhập số điện thoại hợp lệ
                                        (10-12 chữ số).</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editDob">Ngày sinh:</label>
                                    {{-- Thêm optional() và format lại ngày YYYY-MM-DD --}}
                                    <input type="date" class="form-control" id="editDob" name="editDob"
                                        value="{{ optional(optional($shipperProfile)->date_of_birth)->format('Y-m-d') ?? '' }}"
                                        required>
                                    <div class="invalid-feedback" id="editDobError">Vui lòng chọn ngày sinh.</div>
                                </div>
                                <div class="form-group">
                                    <label for="editVehicleType">Loại xe:</label>
                                    {{-- Thêm optional() và ?? '' --}}
                                    <input type="text" class="form-control" id="editVehicleType"
                                        name="editVehicleType"
                                        value="{{ optional($shipperProfile)->vehicle_type ?? '' }}" maxlength="50">
                                    <div class="invalid-feedback" id="editVehicleTypeError"></div>
                                </div>
                                <div class="form-group">
                                    <label for="editLicensePlate">Biển số xe:</label>
                                    {{-- Thêm optional() và ?? '' --}}
                                    <input type="text" class="form-control" id="editLicensePlate"
                                        name="editLicensePlate"
                                        value="{{ optional($shipperProfile)->license_plate ?? '' }}" maxlength="20">
                                    <div class="invalid-feedback" id="editLicensePlateError"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" id="saveAccountChanges">Lưu thay đổi</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // --- Setup AJAX (Chạy 1 lần) ---
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // --- Sự kiện khi Modal mở ra ---
            $('#editAccountModal').on('show.bs.modal', function(event) {
                var modal = $(this);
                // Lấy dữ liệu từ phần hiển thị tĩnh (nên lấy từ biến PHP nếu có sẵn để chính xác hơn)
                var currentName = $('.account-name').text().trim();
                var currentEmail = $('.account-email').text().trim();
                var currentPhone = $('.account-phone').text().trim();
                var currentDobText = $('.account-dob').text().trim();
                var currentVehicleType = $('.account-vehicle-type').text().trim();
                var currentLicensePlate = $('.account-license-plate').text().trim();

                // Điền vào form modal
                modal.find('#editName').val(currentName);
                modal.find('#editEmail').val(currentEmail);
                modal.find('#editPhone').val(currentPhone);
                // Chuyển đổi ngày sinh dd/mm/yyyy -> yyyy-mm-dd
                var dobForInput = '';
                if (currentDobText && currentDobText !== 'Chưa cập nhật') {
                    var dobParts = currentDobText.split('/');
                    if (dobParts.length === 3) {
                        dobForInput = dobParts[2] + '-' + dobParts[1].padStart(2, '0') + '-' + dobParts[0]
                            .padStart(2, '0');
                    }
                }
                modal.find('#editDob').val(dobForInput);
                modal.find('#editVehicleType').val(currentVehicleType);
                modal.find('#editLicensePlate').val(currentLicensePlate);

                // Xóa trạng thái lỗi cũ
                modal.find('.is-invalid').removeClass('is-invalid');
                modal.find('.invalid-feedback').text('');
            });

            // --- Sự kiện click nút "Lưu thay đổi" ---
            $('#saveAccountChanges').on('click', function() {
                var saveButton = $(this);
                var form = $('#editAccountForm');
                var modal = $('#editAccountModal');

                saveButton.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang lưu...'
                );
                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.invalid-feedback').text('');

                // Lấy dữ liệu form (tên key khớp với Request trong Controller)
                var formData = {
                    editName: form.find('#editName').val(),
                    editEmail: form.find('#editEmail').val(),
                    editPhone: form.find('#editPhone').val(),
                    editDob: form.find('#editDob').val(),
                    editVehicleType: form.find('#editVehicleType').val(),
                    editLicensePlate: form.find('#editLicensePlate').val(),
                    _method: 'PUT' // Hoặc POST nếu route là POST
                };

                // Gửi AJAX
                $.ajax({
                    type: 'POST', // Luôn là POST nếu dùng _method
                    url: '{{ route('shipper.updateAccount') }}', // *** KIỂM TRA LẠI TÊN ROUTE ***
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Cập nhật giao diện chính
                            $('.account-name').text(response.user.name);
                            $('.account-email').text(response.user.email);
                            $('.account-phone').text(response.user.phone);
                            // Cập nhật ngày sinh (từ profile)
                            let dobDisplay = 'Chưa cập nhật';
                            if (response.user.shipper_profile && response.user.shipper_profile
                                .date_of_birth) {
                                try {
                                    dobDisplay = new Date(response.user.shipper_profile
                                        .date_of_birth).toLocaleDateString('vi-VN');
                                } catch (e) {}
                            }
                            $('.account-dob').text(dobDisplay);
                            // Cập nhật thông tin xe (từ profile)
                            if (response.user.shipper_profile) {
                                $('.account-vehicle-type').text(response.user.shipper_profile
                                    .vehicle_type || 'Chưa cập nhật');
                                $('.account-license-plate').text(response.user.shipper_profile
                                    .license_plate || 'Chưa cập nhật');
                            } else {
                                $('.account-vehicle-type').text('Chưa cập nhật');
                                $('.account-license-plate').text('Chưa cập nhật');
                            }
                            // Đóng modal và báo thành công
                            modal.modal('hide');
                            alert(response.message ||
                                'Cập nhật thành công!'); // Hoặc dùng SweetAlert
                        } else {
                            alert(response.message || 'Có lỗi xảy ra.'); // Lỗi logic từ server
                        }
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 422) { // Lỗi Validation
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                var inputId = '#edit' + key.charAt(0).toUpperCase() +
                                    key.slice(1);
                                var errorDivId = inputId + 'Error';
                                $(inputId).addClass('is-invalid');
                                $(errorDivId).text(value[0]);
                            });
                            alert(
                                'Dữ liệu nhập không hợp lệ. Vui lòng kiểm tra lại.'
                            ); // Hoặc SweetAlert
                        } else { // Lỗi hệ thống khác
                            console.error("AJAX Error:", status, error, xhr.responseText);
                            alert(
                                'Lỗi hệ thống khi cập nhật. Vui lòng thử lại.'
                            ); // Hoặc SweetAlert
                        }
                    },
                    complete: function() {
                        saveButton.prop('disabled', false).html(
                            'Lưu thay đổi'); // Kích hoạt lại nút
                    }
                }); // Kết thúc ajax
            }); // Kết thúc sự kiện click Lưu

        }); // Kết thúc document ready
    </script>
@endpush
