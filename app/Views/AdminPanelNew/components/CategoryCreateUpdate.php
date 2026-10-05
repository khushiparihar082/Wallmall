<div class="offcanvas-header">
    <h5 class="offcanvas-title" id="RightSlideBoxLabel">
        <?= (isset($category_id) && !empty($category_id)) ? "Update" : "Add" ?> Category</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body">
    <div class="error-message-box d-none">
        <p id="error-message"></p>
    </div>
    <div class="success-message-box d-none">
        <p id="success-message"></p>
    </div>
    <form id="form" method="POST" enctype="multipart/form-data" action="<?= @$ApiUrl ?>">
        <input type="hidden" name="category_id" id="category_id" value="<?= @$category_id  ?>">
        <input type="hidden" name="category_image" id="category_image" value="<?= @$category_image ?>">
        <div class="mb-3">
            <label class="form-label" for="category_type_id">Category Type<span class="text-danger">*</span></label>
            <select id="category_type_id" name="category_type_id" placeholder="Select Category Type">
            </select>
            <span class="error-message" id="error-category_type_id"></span>
        </div>
        <div class="mb-3">
            <label class="form-label">Category Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Category Name" value="<?= @$category_name ?>">
            <span class="error-message" id="error-category_name"></span>
        </div>
        <div class="mb-3">
            <img class="image-fluid" style="height:auto; width:100px" id="category_image_display" onclick="enlargeImage(event)" src="<?= (isset($category_image) && !empty($category_image)) ? base_url($category_image) : "" ?>">

            <?php if (isset($category_image) && !empty($category_image)) : ?>
                <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('category_image', 'category_image_display')"><i class="bx bx-trash-alt"></i></button>
            <?php endif; ?>
            <label class="form-label">Upload Files</label>
            <input type="file" name="file_upload" id="file_upload" class="form-control" onchange="uploadImage('file_upload','category','category_image','category_image_display')">
            <span class="error-message" id="error-file_upload"></span>
            <input type="text" class="form-control" id="category_alt_text" name="category_alt_text" placeholder="Alt Text" value="<?= @$category_alt_text ?>">
            <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
        </div>
        <div class="mb-3">
            <label class="form-label">Tag Title</label>
            <div>
                <input type="text" class="form-control" id="category_seo_title" name="category_seo_title" placeholder="Enter Tag Title" value="<?= @$category_seo_title ?>" />
            </div>
            <span class="error-message" id="error-category_seo_title"></span>
        </div>
        <div class="mb-3">
            <label class="form-label">Meta Keywords</label>
            <div>
                <input type="text" class="form-control" id="category_seo_keyword" name="category_seo_keyword" placeholder="Enter Meta Keywords" value="<?= @$category_seo_keyword ?>" />
            </div>
            <span class="error-message" id="error-category_seo_keyword"></span>
        </div>

        <div class="mb-3">
            <label class="form-label">Meta Description</label>
            <div>
                <textarea class="form-control" name="category_seo_description" id="category_seo_description" cols="20" rows="5" placeholder="Enter Meta Description"><?= @$category_seo_description ?></textarea>
            </div>
            <span class="error-message" id="error-category_seo_description"></span>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <div>
                <textarea class="form-control" name="category_description" id="category_description" cols="20" rows="5" placeholder="Enter Description"><?= @$category_description ?></textarea>
            </div>
            <span class="error-message" id="error-category_description"></span>
        </div>
        <div class="mb-3">

            <p class="mb-0"><label class="form-label">Status</label></p>
            <div class="form-check form-check-inline">
                <span class="text-danger">*</span>
                <input class="form-check-input" type="radio" name="is_active" id="active" value="1" <?= (isset($is_active) && $is_active == 1) ? "checked" : "" ?> />
                <label class="form-check-label" for="active">Active</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_active" id="inactive" value="0" <?= (isset($is_active) && $is_active == 0) ? "checked" : "" ?> />
                <label class="form-check-label" for="inactive">InActive</label>
            </div>
            <span class="error-message" id="error-is_active"></span>
        </div>

        <div>
            <div>
                <button type="button" onclick="submitFormWithAjax('form',true,false,successCallback,errorCallback)" class="btn btn-primary waves-effect waves-light me-1">
                    Submit
                </button>
                <button type="reset" class="btn btn-secondary waves-effect">
                    Cancel
                </button>
            </div>
        </div>
    </form>
</div>
<script>
    var selected_category_type_id = "<?= @$category_type_id ?>";
</script>