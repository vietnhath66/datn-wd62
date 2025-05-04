<div class="lg:col-span-2 xl:col-span-12 bootstrap-scope">
    @yield('css')
    <link rel="stylesheet" href="{{ asset('plugins/nice-select/nice-select.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .variant-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            gap: 15px;
        }

        .variant-item .col-lg-3,
        .variant-item .col-lg-8,
        .variant-item .col-lg-1 {
            padding: 0;
            display: flex;
            align-items: center;
        }

        .variant-item .col-lg-3 {
            flex: 1;
        }

        .variant-item .col-lg-8 {
            flex: 5;
        }

        .variant-item .col-lg-1 {
            flex: 0 0 50px;
            justify-content: center;
        }

        .variant-item select,
        .variant-item input {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #f5f5f5;
            height: 40px;
        }

        .variant-item select.niceSelect {
            background-color: white;
        }

        .variant-item button.remove-attribute {
            background: #f44336;
            color: #fff;
            border: none;
            width: 40px;
            height: 40px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
        }

        .variant-item button.remove-attribute:hover {
            background-color: #d32f2f;
        }

        .variant-box {
            background-color: #fff;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 20px;
        }

        select.choose-attribute,
        select.selectVariant {
            appearance: none;
            /* Ẩn UI mặc định của trình duyệt */
            background-color: #fff;
            border: 1px solid #d1d5db;
            /* màu viền xám nhạt */
            border-radius: 6px;
            padding: 10px 12px;
            width: 100%;
            font-size: 14px;
            color: #111827;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        select.choose-attribute:focus,
        select.selectVariant:focus {
            border-color: #2563eb;
            /* xanh dương nhạt khi focus */
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }

        select.choose-attribute option,
        select.selectVariant option {
            padding: 8px 12px;
        }

        /* Tiêu đề */
        .variant-box .ibox-title h5 {
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            color: #111827;
            margin-bottom: 8px;
        }

        .variant-box .description {
            font-size: 14px;
            color: #374151;
            margin-bottom: 10px;
        }

        .variant-box .text-danger {
            color: #dc2626;
            /* màu đỏ cho "màu sắc", "size" */
        }

        /* Checkbox hàng đầu */
        .variant-checkbox {
            margin-top: 10px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .variant-checkbox input[type="checkbox"] {
            margin-right: 8px;
            transform: scale(1.2);
        }

        /* Phần chọn thuộc tính và giá trị */
        .variant-container .attribute-title {
            font-weight: 500;
            color: #1e3a8a;
            margin-bottom: 6px;
            font-size: 14px;
        }

        /* Ô chọn attribute */
        .attribute-catalogue select {
            width: 100%;
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            font-size: 14px;
        }

        .attribute-catalogue select {
            appearance: none;
            width: 100%;
            padding: 10px 12px;
            font-size: 14px;
            color: #1f2937;
            /* text-gray-800 */
            background-color: #ffffff;
            border: 1px solid #d1d5db;
            /* border-gray-300 */
            border-radius: 6px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.5;
        }

        .attribute-catalogue select:focus {
            border-color: #2563eb;
            /* blue-600 */
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
            /* blue shadow */
        }

        .attribute-catalogue option {
            padding: 8px 12px;
        }

        .attribute-catalogue li {
            padding: 10px;
            cursor: pointer;
        }

        .attribute-catalogue li:hover {
            background-color: #d1d5db
        }

        /* Select2 hoặc select multiple */
        .selectVariant {
            width: 100%;
            padding: 6px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            font-size: 14px;
            background-color: #f9fafb;
            min-height: 42px;
        }

        /* Nút xóa đỏ */
        .remove-attribute.btn {
            background-color: #ef4444;
            border: none;
            padding: 8px;
            border-radius: 6px;
            color: #fff;
            width: 100%;
        }

        .remove-attribute.btn:hover {
            background-color: #dc2626;
        }

        /* Nút thêm phiên bản */
        .variant-foot .add-variant {
            padding: 8px 16px;
            border: 1px dashed #3b82f6;
            color: #3b82f6;
            font-size: 14px;
            border-radius: 6px;
            background-color: #fff;
            cursor: pointer;
        }

        .variant-foot .add-variant:hover {
            background-color: #eff6ff;
        }

        /* Dòng item */
        .variant-item {
            align-items: center;
            margin-bottom: 12px;
        }

        /* Nút xóa thuộc tính */
        .remove-attribute {
            background-color: #ef4444;
            border: none;
            color: white;
            border-radius: 6px;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            transition: background 0.2s;
        }

        .remove-attribute:hover {
            background-color: #dc2626;
        }

        /* Bảng phiên bản */
        .variantTable {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .variantTable th,
        .variantTable td {
            border: 1px solid #e5e7eb;
            padding: 10px;
            text-align: center;
            font-size: 14px;
        }

        .variantTable thead {
            background-color: #1f2937;
            color: white;
        }

        .updateVariant {
            background-color: #e5e5e5;
            /* màu nền xám */
            padding: 20px;
            border-radius: 6px;
            margin-top: 10px;
        }

        /* Tiêu đề */
        .updateVariant .ibox-title h5 {
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 10px;
        }

        /* Nhãn label */
        .updateVariant label {
            font-weight: 500;
            color: #1e3a8a;
            /* xanh đậm */
            font-size: 14px;
        }

        /* Input text */
        .updateVariant input.form-control {
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 6px 10px;
            font-size: 14px;
            height: 38px;
        }

        /* Input khi disabled */
        .updateVariant input[disabled] {
            background-color: #f3f4f6;
            color: #9ca3af;
        }

        /* Switchery toggle (giả lập) */
        .updateVariant .switchery {
            border: 1px solid #dfdfdf !important;
            background-color: #fff !important;
            width: 36px;
            height: 20px;
        }

        .updateVariant .switchery small {
            background-color: #ccc;
            height: 18px;
            width: 18px;
            top: 1px;
            left: 1px;
            transition: left 0.2s, background-color 0.2s;
        }

        /* Nút */
        .updateVariant .btn {
            padding: 6px 14px;
            font-size: 14px;
            border-radius: 6px;
            box-shadow: none;
        }

        .updateVariant .btn-danger {
            background-color: #ef4444;
            border: none;
            color: #fff;
        }

        .updateVariant .btn-danger:hover {
            background-color: #dc2626;
        }

        .updateVariant .btn-success {
            background-color: #22c55e;
            border: none;
            color: #fff;
        }

        .updateVariant .btn-success:hover {
            background-color: #16a34a;
        }

        /* Canh chỉnh lề cho cột */
        .updateVariant .row .col-lg-3 {
            margin-bottom: 10px;
        }
    </style>
    <div class="lg:col-span-2 xl:col-span-12">
        <div class="ibox variant-box">
            <div class="ibox-title">
                <div>
                    <h5>Sản phẩm có nhiều phiên bản</h5>
                </div>
                <div class="description">Cho phép bạn bán các phiên bản khác nhau của sản phẩm, ví dụ: : quần, áo thì có
                    các
                    <strong class="text-danger">màu sắc</strong> và <strong class="text-danger">size</strong> số khác
                    nhau.
                    Mỗi
                    phiên bản sẽ là 1 dòng trong mục danh sách phiên bản phía dưới
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="variant-checkbox uk-flex uk-flex-middle">
                            <input type="checkbox" value="1" name="accept" id="variantCheckbox"
                                class="variantInputCheckbox"
                                {{ old('accept') == 1 || (isset($product) && count($product->product_variants) > 0) ? 'checked' : '' }}>
                            <label for="variantCheckbox" class="turnOnVariant">Sản phẩm này có nhiều biến thể. Ví dụ như
                                khác
                                nhau về màu sắc, kích thước</label>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="variant-checkbox uk-flex uk-flex-middle">
                                <input type="checkbox" value="1" name="accept" id="variantCheckbox"
                                    class="variantInputCheckbox"
                                    {{ old('accept') == 1 || (isset($product) && count($product->product_variants) > 0) ? 'checked' : '' }}>
                                <label for="variantCheckbox" class="turnOnVariant">Sản phẩm này có nhiều biến thể. Ví dụ
                                    như
                                    khác
                                    nhau về màu sắc, kích thước</label>
                            </div>
                        </div>
                    </div>
                    @php
                        $variantCatalogue = old(
                            'attributeCatalogue',
                            isset($product->attributeCatalogue) ? json_decode($product->attributeCatalogue, true) : [],
                        );
                        // dd($variantCatalogue);
                    @endphp
                    <div class="variant-wrapper {{ $variantCatalogue ? '' : 'hidden' }}">
                        <div class="row variant-container">
                            <div class="col-lg-3">
                                <div class="attribute-title">Chọn thuộc tính</div>
                            </div>
                            <div class="col-lg-9">
                                <div class="attribute-title">Chọn giá trị của thuộc tính (nhập 1 từ để tìm kiếm)</div>
                            </div>
                        </div>
                        <div class="variant-body">

                            @if ($variantCatalogue && count($variantCatalogue))
                                @foreach ($variantCatalogue as $keyAttr => $valAttr)
                                    {{-- @dd($valAttr) --}}
                                    <div class="row mb20 variant-item">
                                        <div class="col-lg-3">
                                            <div class="attribute-catalogue">
                                                <select name="attributeCatalogue[]" id=""
                                                    class="choose-attribute niceSelect">
                                                    <option value="">Chọn Nhóm thuộc tính</option>
                                                    @foreach ($attributeCatalogue as $key => $val)
                                                        <option {{ $valAttr == $val->id ? 'selected' : '' }}
                                                            value="{{ $val->id }}">
                                                            {{ $val->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            {{-- <input type="text" name="" disabled class="fake-variant form-control"> --}}

                                            <select name="attribute[{{ $valAttr }}][]" id=""
                                                class="selectVariant variant-{{ $valAttr }} form-control" multiple
                                                data-catid="{{ $valAttr }}"></select>
                                        </div>
                                        <div class="col-lg-1">
                                            <button type="button" class="remove-attribute btn btn-danger"><svg
                                                    data-icon="TrashSolidLarge" aria-hidden="true" focusable="false"
                                                    width="15" height="16" viewBox="0 0 15 16" class="bem-Svg"
                                                    style="display: block;">
                                                    <path fill="currentColor"
                                                        d="M2 14a1 1 0 001 1h9a1 1 0 001-1V6H2v8zM13 2h-3a1 1 0 01-1-1H6a1 1 0 01-1 1H1v2h13V2h-1z">
                                                    </path>
                                                </svg></button>
                                            <div class="variant-body">
                                                @if ($variantCatalogue && count($variantCatalogue))
                                                    @foreach ($variantCatalogue as $keyAttr => $valAttr)
                                                        {{-- @dd($valAttr) --}}
                                                        <div class="row mb20 variant-item">
                                                            <div class="col-lg-3">
                                                                <div class="attribute-catalogue">
                                                                    <select name="attributeCatalogue[]" id=""
                                                                        class="choose-attribute niceSelect">
                                                                        <option value="">Chọn Nhóm thuộc tính
                                                                        </option>
                                                                        @foreach ($attributeCatalogue as $key => $val)
                                                                            <option
                                                                                {{ $valAttr == $val->id ? 'selected' : '' }}
                                                                                value="{{ $val->id }}">
                                                                                {{ $val->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="variant-foot mt10">
                                                <button type="button" class="add-variant">Thêm phiên bản mới</button>
                                            </div>
                                        </div>
                                    </div>
                        </div>

                        <div class="ibox product-variant">
                            <div class="ibox-title">
                                <h5>Danh sách phiên bản</h5>
                            </div>
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <table class="table table-striped variantTable">
                                        <thead></thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        var attributeCatalogue = @json(
            $attributeCatalogue->map(function ($item) {
                    $name = $item->name;
                    return [
                        'id' => $item->id,
                        'name' => $name,
                    ];
                })->values());

        var attribute =
            '{{ base64_encode(json_encode(old('attribute', isset($product->attribute) ? $product->attribute : []))) }}';
        var variant =
            '{{ base64_encode(json_encode(old('variant', isset($product->variant) ? json_decode($product->variant, true) : []))) }}';
    </script>



    {{-- JS --}}
    <script src="{{ asset('plugins/nice-select/jquery.nice-select.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('select.niceSelect').niceSelect();
            $('.selectVariant').select2({
                placeholder: 'Nhập để tìm...',
                width: '100%'
            });
        });
    </script>
