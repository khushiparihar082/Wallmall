<table class="table table-bordered">
    <tbody>
        <tr>
            <td>Order Number</td>
            <td><?= $order_data['order_number'] ?? 'Not Available' ?></td>
        </tr>
        <tr>
            <td>Order Status</td>
            <td>
                <label class="btn btn-sm btn-secondary">
                    <?= $order_data['order_status'] ?? 'Not Available' ?>
                </label>
            </td>
        </tr>
        <tr>
            <td>Order Ordered Date</td>
            <td><?= isset($order_data['order_date']) ? date('F j, Y', strtotime($order_data['order_date'])) : 'Not Available' ?></td>
        </tr>
        <tr>
            <td>Delivery Address</td>
            <td>
                <?= $order_data['billing_address'] ?? 'Not Available' ?>,
                <?= $order_data['landmark'] ?? '' ?>,
                <?= $order_data['city_name'] ?? 'Not Available' ?>,
                <?= $order_data['billing_pincode'] ?? 'Not Available' ?>
            </td>
        </tr>
        <tr>
            <td>Shipping Address</td>
            <td>
                <?= $order_data['billing_address'] ?? 'Not Available' ?>,
                <?= $order_data['landmark'] ?? '' ?>,
                <?= $order_data['city_name'] ?? 'Not Available' ?>,
                <?= $order_data['billing_pincode'] ?? 'Not Available' ?>
            </td>
        </tr>
    </tbody>
</table>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No.</th>
            <th>Menu Name</th>
            <th>Qty</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($order_data['items'])): ?>
            <?php foreach ($order_data['items'] as $index => $item): ?>

                <?php
                // ✅ If Return Requested → show only items with return_qty > 0
                if ($order_data['order_status_alias'] === 'Return Requested') {
                    if (empty($item['return_qty']) || (int)$item['return_qty'] <= 0) {
                        continue; // ⛔ skip this row
                    }
                }
                // ✅ If Exchange Requested → show only items with exchange_qty > 0
                if ($order_data['order_status_alias'] === 'Exchange Requested') {
                    if (empty($item['exchange_qty']) || (int)$item['exchange_qty'] <= 0) {
                        continue; // ⛔ skip this row
                    }
                }
                ?>

                <tr>
                    <td><?= $index + 1 ?></td>

                    <td>
                        <?= esc($item['product_name']) ?>

                        <!-- Image preview section -->
                        <div class="mt-2">
                            <div class="row g-2">
                                <?php for ($i = 1; $i <= 4; $i++):
                                    $imgKey = 'return_exchange_image' . $i;
                                    if (!empty($item[$imgKey])): ?>
                                        <div class="col-6 col-md-3">
                                            <div class="border rounded p-1 text-center">
                                                <img
                                                    src="<?= base_url($item[$imgKey]) ?>"
                                                    alt="return_image<?= $i ?>"
                                                    onclick="enlargeImage(event, '<?= base_url($item[$imgKey]) ?>')"
                                                    class="img-fluid rounded shadow-sm"
                                                    style="width:100%; height:100px; object-fit:cover; cursor:pointer;">
                                            </div>
                                        </div>
                                <?php endif;
                                endfor; ?>
                            </div>
                        </div>
                    </td>

                    <td>
                        <?php
                        if (
                            $order_data['order_status_alias'] === 'Exchange Requested' ||
                            $order_data['order_status_alias'] === 'Exchange Approved'
                        ) {
                            echo esc($item['exchange_qty']);
                        } elseif (
                            $order_data['order_status_alias'] === 'Return Requested' ||
                            $order_data['order_status_alias'] === 'Return Approved'
                        ) {
                            echo esc($item['return_qty']);
                        } else {
                            echo esc($item['order_qty']);
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        $itemTotal   = (float)$item['item_total_amount'];
                        $orderQty    = (float)$item['order_qty'];
                        $exchangeQty = (float)$item['exchange_qty'];
                        $returnQty   = (float)$item['return_qty'];

                        $perUnitPrice = ($orderQty > 0) ? ($itemTotal / $orderQty) : 0;

                        if (
                            $order_data['order_status_alias'] === 'Exchange Requested' ||
                            $order_data['order_status_alias'] === 'Exchange Approved'
                        ) {
                            echo "₹" . number_format($perUnitPrice * $exchangeQty, 2) . " /-";
                        } elseif (
                            $order_data['order_status_alias'] === 'Return Requested' ||
                            $order_data['order_status_alias'] === 'Return Approved'
                        ) {
                            echo "₹" . number_format($perUnitPrice * $returnQty, 2) . " /-";
                        } else {
                            echo "₹" . number_format($itemTotal, 2) . " /-";
                        }
                        ?>
                    </td>
                </tr>

            <?php endforeach; ?>


            <?php if (!empty($order_data['coupon_dis_total']) && $order_data['coupon_dis_total'] > 0): ?>
                <tr>
                    <td colspan="2"></td>
                    <td>Coupon Discount</td>
                    <td>- ₹<?= number_format($order_data['coupon_dis_total'], 2) ?></td>
                </tr>
            <?php endif; ?>

            <!-- shipping amount-->
            <tr>
                <td colspan="2"></td>
                <td>Shipping Amount</td>
                <td> ₹<?= number_format(floatval($order_data['shipping_charges_total'] ?? 0), 2) ?></td>
            </tr>
            <!-- cod amount-->
            <?php if ($order_data['payment_mode'] == 'COD'): ?>
                <tr>
                    <td colspan="2"></td>
                    <td>COD Amount</td>
                    <td> ₹<?= number_format($order_data['cod_charges_total'], 2) ?></td>
                </tr>
            <?php endif; ?>

            <!-- wallet amount-->
            <tr>
                <td colspan="2"></td>
                <td>Use Wallet Amount</td>
                <td> ₹<?= number_format(floatval($order_data['wallet_used_amount'] ?? 0), 2) ?></td>
            </tr>
            <!--total amount -->
            <tr>

                <td colspan="2"></td>
                <td>Total</td>
                <td>
                    <?php
                    $totalAmount = 0;

                    if (!empty($order_data['items'])) {

                        foreach ($order_data['items'] as $item) {

                            $itemTotal   = (float) ($item['item_total_amount'] ?? 0);
                            $orderQty    = (float) ($item['order_qty'] ?? 0);
                            $exchangeQty = (float) ($item['exchange_qty'] ?? 0);
                            $returnQty   = (float) ($item['return_qty'] ?? 0);

                            $perUnitPrice = ($orderQty > 0) ? ($itemTotal / $orderQty) : 0;

                            /* ===============================
                            * EXCHANGE TOTAL
                            * =============================== */
                            if (
                                $order_data['order_status_alias'] === 'Exchange Requested' ||
                                $order_data['order_status_alias'] === 'Exchange Approved'
                            ) {
                                if ($exchangeQty > 0) {
                                    $totalAmount += ($perUnitPrice * $exchangeQty);
                                }

                                /* ===============================
                                 * RETURN TOTAL
                                 * =============================== */
                            } elseif (
                                $order_data['order_status_alias'] === 'Return Requested' ||
                                $order_data['order_status_alias'] === 'Return Approved'
                            ) {
                                if ($returnQty > 0) {
                                    $totalAmount += ($perUnitPrice * $returnQty);
                                }

                                /* ===============================
                              * NORMAL ORDER
                              * =============================== */
                            } else {
                                $totalAmount += $itemTotal;
                            }
                        }
                    }

                    /* ===============================
                      * APPLY COUPON & WALLET (ONLY NORMAL ORDER)
                      * =============================== */
                    if (
                        $order_data['order_status_alias'] !== 'Return Requested' &&
                        $order_data['order_status_alias'] !== 'Return Approved' &&
                        $order_data['order_status_alias'] !== 'Exchange Requested' &&
                        $order_data['order_status_alias'] !== 'Exchange Approved'
                    ) {
                        $couponDis  = (float) ($order_data['coupon_dis_total'] ?? 0);
                        $walletUsed = (float) ($order_data['wallet_used_amount'] ?? 0);

                        $totalAmount = $totalAmount - $couponDis - $walletUsed;
                    }

                    echo "₹" . number_format(max($totalAmount, 0), 2) . " /-";
                    ?>
                </td>

            </tr>


        <?php else: ?>
            <tr>
                <td colspan="4">No items found</td>
            </tr>
        <?php endif; ?>
    </tbody>



</table>