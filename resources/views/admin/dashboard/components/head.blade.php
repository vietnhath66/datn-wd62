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


<link href="../backend/font-awesome/css/font-awesome.css" rel="stylesheet">

{{-- <link href="../backend/css/animate.css" rel="stylesheet"> --}}
<link href="../backend/css/style.css" rel="stylesheet">
{{-- <link href="../backend/css/customize.css" rel="stylesheet"> --}}
<link href="../backend/css/customize.css" rel="stylesheet">
<link rel="icon" href="../backend/img/logo.jpg" type="image/x-icon" />
<link href="../backend/css/plugins/toastr/toastr.min.css" rel="stylesheet">
<style>
    .badge {
        display: inline-block;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 600;
        color: #fff;
        text-align: center;
        border-radius: 0.25rem;
    }
    .badge-success {
        background-color: #28a745;
    }
    .badge-danger {
        background-color: #dc3545;
    }
    </style>
    

@if (isset($config['css']))
    @foreach ($config['css'] as $css => $value)
        <link href="{{ $value }}" rel="stylesheet">
    @endforeach
@endif

<script src="../backend/js/jquery-3.1.1.min.js"></script>
<!-- CSS -->
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">

<!-- JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script> --}}
<script>
    var BASE_URL = '{{ env('APP_URL') }}';
    var SUFFIX = '{{ config('apps.general.suffix') }}';
</script>


{{-- C:\laragon\www\admindatn\resources\css\admin\starcode2.css --}}
