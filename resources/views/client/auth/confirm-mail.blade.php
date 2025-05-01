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
    <title>Xác thực mail</title>
</head>

<body>
    <div class="container" id="container">
        <div class="sign-in">
            <form action="{{ route('client.postRegister') }}" method="POST">
                @csrf
                <h1>Xác thực email</h1>
                <p style="padding-top: 20px">Chúng tôi đã gửi cho bạn 1 mail để xác thực tài khoản. Vui lòng kiểm tra
                    hộp thư của bạn.</p>
                <button style="margin-top: 20px">Gửi lại mã</button>
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
