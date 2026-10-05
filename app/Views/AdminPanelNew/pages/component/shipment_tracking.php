<style>
    #status {
        word-break: normal;
        overflow-wrap: normal;
    }
</style>

<div class="card shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 fw-semibold" style="color:#0f7369;">
                Shipment Tracking
            </h5>

        </div>

        <!-- Basic Info -->
        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <small class="text-muted">AWB No</small>
                <div class="fw-semibold" id="awb"></div>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Order No</small>
                <div class="fw-semibold" id="order_no"></div>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Payment Mode</small>
                <div class="fw-semibold" id="pay_mode"></div>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Invoice Amount</small>
                <div class="fw-semibold" id="invoice_amount">₹ </div>
            </div>
        </div>

        <hr>

        <div class="row g-3">
            <!-- Current Status -->
            <div class="col-md-5">
                <h6 class="fw-semibold mb-2">Current Status</h6>
                <div class="border rounded-3 p-3 bg-light">
                    <div class="fw-semibold">Pickup scheduled</div>
                    <div class="d-flex gap-1">
                        <p id="current_address"></p>
                        <p id="current_date_time"></p>

                    </div>
                </div>
            </div>

            <!-- Consignee Details -->
            <div class="col-md-5">
                <h6 class="fw-semibold mb-2">Delivery Address</h6>
                <div class="border rounded-3 p-3">
                    <div class="fw-semibold" id="customer_name">Khushi</div>
                    <div class="d-flex gap-1">
                        <p id="customer_city"></p>,
                        <p id="customer_state"></p>
                        <p id="customer_pinocode">-</p>
                        <p id="customer_country"></p>
                    </div>
                </div>
            </div>
            <!--status-->
            <div class="col-md-2 d-flex align-items-start">
                <span
                    id="status"
                    class="badge bg-warning text-dark fw-semibold px-3 py-1 text-nowrap"
                    style="font-size: 12px; width:auto"></span>
            </div>

        </div>

    </div>
</div>
<div class="card shadow-sm rounded-4">
    <div class="card-body p-4">

        <h6 class="fw-semibold mb-3" style="color:#0f7369;">
            Shipment Timeline<? $data ?>
        </h6>

        <ul class="list-group list-group-flush" id="shipmentTimeline" style="height:400px;overflow-y:auto;padding-bottom:100px;">



        </ul>

    </div>
</div>

<script>
    $(document).ready(function() {

        trackingShippingApi();
    });

    function trackingShippingApi() {

        const waybill = <?= $waybill ?>;
        const ref_ids = '<?= $ref_ids ?>';
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
                    console.log('Shipment object:', shipment);
                    console.log('Current Status:', shipment.Status?.Status);
                    console.log('Scans:', shipment.Scans);

                    // bind data
                    $('#awb').text(shipment.AWB);
                    $('#order_no').text(shipment.ReferenceNo);
                    $('#pay_mode').text(shipment.OrderType);
                    $('#invoice_amount').text('₹ ' + shipment.InvoiceAmount);
                    $('#status').text(shipment.Status?.Status);
                    $('#current_address').text(shipment.Status?.StatusLocation);
                    $('#current_date_time').text(formatDateTime(shipment.Status?.StatusDateTime));
                    $('#customer_name').text(shipment.Consignee?.Name);
                    $('#customer_city').text(shipment.Consignee?.City);
                    $('#customer_state').text(shipment.Consignee?.State);
                    $('#customer_pinocode').text(shipment.Consignee?.PinCode);
                    $('#customer_country').text(shipment.Consignee?.Country);
                    //  Timeline binding
                    if (shipment.Scans && shipment.Scans.length > 0) {
                        bindShipmentTimeline(shipment.Scans);
                    } else {
                        $('#shipmentTimeline').html(
                            `<li class="list-group-item text-muted">No tracking updates available</li>`
                        );
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

    function bindShipmentTimeline(scans) {
        console.log('Timeline scans length:', scans.length);
        console.table(scans.map(s => s.ScanDetail?.Instructions));
        let html = '';

        scans.forEach((scanObj, index) => {

            if (!scanObj || !scanObj.ScanDetail) return;

            const scan = scanObj.ScanDetail;

            let formattedDate = '-';
            try {
                formattedDate = scan.StatusDateTime ?
                    formatDateTime(scan.StatusDateTime) :
                    '-';
            } catch (e) {
                console.error('Date format error at index', index, scan.StatusDateTime);
            }

            html += `
        <li class="list-group-item">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="fw-semibold">
                        ${scan.Instructions || '-'}
                    </div>
                    <small class="text-muted">
                        ${scan.ScannedLocation || ''}
                    </small>
                </div>
                <small class="text-muted">
                    ${formattedDate}
                </small>
            </div>
            <span class="badge ${index === scans.length - 1 ? 'bg-warning' : 'bg-secondary'} mt-2">
                ${scan.StatusCode || '-'}
            </span>
        </li>`;
        });

        $('#shipmentTimeline').html(html);
    }


    function formatDateTime(dateStr) {
        const date = new Date(dateStr);

        const options = {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        };

        return date.toLocaleString('en-GB', options).replace(',', '');
    }
</script>