<div class="offcanvas-header">
    <h5 class="offcanvas-title" id="RightSlideBoxLabel">
        <?= (isset($size_id) && !empty($size_id)) ? "Update" : "Add" ?> Size</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close" ></button>
</div>
<div class="offcanvas-body">
    <div class="error-message-box d-none">
        <p id="error-message"></p>
    </div>
    <div class="success-message-box d-none">
        <p id="success-message"></p>
    </div>
    
    <form id="form" method="POST" enctype="multipart/form-data" action="<?= @$ApiUrl ?>">
        <input type="hidden" name="size_id" id="size_id" value="<?= @$size_id  ?>">

        <div class="mb-3">
            <label class="form-label">Size Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="size_name" name="size_name" placeholder="Size Name" value="<?= @$size_name ?>">
            <span class="error-message" id="error-size_name"></span>
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