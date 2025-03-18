<!DOCTYPE html>
<html lang="en" class="light scroll-smmt-3" data-layout="vertical" data-sidebar="light" data-sidebar-size="lg"
    data-mode="light" data-topbar="light" data-skin="default" data-navbar="sticky" data-content="fluid" dir="ltr">

<head>

    <meta charset="utf-8">
    <title>Sign In | StarCode & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta content="Minimal Admin & Dashboard Template" name="description">
    <meta content="StarCode Kh" name="author">
    <!-- App favicon -->

    <link rel="shortcut icon" href="admin/images/favicon.ico">
    <!-- Layout config Js -->
    <script src="admin/js/layout.js"></script>

    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.ico') }}">
    <!-- Layout config Js -->
    <script src="{{ asset('admin/js/layout.js') }}"></script>

    <!-- Icons CSS -->

    <!-- StarCode CSS -->

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('admin/css/starcode2.css') }}">
</head>

<body
    class="flex items-center justify-center min-h-screen py-16 bg-cover bg-auth-pattern dark:bg-auth-pattern-dark dark:text-zink-100 font-public">

    <div class="mb-0 border-none lg:w-[500px] card bg-white/70 shadow-none dark:bg-zink-500/70">
        <div class="!px-10 !py-12 card-body">
            <a href="index-1.html">
                <img src="images/logo-light.png" alt="" class="hidden h-6 mx-auto dark:block">
                <img src="images/logo-dark.png" alt="" class="block h-6 mx-auto dark:hidden">
            </a>

            <div class="mt-8 text-center">
                <h4 class="mb-2 text-purple-500 dark:text-purple-500">Welcome Back !</h4>
                <p class="text-slate-500 dark:text-zink-200">Sign in to continue to starcode.</p>
            </div>
            <form class="mt-10" role="form" action="{{ route('auth.login') }}" method="POST">
                @csrf
                <div class="mt-3">
                    <label for="email" class="inline-block mb-2 text-base font-medium">Email</label>
                    <input type="text"
                        class="form-input dark:bg-zink-600/50 border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                        placeholder="Email" name="email" value="{{ request('email') ?: old('email') }}">
                    @error('email')
                        <span class="text-danger font-italic">* {{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="password" class="inline-block mb-2 text-base font-medium">Mật khẩu</label>
                    <input type="password"
                        class="form-input dark:bg-zink-600/50 border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                        placeholder="Password" name="password">
                    @error('password')
                        <span class="text-danger font-italic">* {{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-10">
                    <button type="submit"
                        class="w-full text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">Đăng
                        Nhập</button>
                </div>
                <div
                    class="relative text-center my-9 before:absolute before:top-3 before:left-0 before:right-0 before:border-t before:border-t-slate-200 dark:before:border-t-zink-500">
                    <h5
                        class="inline-block px-2 py-0.5 text-sm bg-white text-slate-500 dark:bg-zink-600 dark:text-zink-200 rounded relative">
                        Sign In with</h5>
                </div>

                <div class="flex flex-wrap justify-center gap-2">
                    <button type="button"
                        class="flex items-center justify-center size-[37.5px] transition-all duration-200 ease-linear p-0 text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 active:text-white active:bg-custom-600 active:border-custom-600"><i
                            data-lucide="facebook" class="size-4"></i></button>
                    <button type="button"
                        class="flex items-center justify-center size-[37.5px] transition-all duration-200 ease-linear p-0 text-white btn bg-orange-500 border-orange-500 hover:text-white hover:bg-orange-600 hover:border-orange-600 focus:text-white focus:bg-orange-600 focus:border-orange-600 active:text-white active:bg-orange-600 active:border-orange-600"><i
                            data-lucide="mail" class="size-4"></i></button>
                    <button type="button"
                        class="flex items-center justify-center size-[37.5px] transition-all duration-200 ease-linear p-0 text-white btn bg-sky-500 border-sky-500 hover:text-white hover:bg-sky-600 hover:border-sky-600 focus:text-white focus:bg-sky-600 focus:border-sky-600 active:text-white active:bg-sky-600 active:border-sky-600"><i
                            data-lucide="twitter" class="size-4"></i></button>
                    <button type="button"
                        class="flex items-center justify-center size-[37.5px] transition-all duration-200 ease-linear p-0 text-white btn bg-slate-500 border-slate-500 hover:text-white hover:bg-slate-600 hover:border-slate-600 focus:text-white focus:bg-slate-600 focus:border-slate-600 active:text-white active:bg-slate-600 active:border-slate-600"><i
                            data-lucide="github" class="size-4"></i></button>
                </div>

                <div class="mt-10 text-center">
                    <p class="mb-0 text-slate-500 dark:text-zink-200">Don't have an account ? <a
                            href="auth-register-basic.html"
                            class="font-semibold underline transition-all duration-150 ease-linear text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500">
                            SignUp</a> </p>
                </div>
                <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a>
            </form>
        </div>
    </div>

    <script src='{{ asset('admin/libs/choices.js/public/admin/scripts/choices.min.js') }}'></script>
    <script src="{{ asset('admin/libs/%40popperjs/core/umd/popper.min.js') }}"></script>
    <script src="{{ asset('admin/libs/tippy.js/tippy-bundle.umd.min.js') }}"></script>
    <script src="{{ asset('admin/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin/libs/prismjs/prism.js') }}"></script>
    <script src="{{ asset('admin/libs/lucide/umd/lucide.js') }}"></script>
    <script src="{{ asset('admin/js/starcode.bundle.js') }}"></script>
    <script src="{{ asset('admin/js/pages/auth-login.init.js') }}"></script>

</body>

</html>
