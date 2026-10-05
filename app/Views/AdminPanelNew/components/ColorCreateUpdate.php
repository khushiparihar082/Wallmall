<div class="offcanvas-header">
    <h5 class="offcanvas-title" id="RightSlideBoxLabel">
        <?= (isset($color_id) && !empty($color_id)) ? "Update" : "Add" ?> Color</h5>
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
        <input type="hidden" name="color_id" id="color_id" value="<?= @$color_id  ?>">
        <input type="hidden" name="color_image" id="color_image" value="<?= @$color_image ?>">

        <div class="mb-3">
            <label class="form-label">Color Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="color_name" name="color_name" placeholder="Color Name" value="<?= @$color_name ?>">
            <span class="error-message" id="error-color_name"></span>
        </div>
        <div class="mb-3">
            <label class="form-label" for="color_code">Select color<span class="text-danger">*</span></label>
            <input class="form-control form-control-color mw-100" type="color" value="#3b5de7" id="color_code" name="color_code" value="<?= @$color_code ?>">
            <span class="error-message" id="error-color_code"></span>
        </div>
        <div class="mb-3">
            <?php if (isset($color_image) && !empty($color_image)) : ?>
                <img class="image-fluid" style="height:auto; width:100px" id="color_image_display" onclick="enlargeImage(event)" src="<?= (isset($color_image) && !empty($color_image)) ? base_url($color_image) : "" ?>">

                <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('color_image', 'color_image_display')"><i class="bx bx-trash-alt"></i></button>
            <?php endif; ?>
            <label class="form-label">Upload Files</label>
            <input type="file" name="file_upload" id="file_upload" class="form-control" onchange="uploadImage('file_upload','color','color_image','color_image_display')">
            <span class="error-message" id="error-file_upload"></span>
            <input type="text" class="form-control" id="color_alt_text" name="color_alt_text" placeholder="Atl text" value="<?= @$color_alt_text ?>">
            <span class="error-message" id="error-color_alt_text"></span>
            <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
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