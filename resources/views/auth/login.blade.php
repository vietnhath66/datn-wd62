<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input placeholder="Nhập địa chỉ email của bạn" id="email" class="block mt-1 w-full" type="email"
                name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mật khẩu')" />

            <x-text-input placeholder="********" id="password" class="block mt-1 w-full" type="password"
                name="password" required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">

                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Nhớ mật khẩu') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))

                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Quên mật khẩu?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Đăng Nhập') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Script Hiển/Ẩn Mật khẩu -->
    <script>
        function togglePassword() {
            let passwordInput = document.getElementById("password");
            let eyeIcon = document.getElementById("eyeIcon");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 5.121A12.034 12.034 0 0112 3c6.627 0 12 5.373 12 12a12.034 12.034 0 01-2.121 6.879m-4.95-4.95a5 5 0 00-7.07 0m12.02-4.95a12.034 12.034 0 01-7.879 2.121A12.034 12.034 0 015.121 5.121" />`;
            } else {
                passwordInput.type = "password";
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm9 0c0 4-6 8-9 8s-9-4-9-8 6-8 9-8 9 4 9 8z" />`;
            }
        }
    </script>
</x-guest-layout>
