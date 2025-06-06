<script src="{{ asset('admin/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
<script src="{{ asset('admin/libs/%40popperjs/core/umd/popper.min.js') }}"></script>
<script src="{{ asset('admin/libs/tippy.js/tippy-bundle.umd.min.js') }}"></script>
<script src="{{ asset('admin/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('admin/libs/prismjs/prism.js') }}"></script>
<script src="{{ asset('admin/libs/lucide/umd/lucide.js') }}"></script>
<script src="{{ asset('admin/js/starcode.bundle.js') }}"></script>
<!--apexchart js-->
<script src="{{ asset('admin/libs/apexcharts/apexcharts.min.js') }}"></script>

<!--dashboard ecommerce init js-->
<script src="{{ asset('admin/js/pages/dashboards-ecommerce.init.js') }}"></script>

<!-- App js -->
<script src="{{ asset('admin/js/app.js') }}"></script>
<script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('backend/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('backend/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('backend/js/inspinia.js') }}"></script>
<script src="{{ asset('backend/js/plugins/pace/pace.min.js') }}"></script>
<script src="{{ asset('backend/js/plugins/toastr/toastr.min.js') }}"></script>

<script src="{{ asset('backend/library/library.js') }}"></script>


<!-- jQuery UI -->
<script src="{{ asset('backend/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

@if (isset($config['js']) && is_array($config['js']))
    @foreach ($config['js'] as $key => $value)
        {!! '<script src="' . $value . '"></script>' !!}
    @endforeach
@endif

{{-- <script>
    Dropzone.options.myDropzone = {
        paramName: "file",
        maxFilesize: 2, // Giới hạn 2MB
        acceptedFiles: "image/*", // Chỉ nhận ảnh
        dictDefaultMessage: "Kéo thả ảnh vào đây hoặc click để chọn ảnh"
    };
</script> --}}
