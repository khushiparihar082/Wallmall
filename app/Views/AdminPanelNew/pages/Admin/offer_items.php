<div class="card-body">
    <div class="row">
        <div class="col-10">
            <div class="row">
                <div class="mb-1 col-md-3">
                    <label for="offer_name">Offer name</label>
                    <p class="font-bold text-black"> <?= @$offer_name ?></p>
                </div>
                <div class="mb-1 col-md-3">
                    <label class="form-label" for="offer_discount">Offer Discount %</label>
                    <p class="font-bold text-black"> <?= @$offer_discount ?></p>
                </div>
                <div class="mb-1 col-md-3">
                    <label for="offer_from">Offer From</label>
                    <p class="font-bold text-black"> <?= @$offer_from ?></p>
                </div>
                <div class="mb-1 col-md-3">
                    <label for="offer_to">Offer To</label>
                    <p class="font-bold text-black"> <?= @$offer_to ?></p>
                </div>
                <div class="mb-1 col-md-3">
                    <label for="offer_type">Offer Type</label>
                    <p class="font-bold text-black"> <?= ucwords($offer_type) ?></p>
                </div>
                <div class="mb-1  col-md-3">
                    <label for="offer_title">Offer Title</label>
                    <p class="font-bold text-black"> <?= @$offer_title ?></p>
                </div>
                <div class="mb-1 col-md-3">
                    <label class="form-label">Tag Title</label>
                    <p class="font-bold text-black"> <?= @$offer_seo_title ?></p>
                </div>

                <div class="mb-1 col-md-3">
                    <label class="form-label">Meta Keywords</label>
                    <p class="font-bold text-black"> <?= @$offer_seo_keyword ?></p>
                </div>

                <div class="mb-1 col-md-12">
                    <label class="form-label">Meta Description</label>
                    <p class="font-bold text-black"> <?= @$offer_seo_description ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <img class="image-fluid" onclick="enlargeImage(event,'<?= base_url($offer_image) ?>')" style="height:auto; width:100px" src="<?= base_url(getThumbnailImagePath($offer_image)) ?>">
        </div>
    </div>
</div>
<hr>
<h5><strong>Offer Items</strong></h5>
<form id="offer_items" action="<?= base_url(route_to('offer_items_create_update')) ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="offer_id" value="<?= $offer_id ?>">
    <div class="card-body">
        <div class="table-responsive">
            <table id="offerItemTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle table-sm">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Category Type</th>
                        <th>Category Name</th>
                        <th>Brand</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($product_list) && !empty($product_list)): ?>
                        <?php foreach ($product_list as $key => $product): ?>
                            <tr>
                                <td>
                                    <input type="hidden" name="items[<?= $key ?>][offer_id]" value="<?= $offer_id ?>">
                                    <input 
                                        type="checkbox" 
                                        class="select-row" 
                                        name="items[<?= $key ?>][product_id]" 
                                        value="<?= $product['product_id'] ?>" 
                                        <?= ($product['item_under_offer_item'] == 1) ? "checked" : "" ?>>
                                </td>
                                <td><?= $product['product_id'] ?></td>
                                <td><?= $product['product_name'] ?></td>
                                <td><?= $product['category_type_name'] ?></td>
                                <td><?= $product['category_name'] ?></td>
                                <td><?= $product['brand_name'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Save Items In Offer</button>
    <a href="<?= base_url(route_to('offer_list')) ?>" type="btn" class="btn btn-secondary">Back to Offer List</a>
</form>
<script>
$(document).ready(function() {

    // ✅ Select All checkbox logic
    $('#selectAll').on('change', function() {
        $('.select-row').prop('checked', this.checked);
    });

    // ✅ Uncheck 'Select All' if any row is manually unchecked
    $(document).on('change', '.select-row', function() {
        if (!this.checked) {
            $('#selectAll').prop('checked', false);
        } else if ($('.select-row:checked').length === $('.select-row').length) {
            $('#selectAll').prop('checked', true);
        }
    });

    // ✅ Prevent submit if nothing selected
    $('#offer_items').on('submit', function(e) {
        if ($('.select-row:checked').length === 0) {
            e.preventDefault();
            window.location.href = '<?= base_url(route_to('offer_list')) ?>';
        }
    });

});
</script>