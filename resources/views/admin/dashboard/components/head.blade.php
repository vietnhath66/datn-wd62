<base href="{{ env('APP_URL') }}">
<meta charset="utf-8" />
<title>Ecommerce | StarCode - Admin & Dashboard Template</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<meta content="Minimal Admin & Dashboard Template" name="description" />
<meta content="SttarCode Kh" name="author" />
<!-- App favicon -->
<link rel="shortcut icon" href="{{ asset('admin/images/favicon.ico') }}" />
<!-- Layout config Js -->
<script src="{{ asset('admin/js/layout.js') }}"></script>
<script src="{{ asset('admin/js/select2/select2.full.min.js') }}"></script>
{{-- <script src="{{ asset('admin/js/setup.js') }}"></script> --}}

<!-- Icons CSS -->
<!-- StarCode CSS -->
<link rel="stylesheet" href="{{ asset('admin/css/starcode2.css') }}" />

<link href="{{ asset('backend/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

{{-- <link href="{{asset('')}}backend/css/animate.css" rel="stylesheet"> --}}
{{-- <link href="{{asset('')}}backend/css/style.css" rel="stylesheet"> --}}
{{-- <link href="{{asset('')}}backend/css/customize.css" rel="stylesheet"> --}}
<link href="{{ asset('backend/css/customize.css') }}" rel="stylesheet">
<link rel="icon" href="{{ asset('backend/img/logo.jpg') }}" type="image/x-icon" />
<link href="{{ asset('backend/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">


{{-- <link href="../backend/css/animate.css" rel="stylesheet"> --}}
{{-- <link href="../backend/css/style.css" rel="stylesheet"> --}}
{{-- <link href="../backend/css/customize.css" rel="stylesheet"> --}}
<link href="../backend/css/customize.css" rel="stylesheet">
<link rel="icon" href="../backend/img/logo.jpg" type="image/x-icon" />
<link href="../backend/css/plugins/toastr/toastr.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
{{-- @dd($config['css']) --}}
@if (isset($config['css']))
    @foreach ($config['css'] as $css => $value)
        {{-- @section('css')
    <link rel="stylesheet" href="{{ asset($value) }}">
        @endsection --}}
        @if ($value == 'backend/css/plugins/switchery/switchery.css')
            <link rel="stylesheet" href="{{ asset($value) }}">
        @endif
        {{-- @if ($value == 'backend/plugins/nice-select/css/nice-select.css')
            <link rel="stylesheet" href="{{ asset($value) }}">
        @endif --}}
        @if ($value != 'backend/css/bootstrap.min.css')
            @section('css')
                <link href="{{ asset($value) }}" rel="stylesheet">
            @endsection
        @endif
        @if ($value == 'backend/css/bootstrap.min.css')
            @section('css')
                <link rel="stylesheet" href="{{ asset($value) }}">
            @endsection
        @else
            @section('css')
                <link href="{{ asset($value) }}" rel="stylesheet">
            @endsection
        @endif
        {{-- @if ($value != 'backend/css/bootstrap.min.css')
            @section('css')
                <link href="{{ $value }}" rel="stylesheet">
            @endsection
        @endif --}}
    @endforeach
@endif


<script src="{{ asset('backend/js/jquery-3.1.1.min.js') }}"></script>
@stack('styles') <!-- Thêm dòng này nếu chưa có -->
<!-- CSS -->
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">

<!-- JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script> --}}
<script>
    var BASE_URL = '{{ env('APP_URL') }}';
    var SUFFIX = '{{ config('apps.general.suffix') }}';
</script>


{{-- C:\laragon\www\admindatn\resources\css\admin\starcode2.css --}}
