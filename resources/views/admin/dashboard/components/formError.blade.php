@if ($errors->any())
    <style>
        .alert.alert-danger {
            background-color: #f8d7da;
            /* Màu nền đỏ nhạt */
            color: #721c24;
            /* Màu chữ đỏ đậm */
            border: 1px solid #f5c6cb;
            /* Viền màu hồng nhạt */
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
            font-family: Arial, sans-serif;
        }

        .alert.alert-danger ul {
            margin: 0;
            padding-left: 20px;
        }

        .alert.alert-danger li {
            margin-bottom: 5px;
            list-style-type: disc;
        }
    </style>
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
