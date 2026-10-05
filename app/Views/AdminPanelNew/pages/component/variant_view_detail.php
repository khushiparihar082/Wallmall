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
                      <div class="form-group col-md-12 mb-3">
                          <label class="form-label" for="variant_name">Variant Title</label>
                          <p class="font-bold text-black"> <?= @$variant_name ?></p>
                      </div>
                      <div class="mb-3 col-md-4">
                          <label for="variant_sku_code">SKU Code</label>
                          <p class="font-bold text-black"> <?= @$variant_sku_code ?></p>
                      </div>
                      <div class="mb-3 col-md-4">
                          <label for="variant_unit">Unit</label>
                          <p class="font-bold text-black"> <?= @$unit_name ?></p>
                      </div>

                      <div class="mb-3 col-md-4">
                          <label for="variant_weight">Weight</label>
                          <p class="font-bold text-black"> <?= @$variant_weight ?></p>
                      </div>

                      <div class="form-group mb-3 col-md-8 mb-3">
                          <label class="form-label" for="sizes">Sizes</label>
                          <p class="font-bold text-black"><?= @$sizes ?></p>

                      </div>
                      <div class="form-group mb-3 col-md-4 mb-3">
                          <label class="form-label" for="size_id">Size</label>
                          <p class="font-bold text-black"> <?= @$size_name ?></p>
                      </div>

                      <div class="mb-3 col-md-4">
                          <label class="form-label" for="color_name">Color Name</label>
                          <p class="font-bold text-black"> <?= @$color_name ?></p>
                      </div>

                      <div class="mb-3 col-md-4">
                          <label for="minimum_stock">Minimum Stock</label>
                          <p class="font-bold text-black"> <?= @$minimum_stock ?></p>
                      </div>


                      <!-- Variant Details -->
                      <div class="form-group col-md-12 mb-3">
                          <label for="variant_description">Description</label>
                          <p class="font-bold text-black"> <?= @$variant_description ?></p>
                      </div>

                      <div class="form-group col-md-12 mb-3">
                          <label for="variant_seo_keyword"> Meta Keywords </label>
                          <p class="font-bold text-black"> <?= @$variant_seo_keyword ?></p>
                      </div>
                      <div class="form-group col-md-12">
                          <label for="variant_seo_description"> Meta Description </label>
                          <p class="font-bold text-black"> <?= @$variant_seo_description ?></p>
                      </div>
                      <!-- End -->
                  </div>
              </div>

          </div>
          <div class="col-md-4 bg-light">
              <div class="card-body">
                  <div class="form-group mb-3 col-md-12">
                      <label class="form-label" for="purchase_rate">Purchase Rate/Cost (W/O GST)</label>
                      <p class="font-bold text-black"> <?= @$purchase_rate ?></p>
                  </div>
                  <div class="form-group mb-3 col-md-12">
                      <label class="form-label" for="txt_product_price">M.R.P</label>
                      <p class="font-bold text-black"> <?= @$mrp ?></p>
                  </div>
                  <div class="form-group mb-3 col-md-12">
                      <label class="form-label" for="txt_discount">Dis %</label>
                      <p class="font-bold text-black"> <?= @$discount_per ?></p>
                  </div>
                  <div class="form-group mb-3 col-md-12">
                      <label class="form-label" for="txt_discount_amount">Dis Amt</label>
                      <p class="font-bold text-black"> <?= @$discount_amt ?></p>
                  </div>
                  <div class="form-group mb-3 col-md-12">
                      <label class="form-label" for="txt_offer_price_inc_tax">Selling Price</label>
                      <p class="font-bold text-black"> <?= @$selling_price ?></p>
                  </div>
                  <div class="form-group mb-3 col-md-12">
                      <div class="row">
                          <div class="col-6">
                              <label class="form-label">GST %</label>
                              <p class="font-bold text-black"> <?= @$gst_per ?></p>
                          </div>
                          <div class="col-6">
                              <label class="form-label" for="txt_gst_amount">GST Amt</label>
                              <p class="font-bold text-black"> <?= @$gst_amt ?></p>
                          </div>
                      </div>
                  </div>
                  <hr />
                  <div class="form-group mb-3 col-md-12">
                      <label class="form-label">Selling Cost Price (W/O GST)</label>
                      <p class="font-bold text-black"><?= @$cost_price ?></p>
                  </div>
                  <div class="form-group mb-3 col-md-12">
                      <label class="form-label">Profit Calculation</label>
                      <div class="row">
                          <div class="col-6">
                              <label class="form-label">Profit %</label>
                              <p class="font-bold text-black"><?= @$profit_per ?></p>
                          </div>
                          <div class="col-6">
                              <label class="form-label" for="txt_gst_amount">Profit Amt</label>
                              <p class="font-bold text-black"><?= @$profit_amt ?></p>
                          </div>
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
                          <?php if (isset($variant_image1) && !empty($variant_image1)) : ?>
                              <img class="image-fluid" onclick="enlargeImage(event,'<?= base_url($variant_image1) ?>')" style="height:auto; width:100px" src="<?= base_url(getThumbnailImagePath($variant_image1)) ?>">
                          <?php endif; ?>
                      </div>
                      <div class="form-group mb-3">
                          <?php if (isset($variant_image2) && !empty($variant_image2)) : ?>
                              <img class="image-fluid" onclick="enlargeImage(event,'<?= base_url($variant_image2) ?>')" style="height:auto; width:100px" src="<?= base_url(getThumbnailImagePath($variant_image2)) ?>">
                          <?php endif; ?>
                      </div>
                      <div class="form-group mb-3">
                          <?php if (isset($variant_image3) && !empty($variant_image3)) : ?>
                              <img class="image-fluid" onclick="enlargeImage(event,'<?= base_url($variant_image3) ?>')" style="height:auto; width:100px" src="<?= base_url(getThumbnailImagePath($variant_image3)) ?>">
                          <?php endif; ?>
                      </div>
                      <div class="form-group mb-3">
                          <?php if (isset($variant_image4) && !empty($variant_image4)) : ?>
                              <img class="image-fluid" onclick="enlargeImage(event,'<?= base_url($variant_image4) ?>')" style="height:auto; width:100px" src="<?= base_url(getThumbnailImagePath($variant_image4)) ?>">
                          <?php endif; ?>
                      </div>
                      <div class="form-group mb-3">
                          <?php if (isset($variant_image5) && !empty($variant_image5)) : ?>
                              <img class="image-fluid" onclick="enlargeImage(event,'<?= base_url($variant_image5) ?>')" style="height:auto; width:100px" src="<?= base_url(getThumbnailImagePath($variant_image5)) ?>">
                          <?php endif; ?>
                      </div>
                      <div class="form-group mb-3">
                          <?php if (isset($variant_image6) && !empty($variant_image6)) : ?>
                              <img class="image-fluid" onclick="enlargeImage(event,'<?= base_url($variant_image6) ?>')" style="height:auto; width:100px" src="<?= base_url(getThumbnailImagePath($variant_image6)) ?>">
                          <?php endif; ?>
                      </div>
                  </div>

              </div>
          </div>
      </div>
  </div>

  <script>

  </script>