<style>
    .row {
        width: 80vw;
        margin-left: 0;
        margin-right: 0;
        border-radius: 0;
        flex-wrap: wrap;
    }

    .gallery-item {
        flex: 1 1 calc(33.33% - 1rem);
        /* 3 items per row */
        width: 100%;
        box-sizing: border-box;
        margin-bottom: 1rem;
    }

    .gallery-item .form-control {
        flex: 1;
    }

    .gallery-item .btn-danger {
        white-space: nowrap;
    }

    .gallery-item {
        display: flex;
        flex-direction: column;
    }

    .gallery-item .form-label {
        font-weight: 500;
    }

    .gallery-item .d-flex {
        display: flex;
        gap: 0.1rem;
    }

    .btn-remove-image {
        padding: 0.5rem 0.75rem;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
        color: white;
        padding: 8px 14px;
        border-radius: 6px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.1s ease;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .btn-danger:active {
        transform: scale(0.96);
    }

    .btn-danger i {
        margin-right: 4px;
    }

    input[type="file"].form-control {
        padding: 10px 10px;
        border: 2px solid #ccc;
        border-radius: 6px;
        background-color: #f8f9fa;
        cursor: pointer;
        font-size: 14px;
        color: #495057;
    }

    input[type="file"].form-control:hover {
        border-color: #999;
        background-color: #e9ecef;
    }

    .btn-aqua {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        line-height: 1;
        font-weight: bold;
        width: 120px;
        background-color: rgb(54, 73, 137);
        color: #fff;
        padding: 15px 20px;
        border: none;
        border-radius: 5px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        transition: background 0.3s ease;
    }

    .btn-aqua:hover {
        background-color: rgb(46, 63, 120);
        color: #fff;
    }

    .d-flex {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 40px;
    }

    .gallery-item {
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 6px;
        background-color: #f9f9f9;
    }

    * {
        box-sizing: border-box;
    }

    .card-header {
        height: 30px;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Gallery</h4>
                <button type="button" class="btn btn-primary btn-aqua" onclick="addImageGallery()">Thêm ảnh</button>
            </div><!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-3 d-flex" id="gallery_list" class="">
                        <div class="col-md-4 gallery-item">
                            <label class="form-label">Image</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="file" class="form-control" name="product_galleries[]">
                            </div>
                        </div>
                    </div>
                </div>
                @if (isset($product_galleries))
                    <input type="hidden" id="deleted_gallery_ids" name="file_product_galleries">
                    @foreach ($product_galleries as $item)
                        <div class="col-md-6 gallery-item">
                            <label class="form-label">Image</label>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ \Storage::url($item->image) }}" alt="" width="50px">
                                <input type="file" class="form-control" name="product_galleries[]">
                                <input type="hidden" name="value" value="{{ $item->id }}">
                                <button type="button" class="btn btn-danger" onclick="removeImage(this)">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>


<script>
    function addImageGallery() {
        const container = document.getElementById('gallery_list');
        const index = Date.now();
        const newItem = document.createElement('div');
        newItem.className = 'col-md-4 gallery-item';
        newItem.innerHTML = `
        <label for="gallery_${index}" class="form-label">Image</label>
        <div class="d-flex align-items-center">
            <input type="file" class="form-control me-2" name="product_galleries[]" id="gallery_${index}">
            <button type="button" class="btn btn-danger btn-remove-image" onclick="removeImage(this)">
                <i class="fas fa-trash"></i>
                </button>
                </div>
                `;
        container.appendChild(newItem);
    }

    let deletedGalleryIds = [];

    function removeImage(button) {
        if (confirm("Bạn có chắc chắn muốn xóa ảnh này không ?")) {
            const container = button.closest('.gallery-item');
            const hiddenInput = container.querySelector('input[type="hidden"][name="value"]');
            if (hiddenInput) {
                const id = hiddenInput.value;
                deletedGalleryIds.push(id);
                document.getElementById('deleted_gallery_ids').value = deletedGalleryIds.join(',');
                container.remove();
                console.log('Đã thêm vào danh sách xoá:', deletedGalleryIds);
            }
            button.closest('.gallery-item').remove();
        }
    }
</script>
