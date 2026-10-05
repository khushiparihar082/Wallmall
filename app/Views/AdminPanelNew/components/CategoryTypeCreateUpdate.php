<div class="offcanvas-header">
    <h5 class="offcanvas-title" id="RightSlideBoxLabel">
        <?= (isset($category_type_id) && !empty($category_type_id)) ? "Update" : "Add" ?> Category Type</h5>
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
        <input type="hidden" name="category_type_id" id="category_type_id" value="<?= @$category_type_id  ?>">
        <input type="hidden" name="category_type_image" id="category_type_image" value="<?= @$category_type_image ?>">
        <input type="hidden" name="category_type_icon" id="category_type_icon" value="<?= @$category_type_icon ?>">
        <div class="mb-3">
            <label class="form-label">Category Type Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="category_type_name" name="category_type_name" placeholder="Category Name" value="<?= @$category_type_name ?>">
            <span class="error-message" id="error-category_type_name"></span>
        </div>
        <div class="mb-3">
            <img class="image-fluid" style="height:auto; width:100px" id="category_type_image_display" onclick="enlargeImage(event)" src="<?= (isset($category_type_image) && !empty($category_type_image)) ? base_url($category_type_image) : "" ?>">

            <?php if (isset($category_type_image) && !empty($category_type_image)) : ?>
                <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('category_type_image', 'category_type_image_display')"><i class="bx bx-trash-alt"></i></button>
            <?php endif; ?>
            <label class="form-label">Upload Image</label>
            <input type="file" name="file_upload" id="file_upload" class="form-control" onchange="uploadImage('file_upload','category','category_type_image','category_type_image_display')">
            <span class="error-message" id="error-file_upload"></span>
            <input type="text" class="form-control" id="category_type_alt_text" name="category_type_alt_text" placeholder="Atl Text" value="<?= @$category_type_alt_text ?>">
            <span class="error-message" id="error-category_type_alt_text"></span>
            <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
        </div>
        <div class="mb-3">
            <img class="image-fluid" style="height:auto; width:100px" id="category_type_icon_display" onclick="enlargeImage(event)" src="<?= (isset($category_type_icon) && !empty($category_type_icon)) ? base_url($category_type_icon) : "" ?>">

            <?php if (isset($category_type_icon) && !empty($category_type_icon)) : ?>
                <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('category_type_icon', 'category_type_icon_display')"><i class="bx bx-trash-alt"></i></button>
            <?php endif; ?>
            <label class="form-label">Upload Icon</label>
            <input type="file" name="file_upload1" id="file_upload1" class="form-control" onchange="uploadImage('file_upload1','category','category_type_icon','category_type_icon_display')">
            <span class="error-message" id="error-file_upload1"></span>
            <input type="text" class="form-control" id="category_type_alt_text" name="category_type_alt_text" placeholder="Atl Text" value="<?= @$category_type_alt_text ?>">
            <span class="error-message" id="error-category_type_alt_text"></span>
            <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
        </div>
        <div class="mb-3">
            <label class="form-label">Tag Title</label>
            <div>
                <input type="text" class="form-control" id="category_type_seo_title" name="category_type_seo_title" placeholder="Enter Tag Title" value="<?= @$category_type_seo_title ?>" />
            </div>
            <span class="error-message" id="error-category_type_seo_title"></span>
        </div>

        <div class="mb-3">
            <label class="form-label">Meta Keywords</label>
            <div>
                <input type="text" class="form-control" id="category_type_seo_keyword" name="category_type_seo_keyword" placeholder="Enter Meta Keywords" value="<?= @$category_type_seo_keyword ?>" />
            </div>
            <span class="error-message" id="error-category_type_seo_keyword"></span>
        </div>

        <div class="mb-3">
            <label class="form-label">Meta Description</label>
            <div>
                <textarea class="form-control" name="category_type_seo_description" id="category_type_seo_description" cols="20" rows="5" placeholder="Enter Meta Description"><?= @$category_type_seo_description ?></textarea>

            </div>
            <span class="error-message" id="error-category_type_seo_description"></span>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <div>

                <textarea class="form-control" name="category_type_description" id="category_type_description" cols="20" rows="5" placeholder="Enter Description"><?= @$category_type_description ?></textarea>

            </div>
            <span class="error-message" id="error-category_type_description"></span>
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