<div class="card form_bg">
    <div class="card-body">
        <div class="offcanvas-header d-flex justify-content-between align-items-center mb-3">
            <div class="">
                <h5 class="m-0 font-weight-bold"><?= (isset($variant_id) && !empty($variant_id)) ? "Update" : "Add" ?> Variant</h5>
            </div>
            <a href="<?= base_url(route_to('variant_list', $product_id)) ?>" class="btn btn-secondary">Back</a>
        </div>
        <form id="form" class="custom-validation" method="post" action="<?= (isset($variant_id) && !empty($variant_id)) ? base_url(route_to('variant_update_api')) : base_url(route_to('variant_create_api')) ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">

                    <!-- Add Prodcut Detail -->
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12 mb-3">
                                <input type="hidden" name="variant_id" id="variant_id" value="<?= @$variant_id ?>">
                                <input type="hidden" name="product_id" id="product_id" value="<?= @$product_id ?>">
                                <input type="hidden" name="variant_image1" id="variant_image1" value="<?= @$variant_image1 ?>">
                                <input type="hidden" name="variant_image2" id="variant_image2" value="<?= @$variant_image2 ?>">
                                <input type="hidden" name="variant_image3" id="variant_image3" value="<?= @$variant_image3 ?>">
                                <input type="hidden" name="variant_image4" id="variant_image4" value="<?= @$variant_image4 ?>">
                                <input type="hidden" name="variant_image5" id="variant_image5" value="<?= @$variant_image5 ?>">
                                <input type="hidden" name="variant_image6" id="variant_image6" value="<?= @$variant_image6 ?>">
                                <label class="form-label" for="variant_name">Variant Title</label>
                                <input type="text" placeholder="Enter Variant name" id="variant_name" name="variant_name" class="form-control" value="<?= @$variant_name ?>">
                                <span class="error-message" id="error-variant_name"></span>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="variant_sku_code">SKU Code<span class="text-danger">*</span></label>
                                <input type="number" placeholder="SKU Code" id="variant_sku_code" name="variant_sku_code" class="form-control" placeholder="HSN Code" value="<?= @$variant_sku_code ?>">
                                <span class="error-message" id="error-variant_sku_code"></span>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="unit_id">Unit<span class="text-danger">*</span></label>
                                <select id="unit_id" name="unit_id"></select>
                                <span class="error-message" id="error-unit_id"></span>
                            </div>
                            <div class="mb-3 col-md-4">
                                 <label for="color">Weight (In Gram)<span class="text-danger">*</span></label>
                                <input type="number" placeholder="Weight" id="variant_weight" name="variant_weight" class="form-control" placeholder="Wieght" value="<?= @$variant_weight ?>">
                                <span class="error-message" id="error-variant_weight"></span>
                            </div>

                            <div class="form-group mb-3 col-md-8 mb-3">
                                <label class="form-label" for="size_id">Size<span class="text-danger">*</span></label>
                                <select id="size_id" name="size_id" placeholder="Select size_id">
                                </select>
                                <span class="error-message" id="error-size_id"></span>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="color">Color<span class="text-danger">*</span></label>
                                <select id="color_id" name="color_id"></select>
                                <span class="error-message" id="error-color_id"></span>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="color">Minimum Stock<span class="text-danger">*</span></label>
                                <input type="number" placeholder="Minimum Stock" id="minimum_stock" name="minimum_stock" class="form-control" placeholder="HSN Code" value="<?= @$minimum_stock ?>">
                                <span class="error-message" id="error-minimum_stock"></span>
                            </div>
                            <div class="mb-3 col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" <?= (isset($is_active) && $is_active == 1) ? "checked" : "" ?>>
                                    <label class="form-check-label" for="is_active">
                                        Is Active
                                    </label>
                                    <span class="error-message" id="error-is_active"></span>
                                </div>
                            </div>

                            <div class="form-group col-md-12 mb-3">
                                <label for="product_variant_seo_title"> Tag Title </label>
                                <textarea class="form-control" name="product_variant_seo_title" id="product_variant_seo_title" cols="10" rows="5" placeholder="Enter Tag Title"><?= @$product_variant_seo_title ?></textarea>
                                <span class="error-message" id="error-product_variant_seo_title"></span>
                            </div>

                            <div class="form-group col-md-12 mb-3">
                                <label for="variant_seo_keyword"> Meta Keywords </label>
                                <textarea class="form-control" name="variant_seo_keyword" id="variant_seo_keyword" cols="10" rows="5" placeholder="Enter Meta Keyword"><?= @$variant_seo_keyword ?></textarea>
                                <span class="error-message" id="error-variant_seo_keyword"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="variant_seo_description"> Seo Description </label>
                                <textarea rows="3" id="variant_seo_description" class="form-control" name="variant_seo_description" cols="10" rows="5" placeholder="Enter Seo Description"><?= @$variant_seo_description ?></textarea>
                                <span class="error-message" id="error-variant_seo_description"></span>
                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <label for="variant_description">Description</label>
                                <textarea class="ckeditor-active form-control" name="variant_description" id="variant_description" cols="20" rows="5" placeholder="Enter Description"><?= htmlspecialchars(@$variant_description) ?></textarea>
                                <span class="error-message" id="error-variant_description"></span>
                            </div>
                            <!-- End -->
                        </div>
                    </div>

                </div>
                <div class="col-md-4 bg-white">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold">Product Price</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3 col-md-12">
                            <label class="form-label" for="purchase_rate">Purchase Rate/Cost (W/O GST)</label>
                            <input type="number" autocomplete="off" min="0" name="purchase_rate" placeholder="0.00" class="form-control" id="purchase_rate" onchange="calculate_variant()" value="<?= @$purchase_rate ?>">
                            <span class="error-message" id="error-purchase_rate"></span>
                        </div>
                        <div class="form-group mb-3 col-md-12">
                            <label class="form-label" for="txt_product_price">M.R.P<span class="text-danger">*</span></label>
                            <input type="number" autocomplete="off" min="0" name="mrp" placeholder="0.00" class="form-control" id="mrp" onchange="calculate_variant()" value="<?= @$mrp ?>">
                            <span class="error-message" id="error-mrp"></span>
                        </div>
                        <div class="form-group mb-3 col-md-12">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label" for="txt_discount">Dis %</label>
                                    <input type="number" autocomplete="off" placeholder="0.00" class="form-control" min="0" max="100" name="discount_per" id="discount_per" onchange="calculate_variant()" value="<?= @$discount_per ?>">
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="discount_amt">Dis Amt</label>
                                    <input type="text" class="form-control" name="discount_amt" id="discount_amt" value="<?= @$discount_amt ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3 col-md-12">
                            <label class="form-label" for="selling_price">Selling Price<span class="text-danger">*</span></label>
                            <input type="number" name="selling_price" class="form-control" id="selling_price" value="<?= @$selling_price ?>">
                            <span class="error-message" id="error-selling_price"></span>
                        </div>
                        <!-- <div class="form-group mb-3 col-md-12">
                            <label class="form-label" for="delivery_charge">Delivery Charge<span class="text-danger">*</span></label>
                            <input type="number" name="delivery_charge" class="form-control" id="delivery_charge" value="<#?= @$delivery_charge ?>">
                            <span class="error-message" id="error-delivery_charge"></span>
                        </div> -->
                        <input type="hidden" name="delivery_charge" class="form-control" id="delivery_charge" value="<?= @$delivery_charge ?>">
                        <hr />
                        <div class="form-group mb-3 col-md-12">
                            <label class="form-label">GST Inclusive</label>
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label">GST %</label>
                                    <select class="form-control select2" id="gst_per" name="gst_per" onchange="calculate_variant()" value="<?= @$gst_per ?>">
                                        <option value="0" <?= (isset($gst_per) && $gst_per == '0') ? 'selected' : '' ?>>0%</option>
                                        <option value="5" <?= (isset($gst_per) && $gst_per == '5') ? 'selected' : '' ?>>5%</option>
                                        <option value="12" <?= (isset($gst_per) && $gst_per == '12') ? 'selected' : '' ?>>12%</option>
                                        <option value="18" <?= (isset($gst_per) && $gst_per == '18') ? 'selected' : '' ?>>18%</option>
                                        <option value="28" <?= (isset($gst_per) && $gst_per == '28') ? 'selected' : '' ?>>28%</option>
                                    </select>
                                    <span class="error-message" id="error-gst_per"></span>
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="txt_gst_amount">GST Amt</label>
                                    <input type="number" readonly="true" name="gst_amt" placeholder="0.00" class="form-control" id="gst_amt" value="<?= @$gst_amt ?>">
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="form-group mb-3 col-md-12">
                            <label class="form-label">Selling Cost Price (W/O GST)</label>
                            <input type="number" readonly="true" placeholder="0.00" class="form-control" name="cost_price" id="cost_price" value="<?= @$cost_price ?>">
                        </div>
                        <div class="form-group mb-3 col-md-12">
                            <label class="form-label">Profit Calculation</label>
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label">Profit %</label>
                                    <input type="number" readonly="true" placeholder="0.00" class="form-control" name="profit_per" id="profit_per" value="<?= @$profit_per ?>">
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="txt_gst_amount">Profit Amt</label>
                                    <input type="number" readonly="true" placeholder="0.00" class="form-control" name="profit_amt" id="profit_amt" value="<?= @$profit_amt ?>">
                                </div>
                            </div>
                        </div>

                          <div class="row">
                                <div class="col-12">
                                    <label class="form-label" for="cod_charges">COD Add Cost @ Product</label>
                                    <input type="number" class="form-control" name="cod_charges" id="cod_charges" value="<?= @$cod_charges ?>">
                                </div>
                               
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
                                <img class="image-fluid" style="height:auto; width:100px; margin-bottom:10px;" id="variant_image1_display" onclick="enlargeImage(event)" src="<?= (isset($variant_image1) && !empty($variant_image1)) ? base_url($variant_image1) : "" ?>">
                                <?php if (isset($variant_image1) && !empty($variant_image1)) : ?>
                                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('variant_image1', 'variant_image1_display')"><i class="bx bx-trash-alt"></i></button>
                                <?php endif; ?>
                                <label class="form-label">Upload Files<span class="text-danger">*</span></label>
                                <input type="file" id="file_upload1" class="form-control" onchange="VariantUploadImage('file_upload1','variant_image1','variant_image1_display')">
                                <span class="error-message" id="error-file_upload1"></span>
                                <input type="text" placeholder="Alt text" id="variant_alt_text1" name="variant_alt_text1" class="form-control" value="<?= @$variant_alt_text1 ?>">
                                <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
                            </div>
                            <div class="form-group mb-3">
                                <img class="image-fluid" style="height:auto; width:100px; margin-bottom:10px;" id="variant_image2_display" onclick="enlargeImage(event)" src="<?= (isset($variant_image2) && !empty($variant_image2)) ? base_url($variant_image2) : "" ?>">

                                <?php if (isset($variant_image2) && !empty($variant_image2)) : ?>
                                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('variant_image2', 'variant_image2_display')"><i class="bx bx-trash-alt"></i></button>
                                <?php endif; ?>
                                <label class="form-label">Upload Files</label>
                                <input type="file" id="file_upload2" class="form-control" onchange="VariantUploadImage('file_upload2','variant_image2','variant_image2_display')">
                                <span class="error-message" id="error-file_upload2"></span>
                                <input type="text" placeholder="Alt text" id="variant_alt_text2" name="variant_alt_text2" class="form-control" value="<?= @$variant_alt_text2 ?>">
                                <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
                            </div>
                            <div class="form-group mb-3">
                                <img class="image-fluid" style="height:auto; width:100px; margin-bottom:10px;" id="variant_image3_display" onclick="enlargeImage(event)" src="<?= (isset($variant_image3) && !empty($variant_image3)) ? base_url($variant_image3) : "" ?>">
                                <?php if (isset($variant_image3) && !empty($variant_image3)) : ?>
                                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('variant_image3', 'variant_image3_display')"><i class="bx bx-trash-alt"></i></button>
                                <?php endif; ?>
                                <label class="form-label">Upload Files</label>
                                <input type="file" id="file_upload3" class="form-control" onchange="VariantUploadImage('file_upload3','variant_image3','variant_image3_display')">
                                <span class="error-message" id="error-file_upload3"></span>
                                <input type="text" placeholder="Alt text" id="variant_alt_text3" name="variant_alt_text3" class="form-control" value="<?= @$variant_alt_text3 ?>">
                                <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
                            </div>
                            <!-- ... -->
                            <div class="form-group mb-3">
                                <img class="image-fluid" style="height:auto; width:100px; margin-bottom:10px;" id="variant_image4_display" onclick="enlargeImage(event)" src="<?= (isset($variant_image4) && !empty($variant_image4)) ? base_url($variant_image4) : "" ?>">

                                <?php if (isset($variant_image4) && !empty($variant_image4)) : ?>
                                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('variant_image4', 'variant_image4_display')"><i class="bx bx-trash-alt"></i></button>
                                <?php endif; ?>
                                <label class="form-label">Upload Files</label>
                                <input type="file" id="file_upload4" class="form-control" onchange="VariantUploadImage('file_upload4','variant_image4','variant_image4_display')">
                                <span class="error-message" id="error-file_upload4"></span>
                                <input type="text" placeholder="Alt text" id="variant_alt_text4" name="variant_alt_text4" class="form-control" value="<?= @$variant_alt_text4 ?>">
                                <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
                            </div>
                            <div class="form-group mb-3">
                                <img class="image-fluid" style="height:auto; width:100px; margin-bottom:10px;" id="variant_image5_display" onclick="enlargeImage(event)" src="<?= (isset($variant_image5) && !empty($variant_image5)) ? base_url($variant_image5) : "" ?>">

                                <?php if (isset($variant_image5) && !empty($variant_image5)) : ?>
                                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('variant_image5', 'variant_image5_display')"><i class="bx bx-trash-alt"></i></button>
                                <?php endif; ?>
                                <label class="form-label">Upload Files</label>
                                <input type="file" id="file_upload5" class="form-control" onchange="VariantUploadImage('file_upload5','variant_image5','variant_image5_display')">
                                <span class="error-message" id="error-file_upload5"></span>
                                <input type="text" placeholder="Alt text" id="variant_alt_text5" name="variant_alt_text5" class="form-control" value="<?= @$variant_alt_text5 ?>">
                                <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
                            </div>
                            <div class="form-group mb-3">
                                <img class="image-fluid" style="height:auto; width:100px; margin-bottom:10px;" id="variant_image6_display" onclick="enlargeImage(event)" src="<?= (isset($variant_image6) && !empty($variant_image6)) ? base_url($variant_image6) : "" ?>">

                                <?php if (isset($variant_image6) && !empty($variant_image6)) : ?>
                                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('variant_image6', 'variant_image6_display')"><i class="bx bx-trash-alt"></i></button>
                                <?php endif; ?>
                                <label class="form-label">Upload Files</label>
                                <input type="file" id="file_upload6" class="form-control" onchange="VariantUploadImage('file_upload6','variant_image6','variant_image6_display')">
                                <span class="error-message" id="error-file_upload6"></span>
                                <input type="text" placeholder="Alt text" id="variant_alt_text6" name="variant_alt_text6" class="form-control" value="<?= @$variant_alt_text6 ?>">
                                <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
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
    function calculate_variant() {
        $.ajax({
            type: "post",
            url: "<?= base_url(route_to('calculate_variant')); ?>",
            data: {
                purchase_rate: $('#purchase_rate').val(),
                mrp: $('#mrp').val(),
                discount_per: $('#discount_per').val(),
                gst_per: $('#gst_per').val(),
            },
            success: function(response) {
                if (response.status == 200) {
                    data = JSON.parse(response.data);
                    $('#discount_amt').val(data.discount_amt);
                    $('#gst_amt').val(data.gst_amt);
                    $('#selling_price').val(data.selling_price);
                    $('#cost_price').val(data.cost_price);
                    $('#profit_per').val(data.profit_per);
                    $('#profit_amt').val(data.profit_amt);
                }
            }
        });
    }
    var selected_size = "<?= @$size_id ?>";

    var selected_unit = "<?= @$unit_id ?>";
    var selected_color = "<?= @$color_id ?>";
    $(document).ready(function() {
        initializeSelectize('unit_id', {
                placeholder: "Unit"
            }, "<?= base_url(route_to('unit_list_api')) ?>", {}, "unit_id", "unit_name",
            selected_unit)
        initializeSelectize('color_id', {
                placeholder: "Color"
            }, "<?= base_url(route_to('color_list_api')) ?>", {}, "color_id", "color_name",
            selected_color)
        initializeSelectize('size_id', {
            placeholder: "Select Multiple Sizes"
        }, "<?= base_url(route_to('size_list_api')) ?>", {}, "size_id", "size_name", selected_size);
    });

    function successCallback(response) {
        if (response.status == 200 || response.status == 201) {
            window.location.href = '<?= base_url(route_to('variant_list', $product_id)) ?>'
        }
    }

    function errorCallback(response) {
        console.log(response);
    }

    function VariantUploadImage(id, input_id, image_tag_id) {
        uploadImage(id, 'product', input_id, image_tag_id)
    }
</script>