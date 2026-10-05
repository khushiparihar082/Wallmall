<div class="card form_bg">
    <div class="error-message-box d-none">
        <p id="error-message"></p>
    </div>
    <div class="success-message-box d-none">
        <p id="success-message"></p>
    </div>
    <form autocomplete="on" id="form" class="card-body" method="POST" enctype="multipart/form-data" action="<?= @$ApiUrl ?>">
        <input type="hidden" class="form-control" id="coupon_type" name="coupon_type" value="multi_customer_coupon">
        <div class="row mt-4 offcanvas-body">
            <input type="hidden" name="coupon_image" id="coupon_image" value="<?= @$coupon_image ?>">
            <input type="hidden" name="coupon_id" id="coupon_id" value="<?= @$coupon_id ?>">
            <div class="form-group col-md-5 mb-3">
                <label for="coupon_name" class="form-label">Coupon Name</label>
                <input autocomplete="off" type="text" class="form-control" id="coupon_name" name="coupon_name" value="<?= @$coupon_name ?>" placeholder="Enter Coupon Name">
                <span class="error-message" id="error-coupon_name"></span>
            </div>

            <div class="form-group col-md-5 mb-3">
                <label for="coupon_code" class="form-label">Coupon Code</label>
                <input autocomplete="off" type="text" class="form-control" id="coupon_code" name="coupon_code" value="<?= @$coupon_code ?>" placeholder="Enter Coupon Code">
                <span class="error-message" id="error-coupon_code"></span>
            </div>
            <div class="form-group col-md-12 mb-3">
                <label for="coupon_description" class="form-label">Coupon Description</label>
                <textarea autocomplete="off" class="form-control ckeditor-active" id="coupon_description" name="coupon_description" rows="5" placeholder="Enter Coupon Description"><?= @$coupon_description ?></textarea>
                <span class="error-message" id="error-coupon_description"></span>
            </div>


            <div class="form-group col-md-5 mb-3">
                <img class="image-fluid" style="height:auto; width:100px; margin-bottom:10px;" id="coupon_image_display" onclick="enlargeImage(event)" src="<?= (isset($coupon_image) && !empty($coupon_image)) ? base_url($coupon_image) : "" ?>">

                <?php if (isset($coupon_image) && !empty($coupon_image)) : ?>
                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('coupon_image', 'coupon_image_display')"><i class="bx bx-trash-alt"></i></button>
                <?php endif; ?>
                <label class="form-label">Upload Files</label>
                <input type="file" name="coupon_image_upload" id="coupon_image_upload" class="form-control" onchange="uploadImage('coupon_image_upload','coupan','coupon_image','coupon_image_display')">
                <span class="error-message" id="error-featured_image"></span>
                <input type="text" placeholder="Alt text" id="coupon_image_alt" name="coupon_image_alt" class="form-control" value="<?= @$coupon_image_alt ?>">
                <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
            </div>


            <div class="col-md-4 mb-3">
                <label for="coupon_from" class="form-label">Coupon From</label>

                <input autocomplete="off" type="datetime-local" class="form-control" id="coupon_from" name="coupon_from" value="<?= isset($coupon_from) ? date('Y-m-d\TH:i', strtotime($coupon_from)) : '' ?>">
                <span class="error-message" id="error-coupon_from"></span>
            </div>

            <div class="col-md-4 mb-3">
                <label for="coupon_to" class="form-label">Coupon To</label>
                <input autocomplete="off" type="datetime-local" class="form-control" id="coupon_to" name="coupon_to" value="<?= isset($coupon_to) ? date('Y-m-d\TH:i', strtotime($coupon_to)) : '' ?>">
                <span class="error-message" id="error-coupon_to"></span>
            </div>


            <div class="col-md-4 mb-3">
                <label for="calculation_type" class="form-label">Calculation Type</label>
                <select class="form-control" id="calculation_type" name="calculation_type" value="<?= @$calculation_type ?>">
                    <option value="">Select Calculation Type</option>
                    <option value="percentage" <?= @$calculation_type === 'percentage' ? 'selected' : '' ?>>Percentage</option>
                    <option value="amount" <?= @$calculation_type === 'amount' ? 'selected' : '' ?>>Amount</option>
                </select>
                <span class="error-message" id="error-calculation_type"></span>
            </div>

            <div class="col-md-4 mb-3">
                <label for="coupon_value" class="form-label">Coupon Value</label>
                <input autocomplete="off" type="number" step="0.01" class="form-control" id="coupon_value" name="coupon_value" value="<?= @$coupon_value ?>" placeholder="Enter Coupon Value">
                <span class="error-message" id="error-coupon_value"></span>
            </div>

            <div class="col-md-4 mb-3">
                <label for="repeat_no" class="form-label">Per Customer Coupon Use</label>
                <input autocomplete="off" type="number" class="form-control" id="repeat_no" name="repeat_no" value="<?= @$repeat_no ?>" placeholder="Enter Repeat No.">
                <span class="error-message" id="error-repeat_no"></span>
            </div>

            <div class="col-md-4 mb-3">
                <label for="max_use_coupon_count" class="form-label">Total Customer Coupon Use</label>
                <input autocomplete="off" type="number" class="form-control" id="max_use_coupon_count" name="max_use_coupon_count" value="<?= @$max_use_coupon_count ?>" placeholder="Enter Max Use Count">
                <span class="error-message" id="error-max_use_coupon_count"></span>
            </div>
            <div class="col-md-4 mb-3">
                <label for="min_order_value" class="form-label">Min Order Amount</label>
                <input autocomplete="off" type="text" class="form-control" id="min_order_value" name="min_order_value" value="<?= @$min_order_value ?>" placeholder="Enter Minimum Price">
                <span class="error-message" id="error-min_order_value"></span>
            </div>

            <div class="col-md-4 mb-3">
                <label for="max_order_value" class="form-label">Max Order Amount</label>
                <input autocomplete="off" type="text" class="form-control" id="max_order_value" name="max_order_value" value="<?= @$max_order_value ?>" placeholder="Enter Maximum Price">
                <span class="error-message" id="error-max_order_value"></span>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Status <span class="text-danger">*</span></label>
                <div class="d-flex align-items-center">
                    <div class="form-check form-check-inline">
                        <span class="text-danger">*</span>
                        <input class="form-check-input" type="radio" name="is_active" id="active" value="1" <?= (isset($is_active) && $is_active == 1) ? "checked" : "" ?> />
                        <label class="form-check-label" for="active">Active</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_active" id="inactive" value="0" <?= (isset($is_active) && $is_active == 0) ? "checked" : "" ?> />
                        <label class="form-check-label" for="inactive">Inactive</label>
                    </div>
                </div>
                <span class="text-danger" id="error-is_active"></span>
            </div>

        </div>

        <!-- Input Fields End -->

        <div>
            <button type="button" class="btn btn-primary m-4 p-2" style="width: 200px;" onclick="submitFormWithAjax('form', true, true, successCallback, errorCallback)">Save</button>
        </div>

    </form>
</div>

<script>
    function successCallback(response) {
        if (response.status == 201 || response.status == 200) {
            const data = JSON.parse(response.data);
            callSendNotification(data);
            setTimeout(() => {
                window.location.href = '<?= base_url(route_to('coupon_list')) ?>';
            }, 2000);
        }
    }

    function errorCallback(response) {
        console.log(response);
    }

   function callSendNotification(response) {

    let action = 'created';

    if (response.coupon_id && response.coupon_id !== '') {
        action = 'updated';
    }

    $.ajax({
        url: "<?= base_url(route_to('sendOfferCouponNotification')) ?>",
        type: "POST",
        data: {
            type: 'coupon',
            action: action,
            title: response.coupon_name,
            discount: response.coupon_value,
            redirect_url: '',
            image: '<?= base_url($_assets_path . 'assets/images/the-hillmen-logo.png') ?>'
        },
        success: function (res) {
            if (res?.status === 200 || res?.status === "OK") {
                toastr.success('Notification Sent Successfully');
            } else {
                toastr.error(res?.message || 'Failed to notification');
            }
        },
        error: function () {
            toastr.error('Server error: failed to notification');
        }
    });
}

</script>