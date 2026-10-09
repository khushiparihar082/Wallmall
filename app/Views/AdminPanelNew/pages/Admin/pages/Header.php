<div class="card form_bg">
    <form autocomplete="on" id="form" method="POST" class="card-body" enctype="multipart/form-data" action="<?= @$ApiUrl ?>">
        <input type="hidden" name="website_profile_id" value="<?= @$website_profile_id ?>">
        <input type="hidden" name="firm_logo_url" id="firm_logo_url" value="<?= @$firm_logo_url ?>">
        <!-- Input Fields Start -->
        <div class="offcanvas-header mb-4">
            <div class="">
                <h5 id="Add_outdoor_mediaLabel"> Add Header and Footer detail</h5>
            </div>
        </div>

        <div class="row offcanvas-body">
            <div class="col-md-5">
                <div class="mb-3">
                    <label for="firm_name" class="form-label">Firm Name</label>
                    <input autocomplete="off" type="text" class="form-control" id="firm_name" name="firm_name" placeholder="Firm Name" value="<?= @$firm_name ?>">
                    <span class="error-message" id="firm_name-error"></span>
                </div>
            </div>
            <div class="form-group col-md-4 mb-3">
                <img class="image-fluid" style="height:auto; width:100px" id="firm_logo_url_display" onclick="enlargeImage(event)" src="<?= (isset($firm_logo_url) && !empty($firm_logo_url)) ? base_url($firm_logo_url) : "" ?>">
                <?php if (isset($firm_logo_url) && !empty($firm_logo_url)) : ?>
                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('firm_logo_url', 'firm_logo_url_display')"><i class="bx bx-trash-alt"></i></button>
                <?php endif; ?>
                <label class="form-label" for="file_upload">Upload Files</label>
                <input type="file" name="file_upload" id="file_upload" class="form-control" onchange="uploadImage('file_upload','firmLogo','firm_logo_url','firm_logo_url_display')">
                <span class="error-message" id="error-file"></span>
                <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
            </div>

            <div class="col-md-12">
                <div class="mb-3">
                    <label for="firm_slogan" class="form-label">Tag Line</label>
                    <textarea class="form-control" name="firm_slogan" id="firm_slogan" rows="3" placeholder="Tag Line"><?= @$firm_slogan ?></textarea>
                    <span class="error-message" id="error-firm_slogan"></span>
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="firm_address" class="form-label">Address</label>
                    <textarea class="form-control" name="firm_address" id="firm_address" rows="3"><?= @$firm_address ?></textarea>
                    <span class="error-message" id="firm_address-error"></span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="firm_cin_no" class="form-label">CIN No</label>
                    <input autocomplete="off" type="text" class="form-control" id="firm_cin_no" name="firm_cin_no" value="<?= @$firm_cin_no ?>" placeholder="CIN No">
                    <span class="error-message" id="firm_cin_no-error"></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="firm_gst_no" class="form-label">GST No</label>
                    <input autocomplete="off" type="text" class="form-control" id="firm_gst_no" name="firm_gst_no" value="<?= @$firm_gst_no ?>" placeholder="GST No">
                    <span class="error-message" id="firm_gst_no-error"></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="firm_pan_no" class="form-label">PAN No</label>

                    <input autocomplete="off" type="text" class="form-control" id="firm_pan_no" name="firm_pan_no" value="<?= @$firm_pan_no ?>" placeholder="PAN No">
                    <span class="error-message" id="firm_pan_no-error"></span>
                </div>
            </div>

              <div class="col-md-6">
                <div class="mb-3">
                    <label for="firm_pincode" class="form-label">Pincode</label>
                    <input autocomplete="off" type="text" class="form-control" id="firm_pincode" name="firm_pincode" value="<?= @$firm_pincode ?>" placeholder="Pincode">
                    <span class="error-message" id="firm_pincode-error"></span>
                </div>
            </div>

              <div class="col-md-6">
                <div class="mb-3">
                    <label for="pickup_location" class="form-label">Pickup Location</label>
                    <input autocomplete="off" type="text" class="form-control" id="pickup_location" name="pickup_location" value="<?= @$pickup_location ?>" placeholder="Pickup Location">
                    <span class="error-message" id="pickup_location-error"></span>
                </div>
            </div>
             <div class="col-md-6">
                <div class="mb-3">
                    <label for="order_tracking_url" class="form-label">Order Track Url</label>
                    <input autocomplete="off" type="text" class="form-control" id="order_tracking_url" name="order_tracking_url" value="<?= @$order_tracking_url ?>" placeholder="Order Track Url">
                    <span class="error-message" id="order_tracking_url-error"></span>
                </div>
            </div>
        </div>
        <!--Refferal & Commission-->
        <h3 class="mb-0 mt-3 text-secondary">Refferal & Commission</h3>
        <hr>
        <div class="row input-row offcanvas-body">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="level1" class="form-label">Super StockList</label>
                    <div class="col-md-4 p-0">
                    </div>
                    <div>
                        <input autocomplete="off" type="text" class="form-control" id="level1" name="level1" value="<?= @$level1 ?>" placeholder="Super StockList">
                        <span class="error-message" id="level1-error"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="level1_commission_percentage" class="form-label">Super StockList Commision Percentage</label>
                    <div class="col-md-4 p-0">
                    </div>
                    <div>
                        <input autocomplete="off" type="number" class="form-control" id="level1_commission_percentage" name="level1_commission_percentage" max="100" value="<?= @$level1_commission_percentage ?>" placeholder="Enter commission percentage">
                        <span class="error-message" id="level1_commission_percentage-error"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="level2" class="form-label">Area StockList</label>
                    <div class="col-md-4 p-0">
                    </div>
                    <div>
                        <input autocomplete="off" type="text" class="form-control" id="level2" name="level2" value="<?= @$level2 ?>" placeholder="Area StockList">
                        <span class="error-message" id="level2-error"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="level2_commission_percentage" class="form-label">Area StockList Commision Percentage</label>
                    <div class="col-md-4 p-0">
                    </div>
                    <div>
                        <input autocomplete="off" type="number" class="form-control" id="level2_commission_percentage" name="level2_commission_percentage" max="100" value="<?= @$level2_commission_percentage ?>" placeholder="Enter commission percentage">
                        <span class="error-message" id="level2_commission_percentage-error"></span>
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="wallet_activation_amount" class="form-label">E-wallet Activation Amount</label>
                    <div class="col-md-4 p-0">
                    </div>
                    <div>
                        <input autocomplete="off" type="number" class="form-control" id="wallet_activation_amount" name="wallet_activation_amount" value="<?= @$wallet_activation_amount ?>" placeholder="Enter e-wallet withdrawal amount">
                        <span class="error-message" id="wallet_activation_amount-error"></span>
                    </div>
                </div>


            </div>

               <div class="col-md-6">
                <div class="mb-3">
                    <label for="wallet_withdrawal_amount" class="form-label">E-wallet Withdrawal Amount</label>
                    <div class="col-md-4 p-0">
                    </div>
                    <div>
                        <input autocomplete="off" type="number" class="form-control" id="wallet_withdrawal_amount" name="wallet_withdrawal_amount" value="<?= @$wallet_withdrawal_amount ?>" placeholder="Enter e-wallet withdrawal amount">
                        <span class="error-message" id="wallet_withdrawal_amount-error"></span>
                    </div>
                </div>


            </div>
        </div>



        <!-- URl -->
        <h3 class="mb-0 mt-3 text-secondary">Social Media And Urls</h3>
        <hr>
        <div class="row input-row offcanvas-body">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="google_maps_url" class="form-label">Google Maps URL</label>
                    <div class="col-md-4 p-0">
                    </div>
                    <div>
                        <input autocomplete="off" type="text" class="form-control" id="google_maps_url" name="google_maps_url" value="<?= @$google_maps_url ?>" placeholder="Google Maps URL">
                        <span class="error-message" id="google_maps_url-error"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="website_url" class="form-label">Website URL</label>
                    <div class="col-md-4 p-0">
                    </div>
                    <div>
                        <input autocomplete="off" type="text" class="form-control" id="website_url" name="website_url" value="<?= @$website_url ?>" placeholder="Website URL">
                        <span class="error-message" id="website_url-error"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="play_store_url" class="form-label">Play Store URL</label>
                    <div class="col-md-4 p-0">
                    </div>
                    <div>
                        <input autocomplete="off" type="text" class="form-control" id="play_store_url" name="play_store_url" value="<?= @$play_store_url ?>" placeholder="Play Store URL">
                        <span class="error-message" id="play_store_url-error"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="app_store_url" class="form-label">App Store URL</label>
                    <div class="col-md-4 p-0">
                    </div>
                    <div>
                        <input autocomplete="off" type="text" class="form-control" id="app_store_url" name="app_store_url" value="<?= @$app_store_url ?>" placeholder="App Store URL">
                        <span class="error-message" id="app_store_url-error"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="facebook_url" class="form-label">Facebook URL</label>
                    <div class="col-md-4 p-0">
                    </div>
                    <div>
                        <input autocomplete="off" type="text" class="form-control" id="facebook_url" name="facebook_url" value="<?= @$facebook_url ?>" placeholder="Facebook URL">
                        <span class="error-message" id="facebook_url-error"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="instagram_url" class="form-label">Instagram URL</label>
                    <div class="col-md-4 p-0">
                    </div>
                    <div>
                        <input autocomplete="off" type="text" class="form-control" id="instagram_url" name="instagram_url" value="<?= @$instagram_url ?>" placeholder="Instagram URL">
                        <span class="error-message" id="instagram_url-error"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="twitter_url" class="form-label">Twitter URL</label>
                    <div class="col-md-4 p-0">
                    </div>
                    <div>
                        <input autocomplete="off" type="text" class="form-control" id="twitter_url" name="twitter_url" value="<?= @$twitter_url ?>" placeholder="Twitter URL">
                        <span class="error-message" id="twitter_url-error"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                    <div class="col-md-4 p-0">
                    </div>
                    <div>
                        <input autocomplete="off" type="text" class="form-control" id="linkedin_url" name="linkedin_url" value="<?= @$linkedin_url ?>" placeholder="LinkedIn URL">
                        <span class="error-message" id="linkedin_url-error"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="youtube_url" class="form-label">YouTube URL</label>
                    <div class="col-md-4 p-0">
                    </div>
                    <div>
                        <input autocomplete="off" type="text" class="form-control" id="youtube_url" name="youtube_url" value="<?= @$youtube_url ?>" placeholder="YouTube URL">
                        <span class="error-message" id="youtube_url-error"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="telegram_url" class="form-label">Telegram URL</label>
                    <div class="col-md-4 p-0">
                    </div>
                    <div>
                        <input autocomplete="off" type="text" class="form-control" id="telegram_url" name="telegram_url" value="<?= @$telegram_url ?>" placeholder="Telegram URL">
                        <span class="error-message" id="telegram_url-error"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="pinterest_url" class="form-label">Pinterest URL</label>
                    <div class="col-md-4 p-0">
                    </div>
                    <div>
                        <input autocomplete="off" type="text" class="form-control" id="pinterest_url" name="pinterest_url" value="<?= @$pinterest_url ?>" placeholder="Pinterest URL">
                        <span class="error-message" id="pinterest_url-error"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="google_search_url" class="form-label">Google Search URL </label>

                    <input autocomplete="off" type="text" class="form-control" id="google_search_url" name="google_search_url" value="<?= @$google_search_url ?>" placeholder="Google Search URL">
                    <span class="error-message" id="google_search_url-error"></span>
                </div>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-primary m-4 p-2" style="width: 200px;" onclick="submitFormWithAjax('form',true,true,successCallback,errorCallback)">Save</button>
            </div>
        </div>
        <!-- Input Fields End -->
    </form>
</div>
<script>
    function successCallback(response) {
        if (response.status == 201 || response.status == 200) {
            var data = JSON.parse(response.data);
            console.log(response.data);
            setTimeout(() => {
                window.location.href = '<?= base_url(route_to('default_dashboard')) ?>';
            }, 2000);
        }
    }

    function errorCallback(response) {
        console.log(response);
    }
</script>