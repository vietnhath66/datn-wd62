<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="{{ asset('client/images/icons/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('auth/style.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <title>Quên mật khẩu</title>
</head>

<body>
    <div class="container" id="container">
        <div class="sign-in">
            <form action="{{ route('client.postForgot') }}" method="POST">
                @csrf
                <h1>Xác thực email</h1>
                <p style="padding-top: 20px">Quên mật khẩu? Không vấn đề gì. Chỉ cần cho chúng tôi biết địa chỉ email
                    của bạn và chúng tôi sẽ gửi cho bạn liên kết đặt lại mật khẩu cho phép bạn chọn mật khẩu mới..</p>
                <input type="email" name="email" placeholder="Nhập email của bạn" value="{{ old('email') }}"
                    required />
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <button type="submit" style="margin-top: 20px">Lấy lại mật khẩu</button>
            </form>
        </div>

        <div class="toogle-container">
            <div class="toogle">
                <div class="toogle-panel toogle-right">
                    <h1>Xin chào người dùng!</h1>
                    <p>Nếu bạn đã có tài khoản</p>
                    <a href="{{ route('client.viewLogin') }}">
                        <button class="hidden">Đăng Nhập</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('auth/script.js') }}"></script>
</body>

</html>
