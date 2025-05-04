<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Gallery</h4>
                <button type="button" class="btn btn-primary" onclick="addImageGallery()">Thêm ảnh</button>
            </div><!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4" id="gallery_list">
                        <div class="col-md-4" id="gallery_default_item">
                            <label for="gallery_default" class="form-label">Image</label>
                            <div class="d-flex">
                                <input type="file" class="form-control" name="product_galleries[]"
                                    id="gallery_default">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--end col-->
</div>

<script>
    // CKEDITOR.replace('content');

    function addImageGallery() {
        let id = 'gen' + '_' + Math.random().toString(36).substring(2, 15).toLowerCase();
        let html = `
        <div class="col-md-4" id="${id}_item">
            <label for="${id}" class="form-label">Image</label>
            <div class="d-flex">
                <input type="file" class="form-control" name="product_galleries[]" id="${id}">
                <button type="button" class="btn btn-danger" onclick="removeImageGallery('${id}_item')">
                    <span class="bx bx-trash"></span>
                </button>
            </div>
        </div>
    `;

        $('#gallery_list').append(html);
    }

    function removeImageGallery(id) {
        if (confirm('Chắc chắn xóa không?')) {
            $('#' + id).remove();
        }
    }
</script>