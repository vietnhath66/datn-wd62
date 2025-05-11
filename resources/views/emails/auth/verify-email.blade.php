@component('mail::message')
    # Xin chào {{ $name }}!

    Cảm ơn bạn đã đăng ký tài khoản của chúng tôi. Vui lòng bấm vào nút bên dưới để xác thực địa chỉ email của bạn.

    @component('mail::button', ['url' => $verificationUrl])
        Xác thực Email
    @endcomponent

    Nếu bạn không tạo tài khoản, bạn có thể bỏ qua email này.

    Trân trọng,
    {{ config('app.name') }}
@endcomponent
