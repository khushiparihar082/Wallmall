<div class="card form_bg">
    <form autocomplete="on" id="form" class="card-body" method="POST" enctype="multipart/form-data" action="<?= @$ApiUrl ?>">
        <input type="hidden" name="image_slider_web_img_1" id="image_slider_web_img_1" value="<?= @$image_slider_web_img_1 ?>">
        <input type="hidden" name="image_slider_web_img_2" id="image_slider_web_img_2" value="<?= @$image_slider_web_img_2 ?>">
        <input type="hidden" name="image_slider_web_img_3" id="image_slider_web_img_3" value="<?= @$image_slider_web_img_3 ?>">
        <input type="hidden" name="image_slider_web_img_4" id="image_slider_web_img_4" value="<?= @$image_slider_web_img_4 ?>">
        <input type="hidden" name="image_slider_web_img_5" id="image_slider_web_img_5" value="<?= @$image_slider_web_img_5 ?>">

        <input type="hidden" name="image_slider_mob_img_1" id="image_slider_mob_img_1" value="<?= @$image_slider_mob_img_1 ?>">
        <input type="hidden" name="image_slider_mob_img_2" id="image_slider_mob_img_2" value="<?= @$image_slider_mob_img_2 ?>">
        <input type="hidden" name="image_slider_mob_img_3" id="image_slider_mob_img_3" value="<?= @$image_slider_mob_img_3 ?>">
        <input type="hidden" name="image_slider_mob_img_4" id="image_slider_mob_img_4" value="<?= @$image_slider_mob_img_4 ?>">
        <input type="hidden" name="image_slider_mob_img_5" id="image_slider_mob_img_5" value="<?= @$image_slider_mob_img_5 ?>">

        <div class="offcanvas-header mb-4">
            <div class="">
                <h5 id="Add_outdoor_mediaLabel"> Add Home</h5>
            </div>
        </div>
        <input type="hidden" name="website_profile_id" value="<?= @$website_profile_id ?>">

        <div class="row">
            <h4>Web</h4>

            <div class="form-group col-md-6 mb-3">
                <img class="image-fluid" style="height:auto; width:100px" id="image_slider_web_img_1_display" onclick="enlargeImage(event)" src="<?= (isset($image_slider_web_img_1) && !empty($image_slider_web_img_1)) ? base_url($image_slider_web_img_1) : "" ?>">
                <?php if (isset($image_slider_web_img_1) && !empty($image_slider_web_img_1)) : ?>
                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('image_slider_web_img_1', 'image_slider_web_img_1_display')"><i class="bx bx-trash-alt"></i></button>
                <?php endif; ?>
                <label class="form-label">Upload Files</label>
                <input type="file" id="file_upload1" name="file_upload1" class="form-control" onchange="ProductUploadImage('file_upload1','image_slider_web_img_1','image_slider_web_img_1_display')">
                <span class="error-message" id="error-file_upload1"></span>
                <input type="text" placeholder="Alt text" id="image_slider_web_img_alt_1" name="image_slider_web_img_alt_1" class="form-control" value="<?= @$image_slider_web_img_alt_1 ?>">
                <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="image_slider_web_redirect_url_1">Redirect URL</label>
                <input type="text" id="image_slider_web_redirect_url_1" name="image_slider_web_redirect_url_1" class="form-control" value="<?= @$image_slider_web_redirect_url_1 ?>">
                <span class="error-message" id="error-image_slider_web_redirect_url_1"></span>
            </div>
            <div class="form-group col-md-6 mb-3">
                <img class="image-fluid" style="height:auto; width:100px" id="image_slider_web_img_2_display" onclick="enlargeImage(event)" src="<?= (isset($image_slider_web_img_2) && !empty($image_slider_web_img_2)) ? base_url($image_slider_web_img_2) : "" ?>">

                <?php if (isset($image_slider_web_img_2) && !empty($image_slider_web_img_2)) : ?>
                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('image_slider_web_img_2', 'image_slider_web_img_2_display')"><i class="bx bx-trash-alt"></i></button>
                <?php endif; ?>
                <label class="form-label">Upload Files</label>
                <input type="file" id="file_upload2" class="form-control" onchange="ProductUploadImage('file_upload2','image_slider_web_img_2','image_slider_web_img_2_display')">
                <span class="error-message" id="error-file"></span>
                <input type="text" placeholder="Alt text" id="image_slider_web_img_alt_2" name="image_slider_web_img_alt_2" class="form-control" value="<?= @$image_slider_web_img_alt_2 ?>">
                <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="image_slider_web_redirect_url_2">Redirect URL</label>
                <input type="text" id="image_slider_web_redirect_url_2" name="image_slider_web_redirect_url_2" class="form-control" value="<?= @$image_slider_web_redirect_url_2 ?>">
                <span class="error-message" id="error-image_slider_web_redirect_url_2"></span>
            </div>
            <div class="form-group col-md-6 mb-3">
                <img class="image-fluid" style="height:auto; width:100px" id="image_slider_web_img_3_display" onclick="enlargeImage(event)" src="<?= (isset($image_slider_web_img_3) && !empty($image_slider_web_img_3)) ? base_url($image_slider_web_img_3) : "" ?>">
                <?php if (isset($image_slider_web_img_3) && !empty($image_slider_web_img_3)) : ?>
                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('image_slider_web_img_3', 'image_slider_web_img_3_display')"><i class="bx bx-trash-alt"></i></button>
                <?php endif; ?>
                <label class="form-label">Upload Files</label>
                <input type="file" id="file_upload3" class="form-control" onchange="ProductUploadImage('file_upload3','image_slider_web_img_3','image_slider_web_img_3_display')">
                <span class="error-message" id="error-file"></span>
                <input type="text" placeholder="Alt text" id="image_slider_web_img_alt_3" name="image_slider_web_img_alt_3" class="form-control" value="<?= @$image_slider_web_img_alt_3 ?>">
                <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="image_slider_web_redirect_url_3">Redirect URL</label>
                <input type="text" id="image_slider_web_redirect_url_3" name="image_slider_web_redirect_url_3" class="form-control" value="<?= @$image_slider_web_redirect_url_3 ?>">
                <span class="error-message" id="error-image_slider_web_redirect_url_3"></span>
            </div>

            <div class="form-group col-md-6 mb-3">
                <img class="image-fluid" style="height:auto; width:100px" id="image_slider_web_img_4_display" onclick="enlargeImage(event)" src="<?= (isset($image_slider_web_img_4) && !empty($image_slider_web_img_4)) ? base_url($image_slider_web_img_4) : "" ?>">
                <?php if (isset($image_slider_web_img_4) && !empty($image_slider_web_img_4)) : ?>
                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('image_slider_web_img_4', 'image_slider_web_img_4_display')"><i class="bx bx-trash-alt"></i></button>
                <?php endif; ?>
                <label class="form-label">Upload Files</label>
                <input type="file" id="file_upload4" class="form-control" onchange="ProductUploadImage('file_upload4','image_slider_web_img_4','image_slider_web_img_4_display')">
                <span class="error-message" id="error-file"></span>
                <input type="text" placeholder="Alt text" id="image_slider_web_img_alt_4" name="image_slider_web_img_alt_4" class="form-control" value="<?= @$image_slider_web_img_alt_4 ?>">
                <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="image_slider_web_redirect_url_4">Redirect URL</label>
                <input type="text" id="image_slider_web_redirect_url_4" name="image_slider_web_redirect_url_4" class="form-control" value="<?= @$image_slider_web_redirect_url_4 ?>">
                <span class="error-message" id="error-image_slider_web_redirect_url_4"></span>
            </div>

            <div class="form-group col-md-6 mb-3">
                <img class="image-fluid" style="height:auto; width:100px" id="image_slider_web_img_5_display" onclick="enlargeImage(event)" src="<?= (isset($image_slider_web_img_5) && !empty($image_slider_web_img_5)) ? base_url($image_slider_web_img_5) : "" ?>">
                <?php if (isset($image_slider_web_img_5) && !empty($image_slider_web_img_5)) : ?>
                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('image_slider_web_img_5', 'image_slider_web_img_5_display')"><i class="bx bx-trash-alt"></i></button>
                <?php endif; ?>
                <label class="form-label">Upload Files</label>
                <input type="file" id="file_upload5" class="form-control" onchange="ProductUploadImage('file_upload5','image_slider_web_img_5','image_slider_web_img_5_display')">
                <span class="error-message" id="error-file"></span>
                <input type="text" placeholder="Alt text" id="image_slider_web_img_alt_4" name="image_slider_web_img_alt_4" class="form-control" value="<?= @$image_slider_web_img_alt_4 ?>">
                <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="image_slider_web_redirect_url_5">Redirect URL</label>
                <input type="text" id="image_slider_web_redirect_url_5" name="image_slider_web_redirect_url_5" class="form-control" value="<?= @$image_slider_web_redirect_url_5 ?>">
                <span class="error-message" id="error-image_slider_web_redirect_url_5"></span>
            </div>
        </div>
        <!-- Input Fields Start -->
        <div class="row">
            <h4>Mob</h4>

            <div class="form-group col-md-6 mb-3">
                <img class="image-fluid" style="height:auto; width:100px" id="image_slider_mob_img_1_display" onclick="enlargeImage(event)" src="<?= (isset($image_slider_mob_img_1) && !empty($image_slider_mob_img_1)) ? base_url($image_slider_mob_img_1) : "" ?>">
                <?php if (isset($image_slider_mob_img_1) && !empty($image_slider_mob_img_1)) : ?>
                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('image_slider_mob_img_1', 'image_slider_mob_img_1_display')"><i class="bx bx-trash-alt"></i></button>
                <?php endif; ?>
                <label class="form-label">Upload Files</label>
                <input type="file" id="file_upload6"  class="form-control" onchange="ProductUploadImage('file_upload6','image_slider_mob_img_1','image_slider_mob_img_1_display')">
                <span class="error-message" id="error-file_upload6"></span>
                <input type="text" placeholder="Alt text" id="image_slider_mob_img_alt_1" name="image_slider_mob_img_alt_1" class="form-control" value="<?= @$image_slider_mob_img_alt_1 ?>">
                <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="image_slider_mob_redirect_url_1">Redirect URL</label>
                <input type="text" id="image_slider_mob_redirect_url_1" name="image_slider_mob_redirect_url_1" class="form-control" value="<?= @$image_slider_mob_redirect_url_1 ?>">
                <span class="error-message" id="error-image_slider_mob_redirect_url_1"></span>
            </div>
            <div class="form-group col-md-6 mb-3">
                <img class="image-fluid" style="height:auto; width:100px" id="image_slider_mob_img_2_display" onclick="enlargeImage(event)" src="<?= (isset($image_slider_mob_img_2) && !empty($image_slider_mob_img_2)) ? base_url($image_slider_mob_img_2) : "" ?>">

                <?php if (isset($image_slider_mob_img_2) && !empty($image_slider_mob_img_2)) : ?>
                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('image_slider_mob_img_2', 'image_slider_mob_img_2_display')"><i class="bx bx-trash-alt"></i></button>
                <?php endif; ?>
                <label class="form-label">Upload Files</label>
                <input type="file" id="file_upload7" class="form-control" onchange="ProductUploadImage('file_upload7','image_slider_mob_img_2','image_slider_mob_img_2_display')">
                <span class="error-message" id="error-file_upload7"></span>
                <input type="text" placeholder="Alt text" id="image_slider_mob_img_alt_2" name="image_slider_mob_img_alt_2" class="form-control" value="<?= @$image_slider_mob_img_alt_2 ?>">
                <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="image_slider_mob_redirect_url_2">Redirect URL</label>
                <input type="text" id="image_slider_mob_redirect_url_2" name="image_slider_mob_redirect_url_2" class="form-control" value="<?= @$image_slider_mob_redirect_url_2 ?>">
                <span class="error-message" id="error-image_slider_mob_redirect_url_2"></span>
            </div>
            <div class="form-group col-md-6 mb-3">
                <img class="image-fluid" style="height:auto; width:100px" id="image_slider_mob_img_3_display" onclick="enlargeImage(event)" src="<?= (isset($image_slider_mob_img_3) && !empty($image_slider_mob_img_3)) ? base_url($image_slider_mob_img_3) : "" ?>">
                <?php if (isset($image_slider_mob_img_3) && !empty($image_slider_mob_img_3)) : ?>
                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('image_slider_mob_img_3', 'image_slider_mob_img_3_display')"><i class="bx bx-trash-alt"></i></button>
                <?php endif; ?>
                <label class="form-label">Upload Files</label>
                <input type="file" id="file_upload8" class="form-control" onchange="ProductUploadImage('file_upload8','image_slider_mob_img_3','image_slider_mob_img_3_display')">
                <span class="error-message" id="error-file_upload8"></span>
                <input type="text" placeholder="Alt text" id="image_slider_mob_img_alt_3" name="image_slider_mob_img_alt_3" class="form-control" value="<?= @$image_slider_mob_img_alt_3 ?>">
                <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="image_slider_mob_redirect_url_3">Redirect URL</label>
                <input type="text" id="image_slider_mob_redirect_url_3" name="image_slider_mob_redirect_url_3" class="form-control" value="<?= @$image_slider_mob_redirect_url_3 ?>">
                <span class="error-message" id="error-image_slider_mob_redirect_url_3"></span>
            </div>

            <div class="form-group col-md-6 mb-3">
                <img class="image-fluid" style="height:auto; width:100px" id="image_slider_mob_img_4_display" onclick="enlargeImage(event)" src="<?= (isset($image_slider_mob_img_4) && !empty($image_slider_mob_img_4)) ? base_url($image_slider_mob_img_4) : "" ?>">
                <?php if (isset($image_slider_mob_img_4) && !empty($image_slider_mob_img_4)) : ?>
                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('image_slider_mob_img_4', 'image_slider_mob_img_4_display')"><i class="bx bx-trash-alt"></i></button>
                <?php endif; ?>
                <label class="form-label">Upload Files</label>
                <input type="file" id="file_upload9" class="form-control" onchange="ProductUploadImage('file_upload9','image_slider_mob_img_4','image_slider_mob_img_4_display')">
                <span class="error-message" id="error-file_upload9"></span>
                <input type="text" placeholder="Alt text" id="image_slider_mob_img_alt_4" name="image_slider_mob_img_alt_4" class="form-control" value="<?= @$image_slider_mob_img_alt_4 ?>">
                <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="image_slider_mob_redirect_url_4">Redirect URL</label>
                <input type="text" id="image_slider_mob_redirect_url_4" name="image_slider_mob_redirect_url_4" class="form-control" value="<?= @$image_slider_mob_redirect_url_4 ?>">
                <span class="error-message" id="error-image_slider_mob_redirect_url_4"></span>
            </div>

            <div class="form-group col-md-6 mb-3">
                <img class="image-fluid" style="height:auto; width:100px" id="image_slider_mob_img_5_display" onclick="enlargeImage(event)" src="<?= (isset($image_slider_mob_img_5) && !empty($image_slider_mob_img_5)) ? base_url($image_slider_mob_img_5) : "" ?>">
                <?php if (isset($image_slider_mob_img_5) && !empty($image_slider_mob_img_5)) : ?>
                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('image_slider_mob_img_5', 'image_slider_mob_img_5_display')"><i class="bx bx-trash-alt"></i></button>
                <?php endif; ?>
                <label class="form-label">Upload Files</label>
                <input type="file" id="file_upload10" class="form-control" onchange="ProductUploadImage('file_upload10','image_slider_mob_img_5','image_slider_mob_img_5_display')">
                <span class="error-message" id="error-file_upload10"></span>
                <input type="text" placeholder="Alt text" id="image_slider_mob_img_alt_4" name="image_slider_mob_img_alt_4" class="form-control" value="<?= @$image_slider_mob_img_alt_4 ?>">
                <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="image_slider_mob_redirect_url_5">Redirect URL</label>
                <input type="text" id="image_slider_mob_redirect_url_5" name="image_slider_mob_redirect_url_5" class="form-control" value="<?= @$image_slider_mob_redirect_url_5 ?>">
                <span class="error-message" id="error-image_slider_mob_redirect_url_5"></span>
            </div>
        </div>
        <div class="row ">
            <div class="col-4">
                <label for="sales_mobile" class="form-label">Sales Mobile</label>
                <input autocomplete="off" type="number" class="form-control" id="sales_mobile" name="sales_mobile" value="<?= @$sales_mobile ?>" placeholder="Enter Number">
                <span class="error-message" id="sales_mobile-error"></span>
            </div>

            <div class="col-4">
                <label for="sales_whatsapp" class="form-label">Sales Whatsapp</label>
                <input autocomplete="off" type="number" class="form-control" id="sales_whatsapp" name="sales_whatsapp" value="<?= @$sales_whatsapp ?>" placeholder="Enter Number">
                <span class="error-message" id="sales_whatsapp-error"></span>
            </div>

            <div class="col-4 mb-4">
                <label for="sales_email" class="form-label">Sales Email</label>
                <input autocomplete="off" type="email" class="form-control" id="sales_email" name="sales_email" value="<?= @$sales_email ?>" placeholder="Enter Email">
                <span class="error-message" id="sales_email-error"></span>
            </div>


            <div class="col-12 mb-4">
                <label for="home_page_seo_title" class="form-label">Home Tag Title</label>
                <input class="form-control" name="home_page_seo_title" id="home_page_seo_title" rows="3" value="<?= @$home_page_seo_title ?>">
            </div>

            <div class="col-12 mb-4">
                <label for="home_page_seo_keyword" class="form-label">Home Meta Keyword</label>
                <input class="form-control" name="home_page_seo_keyword" id="home_page_seo_keyword" rows="3" value="<?= @$home_page_seo_keyword ?>">
            </div>

            <div class="col-12 mb-4">
                <label for="home_page_seo_description" class="form-label">Home Meta Description</label>
                <textarea class="form-control" name="home_page_seo_description" id="home_page_seo_description" rows="3"><?= @$home_page_seo_description ?></textarea>
            </div>

            <div class="col-12 mb-4">
                <label for="home_page_content" class="form-label">Home Page Content</label>
                <textarea class="form-control ckeditor-active" name="home_page_content" id="home_page_content" cols="20" rows="5" placeholder="Enter Home"><?= @$home_page_content ?></textarea>
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

    function ProductUploadImage(id, input_id, image_tag_id) {
        uploadImage(id, 'slider_image', input_id, image_tag_id)
    }
</script>