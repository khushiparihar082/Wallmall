<h2>Customer Refers</h2>
<table class="table table-bordered" id="review_table">
    <thead>
        <tr>
            <th>Customer Id</th>
            <th>Customer Name</th>
            <th>Refer CODE</th>
            <th>Refer Id</th>
           
        </tr>
    </thead>
    <tbody>
        <?php if (isset($refer_data) && count($refer_data) > 0): ?>
            <?php foreach ($refer_data as $refer): ?>
                <tr>
                <td><?= esc($refer['customer_id']) ?></td>
                    <td><?= esc($refer['fullname']) ?></td>
                    <td><?= esc($refer['reffer_code']) ?></td>
                    <td><?= esc($refer['reffer_by_id']) ?></td>
                  
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No refers available.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>