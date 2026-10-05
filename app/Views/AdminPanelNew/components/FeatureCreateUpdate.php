<div class="offcanvas-header">
    <h5 class="offcanvas-title" id="RightSlideBoxLabel">
        <?= (isset($feature_id) && !empty($feature_id)) ? "Update" : "Add" ?> Feature</h5>
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
        <input type="hidden" name="feature_id" id="feature_id" value="<?= @$feature_id  ?>">
        <input type="hidden" name="feature_image" id="feature_image" value="<?= @$feature_image ?>">
        <div class="mb-3">
            <label class="form-label" for="feature_type_id">Feature Type<span class="text-danger">*</span></label>
            <select id="feature_type_id" name="feature_type_id" placeholder="Select Feature Type">
            </select>
            <span class="error-message" id="error-feature_type_id"></span>
        </div>
        <div class="mb-3">
            <label class="form-label">Feature Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="feature_name" name="feature_name" placeholder="Feature Name" value="<?= @$feature_name ?>">
            <span class="error-message" id="error-feature_name"></span>
        </div>
        <div class="mb-3">
            <img class="image-fluid" style="height:auto; width:100px" id="feature_image_display" onclick="enlargeImage(event)" src="<?= (isset($feature_image) && !empty($feature_image)) ? base_url($feature_image) : "" ?>">

            <?php if (isset($feature_image) && !empty($feature_image)) : ?>
                <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('feature_image', 'feature_image_display')"><i class="bx bx-trash-alt"></i></button>
            <?php endif; ?>
            <label class="form-label">Upload Files</label>
            <input type="file" name="file_upload" id="file_upload" class="form-control" onchange="uploadImage('file_upload','feature','feature_image','feature_image_display')">
            <span class="error-message" id="error-file_upload"></span>
            <input type="text" class="form-control" id="feature_alt_text" name="feature_alt_text" placeholder="Alt text" value="<?= @$feature_alt_text ?>">
            <span class="error-message" id="error-feature_alt_text"></span>
            <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
        </div>
        <div class="mb-3">
            <label class="form-label">Tag Title</label>
            <div>
                <input type="text" class="form-control" id="feature_seo_title" name="feature_seo_title" placeholder="Enter Tag Title" value="<?= @$feature_seo_title ?>" />
            </div>
            <span class="error-message" id="error-feature_seo_title"></span>
        </div>
        <div class="mb-3">
            <label class="form-label">Meta Keywords</label>
            <div>
                <input type="text" class="form-control" id="feature_seo_keyword" name="feature_seo_keyword" placeholder="Enter Meta Keywords" value="<?= @$feature_seo_keyword ?>" />
            </div>
            <span class="error-message" id="error-feature_seo_keyword"></span>
        </div>

        <div class="mb-3">
            <label class="form-label">Meta Description</label>
            <div>
                <textarea class="form-control" name="feature_seo_description" id="feature_seo_description" cols="20" rows="5" placeholder="Enter Meta Description"><?= @$feature_seo_description ?></textarea>
            </div>
            <span class="error-message" id="error-feature_seo_description"></span>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <div>
                <textarea class="form-control" name="feature_description" id="feature_description" cols="20" rows="5" placeholder="Enter Description"><?= @$feature_description ?></textarea>
            </div>
            <span class="error-message" id="error-feature_description"></span>
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
    var selected_feature_type_id = "<?= @$feature_type_id ?>";
</script>