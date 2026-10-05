<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Order List</h4>
        <div class="d-flex gap-3">
            <?php if (!empty($delivered_order_count) && $delivered_order_count > 0) : ?>
                <h6 class="fw-bold">Sales: <?= $delivered_order_count ?></h6>
            <?php endif; ?>

            <?php if (!empty($Total_order_count) && $Total_order_count > 0) : ?>
                <h6 class="fw-bold">Total Orders: <?= $Total_order_count ?></h6>
            <?php endif; ?>
        </div>

    </div>


    <div class="table-responsive">
        <table id="orderTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle" style="border-collapse: collapse; border-spacing: 0; width: 100%;"></table>
    </div>
</div>
</div>

<div class="offcanvas offcanvas-end offcanvas-product" tabindex="-1" id="viewproduct" aria-labelledby="viewproductLable"></div>
</div>
<div class="offcanvas offcanvas-end offcanvas-product" tabindex="-1" id="shippingTrack" aria-labelledby="shippingTrackLable"></div>
</div>

<script>
    var parameter = {};
    var order_status_array = JSON.parse('<?= json_encode($order_status_array) ?>');
    parameter['_autojoin'] = "Y";
    parameter['_select'] = "*";
    <?= (isset($customer_id)) ? "parameter['order-customer_id'] = '$customer_id';" : "" ?>

    // Initialize order_status_where_in_filter as empty
    var order_status_where_in_filter = {};

    // Check if the order_status_array is not empty
    if (order_status_array.length > 0) {
        order_status_where_in_filter = {
            "fieldname": "order-order_status",
            "value": order_status_array
        };

        // Assign the filter to _whereIn parameter
        parameter['_whereIn'] = [order_status_where_in_filter];
    }

    function ProductDisplay(order_id) {
        $.ajax({
            type: "post",
            url: "<?= base_url(route_to('OrderView')) ?>",
            data: {
                order_id: order_id,
                page_status: '<?= $page_status ?>',
            },
            success: function(response) {
                try {
                    $("#viewproduct").empty().html(response);
                } catch (e) {
                    console.error('Error rendering order view:', e);
                    toastr.error('Failed to load order details');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                console.error('Response:', xhr.responseText);
                toastr.error('Failed to load order details');
            }
        });
    }


    function successDataTableCallbackFunction(response) {
        var columns = [{
                title: "Order ID",
                data: "order_number"
            },
            {
                title: "Order Date",
                data: "order_date",
                render: function(data, type, row) {
                    var date = new Date(data);
                    var options = {
                        year: 'numeric',
                        month: 'short',
                        day: '2-digit'
                    };
                    return date.toLocaleDateString('en-GB', options); // Format as "04 Sep 2024"
                }
            },

            {
                title: "Total Amount",
                data: "order_total"
            },
            {
                title: "Refund Amount",
                data: null,
                render: function(data, type, row) {
                    if (row.order_status === 'request_refund_approved' || row.order_status === 'request_return_approved') {
                        let orderTotal = row.order_total || 0;
                        let shippingCharge = row.shipping_charges_total || 0;
                        let returnShippingCharge = row.return_shipping_charge || 0;
                        let refundAmount = orderTotal - shippingCharge;
                        refundAmount = refundAmount - returnShippingCharge;
                        return refundAmount.toFixed(2);
                    }

                    return '-';
                }
            },

            {
                title: "Customer Name",
                data: "fullname"
            },
            {
                title: "Customer UPI Id",
                data: "customer_upi_id"
            },
            {
                title: "Payment Mode",
                data: "payment_mode"
            },
            {
                title: "Current Status",
                data: "order_status",
                render: function(data, type, row) {
                    let label = "";
                    let btn_class = ""; // initialize

                    switch (data) {
                        case 'order_payment_pending':
                            label = "Payment Pending";
                            btn_class = "payment_pending";
                            break;
                        case 'order_payment_success':
                            label = "Payment Success";
                            btn_class = "payment_success";
                            break;
                        case 'order_payment_fail':
                            label = "Payment Fail";
                            btn_class = "payment_fail";
                            break;
                        case 'order_payment_processing':
                            label = "Payment Processing";
                            btn_class = "payment_processing";
                            break;
                        case 'order_payment_verified_manual':
                        case 'order_payment_verified_razorpay':
                            label = "Payment Verified";
                            btn_class = "payment_verified";
                            break;
                        case 'order_accepted':
                            label = "Order Accepted";
                            btn_class = "order_accepted";
                            break;
                        case 'request_refund_approved':
                            label = "Refund Approved";
                            btn_class = "refund_approved";
                            break;
                        case 'request_return_approved':
                            label = "Return Approved";
                            btn_class = "refund_approved";
                            break;
                        case 'request_exchange_approved':
                            label = "Exchange Approved";
                            btn_class = "refund_approved";
                            break;
                        case 'order_ready_to_ship':
                            label = "Order Ready to Ship";
                            btn_class = "ready_to_ship";
                            break;
                        case 'order_shipped':
                            label = "Order Shipped";
                            btn_class = "order_shipped";
                            break;
                        case 'order_delivered':
                            label = "Order Delivered";
                            btn_class = "order_delivered";
                            break;
                        case 'return_request':
                            label = "Return Request";
                            btn_class = "return_request";
                            break;
                        case 'exchange_request':
                            label = "Exchange Request";
                            btn_class = "return_request";
                            break;
                        case 'refund_request':
                            label = "Refund Request";
                            btn_class = "return_request";
                            break;
                        case 'order_exchange_shipped':
                            label = "Order Exchange Shipped";
                            btn_class = "order_shipped";
                            break;
                        case 'order_not_delivered':
                            label = "Order Not Delivered";
                            btn_class = "payment_fail";
                            break;
                        case 'order_exchanged':
                            label = "Order Exchanged";
                            btn_class = "order_shipped";
                            break;
                        case 'request_return_rejected':
                            label = "Request Return Rejected";
                            btn_class = "order_cancelled";
                            break;
                        case 'request_exchange_rejected':
                            label = "Request Exchange Rejected";
                            btn_class = "order_cancelled";
                            break;
                        default:
                            label = "Unknown Status";
                            btn_class = "btn_default";
                    }

                    // dynamically apply the class
                    return `<button class="btn btn-sm ${btn_class}">${label}</button>`;
                }
            },
            {
                title: "Action By",
                data: "status_action_name"
            },
            {
                title: "Action Date",
                data: "status_action_date",
                render: function(data, type, row) {
                    var date = new Date(data);
                    var options = {
                        year: 'numeric',
                        month: 'short',
                        day: '2-digit'
                    };
                    return date.toLocaleDateString('en-GB', options); // Format as "04 Sep 2024"
                }
            },

            {
                title: "Actions",
                data: null,
                render: function(data, type, row) {
                    let actionButtons = `
                   <button class="btn btn-primary btn-sm" type="button" onclick="ProductDisplay('${row.order_id}')" data-bs-toggle="offcanvas" data-bs-target="#viewproduct" aria-controls="viewproduct">
                         <i class="mdi mdi-file-eye-outline"></i> View
                      </button>
                     `;
                    if (row.order_status === 'order_shipped' || row.order_status === 'order_ready_to_ship' || row.order_status === 'request_refund_approved') {
                        actionButtons += `
                             <button class="btn btn-secondary btn-sm" type="button" onclick="ShippingTrackDisplay('${row.delhivery_waybill},${row.order_number}')" data-bs-toggle="offcanvas" data-bs-target="#shippingTrack" aria-controls="shippingTrack">
                         <i class="mdi mdi-map-marker-path"></i> Track
                      </button>
                             `;
                    }
                    if (row.order_status === 'order_shipped' || row.order_status === 'order_ready_to_ship') {
                        actionButtons += `
                           
                        <button class="btn btn-success btn-sm" type="button" onclick="ShippingStatusCheck('${row.delhivery_waybill},${row.order_number},${row.order_id}')" >
                         <i class="mdi mdi-check-bold"></i> Mark as Delivered
                      </button>
                             `;
                    }
                    // Only show the "Download Invoice" button when the order status is 'order_delivered' or 'order_exchanged'
                    if (row.order_status === 'order_delivered' || row.order_status === 'order_exchanged') {
                        actionButtons += `
                             <button class="btn btn-primary" id="downloadInvoiceBtn" onclick="downloadInvoice('${row.order_id}')">
                            <i class="fa fa-download"></i> Download Invoice
                                </button>
                             `;
                    }


                    return actionButtons;
                }
            }

        ];

        if (response.status == 200) {
            return {
                status: response.status,
                columns: columns,
                data: JSON.parse(response.data)
            };
        } else {
            return {
                status: response.status,
                columns: columns,
                data: []
            };
        }
    }

    function fetchTableData() {
        DataTableInitialized(
            'orderTable', // table_id
            "<?= base_url(route_to('order_list_api')) ?>", // url
            'POST', // method
            parameter, // parameter
            successDataTableCallbackFunction // dataTableSuccessCallBack
        );
    }


    function downloadInvoice(order_id) {
        const url = "<?= base_url(route_to('invoice_download')) ?>" + "?order_id=" + order_id;
        console.log("Invoice Download URL: ", url); // For debugging purposes
        window.open(url, '_blank'); // Open PDF in a new window
    }



    function changeOrderStatus(message, data = {}) {

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

        Swal.fire({
            title: 'Are you sure?',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it!'
        }).then((result) => {
            if (result.isConfirmed) {

                let status_action_id = "<?= session()->get('user_id') ?>";

                // ✅ current datetime (JS se)
                let now = new Date();
                let status_action_date = now.getFullYear() + '-' +
                    String(now.getMonth() + 1).padStart(2, '0') + '-' +
                    String(now.getDate()).padStart(2, '0') + ' ' +
                    String(now.getHours()).padStart(2, '0') + ':' +
                    String(now.getMinutes()).padStart(2, '0') + ':' +
                    String(now.getSeconds()).padStart(2, '0');

                let formData = new FormData($("#order_status_change")[0]);

                // ✅ Add extra params
                formData.set('status_action_id', status_action_id);
                formData.set('status_action_date', status_action_date);


                // ✅ Case 1: only order_status string
                if (typeof data === 'string') {
                    formData.set('order_status', data);
                }

                // ✅ Case 2: order_status + log_remark object
                else if (typeof data === 'object') {
                    Object.keys(data).forEach(key => {
                        formData.set(key, data[key]);
                    });
                }

                $.ajax({
                    url: "<?= base_url(route_to('orderStatusChange')) ?>",
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        if (response.status == 422) {

                            if (response.errors && typeof response.errors === 'object') {
                                // Loop through all validation errors
                                Object.values(response.errors).forEach(function(errorMsg) {
                                    toastr.error(errorMsg);
                                });
                            } else {
                                toastr.error(response.message || 'Validation error');
                            }
                            return;
                        }

                        // 🔴 Bad request
                        if (response.status == 400) {
                            toastr.error(response.message);
                            return;
                        }

                        if (response.status == 200) {
                            Swal.fire(
                                'Updated!',
                                'Order status updated successfully!',
                                'success'
                            ).then(() => {
                                location.reload(); // ✅ Page refresh only on success
                            });
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to update the order status. Please try again.',
                                'error'
                            );
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        Toast.fire({
                            icon: 'error',
                            title: 'An error occurred. Please try again.'
                        });
                    }
                });
            }
        });
    }


    $(document).ready(function() {
        // Call fetchTableData with the parameter object
        fetchTableData();
    });
</script>

<script>
    function ShippingTrackDisplay(value) {
        let parts = value.split(',');

        let waybill = parts[0]?.trim();
        let ref_ids = parts[1]?.trim();
        $.ajax({
            type: "post",
            url: "<?= base_url(route_to('ShipmentTrack')) ?>",
            data: {
                ref_ids: ref_ids,
                waybill: waybill,
            },
            success: function(response) {
                $("#shippingTrack").html("");
                $("#shippingTrack").html(response);
            }
        });
    }
</script>

<script>
    function ShippingStatusCheck(value) {
        let parts = value.split(',');

        let waybill = parts[0]?.trim();
        let ref_ids = parts[1]?.trim();
        let order_id = parts[2]?.trim();
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
                        toastr.error('Shipment data not found');
                        return;
                    }

                    window.trackingData = shipment;
                    console.log('Current Status:', shipment.Status?.Status);
                    const scan = shipment.Scans || [];
                    if (shipment.Status?.Status === 'Delivered') {
                        // Delivered scan object nikaalo
                        const deliveredScan = scan.find(item =>
                            item?.ScanDetail?.Scan === 'Delivered'
                        );
                        let deliveredDate = null;

                        if (deliveredScan?.ScanDetail?.StatusDateTime) {
                            deliveredDate = deliveredScan.ScanDetail.StatusDateTime.split('T')[0];
                        }
                        if (deliveredDate == null && deliveredDate == '') {
                            toastr.error('Order Not Delivered');
                            return;
                        }
                        changeOrderStatus(
                            'Are you sure you want to mark this order as delivered?', {
                                order_status: 'order_delivered',
                                log_remark: 'Order delivered successfully.',
                                order_id: order_id,
                                order_delivered_date: deliveredDate,
                                remaining_total: 0
                            }
                        );
                        location.reload();
                    } else {
                        toastr.error('Order Not Delivered');
                    }

                } else {
                    toastr.error(res?.message || 'Failed to tracked shipping');
                }
            },
            error: function(xhr) {
                toastr.error('Server error: failed to tracked shipping');
            }
        });
    }
</script>