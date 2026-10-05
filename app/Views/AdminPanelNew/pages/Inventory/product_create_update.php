<div class="card form_bg">
    <div class="card-body">
        <div class="offcanvas-header mb-3 d-flex justify-content-between align-items-center">
            <div class="">
                <h5 id="Add_outdoor_mediaLabel"> Add Product</h5>
            </div>
            <a href="<?= base_url(route_to('product_manage')) ?>" class="btn btn-secondary">Back</a>
        </div>
        <div class="error-message-box d-none">
            <p id="error-message"></p>
        </div>
        <div class="success-message-box d-none">
            <p id="success-message"></p>
        </div>

        <form id="form" method="POST" enctype="multipart/form-data" action="<?= @$ApiUrl ?>">
            <input type="hidden" name="product_id" id="product_id" value="<?= @$product_id  ?>">
            <input type="hidden" name="product_image1" id="product_image1" value="<?= @$product_image1 ?>">
            <input type="hidden" name="product_image2" id="product_image2" value="<?= @$product_image2 ?>">
            <input type="hidden" name="product_image3" id="product_image3" value="<?= @$product_image3 ?>">
            <input type="hidden" name="spotlight_image" id="spotlight_image" value="<?= @$spotlight_image ?>">
            <input type="hidden" name="fluencer_video" id="fluencer_video" value="<?= @$fluencer_video ?>">


            <div class="row">
                <div class="col-md-12">

                    <!-- Add Prodcut Detail -->
                    <div class="card-body">
                        <div class="row">

                            <!--Product Name  -->
                            <div class="form-group col-md-6 mb-3">
                                <label for="product_name">Product Name<span class="text-danger">*</span></label>
                                <input type="text" placeholder="Enter Product name" id="product_name" name="product_name" class="form-control" value="<?= @$product_name ?>">
                                <span class="error-message" id="error-product_name"></span>
                            </div>
                            <!-- Product Code -->
                            <div class="form-group col-md-6 mb-3">
                                <label for="product_code">Product Code</label>
                                <input type="text" placeholder="Product Code" id="product_code" name="product_code" class="form-control" value="<?= @$product_code ?>">
                                <span class="error-message" id="error-product_code"></span>
                            </div>
                            <!-- Category Type -->
                            <div class="form-group col-md-6 mb-3">
                                <label class="form-label" for="category_type_id">Category Type<span class="text-danger">*</span></label>
                                <select id="category_type_id" name="category_type_id" placeholder="Select Category Type">
                                </select>
                                <span class="error-message" id="error-category_type_id"></span>
                            </div>
                            <!-- Category -->
                            <div class="form-group col-md-6 mb-3">
                                <label class="form-label" for="category_id">Category<span class="text-danger">*</span></label>
                                <select id="category_id" name="category_id" placeholder="Select Category">
                                </select>
                                <span class="error-message" id="error-category_id"></span>
                            </div>

                            <div class="form-group col-md-6 mb-3">
                                <label class="form-label" for="brand_id">Brand<span class="text-danger">*</span></label>
                                <select id="brand_id" name="brand_id" placeholder="Select Brand ">
                                </select>
                                <span class="error-message" id="error-brand_id"></span>
                            </div>

                            <div class="form-group col-md-6 mb-3">
                                <label for="product_hsn_code">HSN Code<span class="text-danger">*</span></label>
                                <input type="number" placeholder="HSN Code" id="product_hsn_code" name="product_hsn_code" class="form-control" placeholder="HSN Code" value="<?= @$product_hsn_code ?>">
                                <span class="error-message" id="error-product_hsn_code"></span>
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label for="width"> Width</label>
                                <input type="text" placeholder="Width" name="width" id="width" class="form-control" value="<?= @$width ?>">
                                <span class="error-message" id="error-width"></span>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="height"> Height</label>
                                <input type="text" placeholder="Height" name="height" id="height" class="form-control" value="<?= @$height ?>">
                                <span class="error-message" id="error-height"></span>
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label for="length">Length</label>
                                <input type="text" placeholder="length" name="length" id="length" class="form-control" value="<?= @$length ?>">
                                <span class="error-message" id="error-length"></span>
                            </div>
                             <div class="form-group col-md-6 mb-3">
                                <label for="Return Exchange Days">Return Exchange Days<span class="text-danger">*</span></label>
                                <input type="number" placeholder="Return Exchange Days" name="product_return_exchange_days" id="product_return_exchange_days" class="form-control" value="<?= @$product_return_exchange_days ?>">
                                <span class="error-message" id="error-length"></span>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="spotlight_product_title">Spotlight Title</label>
                                <input type="text" placeholder="Spotlight Title" name="spotlight_product_title" id="spotlight_product_title" class="form-control" value="<?= @$spotlight_product_title ?>">
                                <span class="error-message" id="error-spotlight_product_title"></span>
                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <label for="spotlight_product_description">SpotLight Description </label>
                                <textarea class="form-control" name="spotlight_product_description" id="spotlight_product_description" cols="20" rows="5" placeholder="Enter Spotlight Description"><?= @$spotlight_product_description ?></textarea>
                                <span class="error-message" id="error-spotlight_product_description"></span>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="col-md-12 mb-12">
                                    <!-- End -->
                                    <style>
                                        .customHeight>div:first-child {
                                            height: 200px;
                                            overflow-y: scroll;
                                        }
                                    </style>
                      
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <div class=" d-flex gap-2">
                                        <div class="form-check">
                                            <input type="hidden" name="is_spotlight" value="0">
                                            <input class="form-check-input" type="checkbox" value="1" id="is_spotlight" name="is_spotlight" <?= (isset($is_spotlight) && $is_spotlight == 1) ? "checked" : "" ?>>
                                            <label class="form-check-label" for="is_spotlight">
                                                Spotlight
                                            </label>
                                            <span class="error-message" id="error-is_spotlight"></span>
                                        </div>

                                        <div class="form-check">
                                            <input type="hidden" name="is_fluencer" value="0">
                                            <input class="form-check-input" type="checkbox" value="1" id="is_fluencer" name="is_fluencer" <?= (isset($is_fluencer) && $is_fluencer == 1) ? "checked" : "" ?>>
                                            <label class="form-check-label" for="is_fluencer">
                                                Fluencer
                                            </label>
                                            <span class="error-message" id="error-is_fluencer"></span>
                                        </div>

                                        <div class="form-check">
                                            <input type="hidden" name="is_recommended" value="0">
                                            <input class="form-check-input" type="checkbox" value="1" id="is_recommended" name="is_recommended" <?= (isset($is_recommended) && $is_recommended == 1) ? "checked" : "" ?>>
                                            <label class="form-check-label" for="is_recommended">
                                                Recommended
                                            </label>
                                            <span class="error-message" id="error-is_recommended"></span>
                                        </div>
                                        <!-- <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" id="is_exchangeable" name="is_exchangeable" </?= (isset($is_exchangeable) && $is_exchangeable == 1) ? "checked" : "" ?>>
                                            <label class="form-check-label" for="is_exchangeable">
                                                Refund
                                            </label>
                                            <span class="error-message" id="error-is_exchangeable"></span>
                                        </div> -->
                                        <!-- <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" id="is_returnable" name="is_returnable" </?= (isset($is_returnable) && $is_returnable == 1) ? "checked" : "" ?>>
                                            <label class="form-check-label" for="is_returnable">
                                                Return
                                            </label>
                                            <span class="error-message" id="error-is_returnable"></span>
                                        </div> -->
                                        <div class="form-check">
                                            <input type="hidden" name="is_sponsore" value="0">
                                            <input class="form-check-input" type="checkbox" value="1" id="is_sponsore" name="is_sponsore" <?= (isset($is_sponsore) && $is_sponsore == 1) ? "checked" : "" ?>>
                                            <label class="form-check-label" for="is_sponsore">
                                                Sponsore
                                            </label>
                                            <span class="error-message" id="error-is_sponsore"></span>
                                        </div>
                                        <div class="form-check">
                                            <input type="hidden" name="is_active" value="0">
                                            <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" <?= (isset($is_active) && $is_active == 1) ? "checked" : "" ?>>
                                            <label class="form-check-label" for="is_active">
                                                Is Active
                                            </label>
                                            <span class="error-message" id="error-is_active"></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Product Details -->
                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <label for="product_description">Description</label>
                                <textarea class="form-control ckeditor-active" name="product_description" id="product_description" cols="20" rows="5" placeholder="Enter Description"><?= @$product_description ?></textarea>

                                <span class="error-message" id="error-product_description"></span>
                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <label for="product_specialcare">Care and Special Notes</label>
                                <textarea class="form-control" name="product_specialcare" id="product_specialcare" cols="20" rows="5" placeholder="Enter Special care"><?= @$product_specialcare ?></textarea>
                                <span class="error-message" id="error-product_specialcare"></span>
                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <label for="product_refund_exchange">Refunds and Exchange</label>
                                <textarea class="form-control" name="product_refund_exchange" id="product_refund_exchange" cols="20" rows="5" placeholder="Enter Refund Exchange"><?= @$product_refund_exchange ?></textarea>
                                <span class="error-message" id="error-product_refund_exchange"></span>
                            </div>
                            <!-- End -->

                            <!-- Seo Keywords  -->
                            <div class="form-group col-md-12 mb-3">
                                <label for="product_keyfeature"> Product Keywords </label>
                                <textarea class="form-control" name="product_keyfeature" id="product_keyfeature" cols="20" rows="5" placeholder="Enter key Feature"><?= @$product_keyfeature ?></textarea>
                                <span class="error-message" id="error-product_keyfeature"></span>
                            </div>

                            <div class="form-group col-md-12 mb-3">
                                <label for="product_seo_title">Tag title </label>
                                <textarea class="form-control" name="product_seo_title" id="product_seo_title" cols="20" rows="5" placeholder="Enter Tag title"><?= @$product_seo_title ?></textarea>
                                <span class="error-message" id="error-product_seo_title"></span>
                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <label for="product_seo_description">Meta Description</label>
                                <textarea class="form-control" name="product_seo_description" id="product_seo_description" cols="20" rows="5" placeholder="Enter Meta Discription"><?= @$product_seo_description ?></textarea>

                                <span class="error-message" id="error-product_seo_description"></span>
                            </div>
                            <!-- End -->
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Upload Product Images</h6>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-3">
                            <div class="form-group mb-3">
                                <img class="image-fluid" style="height:auto; width:100px" id="product_image1_display" onclick="enlargeImage(event)" src="<?= (isset($product_image1) && !empty($product_image1)) ? base_url($product_image1) : "" ?>">
                                <?php if (isset($product_image1) && !empty($product_image1)) : ?>
                                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('product_image1', 'product_image1_display')"><i class="bx bx-trash-alt"></i></button>
                                <?php endif; ?>
                                <label class="form-label">Upload Files</label>
                                <input type="file" id="file_upload1" name="file_upload1" class="form-control" onchange="ProductUploadImage('file_upload1','product_image1','product_image1_display')">
                                <span class="error-message" id="error-file_upload1"></span>
                                <input type="text" placeholder="Alt text" id="product_alt_text1" name="product_alt_text1" class="form-control" value="<?= @$product_alt_text1 ?>">
                                <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
                            </div>
                            <div class="form-group mb-3">
                                <img class="image-fluid" style="height:auto; width:100px" id="product_image2_display" onclick="enlargeImage(event)" src="<?= (isset($product_image2) && !empty($product_image2)) ? base_url($product_image2) : "" ?>">

                                <?php if (isset($product_image2) && !empty($product_image2)) : ?>
                                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('product_image2', 'product_image2_display')"><i class="bx bx-trash-alt"></i></button>
                                <?php endif; ?>
                                <label class="form-label">Upload Files</label>
                                <input type="file" id="file_upload2" class="form-control" onchange="ProductUploadImage('file_upload2','product_image2','product_image2_display')">
                                <span class="error-message" id="error-file"></span>
                                <input type="text" placeholder="Alt text" id="product_alt_text2" name="product_alt_text2" class="form-control" value="<?= @$product_alt_text2 ?>">
                                <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
                            </div>
                            <div class="form-group mb-3">
                                <img class="image-fluid" style="height:auto; width:100px" id="product_image3_display" onclick="enlargeImage(event)" src="<?= (isset($product_image3) && !empty($product_image3)) ? base_url($product_image3) : "" ?>">
                                <?php if (isset($product_image3) && !empty($product_image3)) : ?>
                                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('product_image3', 'product_image3_display')"><i class="bx bx-trash-alt"></i></button>
                                <?php endif; ?>
                                <label class="form-label">Upload Files</label>
                                <input type="file" id="file_upload3" class="form-control" onchange="ProductUploadImage('file_upload3','product_image3','product_image3_display')">
                                <span class="error-message" id="error-file"></span>
                                <input type="text" placeholder="Alt text" id="product_alt_text3" name="product_alt_text3" class="form-control" value="<?= @$product_alt_text3 ?>">
                                <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row row-cols-2">
                            <div class="form-group mb-3">
                                <img class="image-fluid" style="height:auto; width:100px" id="spotlight_image_display" onclick="enlargeImage(event)" src="<?= (isset($spotlight_image) && !empty($spotlight_image)) ? base_url($spotlight_image) : "" ?>">
                                <?php if (isset($spotlight_image) && !empty($spotlight_image)) : ?>
                                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('spotlight_image', 'spotlight_image_display')"><i class="bx bx-trash-alt"></i></button>
                                <?php endif; ?>
                                <label class="form-label">Spotlight Image</label>
                                <input type="file" id="spotlight-upload" class="form-control" onchange="ProductUploadImage('spotlight-upload','spotlight_image','spotlight_image_display')">
                                <span class="error-message" id="error-spotligt-upload"></span>
                                <input type="text" placeholder="Alt text" id="spotlight_alt_text" name="spotlight_alt_text" class="form-control" value="<?= @$spotlight_alt_text ?>">
                                <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
                            </div>

                            <div class="form-group mb-3">
                                <video id="fluencer_video_display"
                                    style="height:auto; width:150px"
                                    onclick="enlargeVideo(event)"
                                    controls>
                                    <?php if (!empty($fluencer_video)) : ?>
                                        <source src="<?= base_url($fluencer_video) ?>" type="video/mp4">
                                    <?php endif; ?>
                                    Your browser does not support the video tag.
                                </video>

                                <?php if (isset($fluencer_video) && !empty($fluencer_video)) : ?>
                                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('fluencer_video', 'fluencer_video_display')"><i class="bx bx-trash-alt"></i></button>
                                <?php endif; ?>
                                <label class="form-label">Upload Video</label>
                                <input type="file" id="fluencer_video_upload" name="fluencer_video_upload" class="form-control" onchange="ProductUploadImage('fluencer_video_upload','fluencer_video','fluencer_video_display')">
                                <span class="error-message" id="error-file"></span>
                                <input type="text" placeholder="Alt text" id="fluencer_alt_text" name="fluencer_alt_text" class="form-control" value="<?= @$fluencer_alt_text ?>">
                                <p class="my-1 font_size_11">The video must be uploaded under 500KB.<span class="text-danger">*</span></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div>
                    <button type="button" onclick="submitFormWithAjax('form',true,true,successCallback,errorCallback)" class="btn btn-primary waves-effect waves-light me-1">
                        Submit
                    </button>
                    <button type="reset" class="btn btn-secondary waves-effect" onclick="window.location.href='<?= base_url(route_to('product_manage')) ?>'">
                        Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function successCallback(response) {
        if (response.status == 201) {
            var data = JSON.parse(response.data);
            console.log(response.data);
            window.location.href = '<?= base_url(route_to('variant_create_update', '')) ?>' + "/" + data.product_id;
        }
        if (response.status == 200) {
            window.location.href = '<?= base_url(route_to('product_manage')) ?>';
        }
    }

    function errorCallback(response) {
        console.log(response);
    }

    function ProductUploadImage(id, input_id, image_tag_id) {
        let forType = 'product'; // default

        if (input_id === 'fluencer_video') {
            forType = 'product_video'; // or 'fluencer_video' if backend supports it
        } else if (input_id === 'spotlight_image') {
            forType = 'slider_image';
        }

        uploadImage(id, forType, input_id, image_tag_id);
    }


    var selected_category_type_id = "<?= @$category_type_id ?>";
    var selected_category_id = "<?= @$category_id ?>";
    var selected_brand_id = "<?= @$brand_id ?>";
    var selected_variant_id = "<?= @$variant_id ?>";
    var selected_features = JSON.parse('<?= json_encode($features) ?>');

    $(document).ready(function() {
        initializeSelectize('category_id', {
            placeholder: "Select Category"
        })
        initializeSelectize('features', {
                placeholder: "Select Multiple Features"
            }, "<?= base_url(route_to('feature_list_api')) ?>", {
                _autojoin: "Y",
                _select: "*",
                _selectOther: "concat(feature_type.feature_type_name,'(',feature.feature_name,')') as feature_name_with_type"
            }, "feature_id", "feature_name_with_type",
            selected_features, 'feature_type_name')
        initializeSelectize('category_type_id', {}, "<?= base_url(route_to('categoryType_list_api')) ?>", {},
            "category_type_id", "category_type_name", selected_category_type_id).onchange(function(
            category_type_id) {
            // Handle onchange event for country selectize dropdown
            // Clear options of state selectize dropdown
            // Reset variables
            initializeSelectize('category_id').clearOptions().then(function() {
                // Initialize state selectize dropdown
                if (category_type_id != '') {
                    initializeSelectize('category_id', {
                        placeholder: "Select Category"
                    }, "<?= base_url(route_to('category_list_api')) ?>", {
                        category_type_id: category_type_id
                    }, 'category_id', 'category_name', selected_category_id)
                }
            });
        });
        initializeSelectize('brand_id', {}, "<?= base_url(route_to('brand_list_api')) ?>", {}, "brand_id",
            "brand_name", selected_brand_id)
        initializeSelectize('variant_id', {}, "<?= base_url(route_to('variant_list_api')) ?>", {}, "variant_id",
            "variant_name", selected_variant_id)
    });
</script>