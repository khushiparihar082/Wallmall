<h2 class="mb-4">Customer Review</h2>
<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped" id="review_table">
        <thead class="thead-dark">
            <tr>
                <th>Customer Name</th>
                <th>SKU CODE</th>
                <th>Product Name</th>
                <th>Review</th>
                <th>Rating</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($review_data) && count($review_data) > 0): ?>
                <?php foreach ($review_data as $review): ?>
                    <tr>
                        <td><?= esc($review['fullname']) ?></td>
                        <td><?= esc($review['product_id']) . "-" . esc($review['variant_id']) ?></td>
                        <td><?= esc($review['product_name']) . "-" . esc($review['variant_name']) ?></td>
                        <td><?= esc($review['customer_review']) ?></td>
                        <td>
                            <!-- Display numeric rating with stars -->
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="fa fa-star <?= $i <= esc($review['customer_rating']) ? 'checked' : '' ?>"></span>
                            <?php endfor; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No reviews available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<style>
    .fa-star {
        color: #ddd; 
    }
    .fa-star.checked {
        color: #ffc107; 
    }
     
</style>
