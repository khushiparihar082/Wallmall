<div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasRightLabel">View Order</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body">
    <div class="card-body">
        <div class="col-md-12 new-contact-fad">
            <div id="order-preview">
                <?= view('AdminPanelNew/components/order_preview', $order_data) ?>
            </div>
            <?php if (isset($order_data['items']) && !empty($order_data['items'])) : ?>
                <?php
                $exchange_pickup_hide = 0;
                $returnImages = [];          // ✅ array
                $product_weight = 0;
                $total_return_qty = 0;
                $product_name = $order_data['items'][0]['product_name'];

                foreach ($order_data['items'] as $item) :

                    // total return qty
                    $total_return_qty += (int) ($item['return_qty'] ?? 0);

                    // variant weight
                    $weight = isset($item['variant_weight'])
                        ? $item['variant_weight'] * ($item['order_qty'] ?? 1)
                        : 0;
                    $product_weight += $weight;

                    // collect return images
                    if (!empty($item['return_exchange_image1'])) {
                        $returnImages[] = $_ENV['app.baseURL'] . $item['return_exchange_image1'];
                    }

                endforeach;

                // ✅ convert to comma-separated string
                $returnImage = implode(',', $returnImages);
                ?>
            <?php endif; ?>

            <form id="order_status_change" action="order_status_change" method="post" enctype="multipart/form-data">
                <div class="row">
                    <input type="hidden" name="order_id" id="order_id" value="<?= @$order_id ?>">

                    <?php if ($page_status == 'delivery_ready_to_ship'): ?>
                        <!---without 3rd party intregation use code-->
                        <!-- <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="docket_number" class="form-label">Docket Number</label>
                                <input type="text" class="form-control" name="docket_number" id="docket_number" value="<#? @$order_data['delhivery_waybill'] ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="order_shipping_company_name" class="form-label">Shipping Company Name</label>
                                <input type="text" class="form-control" name="order_shipping_company_name"
                                    id="order_shipping_company_name" value="Delhivery">
                            </div>
                            <div class="col-md-4">
                                <label for="order_delivery_expected_date" class="form-label">Expected Delivery Date</label>
                                <input type="date" class="form-control" name="order_delivery_expected_date"
                                    id="order_delivery_expected_date">
                            </div>
                        </div> -->
                        <input type="hidden" class="form-control" name="docket_number" id="docket_number" value="78362552849">
                        <input type="hidden" class="form-control" name="order_shipping_company_name"
                            id="order_shipping_company_name" value="Delhivery">
                        <input type="hidden" class="form-control" name="order_delivery_expected_date"
                            id="order_delivery_expected_date" value="<?= @(new DateTime($order_data['order_date']))
                                                                            ->modify('+5 days')
                                                                            ->format('Y-m-d') ?>">

                    <?php endif; ?>

                    <?php if ($page_status == 'finance_pending_order' && $order_data['payment_mode'] == 'COD'): ?>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="refund_transaction_id" class="form-label">Razorpay Payment Transaction ID</label>
                                <input type="text" class="form-control" name="refund_transaction_id" id="refund_transaction_id">
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($page_status == 'delivery_shipped'): ?>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="order_delivered_date" class="form-label">Delivery Date</label>
                                <input type="date" class="form-control" name="order_delivered_date" id="order_delivered_date">
                            </div>
                            <?php if ($order_data['remaining_total'] > 0): ?>
                                <div class="col-md-3">
                                    <label for="remaining_total" class="form-label">Ramaining Amount</label>
                                    <input type="number" class="form-control" name="remaining_total" id="remaining_total" value="<?= @$order_data['remaining_total'] ?>" readonly>
                                </div>
                            <?php endif; ?>
                            <?php if ($order_data['remaining_total'] <= 0): ?>
                                <input type="hidden" class="form-control" name="remaining_total" id="remaining_total" value="<?= @$order_data['remaining_total'] ?>" readonly>
                            <?php endif; ?>
                            <?php if ($order_data['payment_mode'] == 'COD'): ?>
                                <div class="col-md-3">
                                    <label for="cod_charges_total" class="form-label">Receive Amount</label>
                                    <input type="number" class="form-control" name="cod_charges_total" id="cod_charges_total" value="<?= @$order_data['cod_charges_total'] ?>" readonly>
                                </div>
                            <?php endif; ?>
                            <?php if ($order_data['remaining_total'] > 0): ?>
                                <div class="col-md-3">
                                    <label for="order_total" class="form-label">Total Amount</label>
                                    <input type="number" class="form-control" name="order_total" id="order_total" value="<?= @$order_data['order_total'] ?>" readonly>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($page_status == 'return_request_pending' && $order_data['order_status'] == 'return_request'): ?>
                        <div class="col-md-6">
                            <label for="return_shipping_charge" class="form-label">Return Shipping Charge</label>
                            <span class="text-danger">*</span>
                            <input type="number" class="form-control" name="return_shipping_charge" id="return_shipping_charge" value="<?= @$order_data['return_shipping_charge'] ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="delhivery_waybill" class="form-label">Return Waybill</label>
                            <span class="text-danger">*</span>
                            <input type="number" class="form-control" name="delhivery_waybill" id="delhivery_waybill" value="">
                        </div>
                    <?php endif; ?>

                    <?php if ($page_status == 'exchange_request_pending' && $order_data['order_status'] == 'exchange_request'): ?>
                        <div class="col-md-12">
                            <label for="delhivery_waybill" class="form-label">Exchange Waybill</label>
                            <span class="text-danger">*</span>
                            <input type="number" class="form-control" name="delhivery_waybill" id="delhivery_waybill" value="">
                        </div>
                    <?php endif; ?>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="log_remark" class="form-label">Remark</label>
                            <span class="text-danger">*</span>
                            <textarea class="form-control" name="log_remark" id="log_remark" rows="2" require></textarea>
                        </div>
                    </div>
                    <!-- Action Button -->
                    <div class="d-flex gap-2">
                        <!-- Finance Pending Order Page Button -->
                        <?php if ($page_status == 'finance_pending_order'): ?>
                            <?php if ($order_data['order_status'] == 'request_refund_approved'): ?>

                                <?php if ($order_data['payment_mode'] == 'COD'): ?>
                                    <button type="button"
                                        onclick="returnRefundPay()"
                                        class="btn btn-warning">
                                        Refund Processed
                                    </button>
                                <?php endif; ?>
                                <?php if ($order_data['payment_mode'] == 'online'): ?>
                                    <button type="button"
                                        onclick="ReturnStatusCheck(<?= (int)$order_data['order_id'] ?>,'<?= esc($order_data['delhivery_waybill'], 'js') ?>','<?= esc($order_data['order_number'], 'js') ?>')"
                                        class="btn btn-warning">
                                        Refund Processed
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if ($order_data['order_status'] == 'order_not_delivered'): ?>
                                <button type="button"
                                    onclick="orderNotDeliveredRefundPay()"
                                    class="btn btn-warning">
                                    Refund Processed
                                </button>
                            <?php endif; ?>

                            <?php if ($order_data['order_status'] == 'order_payment_processing' || $order_data['order_status'] == 'order_payment_success'): ?>
                                <button type="button"
                                    onclick="changeOrderStatus('Are you sure you want to manually verify this payment?', {verify_mode: 'manual', order_status: 'order_payment_verified_manual'})"
                                    class="btn btn-warning">
                                    Verify Payment (Manual)
                                </button>
                                <button type="button"
                                    onclick="changeOrderStatus('Are you sure you want to verify this payment through Razorpay?', {verify_mode: 'razorpay', order_status: 'order_payment_verified_razorpay'})"
                                    class="btn btn-outline-primary">
                                    Verify Payment (Razorpay)
                                </button>
                                <button type="button"
                                    onclick="changeOrderStatus('Are you sure the payment has failed?', {order_status: 'order_payment_fail'})"
                                    class="btn btn-outline-danger">
                                    Mark Payment as Failed
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                        <!-- return request approve-->
                        <?php if ($page_status == 'request_return_approved'): ?>
                            <?php if ($order_data['order_status'] == 'request_return_approved'): ?>
                                <button type="button"
                                    onclick="changeOrderStatus('Confirm that you have processed the refund Approved.', {order_status: 'request_refund_approved'})"
                                    class="btn btn-warning">
                                    Refund Approved
                                </button>
                            <?php endif; ?>
                            <?php if ($order_data['order_status'] == 'order_payment_processing' || $order_data['order_status'] == 'order_payment_success'): ?>
                                <button type="button"
                                    onclick="changeOrderStatus('Are you sure you want to manually verify this payment?', {verify_mode: 'manual', order_status: 'order_payment_verified_manual'})"
                                    class="btn btn-warning">
                                    Verify Payment (Manual)
                                </button>
                                <button type="button"
                                    onclick="changeOrderStatus('Are you sure you want to verify this payment through Razorpay?', {verify_mode: 'razorpay', order_status: 'order_payment_verified_razorpay'})"
                                    class="btn btn-outline-primary">
                                    Verify Payment (Razorpay)
                                </button>
                                <button type="button"
                                    onclick="changeOrderStatus('Are you sure the payment has failed?', {order_status: 'order_payment_fail'})"
                                    class="btn btn-outline-danger">
                                    Mark Payment as Failed
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                        <!-- Admin Order Pending Approvel Page Buttons -->
                        <?php if ($page_status == 'admin_pending_approval'): ?>
                            <?php if ($order_data['order_status'] == 'order_payment_verified_manual' || $order_data['order_status'] == ''): ?>
                                <button type="button"
                                    onclick="changeOrderStatus(
                        'Are you sure you want to accept this order?', {
                            order_status: 'order_accepted'} )"
                                    class="btn btn-warning">
                                    Accept Order
                                </button>
                                <button type="button"
                                    onclick="changeOrderStatus('Are you sure you want to reject this order?', {order_status: 'request_refund_approved'})"
                                    class="btn btn-primary">
                                    Reject Order
                                </button>
                            <?php endif; ?>

                            <?php if ($order_data['order_status'] == 'order_payment_verified_razorpay'): ?>
                                <button type="button"
                                    onclick="createShippingApi()"
                                    class="btn btn-warning">
                                    Accept Order
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if ($page_status == 'cancel_order'): ?>

                            <?php if (trim($order_data['order_status']) === 'refund_request'): ?>
                                <input type="hidden" name="order_status" id="order_status" value="">
                                <button type="button"
                                    onclick="cancelShippingApi()"
                                    class="btn btn-warning">
                                    Approve Refund Request
                                </button>
                            <?php endif; ?>

                        <?php endif; ?>

                        <?php if ($page_status == 'return_request_pending'): ?>

                            <?php if ($order_data['order_status'] == 'return_request'): ?>
                                <input type="hidden" name="order_status" id="order_status" value="">
                                <button type="button"
                                    onclick="returnShippingApi()"
                                    class="btn btn-warning">
                                    Accept Return Request
                                </button>
                                <button type="button"
                                    onclick="changeOrderStatus('Are you sure you want to reject this return request?', {order_status: 'request_return_rejected'})"
                                    class="btn btn-primary">
                                    Reject Return Request
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if ($page_status == 'exchange_request_pending'): ?>
                            <?php if ($order_data['order_status'] == 'exchange_request'): ?>
                                <button type="button"
                                    onclick="changeOrderStatus('Are you sure you want to accept this exchange request?', {order_status: 'request_exchange_approved'})"
                                    class="btn btn-warning">
                                    Accept Exchange Request
                                </button>
                                <button type="button"
                                    onclick="changeOrderStatus('Are you sure you want to reject this exchange request?', {order_status: 'request_exchange_rejected'})"
                                    class="btn btn-primary">
                                    Reject Exchange Request
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                        <!-- Delivery Order Pending Page Button -->
                        <?php if ($page_status == 'delivery_pending_orders'): ?>
                            <!--for use this code pickup for using api-->
                            <div class="card shadow-sm rounded-4 border-0 mb-4 " style="width:98%;">
                                <div class="card-body p-4">

                                    <h6 class="fw-semibold mb-3" style="color:#0f7369;">
                                        Pickup Details
                                    </h6>

                                    <div class="row g-3">

                                        <div class="col-md-3">
                                            <label for="pickup_time" class="form-label fw-semibold">
                                                Pickup Time <span class="text-danger">*</span>
                                            </label>
                                            <input type="time" class="form-control form-control-sm"
                                                name="pickup_time" id="pickup_time" required>
                                        </div>


                                        <div class="col-md-3">
                                            <label for="pickup_date" class="form-label fw-semibold">
                                                Pickup Date <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" class="form-control form-control-sm"
                                                name="pickup_date" id="pickup_date" required>
                                        </div>


                                        <div class="col-md-3">
                                            <label for="pickup_location" class="form-label fw-semibold">
                                                Pickup Location <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control form-control-sm"
                                                name="pickup_location" id="pickup_location"
                                                value="<?= @$order_data['pickup_location'] ?>" readonly>
                                        </div>


                                        <div class="col-md-3">
                                            <label for="expected_package_count" class="form-label fw-semibold">
                                                Expected Package Count <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" class="form-control form-control-sm"
                                                name="expected_package_count" id="expected_package_count"
                                                placeholder="No. of packages" required>
                                        </div>
                                    </div>


                                    <div class="text-end mt-4">
                                        <button type="button"
                                            onclick="pickupShippingApi()"
                                            class="btn btn-warning px-4 fw-semibold">
                                            Mark as Ready to Ship
                                        </button>
                                    </div>

                                </div>
                            </div>
                            <!-- this use pickup api not use -->
                            <!-- <button type="button"
                                onclick="changeOrderStatus(
                        'Are you sure you want to mark this order as ready to ship?', { order_status: 'order_ready_to_ship'})"
                                class="btn btn-warning px-4 fw-semibold">
                                Mark as Ready to Ship
                            </button> -->
                        <?php endif; ?>
                        <!-- Delivery Order Ready To Ship Button -->
                        <?php if ($page_status == 'delivery_ready_to_ship'): ?>
                            <?php if ($order_data['order_status'] == 'order_ready_to_ship' || $order_data['order_status'] == 'request_exchange_rejected' || $order_data['order_status'] == 'request_return_rejected'): ?>
                                <button type="button"
                                    onclick="changeOrderStatus('Are you sure you want to mark this order as shipped?', {order_status: 'order_shipped'})"
                                    class="btn btn-warning">
                                    Mark as Shipped
                                </button>
                            <?php endif; ?>
                            <?php if ($order_data['order_status'] == 'request_exchange_approved'): ?>
                                <button type="button"
                                    onclick="changeOrderStatus('Are you sure you want to mark this exchanged order as shipped?', {order_status: 'order_exchange_shipped'})"
                                    class="btn btn-warning">
                                    Mark Exchanged Order as Shipped
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                        <!-- Delivery Order Shipped Page Button -->
                        <?php if ($page_status == 'delivery_shipped'): ?>
                            <?php if ($order_data['order_status'] == 'order_shipped'): ?>
                                <!-- Button to open modal -->
                                <?php if ($order_data['payment_mode'] == 'COD'): ?>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#markDeliveredModal">
                                        Mark as Delivered
                                    </button>
                                <?php endif; ?>
                                <?php if ($order_data['payment_mode'] == 'online'): ?>
                                    <button type="button"
                                        onclick="changeOrderStatus('Are you sure you want to mark this order as delivered?', {order_status: 'order_delivered'})"
                                        class="btn btn-warning">
                                        Mark as Delivered
                                    </button>
                                <?php endif; ?>
                                <div class="modal fade" id="markDeliveredModal" tabindex="-1" aria-labelledby="markDeliveredLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg rounded-3 overflow-hidden">
                                            <div class="modal-header bg-warning text-white">
                                                <h5 class="modal-title" id="markDeliveredLabel">Confirm Delivery</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-md-12">
                                                    <label for="delivered_date" class="form-label">Delivery Date</label>
                                                    <span class="text-danger">*</span>
                                                    <input type="date" class="form-control" name="delivered_date" id="delivered_date">
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="remaining_amount" class="form-label">Enter Ramaining Amount</label>
                                                    <span class="text-danger">*</span>
                                                    <input type="number" class="form-control" name="remaining_amount" id="remaining_amount" value="">
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="delivery_remark" class="form-label">Enter Remark</label>
                                                    <span class="text-danger">*</span>
                                                    <input type="text" class="form-control" name="delivery_remark" id="delivery_remark" value="">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-warning" onclick="confirmDelivery(<?= $order_data['order_id'] ?>)" data-bs-dismiss="modal">
                                                    Confirm
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($order_data['order_status'] == 'order_exchange_shipped'): ?>
                                <button type="button"
                                    onclick="changeOrderStatus('Are you sure this exchanged order has been delivered?', {order_status: 'order_exchanged'})"
                                    class="btn btn-warning">
                                    Mark Exchanged Order as Delivered
                                </button>
                            <?php endif; ?>
                            <button type="button"
                                onclick="changeOrderStatus('Are you sure you want to mark this order as not delivered?', {order_status: 'order_not_delivered'})"
                                class="btn btn-primary">
                                Mark as Not Delivered
                            </button>
                        <?php endif; ?>

                    </div>
            </form>
        </div>
    </div>
</div>
<!-- ✅ Keep modal OUTSIDE other modals -->
<style>
    .modal-backdrop.show {
        opacity: 0 !important;
        position: relative;
    }
</style>

<script>
    function confirmDelivery(orderId) {
        const remainingAmount = document.getElementById('remaining_amount').value;
        const deliveryDate = document.getElementById('delivered_date').value;
        const delivery_remark = document.getElementById('delivery_remark').value;

        const logRemarkInput = document.getElementById('log_remark');
        logRemarkInput.value = delivery_remark;
        const OrderdeliveryDate = document.getElementById('order_delivered_date');
        OrderdeliveryDate.value = deliveryDate;


        if (!remainingAmount) {
            toastr.error('Please enter remaining amount');
            return;
        }
        if (!deliveryDate) {
            toastr.error('Please enter delivery date');
            return;
        }

        $.ajax({
            url: "<?= base_url(route_to('updateOrderRemainingAmount')) ?>",
            type: "POST",
            data: {
                order_id: orderId,
                remaining_total: remainingAmount,
                order_delivered_date: deliveryDate,
                remark: delivery_remark
            },
            success: function(res) {
                console.log('Remaining amount update response:', res);

                // Handle API response status
                if (res?.status === 200 || res?.status === "OK") {
                    toastr.success('Remaining amount updated successfully');

                    // Then change order status
                    changeOrderStatus('Are you sure this exchanged order has been delivered?', {
                        order_status: 'order_delivered'
                    });
                } else {
                    toastr.error(res?.message || 'Failed to update remaining amount');
                }
            },
            error: function(xhr) {
                console.error('Error updating remaining amount:', xhr.responseText);
                toastr.error('Server error: failed to update remaining amount');
            }
        });
    }
</script>
<script>
    function createShippingApi() {
        $.ajax({
            url: "<?= base_url(route_to('createShipping')) ?>",
            type: "POST",
            data: {
                name: <?= json_encode($order_data['receiver_name'] ?? '') ?>,
                order: <?= json_encode($order_data['order_number'] ?? '') ?>,
                phone: <?= json_encode($order_data['receiver_mobile'] ?? '') ?>,
                add: <?= json_encode($order_data['billing_address'] ?? '') ?>,
                pin: <?= json_encode($order_data['billing_pincode'] ?? '') ?>,
                city: <?= json_encode($order_data['city_name'] ?? '') ?>,
                state: <?= json_encode($order_data['state_name'] ?? '') ?>,
                country: <?= json_encode($order_data['country_name'] ?? '') ?>,
                total_amount: <?= json_encode($order_data['order_total'] ?? 0) ?>,
                weight: <?= json_encode($product_weight ?? 0) ?>,
                cod_amount: <?= json_encode($order_data['remaining_total'] ?? 0) ?>,
                pickup_location: <?= json_encode($order_data['pickup_location'] ?? '') ?>

            },
            success: function(res) {
                console.log('Return Shipping response:', res);

                if (res?.status === 200 || res?.status === "OK") {
                    toastr.success('Shipping created successfully');

                    changeOrderStatus(
                        'Are you sure you want to accept this order?', {
                            order_status: 'order_accepted'
                        }
                    );
                } else {
                    toastr.error(res?.message || 'Failed to create shipping');
                }
            },
            error: function(xhr) {
                toastr.error('Server error: failed to create shipping');
            }
        });
    }

    function cancelShippingApi() {
        const waybill = "<?= esc($order_data['delhivery_waybill'] ?? '') ?>";
        $.ajax({
            url: "<?= base_url(route_to('cancelShipping')) ?>",
            type: "POST",
            data: {
                waybill: waybill
            },
            success: function(res) {
                console.log('Cancel Shipping response:', res);

                if (res?.status === 200 || res?.status === "OK") {
                    toastr.success('Shipping Cancelled Successfully');
                    changeOrderStatus('Are you sure you want to approve this refund request?', {
                        order_status: 'request_refund_approved'
                    });
                } else {
                    toastr.error(res?.message || 'Failed to cancel shipping');
                }
            },
            error: function(xhr) {
                toastr.error('Server error: failed to cancel shipping');
            }
        });
    }

    function pickupShippingApi() {
        $.ajax({
            url: "<?= base_url(route_to('pickupShipping')) ?>",
            type: "POST",
            data: {
                pickup_location: document.getElementById('pickup_location').value,
                pickup_date: document.getElementById('pickup_date').value,
                pickup_time: document.getElementById('pickup_time').value,
                expected_package_count: document.getElementById('expected_package_count').value
            },
            success: function(res) {
                console.log('Pickup Shipping response:', res);

                if (res?.status === 200 || res?.status === "OK") {
                    toastr.success('Shipping Picked Up Successfully');
                    changeOrderStatus(
                        'Are you sure you want to mark this order as ready to ship?', {
                            order_status: 'order_ready_to_ship'
                        }
                    );
                } else {
                    toastr.error(res?.message || 'Failed to pick up shipping');
                }
            },
            error: function(xhr) {
                toastr.error('Server error: failed to pick up shipping');
            }
        });
    }

    function returnShippingApi() {
        $.ajax({
            url: "<?= base_url(route_to('returnShipping')) ?>",
            type: "POST",
            data: {
                // Basic Details
                name: <?= json_encode($order_data['receiver_name'] ?? '') ?>,
                order: <?= json_encode($order_data['order_number'] ?? '') ?>,
                phone: <?= json_encode($order_data['receiver_mobile'] ?? '') ?>,
                add: <?= json_encode($order_data['billing_address'] ?? '') ?>,
                pin: <?= json_encode($order_data['billing_pincode'] ?? '') ?>,
                city: <?= json_encode($order_data['city_name'] ?? '') ?>,
                state: <?= json_encode($order_data['state_name'] ?? '') ?>,
                country: <?= json_encode($order_data['country_name'] ?? '') ?>,

                // Order Details
                total_amount: <?= json_encode($order_data['order_total'] ?? 0) ?>,
                weight: <?= json_encode($product_weight ?? 0) ?>,
                cod_amount: <?= json_encode($order_data['remaining_total'] ?? 0) ?>,
                pickup_location: <?= json_encode($order_data['pickup_location'] ?? '') ?>,
                waybill: <?= json_encode($order_data['delhivery_waybill'] ?? '') ?>,

                // Return Details
                return_city: <?= json_encode($order_data['city_name'] ?? '') ?>,
                return_state: <?= json_encode($order_data['state_name'] ?? '') ?>,
                return_add: <?= json_encode($order_data['billing_address'] ?? '') ?>,
                return_pin: <?= json_encode($order_data['billing_pincode'] ?? '') ?>,
                quantity: <?= json_encode($total_return_qty ?? 0) ?>,
                return_reason: <?= json_encode($order_data['order_remark'] ?? '') ?>,
                order_date: <?= json_encode($order_data['order_date'] ?? '') ?>,

                // QC Details
                image: <?= json_encode($returnImage ?? '') ?>,
                qc_question_id: "Client Question id-1",

                // Additional Mandatory Fields (Add these)
                products_desc: <?= json_encode($product_name ?? 'Return Product') ?>,
                shipping_mode: "Express",
                seller_name: "SHREYANS JAIN",
                seller_gst_tin: <?= json_encode($order_data['gstin'] ?? '') ?>,
                // Optional QC fields
                item: <?= json_encode($product_name ?? 'product') ?>,
                description: <?= json_encode($product_name ?? 'Return Product') ?>,
                brand: "The Hillmen",
                product_category: "gromming product"
            },
            success: function(res) {
                console.log('Return Shipping response:', res);

                if (res?.status === 200 || res?.status === "OK") {
                    toastr.success('Shipping return created successfully');

                    // Update order status
                    changeOrderStatus('Are you sure you want to accept this return request?', {
                        order_status: 'request_return_approved'
                    });
                } else {
                    toastr.error(res?.message || 'Failed to create return shipping');
                }
            },
            error: function(xhr) {
                console.error('Server error:', xhr.responseText);
                toastr.error('Server error: failed to create return shipping');
            }
        });
    }

    function returnRefundPay() {
        const paid_amount = <?= $order_data['order_total'] - $order_data['shipping_charges_total'] ?>;
        $.ajax({
            url: "<?= base_url(route_to('customer_order_payment_refund_razorpay')) ?>",
            type: "POST",
            data: {
                order_id: <?= json_encode($order_data['order_id']) ?>,
                return_shipping_charge: <?= json_encode($order_data['return_shipping_charge']) ?>,
                paid_amount: paid_amount,
                customer_id: <?= json_encode($order_data['customer_id']) ?>,
                purpose: 'return'
            },
            success: function(res) {
                console.log('Refund payed response:', res);

                if (res?.status === 200 || res?.status === "OK") {
                    toastr.success('Refund payed Successfully');
                    changeOrderStatus('Confirm that you have processed the refund to the customer.', {
                        order_status: 'refund_to_customer'
                    });
                } else {
                    toastr.error(res?.message || 'Failed to refund payed shipping');
                }
            },
            error: function(xhr) {
                toastr.error('Server error: failed to refunf payed');
            }
        });
    }

    function ReturnStatusCheck(id, returnwaybill, number) {

        let waybill = returnwaybill;
        let ref_ids = number;
        let order_id = id;
        $.ajax({
            url: "<?= base_url(route_to('trackingShipping')) ?>",
            type: "POST",
            data: {
                waybill: waybill,
                ref_ids: ref_ids
            },
            success: function(res) {
                if (res?.status === 200 || res?.status === "OK") {
                    const shipment =
                        res?.data?.ShipmentData?.[0]?.Shipment ?? null;

                    if (!shipment) {
                        toastr.error('Tracking data not found');
                        return;
                    }

                    window.trackingData = shipment;
                    console.log('Current Status:', shipment.Status?.Status);
                    const scan = shipment.Scans || [];
                    if (shipment.Status?.Status === 'DTO') {
                        returnRefundPay();
                        location.reload();
                    } else {
                        toastr.error('Order Not Return');
                    }

                } else {
                    toastr.error(res?.message || 'Failed to tracked return');
                }
            },
            error: function(xhr) {
                toastr.error('Server error: failed to tracked return');
            }
        });
    }

    function orderNotDeliveredRefundPay() {
        const paid_amount = <?= $order_data['order_total'] ?>;
        $.ajax({
            url: "<?= base_url(route_to('customer_order_payment_refund_razorpay')) ?>",
            type: "POST",
            data: {
                order_id: <?= json_encode($order_data['order_id']) ?>,
                return_shipping_charge: <?= json_encode($order_data['return_shipping_charge']) ?>,
                paid_amount: paid_amount,
                customer_id: <?= json_encode($order_data['customer_id']) ?>,
                purpose: 'order_not_delivered'
            },
            success: function(res) {
                console.log('Refund payed response:', res);

                if (res?.status === 200 || res?.status === "OK") {
                    toastr.success('Refund payed Successfully');
                    changeOrderStatus('Confirm that you have processed the refund to the customer.', {
                        order_status: 'refund_to_customer'
                    });
                } else {
                    toastr.error(res?.message || 'Failed to refund payed shipping');
                }
            },
            error: function(xhr) {
                toastr.error('Server error: failed to refunf payed');
            }
        });
    }
</script>