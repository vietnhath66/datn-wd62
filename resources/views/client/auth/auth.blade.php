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
    <title>Đăng Nhập</title>
</head>

<body>
    <div class="container" id="container">
        <div class="sign-up">
            <form action="{{ route('client.postRegister') }}" method="POST">
                @csrf
                <h1>Đăng Ký</h1>
                <div class="icons">
                    <a href="#" class="icon"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-google"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                </div>
                <span>hoặc có thể sử dụng email</span>
                <input type="text" name="name" placeholder="Họ và tên" />
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <input type="email" name="email" placeholder="Nhập email của bạn" />
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <input type="password" name="password" placeholder="********" />
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <button type="submit">Đăng Ký</button>
            </form>
        </div>
        <div class="sign-in">
            <form action="{{ route('client.postLogin') }}" method="POST">
                @csrf

                <h1>Đăng Nhập</h1>
                <div class="icons">
                    <a href="#" class="icon"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-google"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                </div>
                <span>hoặc có thể sử dụng email</span>
                <input type="email" name="email" placeholder="Nhập email của bạn" />
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <input type="password" name="password" placeholder="********" />
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <a href="{{ route('client.viewForgot') }}">Quên mật khẩu</a>
                <button type="submit">Đăng Nhập</button>

            </form>
        </div>
        <div class="toogle-container">

            <div class="toogle">

                <div class="toogle-panel toogle-left">

                    <h1>Xin chào người dùng!</h1>
                    <p>Nếu bạn đã có tài khoản</p>
                    <button class="hidden" id="login">Đăng Nhập</button>
                </div>
                <div class="toogle-panel toogle-right">
                    <h1>Xin chào người dùng!</h1>
                    <p>Nếu bạn chưa có tài khoản</p>
                    <button class="hidden" id="register">Đăng Ký</button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('auth/script.js') }}"></script>
</body>

</html>
