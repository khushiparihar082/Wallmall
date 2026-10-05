<div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasRightLabel">View Product</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body">
    <div class="row">
        <div class="col-md-8">
            <!-- Add Prodcut Detail -->
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-4 mb-3">
                        <label class="form-label" for="product_name">Product Name</label>
                        <p class="font-bold text-black"> <?= @$product_name ?></p>
                    </div>
                    <div class="form-group col-md-8 mb-3">
                        <label class="form-label" for="product_code">Product Code</label>
                        <p class="font-bold text-black"> <?= @$product_code ?></p>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="category_type_id">Category Type</label>
                        <p class="font-bold text-black"> <?= @$category_type_name ?></p>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="category_id">Category</label>
                        <p class="font-bold text-black"> <?= @$category_name ?></p>
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="brand_id">Brand</label>
                        <p class="font-bold text-black"> <?= @$brand_name ?></p>
                    </div>

                    <div class="form-group mb-3 col-md-4 mb-3">
                        <label class="form-label" for="product_hsn_code">HSN Code</label>
                        <p class="font-bold text-black"> <?= @$product_hsn_code ?></p>
                    </div>
                    <div class="form-group mb-3 col-md-4 mb-3">
                        <label class="form-label" for="width">Width</label>
                        <p class="font-bold text-black"> <?= @$width ?></p>
                    </div>

                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="height">Length</label>
                        <p class="font-bold text-black"> <?= @$height ?></p>
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="minimum_stock">Recommended</label>
                        <p class="font-bold text-black"> <?= @$is_recommended ?></p>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="minimum_stock"> Refund</label>
                        <p class="font-bold text-black"> <?= @$is_exchangeable ?></p>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="minimum_stock"> Return</label>
                        <p class="font-bold text-black"> <?= @$is_returnable ?></p>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="minimum_stock"> Return</label>
                        <p class="font-bold text-black"> <?= @$is_sponsore ?></p>
                    </div>


                    <!-- product Details -->
                    <div class="form-group col-md-12 mb-3">
                        <label for="product_description">Description</label>
                        <p class="font-bold text-black"> <?= @$product_description ?></p>
                    </div>
                    <div class="form-group col-md-12 mb-3">
                        <label for="product_specialcare">Care and Special Notes</label>
                        <p class="font-bold text-black"> <?= @$product_specialcare ?></p>
                    </div>
                    <div class="form-group col-md-12 mb-3">
                        <label for="product_refund_exchange">Refunds and Exchange</label>
                        <p class="font-bold text-black"> <?= @$product_refund_exchange ?></p>
                    </div>
                    <div class="form-group col-md-12 mb-3">
                        <label for="product_keyfeature"> Product Keywords</label>
                        <p class="font-bold text-black"> <?= @$product_keyfeature ?></p>
                    </div>

                    <div class="form-group col-md-12 mb-3">
                        <label for="product_seo_title"> Tag Title </label>
                        <p class="font-bold text-black"> <?= @$product_seo_title ?></p>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="product_seo_description"> Meta Description </label>
                        <p class="font-bold text-black"> <?= @$product_seo_description ?></p>
                    </div>
                    <!-- End -->
                </div>
            </div>

        </div>
        <div class="col-md-4">
            <label class="form-label" for="product_name">Features</label>
            <div class="table-responsive-sm">
                <table class="table table-secondary">
                    <tbody>
                        <?php if (isset($features) && !empty($features) && is_array($features)) : ?>
                            <?php foreach ($features as $feature) : ?>
                                <tr>
                                    <td><?= $feature['feature_type_name'] ?></td>
                                    <td><?= $feature['feature_name'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </tbody>
                </table>
            </div>
            <label class="form-label" for="product_name">Variants</label>
            <div class="table-responsive-sm">
                <table class="table table-secondary">
                    <thead>
                        <tr>
                            <th>Variant Name</th>
                            <th>Color</th>
                            <th>Size</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($variants) && !empty($variants) && is_array($variants)) : ?>
                            <?php foreach ($variants as $variant) : ?>
                                <tr>
                                    <td><?= $variant['variant_name'] ?></td>
                                    <td><?= $variant['color_name'] ?></td>
                                    <td><?= $variant['size_name'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </tbody>
                </table>
            </div>

        </div>

        <div class="col-md-12">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Upload Product Images</h6>
            </div>
            <div class="card-body">
                <div class="row row-cols-3">
                    <div class="form-group mb-3">
                        <?php if (isset($product_image1) && !empty($product_image1)) : ?>
                            <img class="image-fluid" onclick="enlargeImage(event,'<?= base_url($product_image1) ?>')" style="height:auto; width:100px" src="<?= base_url(getThumbnailImagePath($product_image1)) ?>">
                        <?php endif; ?>
                    </div>
                    <div class="form-group mb-3">
                    <?php if (isset($product_image2) && !empty($product_image2)) : ?>
                        <img class="image-fluid" onclick="enlargeImage(event,'<?= base_url($product_image2) ?>')" style="height:auto; width:100px" src="<?= base_url(getThumbnailImagePath($product_image2)) ?>">
                        <?php endif; ?>
                    </div>
                    <div class="form-group mb-3">
                    <?php if (isset($product_image3) && !empty($product_image3)) : ?>
                        <img class="image-fluid" onclick="enlargeImage(event,'<?= base_url($product_image3) ?>')" style="height:auto; width:100px" src="<?= base_url(getThumbnailImagePath($product_image3)) ?>">
                        <?php endif; ?>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<script>

</script>