<div class="card form_bg">
    <div class="card-header d-flex justify-content-between align-items-center">
        <?= (isset($offer_id) && !empty($offer_id)) ? "Update" : "Add" ?> Offer Master</h5>
        <a href="<?= base_url(route_to('offer_list')) ?>" class="btn btn-secondary">Back</a>
    </div>
    <div class="card-body">
        <div class="error-message-box d-none">
            <p id="error-message"></p>
        </div>
        <div class="success-message-box d-none">
            <p id="success-message"></p>
        </div>
        <form id="form" method="POST" enctype="multipart/form-data" action="<?= @$ApiUrl ?>">
            <input type="hidden" name="offer_id" id="offer_id" value="<?= @$offer_id ?>">
            <input type="hidden" name="offer_image" id="offer_image" value="<?= @$offer_image ?>">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4 mb-3">
                                <label for="offer_name">Offer Name<span class="text-danger">*</span></label>
                                <input type="text" placeholder="Offer name" id="offer_name" name="offer_name" class="form-control" value="<?= @$offer_name ?>">
                                <span class="error-message" id="error-offer_name"></span>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="offer_title">Offer Title<span class="text-danger">*</span></label>
                                <input type="text" placeholder="Enter Title" id="offer_title" name="offer_title" class="form-control" value="<?= @$offer_title ?>">
                                <span class="error-message" id="error-offer_title"></span>
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label for="offer_type">Offer Type<span class="text-danger">*</span></label>
                                <select id="offer_type" name="offer_type" class="form-control">
                                    <option value="" disabled <?= !isset($offer_type) ? 'selected' : '' ?>>Select</option>
                                    <option value="festival" <?= (isset($offer_type) && $offer_type == 'festival') ? 'selected' : '' ?>>Festival</option>
                                    <option value="season" <?= (isset($offer_type) && $offer_type == 'season') ? 'selected' : '' ?>>Season</option>
                                    <option value="other" <?= (isset($offer_type) && $offer_type == 'other') ? 'selected' : '' ?>>Other</option>
                                    <option value="deal_of_the_day" <?= (isset($offer_type) && $offer_type == 'deal_of_the_day') ? 'selected' : '' ?>>Deal_Of_The_Day</option>
                                </select>
                                <span class="error-message" id="error-offer_type"></span>
                            </div>

                            <div class="form-group col-md-5 mb-3">
                                <img class="image-fluid" style="height:auto; width:100px; margin-bottom:10px;" id="offer_image_display" onclick="enlargeImage(event)" src="<?= (isset($offer_image) && !empty($offer_image)) ? base_url($offer_image) : "" ?>">

                                <?php if (isset($offer_image) && !empty($offer_image)) : ?>
                                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('offer_image', 'offer_image_display')"><i class="bx bx-trash-alt"></i></button>
                                <?php endif; ?>
                                <label class="form-label">Upload Files</label>
                                <input type="file" name="offer_image_upload" id="offer_image_upload" class="form-control" onchange="uploadImage('offer_image_upload','offer','offer_image','offer_image_display')">
                                <span class="error-message" id="error-offer_image"></span>
                                <input type="text" placeholder="Alt text" id="offer_alt_text" name="offer_alt_text" class="form-control" value="<?= @$offer_alt_text ?>">
                                <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tag Title</label>
                                <div>
                                    <input type="text" class="form-control" id="offer_seo_title" name="offer_seo_title" placeholder="Enter Tag Title" value="<?= @$offer_seo_title ?>" />
                                </div>
                                <span class="error-message" id="error-offer_seo_title"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Meta Keywords</label>
                                <div>
                                    <input type="text" class="form-control" id="offer_seo_keyword" name="offer_seo_keyword" placeholder="Enter Meta Keywords" value="<?= @$offer_seo_keyword ?>" />
                                </div>
                                <span class="error-message" id="error-offer_seo_keyword"></span>
                            </div>

                            <span class="error-message" id="error-long_content"></span>
                            <div class="mb-3">
                                <label class="form-label">Meta Description</label>
                                <div>
                                    <textarea class="form-control" name="offer_seo_description" id="offer_seo_description" cols="20" rows="5" placeholder="Enter Meta Description"><?= @$offer_seo_description ?></textarea>
                                </div>
                                <span class="error-message" id="error-offer_seo_description"></span>
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label class="form-label" for="offer_discount">Offer Discount %<span class="text-danger">*</span></label>
                                <input type="number" autocomplete="off" placeholder="Enter Discount %" class="form-control" name="offer_discount" id="offer_discount" value="<?= @$offer_discount ?>">
                                <span class="error-message" id="error-offer_discount"></span>
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label for="offer_from">Offer From<span class="text-danger">*</span></label>
                                <input type="date" placeholder="Offer From" id="offer_from" name="offer_from" class="form-control" value="<?= isset($offer_from) ? date('Y-m-d', strtotime($offer_from)) : '' ?>">
                                <span class="error-message" id="error-offer_from"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="offer_to">Offer To<span class="text-danger">*</span></label>
                                <input type="date" placeholder="Offer to" id="offer_to" name="offer_to" class="form-control" value="<?= isset($offer_to) ? date('Y-m-d', strtotime($offer_to)) : '' ?>">
                                <span class="error-message" id="error-offer_to"></span>
                            </div>

                            <div class="form-group col-md-4 mb-3">
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

                        </div>
                    </div>
                </div>
                <div>
                    <button type="button" onclick="submitFormWithAjax('form',true,true,successCallback,errorCallback)" class="btn btn-primary waves-effect waves-light me-1">
                        Submit
                    </button>
                    <button type="reset" class="btn btn-secondary waves-effect" onclick="window.location.href='<?= base_url(route_to('offer_list')) ?>'">
                        Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    function successCallback(response) {
        debugger
        if (response.status == 201 || response.status == 200) {
            const data = JSON.parse(response.data);
            callSendNotification(data);
            window.location.href = '<?= base_url(route_to('offer_list')) ?>';
        }
    }

    function errorCallback(response) {
        console.log(response);
    }

    function callSendNotification(response) {
        let action = 'created';

        if (response.offer_id && response.offer_id !== '') {
            action = 'updated';
        }

        $.ajax({
            url: "<?= base_url(route_to('sendOfferCouponNotification')) ?>",
            type: "POST",
            data: {
                type: 'offer',
                action: action,
                title: response.offer_name,
                discount: response.offer_discount,
                redirect_url: '',
                image: '<?= base_url($_assets_path . 'assets/images/the-hillmen-logo.png') ?>'
            },
            success: function(res) {
                if (res?.status === 200 || res?.status === "OK") {
                    toastr.success('Notification Sent Successfully');
                } else {
                    toastr.error(res?.message || 'Failed to notification');
                }
            },
            error: function() {
                toastr.error('Server error: failed to notification');
            }
        });
    }
</script>